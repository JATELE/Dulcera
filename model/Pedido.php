<?php

require_once __DIR__ . '/../config/Database.php';

class Pedido
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->conectar();
    }

    public function listar(): array
    {
        $sql = "SELECT 
                    p.*,
                    c.nombre AS nombre_cliente,
                    c.apellido AS apellido_cliente,
                    pr.nombre_producto
                FROM pedido p
                INNER JOIN cliente c ON p.id_cliente = c.id_cliente
                INNER JOIN producto_regional pr ON p.id_producto = pr.id_producto
                ORDER BY p.id_pedido DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $idPedido): ?array
    {
        $sql = "SELECT * FROM pedido WHERE id_pedido = :id_pedido LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id_pedido' => $idPedido
        ]);

        $pedido = $stmt->fetch();

        return $pedido ?: null;
    }

    public function registrar(array $datos): int
    {
        $sql = "INSERT INTO pedido (
                    id_cliente,
                    id_producto,
                    cantidad,
                    total,
                    estado_pedido
                ) VALUES (
                    :id_cliente,
                    :id_producto,
                    :cantidad,
                    :total,
                    :estado_pedido
                )";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id_cliente' => $datos['id_cliente'],
            'id_producto' => $datos['id_producto'],
            'cantidad' => $datos['cantidad'],
            'total' => $datos['total'],
            'estado_pedido' => $datos['estado_pedido']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function actualizar(int $idPedido, array $datos): bool
    {
        $sql = "UPDATE pedido SET
                    id_cliente = :id_cliente,
                    id_producto = :id_producto,
                    cantidad = :cantidad,
                    total = :total,
                    estado_pedido = :estado_pedido
                WHERE id_pedido = :id_pedido";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id_cliente' => $datos['id_cliente'],
            'id_producto' => $datos['id_producto'],
            'cantidad' => $datos['cantidad'],
            'total' => $datos['total'],
            'estado_pedido' => $datos['estado_pedido'],
            'id_pedido' => $idPedido
        ]);
    }

    public function eliminar(int $idPedido): bool
    {
        $sql = "DELETE FROM pedido WHERE id_pedido = :id_pedido";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id_pedido' => $idPedido
        ]);
    }
}