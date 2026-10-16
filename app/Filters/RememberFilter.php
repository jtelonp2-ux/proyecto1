<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RememberFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session('logged_in')) {
            return;
        }

        $cookie = (string) $request->getCookie('remember');

        if (! str_contains($cookie, ':')) {
            return;
        }

        [$id, $token] = explode(':', $cookie, 2);

        $usuario = (new UserModel())->find((int) $id);

        if (
            ! $usuario
            || (int) $usuario['active'] !== 1
            || empty($usuario['remember_token'])
            || ! hash_equals($usuario['remember_token'], hash('sha256', $token))
        ) {
            return;
        }

        session()->regenerate();
        session()->set([
            'user_id'       => $usuario['id'],
            'user_name'     => $usuario['name'],
            'administrator' => (int) $usuario['administrator'],
            'logged_in'     => true,
        ]);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}