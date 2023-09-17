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
 <link rel="icon" href="../../assets/img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">

    <title>Gestión de convenios</title>

    <style>
        .icon-container {
            display: flex;
            gap: 5px;
            /* Espacio horizontal entre los íconos */
        }

        .icon-container a {
            font-size: 23px;

        }
    </style>

</head>

<body style="background: #E1E8EE;">

    <?php

    require_once '../../header.php';

    ?>

    <div class="container mt-3">
        <p class="fs-4"> <i class="fas fa-folder" style="color: #DF6914"></i> Gestión de convenios
        </p>
        <nav class="navbar navbar-expand-lg">
            <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
                <form class="d-flex" onsubmit="buscarConvenios(event)">
                    <input id="searchInput" class="form-control me-2" name="busqueda" type="search" placeholder="Buscar"
                        aria-label="Search" maxlength="100">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>



                <a href="./nuevoConvenio.php" class="btn btn-secondary" style="color: #fff; margin-left: 5px;">
                    <i class="fa fa-user-plus" style="color: #fff;"></i> Agregar Convenio
                </a>






            </div>
            <style>
                .table th {
                    font-family: Arial;
                    font-size: 12px;
                    color: black;
                }
            </style>
        </nav>

        <!-- Tabla de convenios -->
        <table class="table">
            <thead>
                <tr>
                    <th >ESTADO</th>
                    <th >NÚMERO</th>
                    <th >INSTITUCIÓN</th>
                    <th >NACIONALIDAD</th>
                    <th >CAT</th>
                    <th >DESCRIPCIÓN</th>
                    <th >CARACTERÍSTICA</th>
                    <th >PDF</th>
                    <th >FECHA INSCRIPCIÓN</th>
                    <th >FECHA EXPIRACIÓN</th>
                    <th >ACCIONES</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $records_per_page = 8;

                require_once '../../conexion.php';

                $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                // Calcular el desplazamiento para la consulta SQL
                $offset = ($current_page - 1) * $records_per_page;
                $busqueda = $_GET['busqueda'] ?? '';
                $busqueda = mysqli_real_escape_string($conn, $busqueda); // Prevenir SQL injection

                // Consulta SELECT con INNER JOIN utilizando una consulta preparada
                $query = "SELECT c.*, cat.nombre AS nombre_cat 
                FROM convenio c
                LEFT JOIN cat ON c.id = cat.id
                WHERE nombre_institucion LIKE ? OR 
               numero_convenio  LIKE?
                ORDER BY c.numero_convenio DESC
                LIMIT $offset, $records_per_page";

                $total_records_query = "SELECT COUNT(*) AS total FROM convenio";
                $total_records_result = mysqli_query($conn, $total_records_query);
                $total_records_row = mysqli_fetch_assoc($total_records_result);
                $total_records = $total_records_row['total'];
                $total_pages = ceil($total_records / $records_per_page);


                // Preparar la consulta y ejecutarla
                $stmt = mysqli_prepare($conn, $query);
                $searchTerm = '%' . $_GET['busqueda'] . '%';
               
                mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
                mysqli_stmt_execute($stmt);
                $resultado = mysqli_stmt_get_result($stmt);

                // Procesar los resultados de la consulta
                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo '<tr>';

                    // Estado (checkbox)
                    echo '<td>';
                    if ($_SESSION['rol_id'] === 1) {
                        echo '<div class="form-check form-switch">';
                        echo '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchChecked' . $row["id_convenio"] . '"';
                        if ($row["habilitado"] == 1) {
                            echo ' checked';
                        }
                        echo ' onchange="cambiarEstado(' . $row["id_convenio"] . ', this.checked);" style="font-family: Arial; font-size: 12px;">';
                        echo '<label class="form-check-label" for="flexSwitchChecked' . $row["id_convenio"] . '"></label></div>';
                    } else {
                        // Mostrar el estado actual en colores diferentes si no es administrador
                        if ($row["habilitado"] == 1) {
                            echo '<span style="font-family: Arial; font-size: 13px; color: green;"">Habilitado</span>';
                        } else {
                            echo '<span style="font-family: Arial; font-size: 13px; color: red;">Deshabilitado</span>';
                        }
                    }
                    echo '</td>';
                    
                    // Número de convenio
                    echo '<td style="font-family: Arial; font-size: 12px;">' . htmlspecialchars($row["numero_convenio"]) . '</td>';
                    
                    // Nombre de la institución (con descripción corta y toggle para mostrar completa)
                    echo '<td class="descripcion-toggle" data-full-description="' . htmlspecialchars($row["nombre_institucion"]) . '" onclick="toggleDescription(this)" style="font-family: Arial; font-size: 12px;">';
                    echo htmlspecialchars(mb_strlen($row["nombre_institucion"]) > 30 ? mb_substr($row["nombre_institucion"], 0, 30) . '...' : $row["nombre_institucion"]) . '</td>';
                    
                    // Nacionalidad
                    echo '<td style="font-family: Arial; font-size: 13px;">' . htmlspecialchars($row["nacionalidad"]) . '</td>';
                    
                    // CAT (nombre obtenido a través del INNER JOIN)
                    echo '<td class="descripcion-toggle" data-full-description="' . htmlspecialchars($row["nombre_cat"]) . '" onclick="toggleDescription(this)" style="font-family: Arial; font-size: 13px;">';
                    echo htmlspecialchars(mb_strlen($row["nombre_cat"]) > 15 ? mb_substr($row["nombre_cat"], 0, 15) . '...' : $row["nombre_cat"]) . '</td>';
                    
                    // Descripción (con descripción corta y toggle para mostrar completa)
                    echo '<td class="descripcion-toggle" data-full-description="' . htmlspecialchars($row["objeto_descripcion"]) . '" onclick="toggleDescription(this)" style="font-family: Arial; font-size: 13px;">';
                    echo htmlspecialchars(mb_strlen($row["objeto_descripcion"]) > 15 ? mb_substr($row["objeto_descripcion"], 0, 15) . '...' : $row["objeto_descripcion"]) . '</td>';
                    
                    // Característica
                    echo '<td style="font-family: Arial; font-size: 13px;">' . htmlspecialchars($row["caracteristica"]) . '</td>';
                    
                    // Enlace para descargar el PDF
                    echo '<td>
                        <a target="_blank" class="fas fa-file-pdf" href="../../PDF_Convenio/' . htmlspecialchars($row["cargar_pdf"]) . '"></a>
                        <a download class="fas fa-download" style="color: green;  " href="../../PDF_Convenio/' . htmlspecialchars($row["cargar_pdf"]) . '"></a>
                    </td>';
                    
                    // Fechas de inscripción y expiración
                    echo '<td style="font-family: Arial; font-size: 13px;">' . htmlspecialchars($row["fecha_inscripcion"]) . '</td>';
                    echo '<td style="font-family: Arial; font-size: 13px;">' . htmlspecialchars($row["fecha_expiracion"]) . '</td>';
                    
                    // echo '<a href="#" onclick="confirmarEliminarEstudiante(event, ' . $row['id'] . ')">';)
                    echo '<td class="icon-container">';
                    echo '<a href="actualizarConvenio.php?id_convenio=' . htmlspecialchars($row["id_convenio"]) . '" class="btn "style="color:#0a6aa2 ; font-family: Arial; font-size: 13px;"><i class="fa fa-pencil"></i></a>';
                    if ($_SESSION['rol_id'] === 1) {
                        echo '<a onclick="confirmarEliminarConvenio(event, ' . htmlspecialchars($row["id_convenio"]) . ')" class="btn "style="color: #FF0000 ; font-family: Arial; font-size: 13px;"><i class="fas fa-trash-alt"></i></a>';
                    } else {
                        echo '<span class="btn disabled" style="color: gray; font-family: Arial; font-size: 13px;"><i class="fas fa-trash-alt"></i></span>';
                    }
                    echo '</td>';
                    echo '</tr>';
                    



                }

                // Cerrar el statement y la conexión a la base de datos
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                ?>

            </tbody>
        </table>


        <script>
            function cambiarEstado(idConvenio, estado) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Éxito en la solicitud
                            if (estado) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Convenio habilitado',
                                    text: '¡Se ha habilitado el convenio exitosamente!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Convenio deshabilitado',
                                    text: '¡Se ha deshabilitado el convenio exitosamente!',
                                    showConfirmButton: false,
                                    timer: 1500

                                }).then(() => {
                                    location.reload();
                                });
                            }
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Se ha presentado un error',
                                text: '¡Error al cambiar el estado del convenio.!',
                                showConfirmButton: false,
                                timer: 1500

                            }).then(() => {
                                location.reload();
                            });;

                        }
                    }
                };

                xhr.open("GET", "./cambiar_estado_convenio.php?id_convenio=" + idConvenio + "&habilitado=" + (estado ? 1 : 0), true);
                xhr.send();
            }
        </script>

    </div>
    <nav aria-label="Page navigation example" class="mt-3">
        <ul class="pagination justify-content-center">
            <?php if ($current_page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $current_page - 1; ?>">Anterior</a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $i === $current_page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($current_page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $current_page + 1; ?>">Siguiente</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>


    <script src="https://kit.fontawesome.com/4b93f520b2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleDescription(cell) {
            const $cell = $(cell);
            const fullDescription = $cell.attr("data-full-description");
            const currentDescription = $cell.text();

            if (currentDescription !== fullDescription) {
                $cell.attr("title", fullDescription); // Mostrar descripción completa en el tooltip
                $cell.text(fullDescription.substring(0, 15) + "...");
            } else {
                const originalDescription = $cell.data("original-description");
                $cell.attr("title", originalDescription); // Restaurar el tooltip con la descripción completa original
                $cell.text(originalDescription.substring(0, 15) + "..."); // Truncar nuevamente en caso de que se haya cambiado la descripción
            }
        }

        // Agregar un evento clic a cada celda para llamar a la función toggleDescription
        $(document).ready(function () {
            $("td").click(function () {
                toggleDescription(this);
            });

            // Al cargar la página, guardar la descripción completa original en el atributo de datos "original-description"
            $("td").each(function () {
                const $cell = $(this);
                const fullDescription = $cell.attr("data-full-description");
                $cell.data("original-description", fullDescription);
            });
        });
    </script>
    <script>
        function confirmarEliminarConvenio(event, id_convenio) {
            event.preventDefault(); // Detiene el comportamiento predeterminado del enlace

            Swal.fire({
                title: "¿Estás seguro?",
                text: "Esta acción eliminará el convenio.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {

                    window.location.href = "../../API/convenio/delete_convenio.php?id_convenio=" + id_convenio;
                }
            });
        }
    </script>




</body>


</html>

<?php
if (isset($_SESSION['habilitarConvenioAlert'])) {

    echo "<script>
  Swal.fire({
      icon: 'success',
      title: 'Convenio habilitado',
      text: '¡Se ha habilitado un convenio exitosamente!' 
      });
      </script>";
    unset($_SESSION['habilitarConvenioAlert']);
}
?>
<?php
if (isset($_SESSION['detetedConvenioAlert'])) {
    echo "<script>
    swal({
      title: 'El convenio se ha eliminado!',
      text: '',
      icon: 'success',
      buttons: true,
      dangerMode: true,
    });
      </script>";
    unset($_SESSION['detetedConvenioAlert']);
}
if (isset($_SESSION['createConvenio'])) {
    echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Registro exitoso',
        text: 'Se ha registrado el convenio exitosamente',
        showConfirmButton: false,
        timer: 2000
    });
    </script>";
    unset($_SESSION['createConvenio']);
}
if (isset($_SESSION['nuemeroExiste'])) {
    echo "<script>
    Swal.fire({
        icon: 'warning',
        title: 'Número de convenio repetido',
        text: 'Por favor ingrese un número diferente',
        showConfirmButton: false,
        timer: 2000
    });
    </script>";
    unset($_SESSION['nuemeroExiste']);
}
if (isset($_SESSION['updateConvenio'])) {
    echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Convenio actualizado',
        text: 'Se ha actualizado el convenio exitosamente',
        showConfirmButton: false,
        timer: 2000
    });
    </script>";
    unset($_SESSION['updateConvenio']);
}


?>
