@extends('layout')

@section('contenido')
    <h1>{{ lang('App.users') }}</h1>

    <a href="/users/new">{{ lang('App.newUser') }}</a>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>{{ lang('App.name') }}</th>
                <th>{{ lang('App.email') }}</th>
                <th>{{ lang('App.active') }}</th>
                <th>{{ lang('App.administrator') }}</th>
                <th>{{ lang('App.createdAt') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $u)
                <tr>
                    <td><a href="/users/{{ $u['id'] }}">{{ $u['name'] }}</a></td>
                    <td>{{ $u['email'] }}</td>
                    <td>{{ $u['active'] ? lang('App.yes') : lang('App.no') }}</td>
                    <td>{{ $u['administrator'] ? lang('App.yes') : lang('App.no') }}</td>
                    <td>{{ $u['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $pager->links() !!}
@endsection