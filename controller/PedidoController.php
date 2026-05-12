<?php

require_once __DIR__ . '/../model/Pedido.php';
require_once __DIR__ . '/../model/Cliente.php';
require_once __DIR__ . '/../model/Producto.php';

class PedidoController
{
    public function listar(): array
    {
        $pedidoModel = new Pedido();
        return $pedidoModel->listar();
    }

    public function obtenerPorId(int $idPedido): ?array
    {
        $pedidoModel = new Pedido();
        return $pedidoModel->obtenerPorId($idPedido);
    }

    public function listarClientes(): array
    {
        $clienteModel = new Cliente();
        return $clienteModel->listar();
    }

    public function listarProductos(): array
    {
        $productoModel = new Producto();
        return $productoModel->listar();
    }

    public function registrar(array $post): array
    {
        $validacion = $this->validarDatos($post);

        if (!$validacion['ok']) {
            return $validacion;
        }

        try {
            $pedidoModel = new Pedido();
            $idPedido = $pedidoModel->registrar($validacion['datos']);

            if ($idPedido > 0) {
                return [
                    'ok' => true,
                    'mensaje' => 'Pedido registrado correctamente'
                ];
            }

            return [
                'ok' => false,
                'mensaje' => 'No se pudo registrar el pedido'
            ];

        } catch (PDOException $e) {
            return [
                'ok' => false,
                'mensaje' => 'Error al registrar el pedido'
            ];
        }
    }

    public function actualizar(array $post): array
    {
        $idPedido = (int)($post['idPedido'] ?? 0);

        if ($idPedido <= 0) {
            return [
                'ok' => false,
                'mensaje' => 'Pedido no válido'
            ];
        }

        $validacion = $this->validarDatos($post);

        if (!$validacion['ok']) {
            return $validacion;
        }

        try {
            $pedidoModel = new Pedido();
            $actualizado = $pedidoModel->actualizar($idPedido, $validacion['datos']);

            if ($actualizado) {
                return [
                    'ok' => true,
                    'mensaje' => 'Pedido actualizado correctamente'
                ];
            }

            return [
                'ok' => false,
                'mensaje' => 'No se pudo actualizar el pedido'
            ];

        } catch (PDOException $e) {
            return [
                'ok' => false,
                'mensaje' => 'Error al actualizar el pedido'
            ];
        }
    }

    public function eliminar(int $idPedido): array
    {
        if ($idPedido <= 0) {
            return [
                'ok' => false,
                'mensaje' => 'Pedido no válido'
            ];
        }

        try {
            $pedidoModel = new Pedido();
            $eliminado = $pedidoModel->eliminar($idPedido);

            if ($eliminado) {
                return [
                    'ok' => true,
                    'mensaje' => 'Pedido eliminado correctamente'
                ];
            }

            return [
                'ok' => false,
                'mensaje' => 'No se pudo eliminar el pedido'
            ];

        } catch (PDOException $e) {
            return [
                'ok' => false,
                'mensaje' => 'Error al eliminar el pedido'
            ];
        }
    }

    private function validarDatos(array $post): array
    {
        $idCliente = (int)($post['idCliente'] ?? 0);
        $idProducto = (int)($post['idProducto'] ?? 0);
        $cantidad = trim($post['txtCantidad'] ?? '');
        $total = trim($post['txtTotal'] ?? '');
        $estado = trim($post['txtEstadoPedido'] ?? 'PENDIENTE');

        if ($idCliente <= 0 || $idProducto <= 0 || $cantidad === '' || $total === '') {
            return [
                'ok' => false,
                'mensaje' => 'Complete los campos obligatorios'
            ];
        }

        if (!ctype_digit($cantidad) || (int)$cantidad <= 0) {
            return [
                'ok' => false,
                'mensaje' => 'Ingrese una cantidad válida'
            ];
        }

        if (!is_numeric($total) || (float)$total <= 0) {
            return [
                'ok' => false,
                'mensaje' => 'Ingrese un total válido'
            ];
        }

        $estadosPermitidos = ['PENDIENTE', 'COMPLETADO', 'CANCELADO'];

        if (!in_array($estado, $estadosPermitidos)) {
            $estado = 'PENDIENTE';
        }

        return [
            'ok' => true,
            'datos' => [
                'id_cliente' => $idCliente,
                'id_producto' => $idProducto,
                'cantidad' => (int)$cantidad,
                'total' => (float)$total,
                'estado_pedido' => $estado
            ]
        ];
    }
}