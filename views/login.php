<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: home.php');
    exit;
}

$error = $_SESSION['error_login'] ?? '';
unset($_SESSION['error_login']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Dulcera Doña Solina</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../imagenes/dulces.png">
</head>

<body class="login-page">

    <div class="login-container">

        <div class="login-wrapper">

            <div class="login-banner">
                <div class="overlay"></div>
            </div>

            <div class="login-card">

                <h1>HELLO!</h1>

                <p class="subtitulo">
                    Inicia sesión para ingresar al sistema
                </p>

                <?php if (!empty($error)): ?>
                    <div class="error">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="../controller/UsuarioController.php?accion=login">

                    <div class="input-group">
                        <input type="email" name="correo" placeholder="Correo electrónico" required>
                    </div>

                    <div class="input-group">
                        <input type="password" name="clave" id="clave" placeholder="Contraseña" required>
                    </div>

                    <div class="show-password">
                        <label>
                            <input type="checkbox" onclick="togglePassword()">
                            Mostrar contraseña
                        </label>
                    </div>

                    <div class="login-options">
                        <label>
                            <input type="checkbox" name="remember">
                            Remember
                        </label>

                        <a href="#">
                            Forgot your password?
                        </a>
                    </div>

                    <button type="submit">
                        NEXT →
                    </button>

                    <a class="create-account" href="#">
                        Create account
                    </a>

                </form>

            </div>



        </div>
        <div class="credit-login">
            designed by Jatele
        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById("clave");

            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>

</body>

</html>