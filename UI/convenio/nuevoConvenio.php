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
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <link rel="icon" href="../../assets/img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
    <title>Nuevo convenio</title>
</head>

<body style="background: #E1E8EE;">
    <?php
    require_once '../../header.php';

    ?>
    </header>
    <div class="container mt-3">
        <p class="fs-4"><i class="fas fa-folder" style="color: #DF6914"></i> Registrar nuevo convenio</p>
        <p>En esta sección podrás registrar un nuevo convenio diligenciando el siguiente formulario.</p>
        <?php
        if (isset($_SESSION['addConvenioAlert'])) {

            echo "<script>
  Swal.fire({
      icon: 'success',
      title: 'Registro exitoso',
      text: '¡Se ha creado un nuevo usuario exitosamente!' 
      });
      </script>";
            unset($_SESSION['addConvenioAlert']);
        }
        ?>

        <form action="../../API/convenio/create_convenio.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                    <label for="">Nombre de la Institucion</label>
                    <input type="text" class="form-control" maxlength="100" name="nombre_institucion" required>
                </div>
                <!-- Consulta maestra -->
                <?php
                require_once '../../conexion.php'; // Incluye el archivo de conexión a la base de datos
                
                // Realiza la consulta a la tabla "CAT"
                $query = "SELECT id, nombre FROM cat";
                $result = mysqli_query($conn, $query);
                ?>
                <div class="col">
                    <label for="">Seleccionar CAT</label>
                    <select type="text" class="form-select" name="id" required>
                        <option value="">Seleccionar</option>
                        <?php
                        // Itera sobre los resultados y crea las opciones del campo de selección
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $nombre = $row['nombre'];
                            echo "<option value='$id'>$nombre</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Fin Consulta maestra -->
                <?php
                require_once '../../conexion.php'; // Incluye el archivo de conexión a la base de datos
                
                // Realiza la consulta a la tabla "CAT"
                $query2 = "SELECT id, nacionalidad FROM cat";
                $result2 = mysqli_query($conn, $query2);
                ?>
                <div class="col">
                    <label for="nacionalidad">Seleccionar Nacionalidad</label>
                    <select class="form-select" name="nacionalidad" required>
                        <option value="">Seleccionar</option>
                        <?php
                        // Itera sobre los resultados y crea las opciones del campo de selección
                        while ($row = mysqli_fetch_assoc($result2)) {
                            $id = $row['id'];
                            $nacionalidad = $row['nacionalidad'];

                            // Verifica si la nacionalidad no está vacía antes de generar la opción
                            if (!empty($nacionalidad)) {
                                echo "<option value='$nacionalidad'>$nacionalidad</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

            </div>
            <!-- Resto del formulario ... -->
            <div class="row">
                <?php
                require_once '../../conexion.php'; // Incluye el archivo de conexión a la base de datos
                
                // Realiza la consulta a la tabla "CAT"
                $query3 = "SELECT id, caracteristica FROM cat";
                $result3 = mysqli_query($conn, $query3);
                ?>
                <div class="col">
                    <label for="">Seleccionar característica</label>
                    <select type="text" class="form-select" name="caracteristica" required>
                        <option value="">Seleccionar</option>
                        <?php
                        // Itera sobre los resultados y crea las opciones del campo de selección
                        while ($row = mysqli_fetch_assoc($result3)) {
                            $id = $row['id'];
                            $caracteristica = $row['caracteristica'];
                            // Verifica si la nacionalidad no está vacía antes de generar la opción
                            if (!empty($caracteristica)) {
                                echo "<option value='$caracteristica'>$caracteristica</option>";
                            }

                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <label for="">Fecha de Suscripción</label>
                    <input type="date" name="fecha_inscripcion" class="form-control" id="fecha_inscripcion" required>
                </div>
                <div class="col">
                    <label for="">Fecha de Expiración</label>
                    <input type="date" name="fecha_expiracion" class="form-control" id="fecha_expiracion" required>
                </div>
            </div>
            <div class="row">
                <?php
                require_once '../../conexion.php';
                $result = mysqli_query($conn, "SELECT MAX(numero_convenio) AS max_num FROM convenio");
                $row = mysqli_fetch_assoc($result);
                $next_num = isset($row['max_num']) ? $row['max_num'] + 1 : 1;
                ?>


                <div class="col">
                    <label for="numero_convenio">Número de convenio</label>
                    <input type="text" name="numero_convenio" class="form-control" maxlength="10" id="numero_convenio"
                        required pattern="[0-9]+" title="Solo se permiten números" value="<?php echo $next_num; ?>">
                </div>


                <?php
                require_once '../../conexion.php'; // Incluye el archivo de conexión a la base de datos
                
                // Realiza la consulta a la tabla "CAT"
                $query4 = "SELECT id, tipo_convenio FROM cat";
                $result4 = mysqli_query($conn, $query4);
                ?>
                <div class="col">

                    <label for="">Seleccionar Tipo de convenio</label>
                    <select type="text" class="form-select" name="tipo_convenio" id="tipo_convenio" required>
                        <option value="">Seleccionar</option>
                        <?php
                        // Itera sobre los resultados y crea las opciones del campo de selección
                        while ($row = mysqli_fetch_assoc($result4)) {
                            $id = $row['id'];
                            $tipo_convenio = $row['tipo_convenio'];

                            if (!empty($tipo_convenio)) {
                                echo "<option value='$tipo_convenio'>$tipo_convenio</option>";
                            }

                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <div class="col">
                        <label for="">Cargar PDF del convenio</label>
                        <div class="input-group">
                            <input type="file" name="archivo" id="archivo" class="form-control" style="display: none;"
                                required>
                            <input type="text" name="cargar_pdf" class="form-control" readonly id="cargar_pdf" required>
                            <button class="btn btn-outline-secondary" type="button" id="adjuntar-btn">
                                <i class="fas fa-paperclip"></i> Cargar PDF
                            </button>
                        </div>
                        <small class="text-danger" id="error-msg" style="display: none;">Por favor, adjunta un archivo
                            PDF.</small>
                    </div>
                </div>


                <div class="row">
                    <div class="col mt-3">
                        <label for="">Objeto</label>
                        <textarea class="form-control" name="objeto_descripcion" cols="129" rows="5"
                            style="resize: none;" maxlength="500" id="objeto_descripcion" required></textarea>
                    </div>
                </div>
                <nav class="navbar navbar-expand-lg">
                    <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
                        <a href="./listarConvenios.php" class="btn btn-outline-success" type="submit"
                            style="margin-right: 5px;">Cancelar</a>
                        <button class="btn btn-outline-success" type="submit">Guardar</button>
                    </div>
                </nav>
        </form>
    </div>
    <script>
        const archivoInput = document.getElementById('archivo');
        const errorMensaje = document.getElementById('error-msg');
        const inputText = document.querySelector('input[name="cargar_pdf"]');

        document.getElementById('adjuntar-btn').addEventListener('click', () => {
            archivoInput.click();
        });

        archivoInput.addEventListener('change', () => {
            const archivo = archivoInput.files[0];
            if (archivo) {
                if (archivo.name.toLowerCase().endsWith('.pdf')) {
                    inputText.value = archivo.name;
                    errorMensaje.style.display = 'none';
                    archivoInput.style.borderColor = ''; // Restaurar el color del borde
                } else {
                    inputText.value = '';
                    errorMensaje.style.display = 'block';
                    archivoInput.style.borderColor = 'red'; // Cambia el color del borde en caso de error
                }
            }
        });
    </script>

</body>

</html>
