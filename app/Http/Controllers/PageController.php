<?php

namespace App\Http\Controllers;

use App\Models\MainCompany;
use App\Models\OutsourceCompany;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function dashboard()
    {
        $send = ['oke'];
        return view('pages/dashboard', $send);
    }
    public function user()
    {
        return view('pages/users');
    }
    public function mainCompany()
    {
        $data = DB::table('main_company')
            ->selectRaw('id, name, contact, address, ST_AsGeoJSON(location_radius) AS location_radius')
            ->first();
        $data = (array) $data;
        $send = [
            'data' => $data
        ];
        // dd($data);
        return view('pages/main-company', $send);
    }
    public function outsourceCompany()
    {
        return view('pages/outsource-company');
    }
    public function shift()
    {
        return view('pages/shift');
    }
    public function attendance()
    {
        return view('pages/attendance');
    }
}
