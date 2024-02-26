<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function index($id = null)
    {
        if ($id != null) {
            $items = $this->model::with('roles')->where('id', $id)->first();
        } else {
            $items = $this->model::with('roles')->orderBy('id', 'ASC')->get();
        }
        return response(['data' => $items, 'status' => 200]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'name' => 'required',
                'email' => 'required|string',
                'phone_number' => 'required|string',
                'password' => 'required|string',
            ]);
            $user = $this->model::create([
                'role_id' => $request->role_id,
                'name' => $request->name,
                'email' => $request->email,
                "departmen" => $request->departmen,
                "phone_number" => $request->phone_number,
                "address" => $request->address,
                "status" => "active",
                'password' => Hash::make($request->password),
                "created_by" => Auth::user()->name,
            ]);

            return response()->json([
                'message' => 'success created account',
                'user' => $user
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'name' => 'required',
                'email' => 'required|string',
                'phone_number' => 'required|string',
            ]);

            $user = $this->model::where('id', $id)->update([
                'role_id' => $request->role_id,
                'name' => $request->name,
                'email' => $request->email,
                "departmen" => $request->departmen,
                "phone_number" => $request->phone_number,
                "address" => $request->address,
                "status" => $request->status,
                "updated_by" => Auth::user()->name,
            ]);

            return response()->json([
                'message' => 'success update account',
                'user' => $user
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
            $user = $this->model::where('id', $id)->delete();
            return response()->json([
                'message' => 'success delete account',
                'user' => $user
            ], Response::HTTP_OK);
        } catch (QueryException $th) {
            return $th->getMessage();
        }
    }
}
