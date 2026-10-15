@extends('layout')

@section('contenido')
    <h1>{{ lang('App.task') }}</h1>

    <a href="/tasks">&lt;&lt; {{ lang('App.backToIndex') }}</a>

    <p><strong>ID</strong><br>{{ $tarea['id'] }}</p>
    <p><strong>{{ lang('App.description') }}</strong><br>{{ $tarea['description'] }}</p>
    <p><strong>{{ lang('App.createdAt') }}</strong><br>{{ $tarea['created_at'] }}</p>
    <p><strong>{{ lang('App.updatedAt') }}</strong><br>{{ $tarea['updated_at'] }}</p>

    <a href="/tasks/{{ $tarea['id'] }}/edit">{{ lang('App.edit') }}</a>

    <form action="/tasks/{{ $tarea['id'] }}/delete" method="post"
          onsubmit="return confirm('{{ lang('App.areYouSure') }}');">
        {!! csrf_field() !!}
        <button type="submit">{{ lang('App.delete') }}</button>
    </form>
@endsection