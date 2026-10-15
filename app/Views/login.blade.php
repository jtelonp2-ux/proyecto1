@extends('layout')

@section('contenido')
    <h1>{{ lang('App.login') }}</h1>

    <form action="/login" method="post">
        {!! csrf_field() !!}

        <label for="email">{{ lang('App.email') }}</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}"><br>

        <label for="password">{{ lang('App.password') }}</label><br>
        <input type="password" id="password" name="password"><br>

        <label>
            <input type="checkbox" name="remember" value="1"> {{ lang('App.rememberMe') }}
        </label><br><br>

        <button type="submit">{{ lang('App.login') }}</button>
        <a href="#">{{ lang('App.forgotPassword') }}</a>
    </form>
@endsection