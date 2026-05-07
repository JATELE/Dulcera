<?php

require_once __DIR__ . '/../config/database.php';

class Usuario {

    private PDO $db;

    public function __construct() {

        $conexion = new DataBase();

        $this->db = $conexion->conectar();

    }

    public function login(string $correo, string $clave): ?array {

        $sql = "SELECT * FROM usuario 
                WHERE correo = :correo
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':correo' => $correo
        ]);

        $usuario = $stmt->fetch();

        if (!$usuario) {
            return null;
        }

        // CONTRASEÑA NORMAL
        if ($clave === $usuario['clave']) {
            return $usuario;
        }

        // CONTRASEÑA ENCRIPTADA
        if (password_verify($clave, $usuario['clave'])) {
            return $usuario;
        }

        return null;

    }

}

?>