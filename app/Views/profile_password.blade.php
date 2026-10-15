@extends('layout')

@section('contenido')
    <h1>{{ lang('App.editPassword') }}</h1>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/profile/password" method="post">
        {!! csrf_field() !!}

        <label for="current_password">{{ lang('App.currentPassword') }}</label><br>
        <input type="password" id="current_password" name="current_password"><br>

        <label for="new_password">{{ lang('App.newPassword') }}</label><br>
        <input type="password" id="new_password" name="new_password"><br>

        <label for="new_password_confirm">{{ lang('App.repeatNewPassword') }}</label><br>
        <input type="password" id="new_password_confirm" name="new_password_confirm"><br><br>

        <button type="submit">{{ lang('App.save') }}</button>
        <a href="/profile">{{ lang('App.cancel') }}</a>
    </form>
@endsection