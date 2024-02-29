<?php

namespace App\Http\Controllers;

use App\Models\MainCompany;
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
        $data =  User::with('roles')->get();
        $send = [
            'data' => $data
        ];

        return view('pages/users', $send);
    }
    public function mainCompany()
    {
        $data = DB::table('main_companies')
            ->selectRaw('id, name, contact, address, ST_AsGeoJSON(location_radius) AS location_radius')
            ->first();
        $data = (array) $data;
        $send = [
            'data' => $data
        ];
        return view('pages/main-company', $send);
    }
}
