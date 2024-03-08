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
            $items = $this->model::where('id', $id)->first();
        } else {
            $items = $this->model::orderBy('id', 'ASC')->get();
        }
        return response(['data' => $items, 'status' => 200]);
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

            return response()->json([
                'message' => 'success created account',
                'data' => $mainCompany
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Query Error',
                'errors' => $e->getMessage()
            ], 422);
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
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'failed update main company',
                'data' => $e->getMessage()
            ], 422);
        }
    }

    public function delete($id)
    {
        try {
            $mainCompany = $this->model::where('id', $id)->delete();
            return response()->json([
                'message' => 'success delete main company',
                'data' => $mainCompany
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Query Error',
                'errors' => $e->getMessage()
            ], 422);
        }
    }
}
