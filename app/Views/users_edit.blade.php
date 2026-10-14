@extends('layout')

@section('contenido')
    <h1>Edit user</h1>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/users/{{ $usuario['id'] }}/edit" method="post">
        {!! csrf_field() !!}

        <label for="name">Name</label><br>
        <input type="text" id="name" name="name" value="{{ old('name', $usuario['name']) }}"><br>

        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" value="{{ old('email', $usuario['email']) }}"><br>

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password"><br>

        <label for="password_confirm">Repeat password</label><br>
        <input type="password" id="password_confirm" name="password_confirm"><br><br>

        <label><input type="checkbox" name="active" value="1" {{ $usuario['active'] ? 'checked' : '' }}> Active</label><br>
        <label><input type="checkbox" name="administrator" value="1" {{ $usuario['administrator'] ? 'checked' : '' }}> Administrator</label><br><br>

        <button type="submit">Save</button>
        <a href="/users/{{ $usuario['id'] }}">Cancel</a>
    </form>
@endsection