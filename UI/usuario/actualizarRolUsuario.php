<?php
session_start();
error_reporting(0);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-Ti7IgZr8kXW+ybRmYqP1M5Jc6bSw+flDb9ikyBKuIWSU19PrUJiG60GXTn0rIy3wjGht1c9SoqPRRXQehVd01g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/convenio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Registro de convenios</title>
</head>

<body style="background: #E1E8EE;">
    <header>
        <nav class="navbar navbar-expand-lg" style="background-color: #fff;">
            <div class="container-fluid">
                <a class="navbar-brand" href="../convenio/convenios.php"><img src="../../assets/img/logo-fucla.png"
                        alt="Logo Fucla"></a>
                <div class="separador-vertical"></div>


                <a class="navbar-brand text-warning fs-1" href="../convenio/convenios.php">Gestión de Usuarios</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
                        <ul class="menu">
                            <li><a href="../convenio/grafico.php"><i class="fas fa-chart-bar"
                                        style="color: #DF6914"></i> Ver gráfico</a></li>
                            <li><a href="../usuario/gestiondeusuario.php"><i class="fas fa-users"
                                        style="color: #DF6914"></i> Gestión
                                    de usuarios</a></li>
                            <li><a href="../convenio/convenios.php"><i class="fas fa-folder" style="color: #DF6914"></i>
                                    Gestión de
                                    convenios</a></li>
                            <li><a href="../redes/DashboardRedes.php"><i class="fas fa-network-wired"
                                        style="color: #DF6914"></i>
                                    Gestión
                                    de redes</a></li>

                            <?php
                            session_start();
                            if (isset($_SESSION['token'])) {
                                $token = $_SESSION['token'];
                            } else {
                                // Contraseña incorrecta
                                session_start();
                                $_SESSION['tokenNot'] = 'token incorrecto';

                                header("Refresh: 0; url=../../index.php");
                                exit;
                            }
                            ?>
                            <li>

                                <form action="../../API/login/logout.php" method="post"
                                    style="display: flex; align-items: center;">
                                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                                    <button type="submit" id="logout"
                                        style="border: none; background: none; cursor: pointer;">
                                        <i class="fas fa-sign-out-alt" style="color: #DF6914"></i>
                                        Salir
                                    </button>
                                </form>

                            </li>
                        </ul>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-3">
        <p class="fs-4"> <i class="fa fa-gear fs-3" style="color: #DF6914"></i> Asignar rol al usuario </p>
        <p>En esta sección podrás asignar el rol al usuario diligenciando el siguiente formulario.</p>
        <?php
        require_once '../../conexion.php';

        // Función para generar opciones del select
        function generateOptions($query, $conn, $valueField, $textField)
        {
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row[$valueField]}'>{$row[$textField]}</option>";
            }
        }

        // Consulta para obtener la lista de correos de la tabla usuarios
        $queryUsuarios = "SELECT nombre, id_usuario FROM usuarios ORDER BY id_usuario DESC";

        // Consulta para obtener la lista de nombres de la tabla roles
        $queryRoles = "SELECT nombre, id_roles FROM roles";
        ?>

        <form action="./updateRol.php" method="post">
            <div class="row">
                <div class="col">
                    <label for="id_usuario">Seleccione el nombre de usuario</label>
                    <select class="form-select" name="id_usuario" id="id_usuario" required>
                        <option value="">Seleccionar</option>
                        <?php generateOptions($queryUsuarios, $conn, "id_usuario", "nombre"); ?>
                    </select>
                </div>

                <div class="col">
                    <label for="id_roles">Seleccione Rol</label>
                    <select class="form-select" name="id_roles" id="id_roles" required>
                        <option value="">Seleccionar</option>
                        <?php generateOptions($queryRoles, $conn, "id_roles", "nombre"); ?>
                    </select>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg">
                <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
                    <a href="./gestiondeusuario.php" class="btn btn-outline-secondary">Cancelar</a>
                    <button class="btn btn-outline-success" type="submit">Guardar</button>
                </div>
            </nav>
        </form>

        <?php
        // Obtener el valor del id_usuario del parámetro GET (si está presente)
        if (isset($_GET["id_usuario"])) {
            $selectedUserId = $_GET["id_usuario"];
            echo "<script>document.getElementById('id_usuario').value = '$selectedUserId';</script>";
        }
        ?>
    </div>




    </div>

    <script src="https://kit.fontawesome.com/4b93f520b2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

</body>

</html>