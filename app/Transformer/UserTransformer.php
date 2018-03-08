<?php

namespace App\Transformer;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'email'     => $user->email,
            'name'      => $user->name,
            'address'   => $user->address,
            'tel'       => $user->tel,
            'created'   => $user->created_at->toIso8601String(),
            'updated'   => $user->updated_at->toIso8601String(),
        ];
    }
}