@extends('layout')

@section('contenido')
    <h1>{{ lang('App.editUser') }}</h1>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/users/{{ $usuario['id'] }}/edit" method="post">
        {!! csrf_field() !!}

        <label for="name">{{ lang('App.name') }}</label><br>
        <input type="text" id="name" name="name" value="{{ old('name', $usuario['name']) }}"><br>

        <label for="email">{{ lang('App.email') }}</label><br>
        <input type="email" id="email" name="email" value="{{ old('email', $usuario['email']) }}"><br>

        <label for="password">{{ lang('App.password') }}</label><br>
        <input type="password" id="password" name="password"><br>

        <label for="password_confirm">{{ lang('App.repeatPassword') }}</label><br>
        <input type="password" id="password_confirm" name="password_confirm"><br><br>

        <label><input type="checkbox" name="active" value="1" {{ $usuario['active'] ? 'checked' : '' }}> {{ lang('App.active') }}</label><br>
        <label><input type="checkbox" name="administrator" value="1" {{ $usuario['administrator'] ? 'checked' : '' }}> {{ lang('App.administrator') }}</label><br><br>

        <button type="submit">{{ lang('App.save') }}</button>
        <a href="/users/{{ $usuario['id'] }}">{{ lang('App.cancel') }}</a>
    </form>
@endsection