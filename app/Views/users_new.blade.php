@extends('layout')

@section('contenido')
    <h1>{{ lang('App.newUser') }}</h1>

    <a href="/users">&lt;&lt; {{ lang('App.backToIndex') }}</a>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/users" method="post">
        {!! csrf_field() !!}

        <label for="name">{{ lang('App.name') }}</label><br>
        <input type="text" id="name" name="name" value="{{ old('name') }}"><br>

        <label for="email">{{ lang('App.email') }}</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}"><br>

        <label for="password">{{ lang('App.password') }}</label><br>
        <input type="password" id="password" name="password"><br>

        <label for="password_confirm">{{ lang('App.repeatPassword') }}</label><br>
        <input type="password" id="password_confirm" name="password_confirm"><br><br>

        <button type="submit">{{ lang('App.save') }}</button>
        <a href="/users">{{ lang('App.cancel') }}</a>
    </form>
@endsection