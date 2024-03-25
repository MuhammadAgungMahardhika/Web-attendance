<?php

namespace App\Http\Controllers;

use App\Models\MainCompany;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $model;
    /**
     * Create a new controller instance.
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function get($id = null)
    {
        if ($id != null) {
            $items = $this->model->where('id', $id)->first();
        } else {
            if (Auth::user()->role_id == 2) {
                $items = $this->model::with('roles')->where('users.role_id', '!=', 1)->orderBy('id', 'ASC')->get();
            } else {
                $items = $this->model::with('roles')->orderBy('id', 'ASC')->get();
            }
        }
        return jsonResponse($items, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'main_company_id' => 'required',
                'name' => 'required',
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

            $checkEmail = $this->model::where("email", $request->email)->exists();
            if ($checkEmail) {
                return jsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, "Email Already Exist!");
            }
            $items = $this->model::create([
                'role_id' => $request->role_id,
                'main_company_id' => $request->main_company_id,
                'outsource_company_id' => $request->outsource_company_id,
                'name' => $request->name,
                'email' => $request->email,
                "departmen" => $request->departmen,
                "position" => $request->position,
                "phone_number" => $request->phone_number,
                "address" => $request->address,
                "status" => "active",
                'password' => Hash::make($request->password),
                "created_by" => Auth::user()->name,
            ]);

            return jsonResponse($items, Response::HTTP_CREATED, "success created account");
        } catch (ValidationException $e) {
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Throwable Error");
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'main_company_id' => 'required',
                'name' => 'required',
                'email' => 'required|string',
                'status' => 'required|string',
            ]);

            $items = $this->model::where('id', $id)->update([
                'role_id' => $request->role_id,
                'main_company_id' => $request->main_company_id,
                'outsource_company_id' => $request->outsource_company_id,
                'name' => $request->name,
                'email' => $request->email,
                "departmen" => $request->departmen,
                "position" => $request->position,
                "phone_number" => $request->phone_number,
                "address" => $request->address,
                "status" => $request->status,
                "updated_by" => Auth::user()->name,
            ]);

            return jsonResponse($items, Response::HTTP_CREATED, "success update account");
        } catch (ValidationException $e) {
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }

    public function delete($id)
    {
        try {
            $items = $this->model::where('id', $id)->delete();
            return jsonResponse($items, Response::HTTP_OK, "success delete account");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }
}
