@extends('layout')

@section('contenido')
    <h1>{{ lang('App.editProfile') }}</h1>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/profile/edit" method="post">
        {!! csrf_field() !!}

        <label for="name">{{ lang('App.name') }}</label><br>
        <input type="text" id="name" name="name" value="{{ old('name', $usuario['name']) }}"><br>

        <label for="email">{{ lang('App.email') }}</label><br>
        <input type="email" id="email" name="email" value="{{ old('email', $usuario['email']) }}"><br><br>

        <button type="submit">{{ lang('App.save') }}</button>
        <a href="/profile">{{ lang('App.cancel') }}</a>
    </form>
@endsection