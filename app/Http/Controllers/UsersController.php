<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Transformer\UserTransformer;
use Illuminate\Support\Facades\Input;

class UsersController extends Controller
{
    public function index()
    {
        $currentCursor = Input::get('cursor', null);
        $previousCursor = Input::get('previous', null);
        $limit = Input::get('limit', 10);

        if ($currentCursor) {
            $users = User::where('id', '>', $currentCursor)->take($limit)->get();
        } else {
            $users = User::take($limit)->get();
        }

        if (count($users)) {
            return $this->collection($users, new UserTransformer(), null, $currentCursor, $previousCursor);
        }

        return response()->json([
            'data' => []
        ], 200);
    }

    public function show($id)
    {
        return $this->item(User::findOrFail($id), new UserTransformer());
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::guard('api')->id());

        $user->fill($request->all());
        $user->save();

        return $this->item($user, new UserTransformer());
    }
}