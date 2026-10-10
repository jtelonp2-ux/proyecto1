<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login(): string 
    {
        return blade_view('login');
    }
    public function signup(): string 
    {
        return blade_view('signup');
    }
}