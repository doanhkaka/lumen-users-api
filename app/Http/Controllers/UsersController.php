<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Transformer\UserTransformer;

class UsersController extends Controller
{
    public function index()
    {
        return $this->collection(User::all(), new UserTransformer());
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::guard('api')->id());

        $user->fill($request->all());
        $user->save();

        return $this->item($user, new UserTransformer());
    }
}