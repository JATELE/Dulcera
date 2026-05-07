<?php

session_start();

$error = $_SESSION['error_login'] ?? '';

unset($_SESSION['error_login']);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="index, follow">
    <meta name="description" content="Agenda de contactos">
    <meta name="keywords" content="agenda, contactos, organizacion">
    <meta name="author" content="JSON">

    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="icon" href="../imagenes/icono.png">

    <title>Agenda Pro</title>

</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <div class="logo">
                <img src="../imagenes/icono.png" alt="">
            </div>

            <h1>
                Agenda Pro
            </h1>

            <p class="subtitulo">
                Sistema básico de agenda de contactos
            </p>

            <?php if (!empty($error)): ?>

                <div class="error">
                    <?= $error ?>
                </div>

            <?php endif; ?>

            <form 
                method="POST" 
                action="../controller/UsuarioController.php?accion=login"
            >

                <div class="input-group">

                    <label>
                        Correo
                    </label>

                    <input 
                        type="email"
                        name="correo"
                        placeholder="Ingrese correo"
                        required
                    >

                </div>

                <div class="input-group">

                    <label>
                        Contraseña
                    </label>

                    <input 
                        type="password"
                        name="clave"
                        placeholder="Ingrese contraseña"
                        required
                    >

                </div>

                <button type="submit">
                    Ingresar
                </button>

            </form>

        </div>

    </div>

</body>

</html>