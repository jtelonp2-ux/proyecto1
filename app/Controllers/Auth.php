<?php

namespace App\Controllers;

use App\Models\UserModel;       

class Auth extends BaseController
{
    protected $helpers = ['form'];

    public function login(): string
    {
        return blade_view('login');
    }

    public function authenticate()
    {
        $reglas = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('error', lang('App.badCredentials'));
        }

        $modelo  = new UserModel();
        $usuario = $modelo->where('email', $this->request->getPost('email'))->first();

        if (! $usuario || ! password_verify((string) $this->request->getPost('password'), $usuario['password'])) {
            return redirect()->back()->withInput()->with('error', lang('App.badCredentials'));
        }

        if ((int) $usuario['active'] !== 1) {
            return redirect()->back()->withInput()->with('error', 'Tu cuenta aún no está activada.');
        }

        session()->regenerate();
        session()->set([
            'user_id'       => $usuario['id'],
            'user_name'     => $usuario['name'],
            'administrator' => (int) $usuario['administrator'],
            'logged_in'     => true,
        ]);

        return redirect()->to('/')->with('message', lang('App.loginSuccess'));
    }

    public function logout()
    {
        session()->destroy();
        session()->start();

        return redirect()->to('/')->with('message', lang('App.logoutSuccess'));
    }

    public function signup(): string
    {
        return blade_view('signup');
    }

    public function register()
    {
        $reglas = [
            'name'             => 'required|min_length[3]|max_length[100]',
            'email'            => 'required|valid_email|max_length[150]|is_unique[users.email]',
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $modelo = new UserModel();
        $modelo->insert([
            'name'             => $this->request->getPost('name'),
            'email'            => $this->request->getPost('email'),
            'password'         => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'active'           => 0,
            'administrator'    => 0,
            'activation_token' => bin2hex(random_bytes(32)),
        ]);

        return redirect()->to('/login')->with('message', 'Cuenta creada. Revisa tu correo para activarla.');
    }
}