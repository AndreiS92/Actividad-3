<?php
require_once "config.php";
session_start();

// Redirigir al usuario a home.php si ya ha iniciado sesión
if (isset($_SESSION["username"])) {
    header("location:home.php");
    exit();
}


if (isset($_POST["register"])) {
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $confirm_password = mysqli_real_escape_string($connection, $_POST["confirm_password"]);

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";

        if (mysqli_query($connection, $query)) {
            echo '<script>alert("Registro exitoso! Por favor inicia sesión.");</script>';
        } else {

            echo '<script>alert("Error al registrar el usuario: ' . mysqli_error($connection) . '");</script>';
        }
    } else {
        echo '<script>alert("Las contraseñas no coinciden.");</script>';
    }
}


// Login de usuario
if (isset($_POST["login"])) {
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $password = $_POST["password"];

    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username;
            header("location:home.php");
            exit();
        } else {
            echo '<script>alert("Contraseña incorrecta!");</script>';
        }
    } else {
        echo '<script>alert("Usuario no encontrado.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login y Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <?php if (isset($_GET["action"]) && $_GET["action"] == "register"): ?>
        <!-- Formulario de Registro -->
        <form method="post" class="p-4 border rounded bg-light" style="max-width: 400px; width: 100%;">
            <h3 class="text-center mb-4">Registro</h3>
            <input type="hidden" name="register" value="1" />
            <div class="form-outline mb-4">
                <input type="text" id="username" name="username" class="form-control" required />
                <label class="form-label" for="username">Username</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" id="password" name="password" class="form-control" required />
                <label class="form-label" for="password">Password</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required />
                <label class="form-label" for="confirm_password">Confirm Password</label>
            </div>
            <input type="submit" class="btn btn-primary btn-block mb-4 w-100" value="Registrar" />
            <p class="text-center">¿Ya tienes una cuenta? <a href="index.php">Inicia sesión</a></p>
        </form>
    <?php else: ?>
        <!-- Formulario de Login -->
        <form method="post" class="p-4 border rounded bg-light" style="max-width: 400px; width: 100%;">
            <h3 class="text-center mb-4">Login</h3>
            <input type="hidden" name="login" value="1" />
            <div class="form-outline mb-4">
                <input type="text" id="username" name="username" class="form-control" required />
                <label class="form-label" for="username">Username</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" id="password" name="password" class="form-control" required />
                <label class="form-label" for="password">Password</label>
            </div>
            <input type="submit" class="btn btn-primary btn-block mb-4 w-100" value="Login" />
            <p class="text-center">¿No tienes una cuenta? <a href="index.php?action=register">Regístrate</a></p>
        </form>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
