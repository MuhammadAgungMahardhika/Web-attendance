<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function user()
    {
        $data =  User::with('roles')->get();
        $send = [
            'data' => $data
        ];

        return view('pages/users', $send);
    }
    public function dashboard()
    {
        $send = ['oke'];
        return view('pages/dashboard', $send);
    }
}
