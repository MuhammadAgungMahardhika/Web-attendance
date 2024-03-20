<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
            if (Auth::user()->role_id == 2) {
                $items = $this->model->where('id', '!=', 1)->get();
            } else {
                $items = $this->model->get();
            }
        }
        return jsonResponse($items, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'name' => 'required',
            ]);

            $items = $this->model::create(
                [
                    "role_id" => $request->role_id,
                    "name" => $request->name,
                ]
            );
            return jsonResponse($items, Response::HTTP_CREATED, "success created account");
        } catch (ValidationException $e) {
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'name' => 'required',
            ]);

            $items = $this->model::where('id', $id)->update([
                "role_id" => $request->role_id,
                "name" => $request->name,
            ]);

            return jsonResponse($items, Response::HTTP_CREATED, "success update account");
        } catch (ValidationException $e) {
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }

    public function delete($id)
    {
        try {
            $items = $this->model->deleteRole($id);
            return jsonResponse($items, Response::HTTP_OK, "success delete account");
        } catch (QueryException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
