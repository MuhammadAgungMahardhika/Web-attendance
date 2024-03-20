<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\MainCompany;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{
    protected $model;
    protected $geom_area = "ST_AsText(main_company.location_radius) AS wkt";
    /**
     * Create a new controller instance.
     */
    public function __construct(Attendance $attendance)
    {
        $this->model = $attendance;
    }

    public function get($id = null)
    {
        if ($id != null) {
            $items = $this->model::with(["user", "shift"])->whereHas('user', function ($query) {
                $query->where('role_id', 3);
            })->orderBy("attendance.id", "DESC")->where('attendance.id', $id)->first();
        } else {
            $items = $this->model::with(["user", "shift"])->whereHas('user', function ($query) {
                $query->where('role_id', 3);
            })->orderBy('attendance.id', 'DESC')->get();
        }
        return jsonResponse($items, Response::HTTP_OK, "success getting data");
    }


    public function getAttendanceByDate($date)
    {
        $items = $this->model::with(['user', 'shift'])
            ->select('id', 'user_id', 'shift_id', 'checkin', 'checkout', 'date', 'status', 'work_from')
            ->whereHas('user', function ($query) {
                $query->where('role_id', 3);
            })
            ->whereRaw('DATE(date) = ?', $date)
            ->orderBy('id', 'DESC')
            ->get();
        if ($items) {
            return jsonResponse($items, Response::HTTP_OK, "success getting data");
        } else {
            return jsonResponse($items, Response::HTTP_NOT_FOUND, "failed getting data");
        }
    }
    public function getAttendanceByDateRange(Request $request)
    {
        $from = $request->from;
        $to = $request->to;

        $items = $this->model::with(['user', 'shift'])
            ->select('id', 'user_id', 'shift_id', 'checkin', 'checkout', 'date', 'status', 'work_from')
            ->whereHas('user', function ($query) {
                $query->where('role_id', 3);
            })
            ->whereRaw('DATE(date) >= ? AND DATE(date) <= ?', [$from, $to])
            ->orderBy('id', 'DESC')
            ->get();
        if ($items) {
            return jsonResponse($items, Response::HTTP_OK, "success getting data");
        } else {
            return jsonResponse($items, Response::HTTP_NOT_FOUND, "data not found");
        }
    }

    public function getAttendanceByUserId($id)
    {
        try {
            $attendanceHistory = $this->model::with("user")->whereHas('user', function ($query) {
                $query->where('role_id', 3);
            })->where("attendance.user_id", $id)->get();
            return jsonResponse($attendanceHistory, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return jsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'checkin' => 'required|date_format:H:i',
                'date' => 'required|date',
                'status' => 'required|in:in,out,late',
                'work_from' => 'required|in:office,home',
            ]);

            $userId = $request->user_id;
            $shiftId = $request->shift_id;
            $checkIn = $request->checkin;
            $date = $request->date;
            $status = $request->status;
            $workFrom = $request->work_from;
            $location = $request->location;
            $createdBy = $request->created_by;

            // jika ambil absen dari kantor, lakukan pengecheckan lokasi
            if ($workFrom == "office") {
                $mainCompanyData = MainCompany::selectRaw("{$this->geom_area}")->first();
                $companyWkt = $mainCompanyData->wkt;
                $isInsideCompany = MainCompany::whereRaw("ST_Contains(ST_GeomFromText('$companyWkt'), ST_GeomFromText('$location'))")->exists();
                if ($isInsideCompany) {
                    $attendance = $this->model::create([
                        'user_id' => $userId,
                        'shift_id' =>  $shiftId,
                        'checkin' => $checkIn,
                        'date' => $date,
                        "status" =>  $status,
                        "work_from" =>  $workFrom,
                        "location" =>  DB::raw("ST_PointFromText('$location')"),
                        "created_by" => $createdBy,
                    ]);

                    return jsonResponse($attendance, Response::HTTP_CREATED, "success to take attendance");
                } else {
                    return jsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, 'failed you are not inside main company');
                }
            } else {
                // Jika absen wfh langsung masukan data
                $attendance = $this->model::create([
                    'user_id' =>  $userId,
                    'shift_id' => $shiftId,
                    'checkin' => $checkIn,
                    'date' => $date,
                    "status" => $status,
                    "work_from" =>  $workFrom,
                    "location" =>  DB::raw("ST_PointFromText('$location')"),
                    "created_by" => $createdBy,
                ]);
                return jsonResponse($attendance, Response::HTTP_CREATED, "success to take attendance");
            }
        } catch (ValidationException $e) {
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'checkout' => 'required|date_format:H:i',
            ]);

            $checkOut = $request->checkout;
            $updatedBy = $request->updated_by;
            $location = $request->location;
            $attendance = $this->model::find($id);
            $workFrom = $attendance->work_from;
            if ($workFrom == "office") {
                $mainCompanyData = MainCompany::selectRaw("{$this->geom_area}")->first();
                $companyWkt = $mainCompanyData->wkt;
                $isInsideCompany = MainCompany::whereRaw("ST_Contains(ST_GeomFromText('$companyWkt'), ST_GeomFromText('$location'))")->exists();
                if ($isInsideCompany) {
                    $attendance->checkout = $checkOut;
                    $attendance->updated_by = $updatedBy;
                    $attendance->save();
                    return jsonResponse($attendance, Response::HTTP_CREATED, "success update data");
                } else {
                    return jsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, "Not in main company location");
                }
            } else {
                $attendance->checkout = $checkOut;
                $attendance->updated_by = $updatedBy;
                $attendance->save();
                return jsonResponse($attendance, Response::HTTP_CREATED, "success update data");
            }
        } catch (ValidationException $e) {
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }

    public function delete($id)
    {
        try {
            $attendance = $this->model::where('id', $id)->delete();
            return jsonResponse($attendance, Response::HTTP_OK, "success delete data");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }
}
