<?php

namespace App\Http\Controllers;

use App\Models\MainCompany;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
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

        return response(['data' => $items, 'status' => 200]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|string',
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
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $th) {
            return $th->getMessage();
        }
    }
}
