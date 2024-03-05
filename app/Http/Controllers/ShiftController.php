<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ShiftController extends Controller
{
    protected $model;
    /**
     * Create a new controller instance.
     */
    public function __construct(Shift $shift)
    {
        $this->model = $shift;
    }

    public function get($id = null)
    {
        if ($id != null) {
            $items = $this->model->orderBy("id", "ASC")->where('id', $id)->first();
        } else {
            $items = $this->model->orderBy('id', 'ASC')->get();
        }
        return response(['data' => $items, 'status' => 200]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'start' => 'required|time',
                'end' => 'required|end',
            ]);
            $shift = $this->model::create([
                'name' => $request->name,
                'start' => $request->start,
                'end' => $request->end,
                "created_by" => Auth::user()->name,
            ]);

            return response()->json([
                'message' => 'success created data',
                'data' => $shift
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
                'name' => 'required|string',
                'start' => 'required|time',
                'end' => 'required|end',
            ]);

            $shift = $this->model::where('id', $id)->update([
                'name' => $request->name,
                'start' => $request->start,
                'end' => $request->end,
                "updated_by" => Auth::user()->name,
            ]);

            return response()->json([
                'message' => 'success update data',
                'data' => $shift
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
            $shift = $this->model::where('id', $id)->delete();
            return response()->json([
                'message' => 'success delete data',
                'data' => $shift
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Query Error',
                'errors' => $e->getMessage()
            ], 422);
        }
    }
}
