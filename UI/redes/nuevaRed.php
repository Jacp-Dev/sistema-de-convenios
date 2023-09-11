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
    <title>Nueva red</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/convenio.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="ruta/absoluta/convenio.css"> <!-- Reemplaza "ruta/absoluta" con la ruta correcta -->
</head>

<body style="background: #E1E8EE;">
    <header>
        <nav class="navbar navbar-expand-lg" style="background-color: #fff;">
            <div class="container-fluid">
                <a class="navbar-brand" href="../convenio/convenios.php"><img src="../../assets/img/logo-fucla.png"
                        alt="Logo Fucla"></a>
                <div class="separador-vertical"></div>

                <a class="navbar-brand text-warning fs-1" href="../convenio/convenios.php">Gestión de redes</a>
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
        <p class="fs-4"><i class="fas fa-network-wired" style="color: #DF6914"></i> Registrar nueva red</p>
        <p>En esta sección podrás registrar una nueva red diligenciando el siguiente formulario.</p>
        <form action="../../API/redes/create_redes.php" method="post">
            <div class="row">
                <div class="col">
                    <label for="nombre_red">Nombre de la red</label>
                    <input type="text" class="form-control" name="nombre_red" id="nombre_red" required>
                </div>
                <div class="col">
                    <label for="fecha_inscripcion">Fecha de afiliación a la red</label>
                    <input type="date" class="form-control" name="fecha_inscripcion" id="fecha_inscripcion" required>
                </div>
                <div class="col">
                    <label for="tipoRed">Tipo de Red</label>
                    <select id="tipoRed" class="form-select" name="tipo_red" id="tipo_red" required>
                        <option value="">Seleccionar</option>
                        <option value="Extensión">Extensión</option>
                        <option value="Academicas">Académicas</option>
                        <option value="Investigación">Investigación</option>
                        <option value="Administrativas">Administrativas</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <label for="caractistica_red">Nacionalidad</label>
                    <select class="form-select" name="caractistica_red" id="caractistica_red" required>
                        <option value="">Seleccionar</option>
                        <option value="Nacional">Nacional</option>
                        <option value="Internacional">Internacional</option>

                    </select>
                </div>
                <div class="col">
                    <label for="enlace">Enlace de acceso a la red</label>
                    <input type="text" class="form-control" maxlength="100" name="enlace" id="enlace" required>
                </div>
                <div class="col">
                    <label for="id_convenio">Convenio</label>
                    <select class="form-select" id="id_convenio" name="id_convenio" required>
                        <option value="">Seleccionar</option>
                        <?php
                        // Realizar la conexión a la base de datos (código específico puede variar)
                        require_once '../../conexion.php';
                        $query = "SELECT id_convenio, nombre_institucion FROM convenio";
                        $result = mysqli_query($conn, $query);

                        // Recorrer los resultados y generar las opciones del select
                        while ($fila = mysqli_fetch_assoc($result)) {
                            $id_convenio = $fila['id_convenio'];
                            $nombre_institucion = $fila['nombre_institucion'];
                            echo "<option value='$id_convenio'>$nombre_institucion</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <label for="objeto">Descripción</label>
                    <textarea class="form-control" maxlength="500" name="objeto" cols="30" rows="5"
                        style="resize: none;" id="objeto" required></textarea>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg">
                <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
                    <a href="./gestionarRedes.php" class="btn btn-outline-secondary" type="submit"
                        style="margin-right: 5px;">Cancelar</a>
                    <button class="btn btn-outline-success" type="submit">Guardar</button>
                </div>
            </nav>
        </form>

    </div>
    <script src="https://kit.fontawesome.com/4b93f520b2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>