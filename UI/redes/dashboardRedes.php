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
    <!-- Incluir Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <title>Gestion de redes</title>

</head>
<?php
require_once '../../header.php';

?>

<body style="background: #E1E8EE;">

    <div class="container">
        <nav class="navbar navbar-expand-lg ">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <p class="text-primary fs-3">Bienvenido</p>
                </li>
            </ul>
            <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
                <!-- Dentro del elemento form -->
                <form class="d-flex" method="GET" action="dashboardRedes.php">
                    <input class="form-control me-2" maxlength="100" type="search" name="q"
                        placeholder="Ingresar búsqueda" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>

                <a href="./gestionarRedes.php" class="btn btn-secondary" style="color:  #fff; margin-left: 5px;"> <i
                        class="fa fa-list-plus" style="color:  #fff;"></i>Gestionar redes</a>
            </div>
        </nav>

    </div>
    <div class="container">
        <div class="separador"></div>


        <div class="row row-cols-1 row-cols-md-6 g-3">
            <?php
            
            require_once '../../conexion.php';

            // Paginación
            $results_per_page = 12; // Cantidad de resultados por página
            $sql = "SELECT COUNT(*) AS total FROM redes";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $total_pages = ceil($row["total"] / $results_per_page);

            // Obtener la página actual
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            if ($current_page < 1) {
                $current_page = 1;
            } elseif ($current_page > $total_pages) {
                $current_page = $total_pages;
            }

            // Calcular el índice del primer registro de la página actual
            $start_index = ($current_page - 1) * $results_per_page;

            // Paso 2: Ejecutar el SELECT para obtener los datos de la tabla 'redes' usando una consulta preparada
            $sql = "SELECT id_redes, nombre_red, fecha_inscripcion, tipo_red FROM redes LIMIT ?, ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {

            }

            $stmt->bind_param("ii", $start_index, $results_per_page);
            // Paso 3: Ejecutar la consulta preparada y enlazar los resultados a variables
            $stmt->execute();
            $stmt->bind_result($id_redes, $nombre_red, $fecha_inscripcion, $tipo_red);

            // Paso 4: Mostrar los resultados en las tarjetas
            
            while ($stmt->fetch()) {
                $nombre_red_abreviado = mb_strlen($nombre_red) > 30 ? mb_substr($nombre_red, 0, 30) . '...' : $nombre_red;

                echo '<div class="col">
                    <div class="card">
                        <div class="card-body">
                            <span data-toggle="tooltip" title="' . htmlspecialchars($nombre_red) . '">' . htmlspecialchars($nombre_red_abreviado) . '</span>
                            <br>
                            <br>
                            <h7 class="card-text" style="color: gray;">Tipo de red:</h7>
                            <p class="card-text">' . htmlspecialchars($tipo_red) . '</p>
                            
                            <h7 class="card-text" style="color: gray;">Fecha de creación:</h7>
                            <p class="card-text">' . htmlspecialchars($fecha_inscripcion) . '</p>
                            
                            <a href="detallered.php?id_redes=' . $id_redes . '" class="btn" id="boton"><i class="fas fa-info-circle" style="color: #df6914; margin-right: 6px;"></i> Ver detalles...</a>
                        </div>
                    </div>
                </div>';
                
            }

            // Paso 5: Cerrar el statement y la conexión a la base de datos
            $stmt->close();
            $conn->close();
            ?>

        </div>
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



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>
    <script src="https://kit.fontawesome.com/4b93f520b2.js" crossorigin="anonymous"></script>
</body>

</html>