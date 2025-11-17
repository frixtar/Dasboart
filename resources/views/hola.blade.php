<h1>Hola desde Blade!</h1>
<p>Esta es una vista renderizada usando el motor de plantillas Blade de Laravel.</p>
<p>¡Bienvenido a Laravel!</p>
<p>Fecha actual: {{ date('d/m/Y') }}</p>
<h2>Iniciar sesion</h2>

<form method="POST" action="/login">
    @csrf
    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Iniciar Sesión</button>