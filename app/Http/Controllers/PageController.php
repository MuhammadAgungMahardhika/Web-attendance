<?php

namespace App\Http\Controllers;

use App\Models\MainCompany;
use App\Models\User;
use Illuminate\Http\Request;

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
        $data =  MainCompany::first();
        $send = [
            'data' => $data
        ];
        return view('pages/main-company', $send);
    }
}
