<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class RolesController extends Controller
{

    protected $model;
    /**
     * Create a new controller instance.
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function get($id = null)
    {
        if ($id != null) {
            $items = $this->model::findOrFail($id);
        } else {
            $items = $this->model->get();
        }
        return response(['data' => $items, 'status' => 200]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'name' => 'required',
            ]);

            $role = $this->model::create(
                [
                    "role_id" => $request->role_id,
                    "name" => $request->name,
                ]
            );
            // event(new AddKandangEvent( $this->model->get() ));
            return response()->json([
                'message' => 'success created account',
                'role' => $role
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $th) {
            return $this->handleQueryException($th);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'name' => 'required',
            ]);

            $role = $this->model::where('id', $id)->update([
                "role_id" => $request->role_id,
                "name" => $request->name,
            ]);
            // event(new AddKandangEvent( $this->model->get() ));
            return response()->json([
                'message' => 'success update account',
                'data' => $role
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $th) {
            return $th->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $role = $this->model->deleteRole($id);
            return response()->json([
                'message' => 'success delete account',
                'data' => $role
            ], Response::HTTP_OK);
        } catch (QueryException $th) {
            return $th->getMessage();
        }
    }
}
