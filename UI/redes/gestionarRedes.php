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
    <title>Gestión de redes</title>

</head>

<body style="background: #E1E8EE;">

    <?php
    require_once '../../header.php';

    ?>

    <div class="container mt-3">
        <p class="fs-4"> <i class="fas fa-network-wired" style="color: #DF6914"></i> Gestión de redes
        </p>
        <nav class="navbar navbar-expand-lg">
            <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
                <form class="d-flex" method="GET" action="./GestionarRedes.php">
                    <input class="form-control me-2" type="search" maxlength="100" name="busqueda"
                        placeholder="Ingresar búsqueda" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                <a href="./nuevaRed.php" class="btn btn-secondary" style="color:  #fff; margin-left: 5px;">
                    <i class="fas fa-network-wired" style="color:  #fff;"></i> Agregar red</a>


            </div>
            <style>
                .table th {
                    font-family: Arial;
                    font-size: 12px;
                    color: black;
                }
            </style>
        </nav>
        <table class="table">
            <thead>
                <tr>
                    <th >NÚMERO</th>
                    <th >NOMBRE DE LA RED</th>
                    <th >AFILIACIÓN</th>
                    <th >TIPO DE RED</th>
                    <th >NACIONALIDAD</th>
                    <th >ENLACE</th>
                    <th >CONVENIO</th>
                    <th >DESCRIPCIÓN</th>
                    <th >ACCIONES</th>
                </tr>
            </thead>

            <tbody>
                <?php

                $records_per_page = 12;


                // Conexión a la base de datos (reemplaza con tus datos de conexión)
                
                require_once '../../conexion.php';

                $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                // Calcular el desplazamiento para la consulta SQL
                $offset = ($current_page - 1) * $records_per_page;
                // Obtener el valor ingresado en el campo de búsqueda y convertirlo a minúsculas
                $busqueda = $_GET['busqueda'] ?? '';
                $busqueda = strtolower($busqueda); // Convertir a minúsculas
                
                // Consulta SELECT con cláusula WHERE utilizando una consulta preparada
                $query = "SELECT r.*, c.nombre_institucion FROM redes r
                  JOIN convenio c ON r.id_convenio = c.id_convenio
                  WHERE 
                  LOWER(r.nombre_red) LIKE ? OR
                  LOWER(r.objeto) LIKE ? OR
                  LOWER(r.tipo_red) LIKE ? OR
                  LOWER(r.fecha_inscripcion) LIKE ?
                    ORDER BY r.id_redes DESC
                     LIMIT $offset, $records_per_page";

                $total_records_query = "SELECT COUNT(*) AS total FROM convenio";
                $total_records_result = mysqli_query($conn, $total_records_query);
                $total_records_row = mysqli_fetch_assoc($total_records_result);
                $total_records = $total_records_row['total'];
                $total_pages = ceil($total_records / $records_per_page);

                // Preparar la consulta
                $stmt = mysqli_prepare($conn, $query);


                // Verificar si la consulta preparada se creó correctamente
                if (!$stmt) {
                    echo "Error en la consulta preparada: " . mysqli_error($conn);
                    exit();
                }

                // Asociar los parámetros y ejecutar la consulta
                $busqueda_param = "%$busqueda%"; // Agregar comodines para la consulta LIKE
                mysqli_stmt_bind_param($stmt, "ssss", $busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param);
                mysqli_stmt_execute($stmt);

                // Procesar los resultados de la consulta
                $resultado = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo '<tr>';

                    echo '<td style="font-family: Arial; font-size: 13px;">' . $row["id_redes"] . '</td>';
                    echo '<td style="font-family: Arial; font-size: 13px;"><span data-toggle="tooltip" title="' . htmlspecialchars($row["nombre_red"]) . '">' . (mb_strlen($row["nombre_red"]) > 35 ? mb_substr($row["nombre_red"], 0, 35) . '...' : $row["nombre_red"]) . '</span></td>';
                    echo '<td style="font-family: Arial; font-size: 13px;">' . $row["fecha_inscripcion"] . '</td>';
                    echo '<td style="font-family: Arial; font-size: 13px;">' . $row["tipo_red"] . '</td>';
                    echo '<td style="font-family: Arial; font-size: 13px;">' . $row["caractistica_red"] . '</td>';
                    echo '<td style="font-family: Arial; font-size: 13px;"><a href="' . $row["enlace"] . '" class="btn btn-link" target="_blank">
    <i class="fas fa-external-link-alt"></i>
    </a></td>';
                    echo '<td style="font-family: Arial; font-size: 13px;"><span data-toggle="tooltip" title="' . htmlspecialchars($row["nombre_institucion"]) . '">' . (mb_strlen($row["nombre_institucion"]) > 35 ? mb_substr($row["nombre_institucion"], 0, 35) . '...' : $row["nombre_institucion"]) . '</span></td>';
                    echo '<td style="font-family: Arial; font-size: 13px;"><span data-toggle="tooltip" title="' . htmlspecialchars($row["objeto"]) . '">' . (mb_strlen($row["objeto"]) > 35 ? mb_substr($row["objeto"], 0, 35) . '...' : $row["objeto"]) . '</span></td>';

                    // Acciones (select con opciones para editar y eliminar)
                    echo '<td class="icon-container">';
                    echo '<a href="editarRed.php?id_redes=' . htmlspecialchars($row["id_redes"]) . '" class="btn "style="color:#0a6aa2 ; font-family: Arial; font-size: 13px;"><i class="fa fa-pencil"></i></a>';
                    if ($_SESSION['rol_id'] === 1) {
                        echo '<a onclick="confirmarEliminarRed(event, ' . htmlspecialchars($row["id_redes"]) . ')" class="btn "style="color: #FF0000 ; font-family: Arial; font-size: 13px;"><i class="fas fa-trash-alt"></i></a>';
                    } else {
                        // Opcional: Agregar alguna acción para otros roles
                    }
                    echo '</td>';
                    echo '</tr>';

                }


                // Cerrar la consulta y la conexión a la base de datos
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                ?>
            </tbody>
        </table>

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
    <script>
        function confirmarEliminarRed(event, id_redes) {
            event.preventDefault(); // Detiene el comportamiento predeterminado del enlace

            Swal.fire({
                title: "¿Estás seguro?",
                text: "Esta acción eliminará esta red.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {

                    window.location.href = "../../API/redes/delete_redes.php?id_redes=" + id_redes;
                } else {

                }
            });
        }
    </script>
</body>

</html>
<?php
if (isset($_SESSION['createRed'])) {
    echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Registro exitoso',
        text: 'Se ha registrado la red exitosamente',
        showConfirmButton: false,
        timer: 2000
    });
    </script>";
    unset($_SESSION['createRed']);
}

if (isset($_SESSION['updateRed'])) {
    echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Actulización exitosa',
        text: 'Se ha actualizado la red exitosamente',
        showConfirmButton: false,
        timer: 2000
    });
    </script>";
    unset($_SESSION['updateRed']);
}
?>
