<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../controller/ProductoController.php';

$controller = new ProductoController();

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

$productoEditar = null;

if (isset($_GET['editar'])) {
    $productoEditar = $controller->obtenerPorId((int)$_GET['editar']);
}

$productos = $controller->listar();

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
    <title>Productos | Dulcera Doña Solina</title>

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
                    <h1>Productos 🍫</h1>
                    <p>Administra los productos regionales de la dulcera.</p>
                </div>
            </div>

            <?php if ($mensaje !== ''): ?>
                <div class="alert <?= $tipoMensaje === 'success' ? 'alert-success' : 'alert-error' ?>">
                    <?= h($mensaje) ?>
                </div>
            <?php endif; ?>

            <form class="form-premium" method="POST" action="producto.php">

                <input type="hidden" name="accion" value="<?= $productoEditar ? 'actualizar' : 'registrar' ?>">
                <input type="hidden" name="idProducto" value="<?= h($productoEditar['id_producto'] ?? '') ?>">

                <div class="form-grid">
                    <input type="text" name="txtNombreProducto" placeholder="Nombre del producto" required value="<?= h($productoEditar['nombre_producto'] ?? '') ?>">

                    <input type="text" name="txtCategoria" placeholder="Categoría" required value="<?= h($productoEditar['categoria'] ?? '') ?>">

                    <input type="text" name="txtRegionOrigen" placeholder="Región de origen" required value="<?= h($productoEditar['region_origen'] ?? '') ?>">

                    <input type="number" step="0.01" name="txtPrecio" placeholder="Precio" required value="<?= h($productoEditar['precio'] ?? '') ?>">

                    <input type="number" name="txtStock" placeholder="Stock" required value="<?= h($productoEditar['stock'] ?? '') ?>">

                    <input type="text" name="txtDescripcion" placeholder="Descripción" value="<?= h($productoEditar['descripcion'] ?? '') ?>">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <?= $productoEditar ? 'Actualizar Producto' : '+ Registrar Producto' ?>
                    </button>

                    <?php if ($productoEditar): ?>
                        <a class="btn-cancel" href="producto.php">Cancelar</a>
                    <?php endif; ?>
                </div>

            </form>

            <div class="table-wrapper">

                <table class="premium-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Región</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (count($productos) > 0): ?>

                            <?php foreach ($productos as $producto): ?>
                                <tr>
                                    <td><?= h($producto['id_producto']) ?></td>
                                    <td><?= h($producto['nombre_producto']) ?></td>
                                    <td><?= h($producto['categoria']) ?></td>
                                    <td><?= h($producto['region_origen']) ?></td>
                                    <td>S/ <?= h(number_format((float)$producto['precio'], 2)) ?></td>
                                    <td><?= h($producto['stock']) ?></td>

                                    <td>
                                        <a class="btn-edit" href="producto.php?editar=<?= h($producto['id_producto']) ?>">
                                            Editar
                                        </a>

                                        <a
                                            class="btn-delete"
                                            href="producto.php?eliminar=<?= h($producto['id_producto']) ?>"
                                            onclick="return confirm('¿Seguro que deseas eliminar este producto?');">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="7" style="text-align:center;">
                                    No hay productos registrados.
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