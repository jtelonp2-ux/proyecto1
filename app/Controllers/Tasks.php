<?php

namespace App\Controllers;

use App\Models\TaskModel;

class Tasks extends BaseController
{
    protected $helpers = ['form'];

    private function tareaDelUsuario(int $id): ?array
    {
        return (new TaskModel())
            ->where('id', $id)
            ->where('user_id', session('user_id'))
            ->first();
    }

    public function index(): string
    {
        $modelo   = new TaskModel();
        $busqueda = trim((string) $this->request->getGet('search'));

        $modelo->where('user_id', session('user_id'));

        if ($busqueda !== '') {
            $modelo->like('description', $busqueda);
        }

        $tareas = $modelo->orderBy('created_at', 'DESC')->paginate(5);

        return blade_view('tasks_index', [
            'tareas'   => $tareas,
            'pager'    => $modelo->pager,
            'busqueda' => $busqueda,
        ]);
    }

    public function new(): string
    {
        return blade_view('tasks_new');
    }

    public function create()
    {
        if (! $this->validate(['description' => 'required|max_length[255]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new TaskModel())->insert([
            'user_id'     => session('user_id'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/tasks')->with('message', lang('App.taskCreated'));
    }

    public function show(int $id)
    {
        $tarea = $this->tareaDelUsuario($id);

        if (! $tarea) {
            return redirect()->to('/tasks')->with('error', lang('App.taskNotFound'));
        }

        return blade_view('tasks_show', ['tarea' => $tarea]);
    }

    public function edit(int $id)
    {
        $tarea = $this->tareaDelUsuario($id);

        if (! $tarea) {
            return redirect()->to('/tasks')->with('error', lang('App.taskNotFound'));
        }

        return blade_view('tasks_edit', ['tarea' => $tarea]);
    }

    public function update(int $id)
    {
        if (! $this->tareaDelUsuario($id)) {
            return redirect()->to('/tasks')->with('error', lang('App.taskNotFound'));
        }

        if (! $this->validate(['description' => 'required|max_length[255]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new TaskModel())->update($id, [
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/tasks/' . $id)->with('message', lang('App.taskUpdated'));
    }

    public function delete(int $id)
    {
        if ($this->tareaDelUsuario($id)) {
            (new TaskModel())->delete($id);
        }

        return redirect()->to('/tasks')->with('message', lang('App.taskDeleted'));
    }
}
