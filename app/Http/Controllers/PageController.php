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
    public function account()
    {
        return view('pages.account');
    }
    public function dashboard()
    {
        return view('pages.dashboard');
    }
    public function user()
    {
        return view('pages.users');
    }
    public function mainCompany()
    {
        return view('pages.main-company');
    }

    public function mainCompanyMap($id)
    {
        $data = DB::table('main_company')
            ->selectRaw('id, name, contact, address, ST_AsGeoJSON(location_radius) AS location_radius')
            ->where('id', $id)->first();
        $data = (array) $data;
        $send = [
            'data' => $data
        ];

        return view('pages.main-company-map', $send);
    }
    public function outsourceCompany()
    {
        return view('pages.outsource-company');
    }
    public function shift()
    {
        return view('pages.shift');
    }
    public function attendance()
    {
        return view('pages.attendance');
    }
}
