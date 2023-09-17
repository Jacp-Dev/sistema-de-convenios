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
 <link rel="icon" href="../../assets/img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
</head>

<body style="background: #E1E8EE;">
    <?php
    require_once '../../header.php';

    ?>
    <div class="container mt-3">
        <p class="fs-4"><i class="fas fa-network-wired" style="color: #DF6914"></i> Actualizar red</p>
        <p>En esta sección podrás actualizar una red diligenciando el siguiente formulario.</p>
        <?php
        // Realizar la conexión a la base de datos (código específico puede variar)
        require_once '../../conexion.php';

        // Obtener el ID de la red a editar desde la URL
        $id_redes = $_GET['id_redes'] ?? '';

        // Consulta para obtener la información de la red por su ID
        $query = "SELECT * FROM redes WHERE id_redes = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_redes);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        ?>
        <form action="../../API/redes/update_red.php" method="post">
            <input type="hidden" name="id_redes" value="<?php echo $row['id_redes']; ?>">
            <div class="row">
                <div class="col">
                    <label for="nombre_red">Nombre de la red</label>
                    <input type="text" class="form-control" maxlength="100" id="nombre_red" required name="nombre_red"
                        value="<?php echo $row['nombre_red']; ?>">
                </div>
                <div class="col">
                    <label for="fecha_inscripcion">Fecha de afiliación a la red</label>
                    <input type="date" class="form-control" id="fecha_inscripcion" name="fecha_inscripcion"
                        value="<?php echo $row['fecha_inscripcion']; ?>">
                </div>
                <div class="col">
                    <label for="tipo_red">Tipo de Red</label>
                    <select class="form-select" id="tipo_red" name="tipo_red" required>
                        <option value="Extensión" <?php if ($row['tipo_red'] === 'Extensión')
                            echo 'selected'; ?>>
                            Extensión</option>
                        <option value="Académicas" <?php if ($row['tipo_red'] === 'Académicas')
                            echo 'selected'; ?>>
                            Académicas</option>
                        <option value="Investigación" <?php if ($row['tipo_red'] === 'Investigación')
                            echo 'selected'; ?>>
                            Investigación</option>
                        <option value="Administrativas" <?php if ($row['tipo_red'] === 'Administrativas')
                            echo 'selected'; ?>>Administrativas</option>
                    </select>
                </div>

            </div> <!-- Primera fila ternima aquí -->
            <br>

            <div class="row">
                <div class="col">
                    <label for="caractistica_red">Nacionalidad</label>
                    <select class="form-select" id="caractistica_red" name="caractistica_red" required>
                        <option value="Nacional" <?php if ($row['caractistica_red'] === 'Nacional')
                            echo 'selected'; ?>>
                            Nacional</option>
                        <option value="Internacional" <?php if ($row['caractistica_red'] === 'Internacional')
                            echo 'selected'; ?>>
                            Internacional</option>

                    </select>
                </div>
                <div class="col">
                    <label for="enlace">Enlace de acceso a la red</label>
                    <input type="text" class="form-control" maxlength="100" id="enlace" required name="enlace"
                        value=" <?php echo $row['enlace']; ?>">
                </div>

                <div class="col">
                    <label for="id_convenio">Convenio</label>
                    <select class="form-select" id="id_convenio" name="id_convenio" required>
                        <?php
                        $convenioQuery = "SELECT id_convenio, nombre_institucion FROM convenio";
                        $convenioResult = mysqli_query($conn, $convenioQuery);

                        while ($convenioRow = mysqli_fetch_assoc($convenioResult)) {
                            $id_convenio = $convenioRow['id_convenio'];
                            $nombre_institucion = $convenioRow['nombre_institucion'];
                            $selected = ($id_convenio === $row['id_convenio']) ? 'selected' : '';
                            echo "<option value='$id_convenio' $selected>$nombre_institucion</option>";
                        }
                        ?>
                    </select>
                </div>


            </div>
            <br>
            <div class="row">

                <div class="col">
                    <label for="objeto">Descripción</label>
                    <textarea class="form-control" id="objeto" required maxlength="500" name="objeto" cols="30" rows="5"
                        style="resize: none; "> <?php echo $row['objeto']; ?></textarea  require>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg">
                <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
                <a href="./gestionarRedes.php" class="btn btn-outline-secondary" type="submit" style="margin-right: 5px;">Cancelar</a>
                    <button class="btn btn-outline-success" type="submit">Guardar</button>
                </div>
            </nav>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/4b93f520b2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
