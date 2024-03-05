<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
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
            $items = $this->model::with("user")->whereHas('user', function ($query) {
                $query->where('role_id', 3);
            })->orderBy("attendance.id", "ASC")->where('attendance.id', $id)->first();
        } else {
            $items = $this->model::with('user')->whereHas('user', function ($query) {
                $query->where('role_id', 3);
            })->orderBy('attendance.id', 'ASC')->get();
        }
        return response(['data' => $items, 'status' => 200]);
    }


    public function getAttendanceByDate($date)
    {
        $items = $this->model::with('user')->whereHas('user', function ($query) {
            $query->where('role_id', 3);
        })->where('date', $date)->orderBy('attendance.id', 'ASC')->get();

        if ($items) {
            return response(['data' => $items, 'status' => 200]);
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
                'checkin' => 'required|time',
                'checkout' => 'required|time',
                'date' => 'required|date',
                'status' => 'required|in:in,out,late',
                'work_from' => 'required|in:office,home',
            ]);
            $attendance = $this->model::create([
                'checkin' => $request->checkin,
                'checkout' => $request->checkout,
                'date' => $request->date,
                "status" => $request->status,
                "work_from" => $request->work_from,
                "location" => $request->location,
                "created_by" => Auth::user()->name,
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
                'checkin' => 'required|time',
                'checkout' => 'required|time',
                'date' => 'required|date',
                'status' => 'required|in:in,out,late',
                'work_from' => 'required|in:office,home',
            ]);

            $attendance = $this->model::where('id', $id)->update([
                'checkin' => $request->checkin,
                'checkout' => $request->checkout,
                'date' => $request->date,
                "status" => $request->status,
                "work_from" => $request->work_from,
                "location" => $request->location,
                "updated_by" => Auth::user()->name,
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
