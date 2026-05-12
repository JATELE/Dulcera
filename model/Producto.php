<?php

require_once __DIR__ . '/../config/Database.php';

class Producto
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->conectar();
    }

    public function listar(): array
    {
        $sql = "SELECT * FROM producto_regional ORDER BY id_producto DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $idProducto): ?array
    {
        $sql = "SELECT * FROM producto_regional WHERE id_producto = :id_producto LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id_producto' => $idProducto
        ]);

        $producto = $stmt->fetch();

        return $producto ?: null;
    }

    public function registrar(array $datos): int
    {
        $sql = "INSERT INTO producto_regional (
                    nombre_producto,
                    categoria,
                    region_origen,
                    precio,
                    stock,
                    descripcion
                ) VALUES (
                    :nombre_producto,
                    :categoria,
                    :region_origen,
                    :precio,
                    :stock,
                    :descripcion
                )";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'nombre_producto' => $datos['nombre_producto'],
            'categoria' => $datos['categoria'],
            'region_origen' => $datos['region_origen'],
            'precio' => $datos['precio'],
            'stock' => $datos['stock'],
            'descripcion' => $datos['descripcion']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function actualizar(int $idProducto, array $datos): bool
    {
        $sql = "UPDATE producto_regional SET
                    nombre_producto = :nombre_producto,
                    categoria = :categoria,
                    region_origen = :region_origen,
                    precio = :precio,
                    stock = :stock,
                    descripcion = :descripcion
                WHERE id_producto = :id_producto";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nombre_producto' => $datos['nombre_producto'],
            'categoria' => $datos['categoria'],
            'region_origen' => $datos['region_origen'],
            'precio' => $datos['precio'],
            'stock' => $datos['stock'],
            'descripcion' => $datos['descripcion'],
            'id_producto' => $idProducto
        ]);
    }

    public function eliminar(int $idProducto): bool
    {
        $sql = "DELETE FROM producto_regional WHERE id_producto = :id_producto";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id_producto' => $idProducto
        ]);
    }
}