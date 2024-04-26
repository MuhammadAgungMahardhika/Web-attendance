<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PDO;

class UserAccountController extends Controller
{
    protected $model;
    /**
     * Create a new controller instance.
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function get($id)
    {

        $items =   $this->model::with(['mainCompany' => function ($query) {
            $query->select('id', 'name');
        }, 'outsourceCompany' => function ($query) {
            $query->select('id', 'name');
        }])
            ->where('users.id', $id)
            ->first();

        return jsonResponse($items, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|string',
                'phone_number' => 'required|string',
            ]);

            $user = $this->model::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->address = $request->address;
            $user->status = $request->status;
            $user->updated_by = $id;
            $user->save();

            if ($user) {
                return jsonResponse(true, Response::HTTP_CREATED, 'success update account');
            } else {
                return jsonResponse(false, Response::HTTP_UNPROCESSABLE_ENTITY, 'failed update account');
            }
        } catch (ValidationException $e) {
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }

    public function checkPassword(Request $request)
    {
        try {
            $id = intval($request->id);
            $user = $this->model::where('id', $id)->first();
            $password = $request->password;

            if (Hash::check($password, $user->password)) {
                return jsonResponse(true, Response::HTTP_OK, "password is matching");
            } else {
                return jsonResponse(false, Response::HTTP_OK, "password is't matching");
            }
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Internal Server Error");
        }
    }
    public function updatePassword(Request $request)
    {
        try {
            $id = intval($request->id);
            $password = Hash::make($request->password);
            $user = $this->model::findOrFail($id);
            $user->password = $password;
            $user->save();
            if ($user) {
                return jsonResponse(true, Response::HTTP_CREATED, "New password updated!");
            } else {
                return jsonResponse(false,  Response::HTTP_UNPROCESSABLE_ENTITY, "Failed to update password");
            }
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Internal Server Error");
        }
    }
}
