<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class UsersController
{
    public function index()
    {
        return User::all();
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::guard('api')->id());

        $user->fill($request->all());
        $user->save();

        return $user;
    }
}