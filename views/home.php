<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$nombreUsuario = htmlspecialchars(($usuario['nombre'] ?? 'Usuario') . ' ' . ($usuario['apellido'] ?? ''), ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Dulcera Doña Solina</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../imagenes/dulces.png">
</head>

<body class="home-page">

    <div class="navbar dulcera-navbar">

        <div class="navbar-logo">
            <img src="../imagenes/dulces.png" alt="Logo">
            <span>Dulcera Doña Solina</span>
        </div>

        <div class="navbar-links">
            <a href="home.php">Inicio</a>
            <a href="cliente.php">Clientes</a>
            <a href="producto.php">Productos</a>
            <a href="pedido.php">Pedidos</a>
            <a class="btn-salir" href="../controller/UsuarioController.php?accion=logout">Salir</a>
        </div>

    </div>

    <main class="home-dulcera">

        <section class="hero-home">

            <div class="hero-text">
                <span class="badge-home">Panel administrativo</span>

                <h1>
                    Bienvenido a Dulcera Doña Solina 🍯
                </h1>

                <p>
                    Gestiona clientes, productos regionales y pedidos desde un solo lugar.
                </p>

                <div class="usuario-box">
                    Sesión iniciada como: <strong><?= $nombreUsuario ?></strong>
                </div>
            </div>

            <div class="hero-logo">
                <img src="../imagenes/dulces.png" alt="Dulcera Doña Solina">
            </div>

        </section>

        <section class="home-grid">

            <a href="cliente.php" class="home-option">
                <div class="icon-home">👥</div>
                <h3>Clientes</h3>
                <p>Registra y consulta compradores.</p>
            </a>

            <a href="producto.php" class="home-option">
                <div class="icon-home">🍫</div>
                <h3>Productos</h3>
                <p>Administra café, cacao, miel y artesanías.</p>
            </a>

            <a href="pedido.php" class="home-option">
                <div class="icon-home">🧾</div>
                <h3>Pedidos</h3>
                <p>Controla cantidades, totales y estados.</p>
            </a>

        </section>

    </main>

</body>
</html>