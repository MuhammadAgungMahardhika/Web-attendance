<?php

namespace App\Http\Controllers;

use App\Models\MainCompany;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MainCompanyController extends Controller
{

    protected $model;
    /**
     * Create a new controller instance.
     */
    public function __construct(MainCompany $mainCompany)
    {
        $this->model = $mainCompany;
    }

    public function get($id = null)
    {
        if ($id != null) {
            $items = $this->model::selectRaw('id,name,contact,status,address')->where('id', $id)->first();
        } else {
            $items = $this->model::selectRaw('main_company.id, main_company.name, main_company.contact, main_company.status, main_company.address,
            (SELECT COUNT(*) FROM users WHERE users.main_company_id = main_company.id) AS total_users')
                ->orderBy('main_company.id', 'ASC')
                ->get();
        }
        return jsonResponse($items, Response::HTTP_OK, "success getting data");
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $mainCompany = $this->model::create([
                'name' => $request->name,
                'contact' => $request->contact,
                'status' => $request->status,
                'address' => $request->address,
                "location_radius" => $request->location_radius,
                "created_by" => Auth::user()->name,
            ]);

            return jsonResponse($mainCompany, Response::HTTP_CREATED, "success created account");
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
                'name' => 'required',
            ]);

            $mainCompany = $this->model::findOrFail($id);
            $mainCompany->name = $request->name;
            $mainCompany->contact = $request->contact;
            $mainCompany->status = $request->status;
            $mainCompany->address = $request->address;
            $mainCompany->updated_by = Auth::user()->name;
            $mainCompany->save();

            return jsonResponse("success", Response::HTTP_CREATED, "Success update data");
        } catch (ValidationException $e) {

            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $e) {

            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "failed update main company");
        }
    }
    public function updateMap(Request $request, $id)
    {
        try {

            $geojson = $request->geojson;
            if (!$geojson) {
                $geojson = 'null';
            }

            $this->model::where('id', $id)
                ->update([
                    'location_radius' => DB::raw("ST_GeomFromGeoJSON('{$geojson}')")
                ]);

            return redirect(url('/main-company'))->with("success", "Success added data");
        } catch (ValidationException $e) {
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $e) {

            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "failed update main company");
        }
    }

    public function delete($id)
    {
        try {
            $mainCompany = $this->model::where('id', $id)->delete();
            return jsonResponse($mainCompany, Response::HTTP_OK, "'success delete main company");
        } catch (QueryException $e) {
            return jsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, "Query Error");
        }
    }
}
