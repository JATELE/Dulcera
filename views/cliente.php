<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../controller/ClienteController.php';

$controller = new ClienteController();

$mensaje = '';
$tipoMensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $accion = $_POST['accion'] ?? '';

    if ($accion === 'registrar') {
        $respuesta = $controller->registrar($_POST);
    } elseif ($accion === 'actualizar') {
        $respuesta = $controller->actualizar($_POST);
    }

    if (isset($respuesta)) {
        $mensaje = $respuesta['mensaje'];
        $tipoMensaje = $respuesta['ok'] ? 'success' : 'error';
    }
}

if (isset($_GET['eliminar'])) {
    $respuesta = $controller->eliminar((int)$_GET['eliminar']);
    $mensaje = $respuesta['mensaje'];
    $tipoMensaje = $respuesta['ok'] ? 'success' : 'error';
}

$clienteEditar = null;

if (isset($_GET['editar'])) {
    $clienteEditar = $controller->obtenerPorId((int)$_GET['editar']);
}

$clientes = $controller->listar();

function h($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes | Dulcera Doña Solina</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../imagenes/dulces.png">
</head>

<body class="home-page">

    <div class="navbar dulcera-navbar">

        <div class="navbar-logo">
            <img src="../imagenes/dulces.png" alt="">
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

    <div class="page-container">

        <div class="page-card premium-card">

            <div class="page-header premium-header">
                <div>
                    <span class="badge-home">Gestión</span>
                    <h1>Clientes 👥</h1>
                    <p>Administra los compradores registrados del sistema.</p>
                </div>
            </div>

            <?php if ($mensaje !== ''): ?>
                <div class="alert <?= $tipoMensaje === 'success' ? 'alert-success' : 'alert-error' ?>">
                    <?= h($mensaje) ?>
                </div>
            <?php endif; ?>

            <form class="form-premium" method="POST" action="cliente.php">

                <input type="hidden" name="accion" value="<?= $clienteEditar ? 'actualizar' : 'registrar' ?>">
                <input type="hidden" name="idCliente" value="<?= h($clienteEditar['id_cliente'] ?? '') ?>">

                <div class="form-grid">
                    <input type="text" name="txtNombre" placeholder="Nombre" required value="<?= h($clienteEditar['nombre'] ?? '') ?>">

                    <input type="text" name="txtApellido" placeholder="Apellido" required value="<?= h($clienteEditar['apellido'] ?? '') ?>">

                    <input type="email" name="txtCorreo" placeholder="Correo" required value="<?= h($clienteEditar['correo'] ?? '') ?>">

                    <input type="text" name="txtDni" placeholder="DNI" maxlength="8" value="<?= h($clienteEditar['dni'] ?? $clienteEditar['DNI'] ?? '') ?>">

                    <input type="text" name="txtTelefono" placeholder="Teléfono" required value="<?= h($clienteEditar['telefono'] ?? '') ?>">

                    <input type="text" name="txtDireccion" placeholder="Dirección" value="<?= h($clienteEditar['direccion'] ?? '') ?>">

                    <input type="number" name="txtEdad" placeholder="Edad" value="<?= h($clienteEditar['edad'] ?? '') ?>">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <?= $clienteEditar ? 'Actualizar Cliente' : '+ Registrar Cliente' ?>
                    </button>

                    <?php if ($clienteEditar): ?>
                        <a class="btn-cancel" href="cliente.php">Cancelar</a>
                    <?php endif; ?>
                </div>

            </form>

            <div class="table-wrapper">

                <table class="premium-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre completo</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Edad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (count($clientes) > 0): ?>

                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?= h($cliente['id_cliente']) ?></td>
                                    <td><?= h($cliente['nombre'] . ' ' . $cliente['apellido']) ?></td>
                                    <td><?= h($cliente['dni'] ?? $cliente['DNI'] ?? '') ?></td>
                                    <td><?= h($cliente['telefono']) ?></td>
                                    <td><?= h($cliente['correo']) ?></td>
                                    <td><?= h($cliente['edad']) ?></td>

                                    <td>
                                        <a class="btn-edit" href="cliente.php?editar=<?= h($cliente['id_cliente']) ?>">
                                            Editar
                                        </a>

                                        <a
                                            class="btn-delete"
                                            href="cliente.php?eliminar=<?= h($cliente['id_cliente']) ?>"
                                            onclick="return confirm('¿Seguro que deseas eliminar este cliente?');">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="7" style="text-align:center;">
                                    No hay clientes registrados.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>
</html>