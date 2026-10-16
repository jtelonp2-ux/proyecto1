@extends('layout')

@section('contenido')
    <h1>Password reset</h1>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/reset-password/{{ $token }}" method="post">
        {!! csrf_field() !!}

        <label for="password">{{ lang('App.newPassword') }}</label><br>
        <input type="password" id="password" name="password"><br>

        <label for="password_confirm">{{ lang('App.repeatNewPassword') }}</label><br>
        <input type="password" id="password_confirm" name="password_confirm"><br><br>

        <button type="submit">Reset password</button>
    </form>
@endsection