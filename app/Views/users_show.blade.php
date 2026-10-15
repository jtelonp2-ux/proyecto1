@extends('layout')

@section('contenido')
    <h1>{{ lang('App.user') }}</h1>

    <a href="/users">&lt;&lt; {{ lang('App.backToIndex') }}</a>

    <p><strong>{{ lang('App.name') }}</strong><br>{{ $usuario['name'] }}</p>
    <p><strong>{{ lang('App.email') }}</strong><br>{{ $usuario['email'] }}</p>
    <p><strong>{{ lang('App.active') }}</strong><br>{{ $usuario['active'] ? lang('App.yes') : lang('App.no') }}</p>
    <p><strong>{{ lang('App.administrator') }}</strong><br>{{ $usuario['administrator'] ? lang('App.yes') : lang('App.no') }}</p>
    <p><strong>{{ lang('App.createdAt') }}</strong><br>{{ $usuario['created_at'] }}</p>
    <p><strong>{{ lang('App.updatedAt') }}</strong><br>{{ $usuario['updated_at'] }}</p>

    <a href="/users/{{ $usuario['id'] }}/edit">{{ lang('App.edit') }}</a>

    <form action="/users/{{ $usuario['id'] }}/delete" method="post"
          onsubmit="return confirm('{{ lang('App.areYouSure') }}');">
        {!! csrf_field() !!}
        <button type="submit">{{ lang('App.delete') }}</button>
    </form>
@endsection