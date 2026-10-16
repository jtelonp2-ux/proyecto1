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

    public function forgot(): string
    {
        return blade_view('forgot');
    }

    public function sendReset()
    {
        if (! $this->validate(['email' => 'required|valid_email'])) {
            return redirect()->back()->withInput()->with('error', 'Correo inválido.');
        }

        $modelo  = new UserModel();
        $usuario = $modelo->where('email', $this->request->getPost('email'))->first();

        if ($usuario) {
            $token = bin2hex(random_bytes(32));

            $modelo->update($usuario['id'], [
                'reset_token'   => hash('sha256', $token),
                'reset_expires' => date('Y-m-d H:i:s', time() + 3600),
            ]);

            $correo = service('email');
            $correo->setTo($usuario['email']);
            $correo->setSubject('Restablecer contraseña');
            $correo->setMessage(
                '<p>Recibimos una solicitud para restablecer tu contraseña.</p>'
                . '<p><a href="' . base_url('reset-password/' . $token) . '">Restablecer contraseña</a></p>'
                . '<p>El enlace vence en 1 hora. Si no fuiste tú, ignora este mensaje.</p>'
            );

            if (! $correo->send()) {
                log_message('error', $correo->printDebugger(['headers']));
            }
        }

        return redirect()->to('/login')->with('message', 'Si el correo existe, te enviamos instrucciones.');
    }

    private function usuarioPorResetToken(string $token): ?array
    {
        $usuario = (new UserModel())->where('reset_token', hash('sha256', $token))->first();

        if (! $usuario || empty($usuario['reset_expires']) || strtotime($usuario['reset_expires']) < time()) {
            return null;
        }

        return $usuario;
    }

    public function resetForm(string $token)
    {
        if (! $this->usuarioPorResetToken($token)) {
            return redirect()->to('/login')->with('error', 'Enlace inválido o vencido.');
        }

        return blade_view('reset', ['token' => $token]);
    }

    public function resetSave(string $token)
    {
        $usuario = $this->usuarioPorResetToken($token);

        if (! $usuario) {
            return redirect()->to('/login')->with('error', 'Enlace inválido o vencido.');
        }

        $reglas = [
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        (new UserModel())->update($usuario['id'], [
            'password'       => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'reset_token'    => null,
            'reset_expires'  => null,
            'remember_token' => null,
        ]);

        return redirect()->to('/login')->with('message', 'Contraseña restablecida. Ya puedes iniciar sesión.');
    }
}