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
     <link rel="icon" href="../../assets/img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Actualizar convenio</title>
</head>

<body style="background: #E1E8EE;">
    <?php
    require_once '../../header.php';

    ?>
    <div class="container mt-3">
        <p class="fs-4"><i class="fas fa-folder" style="color: #DF6914"></i> Actualizar convenio</p>
        <p>En esta sección podrás actualizar un convenio existente diligenciando el siguiente formulario.</p>
        <form action="../../API/convenio/update_convenio.php" method="post" enctype="multipart/form-data">
            <?php
            // Capturar el id_convenio de la URL
            $id_convenio = isset($_GET['id_convenio']) ? $_GET['id_convenio'] : '';

            require_once '../../conexion.php';

            // Consulta para obtener los datos del convenio con el id_convenio especificado
            $query_cat = "SELECT id, nombre FROM cat";
            $result_cat = mysqli_query($conn, $query_cat);

            $query = "SELECT nombre_institucion, caracteristica, nacionalidad, fecha_inscripcion, fecha_expiracion, numero_convenio, tipo_convenio, objeto_descripcion FROM convenio WHERE id_convenio = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id_convenio);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $nombre_institucion = $row['nombre_institucion'];
                $caracteristica = $row['caracteristica'];
                $nacionalidad = $row['nacionalidad'];
                $fecha_inscripcion = $row['fecha_inscripcion'];
                $fecha_expiracion = $row['fecha_expiracion'];
                $numero_convenio = $row['numero_convenio'];
                $objeto_descripcion = $row['objeto_descripcion'];
                $tipo_convenio = $row['tipo_convenio'];

            } else {
                // No se encontró el convenio con el id_convenio especificado
                // Aquí podrías manejar un error o redireccionar a otra página, según tu lógica de negocio
            }

            // Cerrar la conexión a la base de datos
            $query_cat = "SELECT * FROM cat";
            $query_cat2 = "SELECT * FROM cat";
            $result_cat = mysqli_query($conn, $query_cat);
            $result_cat2 = mysqli_query($conn, $query_cat2);
            $query_tipo = "SELECT * FROM cat";
            $result_tipo = mysqli_query($conn, $query_tipo);
            $query_cat3 = "SELECT * FROM cat";
            $result_cat3 = mysqli_query($conn, $query_cat3);
            $query_cat4 = "SELECT * FROM cat";
            $result_cat4 = mysqli_query($conn, $query_cat4);

            mysqli_close($conn);
            ?>
            <div class="row">
                <div class="col">
                    <label for="nombre_institucion">Nombre de la Institución</label>
                    <input type="text" id="nombre_institucion" required class="form-control" maxlength="100"
                        name="nombre_institucion" value="<?php echo $nombre_institucion; ?>">
                </div>

                <div class="col">
                    <label for="id_cat">Seleccionar CAT</label>
                    <select class="form-select" name="id_cat" id="id_cat">
                        <!-- Cambiado 'name' a 'id_cat' y agregado 'id' -->
                        <?php
                        // Iterar sobre los resultados y crear las opciones del campo de selección
                        while ($row_cat = mysqli_fetch_assoc($result_cat)) {
                            $cat_id = $row_cat['id'];
                            $cat_nombre = $row_cat['nombre'];
                            echo "<option value='$cat_id' " . ($id_cat == $cat_id ? "selected" : "") . ">$cat_nombre</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col">
                    <label for="nacionalidad">Seleccionar nacionalidad</label>
                    <select class="form-select" name="nacionalidad" id="nacionalidad">
                        <!-- Cambiado 'name' a 'nacionalidad' y agregado 'id' -->
                        <?php
                        // Iterar sobre los resultados y crear las opciones del campo de selección
                        while ($row_cat2 = mysqli_fetch_assoc($result_cat2)) {
                            $cat_id2 = $row_cat['id'];
                            $cat_nombre2 = $row_cat2['nacionalidad'];

                            
                            if (!empty($cat_nombre2)) {
                                echo "<option value='$cat_nombre2' " . ($nacionalidad == $cat_nombre2 ? "selected" : "") . ">$cat_nombre2</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <!-- bbbbb -->
                <div class="col">
                    <label for="caracteristica">Seleccionar Caracteristica</label>
                    <select class="form-select" name="caracteristica" id="caracteristica">
                        <!-- Cambiado 'name' a 'nacionalidad' y agregado 'id' -->
                        <?php
                        // Iterar sobre los resultados y crear las opciones del campo de selección
                        while ($row_cat4 = mysqli_fetch_assoc($result_cat4)) {
                            $cat_id4 = $row_cat4['id'];
                            $cat_nombre4 = $row_cat4['caracteristica'];

                            
                            if (!empty($cat_nombre4)) {
                                 echo "<option value='$cat_nombre4' " . ($caracteristica == $cat_nombre4 ? "selected" : "") . ">$cat_nombre4</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                 <!-- cccc -->
               
                <div class="col">
                    <label for="">Fecha de Suscripción</label>
                    <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" class="form-control"
                        value="<?php echo $fecha_inscripcion; ?>">
                </div>
                <div class="col">
                    <label for="">Fecha de Expiración</label>
                    <input type="date" name="fecha_expiracion" id="fecha_expiracion" class="form-control"
                        value="<?php echo $fecha_expiracion; ?>">
                </div>
            </div>


            <div class="row">
                <div class="col">
                    <label for="">Número de convenio</label>
                    <input type="text" name="numero_convenio" maxlength="10" id="numero_convenio" required
                        pattern="[0-9]+" title="Solo se permiten números" class="form-control "
                        value="<?php echo $numero_convenio; ?>">
                </div>
              
                <div class="col">
                    <label for="tipo_convenio">Seleccionar tipo de convenio</label>
                    <select class="form-select" name="tipo_convenio" id="tipo_convenio">
                        <!-- Cambiado 'name' a 'nacionalidad' y agregado 'id' -->
                        <?php
                        // Iterar sobre los resultados y crear las opciones del campo de selección
                        while ($row_cat3 = mysqli_fetch_assoc($result_cat3)) {
                            $cat_id3 = $row_cat3['id'];
                            $cat_nombre3 = $row_cat3['tipo_convenio'];

                            
                            if (!empty($cat_nombre3)) {
                                 echo "<option value='$cat_nombre3' " . ($tipo_convenio == $cat_nombre3 ? "selected" : "") . ">$cat_nombre3</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
               
                <div class="col">
        <label for="">Cargar PDF del convenio</label>
        <div class="input-group">
            <input type="file" name="archivo" id="archivo" class="form-control" style="display: none;">
            <input type="text" name="cargar_pdf" class="form-control" readonly>
            <button class="btn btn-outline-secondary" type="button" id="adjuntar-btn">
                <i class="fas fa-paperclip"></i> Cargar PDF
            </button>
        </div>
        <small class="text-danger" id="error-msg" style="display: none;">Por favor, adjunta un archivo PDF.</small>
    </div>
            </div>
            <div class="row">
                <div class="col mt-3">
                    <label for="">Objeto</label>
                    <textarea class="form-control" maxlength="500" name="objeto_descripcion" id="objeto_descripcion"
                        required cols="129" rows="5" style="resize: none;"><?php echo $objeto_descripcion; ?></textarea>
                </div>
            </div>

            <nav class="navbar navbar-expand-lg">
                <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
                    <a href="./listarConvenios.php" class="btn btn-outline-secondary" type="submit"
                        style="margin-right: 5px;">Cancelar</a>
                    <button class="btn btn-outline-success" type="submit">Actualizar</button>
                </div>
            </nav>
            <div class="col">
                <input type="hidden" name="id_convenio" value="<?php echo $id_convenio; ?>">
            </div>
        </form>
    </div>

    <script>
        
        var valorObjeto = "<?php echo $objeto_descripcion; ?>";
        
        document.getElementById("objeto_descripcion").value = valorObjeto;
    </script>
 <script>
    document.getElementById('adjuntar-btn').addEventListener('click', function () {
        document.getElementById('archivo').click();
    });

    document.getElementById('archivo').addEventListener('change', function () {
        var inputText = document.querySelector('input[name="cargar_pdf"]');
        var errorMensaje = document.getElementById('error-msg');
        var archivoInput = document.getElementById('adjuntar-btn');
        var archivo = this.files[0];

        if (archivo) {
            if (archivo.name.toLowerCase().endsWith('.pdf')) {
                inputText.value = archivo.name;
                errorMensaje.style.display = 'none';
                archivoInput.style.borderColor = ''; 
            } else {
                inputText.value = '';
                errorMensaje.style.display = 'block';
                archivoInput.style.borderColor = 'red'; 
            }
        }
    });
</script>


</body>

</html>
