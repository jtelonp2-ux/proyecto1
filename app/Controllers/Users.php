<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string
    {
        $modelo   = new UserModel();
        $usuarios = $modelo->orderBy('created_at', 'DESC')->paginate(5);

        return blade_view('users_index', [
            'usuarios' => $usuarios,
            'pager'    => $modelo->pager,
        ]);
    }

    public function new(): string
    {
        return blade_view('users_new');
    }

    public function create()
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

        (new UserModel())->insert([
            'name'          => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'password'      => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'active'        => 1,
            'administrator' => 0,
        ]);

        return redirect()->to('/users')->with('message', 'Usuario creado.');
    }

    public function show(int $id)
    {
        $usuario = (new UserModel())->find($id);

        if (! $usuario) {
            return redirect()->to('/users')->with('error', 'Usuario no encontrado.');
        }

        return blade_view('users_show', ['usuario' => $usuario]);
    }

    public function edit(int $id)
    {
        $usuario = (new UserModel())->find($id);

        if (! $usuario) {
            return redirect()->to('/users')->with('error', 'Usuario no encontrado.');
        }

        return blade_view('users_edit', ['usuario' => $usuario]);
    }

    public function update(int $id)
    {
        $modelo  = new UserModel();
        $usuario = $modelo->find($id);

        if (! $usuario) {
            return redirect()->to('/users')->with('error', 'Usuario no encontrado.');
        }

        $reglas = [
            'name'  => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|max_length[150]|is_unique[users.email,id,{$id}]",
        ];

        if ((string) $this->request->getPost('password') !== '') {
            $reglas['password']         = 'min_length[8]';
            $reglas['password_confirm'] = 'matches[password]';
        }

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            'name'          => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'active'        => $this->request->getPost('active') ? 1 : 0,
            'administrator' => $this->request->getPost('administrator') ? 1 : 0,
        ];

        if ((string) $this->request->getPost('password') !== '') {
            $datos['password'] = password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Un administrador no puede quitarse a sí mismo el rol ni desactivarse
        if ($id === (int) session('user_id')) {
            $datos['active']        = 1;
            $datos['administrator'] = 1;
        }

        $modelo->update($id, $datos);

        return redirect()->to('/users/' . $id)->with('message', 'Usuario actualizado.');
    }

    public function delete(int $id)
    {
        if ($id === (int) session('user_id')) {
            return redirect()->to('/users')->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        (new UserModel())->delete($id);

        return redirect()->to('/users')->with('message', 'Usuario eliminado.');
    }
}