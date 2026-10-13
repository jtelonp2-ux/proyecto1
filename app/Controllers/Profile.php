<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    public function index(): string
    {
        $usuario = (new UserModel())->find(session('user_id'));

        return blade_view('profile', ['usuario' => $usuario]);
    }
}