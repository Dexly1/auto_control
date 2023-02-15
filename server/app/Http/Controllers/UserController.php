<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function checkUser(Request $req) {
        $users = User::select('login', 'password', 'role')
        ->where('login', $req->get('login'))
        ->where('password', $req->get('password'))
        ->get();
        return response()->json($users);

        //$users = User::all();
        // ->where('password', $req->input('password'))
        // ->get();
        return response()->json($users);
    }

}
