<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string
    {
        $usuario = (new UserModel())->find(session('user_id'));

        return blade_view('profile', ['usuario' => $usuario]);
    }

    public function confirm(): string
    {
        return blade_view('profile_confirm');
    }

    public function checkPassword()
    {
        $usuario = (new UserModel())->find(session('user_id'));

        if (! password_verify((string) $this->request->getPost('password'), $usuario['password'])) {
            return redirect()->back()->with('error', 'Contraseña incorrecta.');
        }

        session()->set('edit_ok', true);

        return redirect()->to('/profile/edit');
    }
    
    public function password(): string
    {
        return blade_view('profile_password');
    }

    public function updatePassword()
    {
        $reglas = [
            'current_password'     => 'required',
            'new_password'         => 'required|min_length[8]',
            'new_password_confirm' => 'required|matches[new_password]',
        ];
        if (!$this->validate($reglas)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }
         $modelo  = new UserModel();
    $usuario = $modelo->find(session('user_id'));

    if (! password_verify((string) $this->request->getPost('current_password'), $usuario['password'])) {
        return redirect()->back()->with('error', 'La contraseña actual es incorrecta.');
    }

      $modelo->update($usuario['id'], [
        'password' => password_hash((string) $this->request->getPost('new_password'), PASSWORD_DEFAULT),
    ]);

    return redirect()->to('/profile')->with('message', 'Contraseña actualizada correctamente');
    }

    public function edit()
    {
        if (! session('edit_ok')) {
            return redirect()->to('/profile/confirm');
        }

        $usuario = (new UserModel())->find(session('user_id'));

        return blade_view('profile_edit', ['usuario' => $usuario]);
    }

    public function update()
    {
        if (! session('edit_ok')) {
            return redirect()->to('/profile/confirm');
        }

        $id = session('user_id');

        $reglas = [
            'name'  => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|max_length[150]|is_unique[users.email,id,{$id}]",
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new UserModel())->update($id, [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ]);

        session()->set('user_name', $this->request->getPost('name'));
        session()->remove('edit_ok');

        return redirect()->to('/profile')->with('message', 'Perfil actualizado correctamente.');
    }
}