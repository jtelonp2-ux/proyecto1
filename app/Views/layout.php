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
        <a href="/signup">Sign up</a>
        <a href="/login">Log in</a>
    </nav>

    <main>
        <?= $this->renderSection('contenido') ?>
    </main>
</body>
</html>
