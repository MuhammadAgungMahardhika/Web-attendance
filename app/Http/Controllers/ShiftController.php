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
        return jsonResponse($items, 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'start' => 'required|date_format:H:i',
                'end' => 'required|date_format:H:i',
            ]);
            $items = $this->model::create([
                'name' => $request->name,
                'start' => $request->start,
                'end' => $request->end,
                "created_by" => Auth::user()->name,
            ]);
            return jsonResponse($items, Response::HTTP_CREATED, "success created data");
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
                'name' => 'required|string',
                'start' => 'required|date_format:H:i',
                'end' => 'required|date_format:H:i',
            ]);

            $items = $this->model::where('id', $id)->update([
                'name' => $request->name,
                'start' => $request->start,
                'end' => $request->end,
                "updated_by" => Auth::user()->name,
            ]);

            return jsonResponse($items, Response::HTTP_CREATED, "success update data");
        } catch (ValidationException $e) {
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
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
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }
}
