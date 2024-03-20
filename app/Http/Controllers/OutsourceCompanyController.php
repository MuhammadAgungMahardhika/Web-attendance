<?php

namespace App\Http\Controllers;

use App\Models\MainCompany;
use App\Models\OutsourceCompany;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class OutsourceCompanyController extends Controller
{
    protected $model;
    /**
     * Create a new controller instance.
     */
    public function __construct(OutsourceCompany $outsourceCompany)
    {
        $this->model = $outsourceCompany;
    }

    public function get($id = null)
    {
        if ($id != null) {
            $items = $this->model::withCount("users")->orderBy("outsource_company.id", "ASC")->where('id', $id)->first();
        } else {
            $items = $this->model::withCount('users')->orderBy('id', 'ASC')->get();
        }
        return jsonResponse($items, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);
            $outsourceCompany = $this->model::create([
                'main_company_id' => MainCompany::first()->id,
                'name' => $request->name,
                "contact" => $request->contact,
                "address" => $request->address,
                "created_by" => Auth::user()->name,
            ]);

            return jsonResponse($outsourceCompany, Response::HTTP_CREATED, "success created outsource company");
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
                'name' => 'required'
            ]);

            $outsourceCompany = $this->model::where('id', $id)->update([
                'main_company_id' => $request->main_company_id,
                'name' => $request->name,
                "contact" => $request->contact,
                "address" => $request->address,
                "updated_by" => Auth::user()->name,
            ]);
            return jsonResponse($outsourceCompany, Response::HTTP_CREATED, "success update outsource company");
        } catch (ValidationException $e) {
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }

    public function delete($id)
    {
        try {
            $outsourceCompany = $this->model::where('id', $id)->delete();
            return jsonResponse($outsourceCompany, Response::HTTP_OK, "success delete outsource company");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }
}
