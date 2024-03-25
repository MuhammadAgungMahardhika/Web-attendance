<?php

namespace App\Http\Controllers;

use App\Models\MainCompany;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $items = $this->model::selectRaw('id,name,contact,address')->where('id', $id)->first();
        } else {
            $items = $this->model::selectRaw('id,name,contact,address')->orderBy('id', 'ASC')->get();
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

            DB::beginTransaction();
            $mainCompany = $this->model::where('id', $id)->update([
                'name' => $request->name,
                'contact' => $request->contact,
                'address' => $request->address,
                "updated_by" => Auth::user()->name,
            ]);
            $geojson = $request->geojson;
            if (!$geojson) {
                $geojson = 'null';
            }

            $updateGeom = $this->model::where('id', $id)
                ->update([
                    'location_radius' => DB::raw("ST_GeomFromGeoJSON('{$geojson}')")
                ]);

            DB::commit();

            return redirect(url('/main-company'))->with("success", "Success added data");
        } catch (ValidationException $e) {
            DB::rollBack();
            return jsonResponse($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY, "Validation Error");
        } catch (QueryException $e) {
            DB::rollBack();
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
