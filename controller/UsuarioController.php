<?php

session_start();

require_once __DIR__ . '/../model/Usuario.php';

$accion = $_GET['accion'] ?? $_POST['accion'] ?? '';

$usuarioModel = new Usuario();

switch ($accion) {

    case 'login':

        $correo = trim($_POST['correo'] ?? '');
        $clave = trim($_POST['clave'] ?? '');

        if ($correo === '' || $clave === '') {
            $_SESSION['error_login'] = 'Completa todos los campos.';
            header('Location: ../views/login.php');
            exit;
        }

        $usuario = $usuarioModel->login($correo, $clave);

        if ($usuario) {

            $_SESSION['usuario'] = $usuario;

            header('Location: ../views/home.php');
            exit;

        } else {

            $_SESSION['error_login'] = 'Correo o contraseña incorrectos.';

            header('Location: ../views/login.php');
            exit;
        }

        break;

    case 'logout':

        session_destroy();

        header('Location: ../views/login.php');
        exit;

        break;

    default:

        header('Location: ../views/login.php');
        exit;

        break;
}

?>