@extends('layout')

@section('contenido')
    <h1>Users</h1>

    <a href="/users/new">New user</a>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Active</th>
                <th>Administrator</th>
                <th>Created at</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $u)
                <tr>
                    <td><a href="/users/{{ $u['id'] }}">{{ $u['name'] }}</a></td>
                    <td>{{ $u['email'] }}</td>
                    <td>{{ $u['active'] ? 'Sí' : 'No' }}</td>
                    <td>{{ $u['administrator'] ? 'Sí' : 'No' }}</td>
                    <td>{{ $u['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $pager->links() !!}
@endsection