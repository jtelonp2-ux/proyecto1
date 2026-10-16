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

        $respuesta = redirect()->to('/')->with('message', lang('App.loginSuccess'));

        if ($this->request->getPost('remember')) {
            $token = bin2hex(random_bytes(32));

            $modelo->update($usuario['id'], ['remember_token' => hash('sha256', $token)]);

            $respuesta->setCookie('remember', $usuario['id'] . ':' . $token, 30 * DAY, '', '/', '', false, true);
        }

        return $respuesta;
    }

    public function logout()
    {
        $id = session('user_id');

        if ($id) {
            (new UserModel())->update($id, ['remember_token' => null]);
        }

        session()->destroy();
        session()->start();

        return redirect()->to('/')
            ->with('message', lang('App.logoutSuccess'))
            ->deleteCookie('remember');
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

        $token = bin2hex(random_bytes(32));

        $modelo = new UserModel();
        $modelo->insert([
            'name'             => $this->request->getPost('name'),
            'email'            => $this->request->getPost('email'),
            'password'         => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'active'           => 0,
            'administrator'    => 0,
            'activation_token' => $token,
        ]);

        $correo = service('email');
        $correo->setTo($this->request->getPost('email'));
        $correo->setSubject('Activa tu cuenta');
        $correo->setMessage(
            '<p>Hola, gracias por registrarte.</p>'
            . '<p><a href="' . base_url('activate/' . $token) . '">Activar mi cuenta</a></p>'
        );

        if (! $correo->send()) {
            log_message('error', $correo->printDebugger(['headers']));

            return redirect()->to('/login')->with('error', 'Cuenta creada, pero no se pudo enviar el correo.');
        }

        return redirect()->to('/login')->with('message', 'Cuenta creada. Revisa tu correo para activarla.');
    }

    public function activate(string $token)
    {
        $modelo  = new UserModel();
        $usuario = $token !== '' ? $modelo->where('activation_token', $token)->first() : null;

        if (! $usuario) {
            return redirect()->to('/login')->with('error', 'Enlace de activación inválido.');
        }

        $modelo->update($usuario['id'], ['active' => 1, 'activation_token' => null]);

        return redirect()->to('/login')->with('message', 'Cuenta activada. Ya puedes iniciar sesión.');
    }
}