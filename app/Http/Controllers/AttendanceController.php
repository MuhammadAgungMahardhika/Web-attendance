<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{
    protected $model;
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
            })->orderBy("attendance.id", "ASC")->where('attendance.id', $id)->first();
        } else {
            $items = $this->model::with(["user", "shift"])->whereHas('user', function ($query) {
                $query->where('role_id', 3);
            })->orderBy('attendance.id', 'ASC')->get();
        }
        return response(['data' => $items, 'status' => 200]);
    }


    public function getAttendanceByDate(Request $request)
    {
        $from = $request->from;
        $to = $request->to;


        $items = $this->model::with(['user', 'shift'])
            ->select('id', 'user_id', 'shift_id', 'checkin', 'checkout', 'date', 'status', 'work_from')
            ->whereHas('user', function ($query) {
                $query->where('role_id', 3);
            })
            ->whereRaw('DATE(checkin) >= ? AND DATE(checkin) <= ?', [$from, $to])
            ->orderBy('id', 'ASC')
            ->get();
        if ($items) {
            return response()->json([
                'message' => 'success getting data',
                'data' => $items
            ], Response::HTTP_ACCEPTED);
        } else {
            return response()->json([
                'message' => 'failed getting data',
                'data' => $items
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function getAttendanceByUserId($id)
    {
        $attendanceHistory = $this->model::with("users")->whereHas('user', function ($query) {
            $query->where('role_id', 3);
        })->where("user_id", $id)->get();
        return response()->json([
            'message' => 'success getting data',
            'data' => $attendanceHistory
        ], Response::HTTP_CREATED);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'checkin' => 'required|date_format:H:i',
                'checkout' => 'required|date_format:H:i',
                'date' => 'required|date',
                'status' => 'required|in:in,out,late',
                'work_from' => 'required|in:office,home',
            ]);
            $attendance = $this->model::create([
                'user_id' => $request->user_id,
                'shift_id' => $request->shift_id,
                'checkin' => $request->checkin,
                'checkout' => $request->checkout,
                'date' => $request->date,
                "status" => $request->status,
                "work_from" => $request->work_from,
                "location" =>  DB::raw("ST_PointFromText('$request->location')"),
                "created_by" => $request->created_by,
            ]);

            return response()->json([
                'message' => 'success created data',
                'data' => $attendance
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Query Error',
                'errors' => $e->getMessage()
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                // 'checkin' => 'required|date_format:H:i',
                // 'checkout' => 'required|date_format:H:i',
                'date' => 'required|date',
                'status' => 'required|in:in,out,late',
                'work_from' => 'required|in:office,home',
            ]);

            $attendance = $this->model::where('id', $id)->update([
                'user_id' => $request->user_id,
                'shift_id' => $request->shift_id,
                'checkin' => $request->checkin,
                'checkout' => $request->checkout,
                'date' => $request->date,
                "status" => $request->status,
                "work_from" => $request->work_from,
                "location" => DB::raw("ST_PointFromText('$request->location')"),
                "updated_by" => $request->updated_by,
            ]);


            return response()->json([
                'message' => 'success update data',
                'data' => $attendance
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Query Error',
                'errors' => $e->getMessage()
            ], 422);
        }
    }

    public function delete($id)
    {
        try {
            $attendance = $this->model::where('id', $id)->delete();
            return response()->json([
                'message' => 'success delete data',
                'data' => $attendance
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Query Error',
                'errors' => $e->getMessage()
            ], 422);
        }
    }
}
