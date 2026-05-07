<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="icon" href="../imagenes/icono.png">

    <title>Clientes</title>

</head>

<body>

    <div class="navbar">

        <div class="navbar-logo">

            <img src="../imagenes/icono.png" alt="">

            <span>Agenda Pro</span>

        </div>

        <div class="navbar-links">

            <a href="home.php">Inicio</a>
            <a href="cliente.php">Clientes</a>
            <a href="cita.php">Citas</a>
            <a href="logout.php">Salir</a>

        </div>

    </div>

    <div class="page-container">

        <div class="page-card">

            <div class="page-header">

                <h1>
                    Clientes
                </h1>

                <button>
                    Nuevo Cliente
                </button>

            </div>

            <table>

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>
                        <td>Juan Pérez</td>
                        <td>999999999</td>
                        <td>juan@gmail.com</td>

                        <td>

                            <button class="btn-edit">
                                Editar
                            </button>

                            <button class="btn-delete">
                                Eliminar
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>