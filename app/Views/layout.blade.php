<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Organizador de tareas</title>
</head>
<body>
<nav>
    <a href="/">Home</a>
    <a href="#">English</a>
    <a href="#">Español</a>

    @if (session('logged_in'))
        <span>Hello, {{ session('user_name') }}</span>
        <a href="profile">Profile</a>
        @if (session('administrator'))
            <a href="#">Users</a>
        @endif
        <a href="/tasks">Tasks</a>
        <a href="/logout">Log out</a>
    @else
        <a href="/signup">Sign up</a>
        <a href="/login">Log in</a>
    @endif
</nav>

<main>
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif

    @yield('contenido')
</main>