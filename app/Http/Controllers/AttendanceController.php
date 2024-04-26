<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\MainCompany;
use App\Models\Shift;
use App\Models\User;
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
            $items = $this->model::with(["user", "shift"])
                ->select('id', 'user_id', 'shift_id', 'checkin', 'checkout', 'date', 'status', 'work_from')
                ->whereHas('user', function ($query) {
                    $query->where('role_id', 3);
                })->orderBy("attendance.id", "DESC")->where('attendance.id', $id)->first();
        } else {
            $items = $this->model::with(["user", "shift"])
                ->select('id', 'user_id', 'shift_id', 'checkin', 'checkout', 'date', 'status', 'work_from')
                ->whereHas('user', function ($query) {
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
    public function getAttendanceByShift($shift = null)
    {

        if ($shift != null) {
            $items = $this->model::with(['user', 'shift'])
                ->select('id', 'user_id', 'shift_id', 'checkin', 'checkout', 'date', 'status', 'work_from')
                ->whereHas('user', function ($query) {
                    $query->where('role_id', 3);
                })
                ->where('attendance.shift_id', $shift)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $items = $this->model::with(['user', 'shift'])
                ->select('id', 'user_id', 'shift_id', 'checkin', 'checkout', 'date', 'status', 'work_from')
                ->whereHas('user', function ($query) {
                    $query->where('role_id', 3);
                })
                ->orderBy('id', 'DESC')
                ->get();
        }

        if ($items) {
            return jsonResponse($items, Response::HTTP_OK, "success getting data");
        } else {
            return jsonResponse($items, Response::HTTP_NOT_FOUND, "data not found");
        }
    }

    public function getAttendanceTodayByUserId($id)
    {
        try {
            $date = now()->toDateString();
            $attendanceHistory = $this->model::with(["user", "shift"])
                ->select('id', 'user_id', 'shift_id', 'checkin', 'checkout', 'date', 'status', 'work_from')
                ->whereHas('user', function ($query) {
                    $query->where('role_id', 3);
                })->where("attendance.user_id", $id)
                ->where('date', $date)
                ->orderBy('id', 'DESC')
                ->first();
            if ($attendanceHistory) {
                return jsonResponse($attendanceHistory, Response::HTTP_OK);
            } else {
                $attendanceHistoryNull = new Attendance();
                $attendanceHistoryNull->status = "unattended";
                return jsonResponse($attendanceHistoryNull, Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return jsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, $th->getMessage());
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }
    public function getAttendanceByUserId($id)
    {
        try {
            $attendanceHistory = $this->model::with(["user", "shift"])
                ->select('id', 'user_id', 'shift_id', 'checkin', 'checkout', 'date', 'status', 'work_from')
                ->whereHas('user', function ($query) {
                    $query->where('role_id', 3);
                })->where("attendance.user_id", $id)
                ->orderBy('id', 'DESC')
                ->get();

            return jsonResponse($attendanceHistory, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return jsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, $th->getMessage());
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'checkin' => 'required|date_format:H:i',
                'date' => 'required|date',
                'work_from' => 'required|in:office,home',
            ]);

            $userId = $request->user_id;
            $shiftId = $request->shift_id;
            $checkIn = $request->checkin;
            $date = $request->date;
            $workFrom = $request->work_from;
            $location = $request->location;
            $createdBy = $request->created_by;

            // check status dari jadwal shift
            $start = Shift::findOrFail($shiftId)->start;
            $startCheck =  strtotime($start);
            $checkInCheck = strtotime($checkIn);

            if ($checkInCheck <= $startCheck) {
                $status = "in";
            } else {
                $status = "late";
            }

            // jika ambil absen dari kantor, lakukan pengecheckan lokasi
            if ($workFrom == "office") {
                $user = User::findOrFail($userId);
                $userMainCompanyId = $user->main_company_id;
                $mainCompanyData = MainCompany::selectRaw("{$this->geom_area}")->where('id', $userMainCompanyId)->first();
                $companyWkt = $mainCompanyData->wkt;
                if (!$companyWkt) {
                    return jsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, "Main company area is not set yet, please contact admin to set it!");
                }

                $isInsideCompany = MainCompany::whereRaw("ST_Contains(ST_GeomFromText('$companyWkt'), ST_GeomFromText('$location'))")->exists();
                if ($isInsideCompany) {
                    $attendance = $this->model::create([
                        'user_id' => $userId,
                        'shift_id' =>  $shiftId,
                        'checkin' => $checkIn,
                        'date' => $date,
                        "status" =>  $status,
                        "work_from" =>  $workFrom,
                        "location" =>  DB::raw("ST_GeomFromText('$location', 4326)"),
                        "created_by" => $createdBy,
                    ]);
                    return jsonResponse(true, Response::HTTP_CREATED, "success to take attendance");
                } else {
                    return jsonResponse(false, Response::HTTP_UNPROCESSABLE_ENTITY, 'You work from office, but you are not inside the main company area');
                }
            } else {
                // Jika absen dari rumah langsung masukan data
                $attendance = $this->model::create([
                    'user_id' =>  $userId,
                    'shift_id' => $shiftId,
                    'checkin' => $checkIn,
                    'date' => $date,
                    "status" => $status,
                    "work_from" =>  $workFrom,
                    "location" =>  DB::raw("ST_GeomFromText('$location', 4326)"),
                    "created_by" => $createdBy,
                ]);
                return jsonResponse(true, Response::HTTP_CREATED, "success to take attendance");
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
            if (!$attendance) {
                return jsonResponse(null, Response::HTTP_NOT_FOUND, "Attendance data is not found");
            }
            $workFrom = $attendance->work_from;
            if ($workFrom == "office") {
                $user = User::findOrFail($attendance->user_id);
                $userMainCompanyId = $user->main_company_id;
                $mainCompanyData = MainCompany::selectRaw("{$this->geom_area}")->where('id', $userMainCompanyId)->first();
                $companyWkt = $mainCompanyData->wkt;

                if (!$companyWkt) {
                    return jsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, "Main company area is not set yet, please contact admin to set it!");
                }

                $isInsideCompany = MainCompany::whereRaw("ST_Contains(ST_GeomFromText('$companyWkt'), ST_GeomFromText('$location'))")->exists();
                if ($isInsideCompany) {
                    $attendance->checkout = $checkOut;
                    $attendance->updated_by = $updatedBy;
                    $attendance->status = "out";
                    $attendance->save();
                    return jsonResponse(true, Response::HTTP_CREATED, "success to checkout from office");
                } else {
                    return jsonResponse(false, Response::HTTP_UNPROCESSABLE_ENTITY, "You need to checout in main company location, because you are work from office today");
                }
            } else {
                $attendance->checkout = $checkOut;
                $attendance->updated_by = $updatedBy;
                $attendance->save();
                return jsonResponse(true, Response::HTTP_CREATED, "success to checkout from home");
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
