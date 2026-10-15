<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Organizador de tareas</title>
</head>
<body>
<nav>
    <a href="/">{{ lang('App.home') }}</a>
    <a href="/lang/en">English</a>
    <a href="/lang/es">Español</a>

    @if (session('logged_in'))
        <span>{{ lang('App.hello') }}, {{ session('user_name') }}</span>
        <a href="/profile">{{ lang('App.profile') }}</a>
        @if (session('administrator'))
            <a href="/users">{{ lang('App.users') }}</a>
        @endif
        <a href="/tasks">{{ lang('App.tasks') }}</a>
        <a href="/logout">{{ lang('App.logout') }}</a>
    @else
        <a href="/signup">{{ lang('App.signup') }}</a>
        <a href="/login">{{ lang('App.login') }}</a>
    @endif
</nav>
<main>
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif

   @if (session('error'))

   <p>{{ session('error') }}</p>
   @endif

   @yield('contenido')
</main>