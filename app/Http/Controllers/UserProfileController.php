<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserProfileController extends Controller
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
            $user->updated_by = Auth::user()->id;
            $user->save();

            return response()->json([
                'message' => 'success update account',
                'data' => $user
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }
}
