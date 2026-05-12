<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../controller/PedidoController.php';

$controller = new PedidoController();

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

$pedidoEditar = null;

if (isset($_GET['editar'])) {
    $pedidoEditar = $controller->obtenerPorId((int)$_GET['editar']);
}

$clientes = $controller->listarClientes();
$productos = $controller->listarProductos();
$pedidos = $controller->listar();

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
    <title>Pedidos | Dulcera Doña Solina</title>

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
                    <h1>Pedidos 🧾</h1>
                    <p>Registra y administra los pedidos de productos regionales.</p>
                </div>
            </div>

            <?php if ($mensaje !== ''): ?>
                <div class="alert <?= $tipoMensaje === 'success' ? 'alert-success' : 'alert-error' ?>">
                    <?= h($mensaje) ?>
                </div>
            <?php endif; ?>

            <form class="form-premium" method="POST" action="pedido.php">

                <input type="hidden" name="accion" value="<?= $pedidoEditar ? 'actualizar' : 'registrar' ?>">
                <input type="hidden" name="idPedido" value="<?= h($pedidoEditar['id_pedido'] ?? '') ?>">

                <div class="form-grid">

                    <select name="idCliente" required>
                        <option value="">Seleccione cliente</option>

                        <?php foreach ($clientes as $cliente): ?>
                            <option 
                                value="<?= h($cliente['id_cliente']) ?>"
                                <?= (($pedidoEditar['id_cliente'] ?? '') == $cliente['id_cliente']) ? 'selected' : '' ?>>
                                <?= h($cliente['nombre'] . ' ' . $cliente['apellido']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="idProducto" required>
                        <option value="">Seleccione producto</option>

                        <?php foreach ($productos as $producto): ?>
                            <option 
                                value="<?= h($producto['id_producto']) ?>"
                                data-precio="<?= h($producto['precio']) ?>"
                                <?= (($pedidoEditar['id_producto'] ?? '') == $producto['id_producto']) ? 'selected' : '' ?>>
                                <?= h($producto['nombre_producto']) ?> - S/ <?= h(number_format((float)$producto['precio'], 2)) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <input 
                        type="number" 
                        name="txtCantidad" 
                        id="txtCantidad"
                        placeholder="Cantidad"
                        min="1"
                        required
                        value="<?= h($pedidoEditar['cantidad'] ?? '') ?>"
                    >

                    <input 
                        type="number" 
                        step="0.01"
                        name="txtTotal" 
                        id="txtTotal"
                        placeholder="Total"
                        required
                        value="<?= h($pedidoEditar['total'] ?? '') ?>"
                    >

                    <select name="txtEstadoPedido" required>
                        <option value="PENDIENTE" <?= (($pedidoEditar['estado_pedido'] ?? '') === 'PENDIENTE') ? 'selected' : '' ?>>PENDIENTE</option>
                        <option value="COMPLETADO" <?= (($pedidoEditar['estado_pedido'] ?? '') === 'COMPLETADO') ? 'selected' : '' ?>>COMPLETADO</option>
                        <option value="CANCELADO" <?= (($pedidoEditar['estado_pedido'] ?? '') === 'CANCELADO') ? 'selected' : '' ?>>CANCELADO</option>
                    </select>

                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <?= $pedidoEditar ? 'Actualizar Pedido' : '+ Registrar Pedido' ?>
                    </button>

                    <?php if ($pedidoEditar): ?>
                        <a class="btn-cancel" href="pedido.php">Cancelar</a>
                    <?php endif; ?>
                </div>

            </form>

            <div class="table-wrapper">

                <table class="premium-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (count($pedidos) > 0): ?>

                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td><?= h($pedido['id_pedido']) ?></td>
                                    <td><?= h($pedido['nombre_cliente'] . ' ' . $pedido['apellido_cliente']) ?></td>
                                    <td><?= h($pedido['nombre_producto']) ?></td>
                                    <td><?= h($pedido['cantidad']) ?></td>
                                    <td>S/ <?= h(number_format((float)$pedido['total'], 2)) ?></td>
                                    <td><?= h($pedido['estado_pedido']) ?></td>
                                    <td><?= h($pedido['fecha_pedido']) ?></td>

                                    <td>
                                        <a class="btn-edit" href="pedido.php?editar=<?= h($pedido['id_pedido']) ?>">
                                            Editar
                                        </a>

                                        <a
                                            class="btn-delete"
                                            href="pedido.php?eliminar=<?= h($pedido['id_pedido']) ?>"
                                            onclick="return confirm('¿Seguro que deseas eliminar este pedido?');">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="8" style="text-align:center;">
                                    No hay pedidos registrados.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <script>
        const productoSelect = document.querySelector('select[name="idProducto"]');
        const cantidadInput = document.getElementById('txtCantidad');
        const totalInput = document.getElementById('txtTotal');

        function calcularTotal() {
            const option = productoSelect.options[productoSelect.selectedIndex];
            const precio = parseFloat(option.getAttribute('data-precio') || 0);
            const cantidad = parseInt(cantidadInput.value || 0);

            if (precio > 0 && cantidad > 0) {
                totalInput.value = (precio * cantidad).toFixed(2);
            }
        }

        productoSelect.addEventListener('change', calcularTotal);
        cantidadInput.addEventListener('input', calcularTotal);
    </script>

</body>
</html>