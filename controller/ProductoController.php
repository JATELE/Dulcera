<?php

require_once __DIR__ . '/../model/Producto.php';

class ProductoController
{
    public function listar(): array
    {
        $productoModel = new Producto();
        return $productoModel->listar();
    }

    public function obtenerPorId(int $idProducto): ?array
    {
        $productoModel = new Producto();
        return $productoModel->obtenerPorId($idProducto);
    }

    public function registrar(array $post): array
    {
        $validacion = $this->validarDatos($post);

        if (!$validacion['ok']) {
            return $validacion;
        }

        try {
            $productoModel = new Producto();
            $idProducto = $productoModel->registrar($validacion['datos']);

            if ($idProducto > 0) {
                return [
                    'ok' => true,
                    'mensaje' => 'Producto registrado correctamente'
                ];
            }

            return [
                'ok' => false,
                'mensaje' => 'No se pudo registrar el producto'
            ];

        } catch (PDOException $e) {
            return [
                'ok' => false,
                'mensaje' => 'Error al registrar el producto'
            ];
        }
    }

    public function actualizar(array $post): array
    {
        $idProducto = (int)($post['idProducto'] ?? 0);

        if ($idProducto <= 0) {
            return [
                'ok' => false,
                'mensaje' => 'Producto no válido'
            ];
        }

        $validacion = $this->validarDatos($post);

        if (!$validacion['ok']) {
            return $validacion;
        }

        try {
            $productoModel = new Producto();
            $actualizado = $productoModel->actualizar($idProducto, $validacion['datos']);

            if ($actualizado) {
                return [
                    'ok' => true,
                    'mensaje' => 'Producto actualizado correctamente'
                ];
            }

            return [
                'ok' => false,
                'mensaje' => 'No se pudo actualizar el producto'
            ];

        } catch (PDOException $e) {
            return [
                'ok' => false,
                'mensaje' => 'Error al actualizar el producto'
            ];
        }
    }

    public function eliminar(int $idProducto): array
    {
        if ($idProducto <= 0) {
            return [
                'ok' => false,
                'mensaje' => 'Producto no válido'
            ];
        }

        try {
            $productoModel = new Producto();
            $eliminado = $productoModel->eliminar($idProducto);

            if ($eliminado) {
                return [
                    'ok' => true,
                    'mensaje' => 'Producto eliminado correctamente'
                ];
            }

            return [
                'ok' => false,
                'mensaje' => 'No se pudo eliminar el producto'
            ];

        } catch (PDOException $e) {
            return [
                'ok' => false,
                'mensaje' => 'No se puede eliminar el producto porque tiene pedidos relacionados'
            ];
        }
    }

    private function validarDatos(array $post): array
    {
        $nombre = trim($post['txtNombreProducto'] ?? '');
        $categoria = trim($post['txtCategoria'] ?? '');
        $region = trim($post['txtRegionOrigen'] ?? '');
        $precio = trim($post['txtPrecio'] ?? '');
        $stock = trim($post['txtStock'] ?? '');
        $descripcion = trim($post['txtDescripcion'] ?? '');

        if ($nombre === '' || $categoria === '' || $region === '' || $precio === '' || $stock === '') {
            return [
                'ok' => false,
                'mensaje' => 'Complete los campos obligatorios'
            ];
        }

        if (!is_numeric($precio) || $precio <= 0) {
            return [
                'ok' => false,
                'mensaje' => 'Ingrese un precio válido'
            ];
        }

        if (!ctype_digit($stock) || (int)$stock < 0) {
            return [
                'ok' => false,
                'mensaje' => 'Ingrese un stock válido'
            ];
        }

        return [
            'ok' => true,
            'datos' => [
                'nombre_producto' => $nombre,
                'categoria' => $categoria,
                'region_origen' => $region,
                'precio' => $precio,
                'stock' => $stock,
                'descripcion' => $descripcion
            ]
        ];
    }
}