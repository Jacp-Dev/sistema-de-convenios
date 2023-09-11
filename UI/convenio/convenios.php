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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">




  <title> Gestion de Convenios </title>


</head>

<body style="background: #E1E8EE;">
  <?php
  require_once '../../header.php';

  ?>
  <div class="container">
    <nav class="navbar navbar-expand-lg ">
      <ul class="nav justify-content-center">
        <li class="nav-item">
          <p class="text-primary fs-3">Bienvenido 💫</p>

      </ul>
      <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
        <form class="d-flex" onsubmit="buscarConvenios(event)">
          <input class="form-control me-2" type="search" name="busqueda" placeholder="Buscar" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>


      </div>
    </nav>

  </div>

  <section>

    <div class=" container espacio">
      <div class="row row-cols-1 row-cols-md-5 ">

        <?php
        $records_per_page = 12;
        require_once '../../conexion.php';

        // Consulta SQL para contar el número total de registros
        $sql_count = "SELECT COUNT(*) AS total_records FROM convenio";
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $total_records = $row_count['total_records'];
        // Calcular el número total de páginas
        $total_pages = ceil($total_records / $records_per_page);


        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;


        $current_page = max(1, min($current_page, $total_pages));


        $offset = ($current_page - 1) * $records_per_page;


        $sql = "SELECT nombre_institucion, fecha_inscripcion FROM convenio LIMIT $offset, $records_per_page";


        $sql = "SELECT nacionalidad, COUNT(*) AS cantidad FROM convenio GROUP BY nacionalidad";
        $result = $conn->query($sql);



        $sql_vigencia = "SELECT * FROM convenio WHERE DATEDIFF(fecha_expiracion, NOW()) >= 1 AND DATEDIFF(fecha_expiracion, NOW()) <= 365";
        $result_vigencia = $conn->query($sql_vigencia);
        $cantidad_vigencia = $result_vigencia->num_rows;



        $sql_vigente = "SELECT * FROM convenio WHERE DATEDIFF(fecha_expiracion, NOW()) > 365";
        $result_vigente = $conn->query($sql_vigente);
        $cantidad_vigente = $result_vigente->num_rows ;



        $sql_vencidos = "SELECT * FROM convenio WHERE DATEDIFF(NOW(), fecha_expiracion) > 0";
        $result_vencidos = $conn->query($sql_vencidos);
        $cantidad_vencidos = $result_vencidos->num_rows;


        // Mostrar el "card" de convenios  vigentes
        echo '<div class="col">
            <div class="card mb-3" style="width: 15rem; height: 8rem;" id="my-border1">
              <div class="card-body">
                <h5 class="card-title text-success">✅ Vigentes</h5>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="descarga">
                  <button onClick="downloadVigenteAll()" class="btn"><i class="fas fa-download" style="margin-right: 6px;"></i>Descargar</button>
                  </div>
                  <div class="valor">
                    <p class="card-text text-end fs-2 text-success">' . $cantidad_vigente . '</p>
                  </div>
                </div>
              </div>
            </div>
            </div>';

        while ($row = $result_vigente->fetch_assoc()) {
          echo '<li hidden>
                              <a class="downloadVigenteAll-pdf" download href="../../PDF_Convenio/' . htmlspecialchars($row["cargar_pdf"]) . '">Descargar</a>
                            </li>';
        }
        while ($row = $result_vigencia->fetch_assoc()) {
          echo '<li hidden>
                                <a class="downloadProximoAvencereAll-pdf" download href="../../PDF_Convenio/' . htmlspecialchars($row["cargar_pdf"]) . '">Descargar</a>
                              </li>';
        }
        while ($row = $result_vencidos->fetch_assoc()) {
          echo '<li hidden>
                      <a class="downloadVencidosAll-pdf" download href="../../PDF_Convenio/' . htmlspecialchars($row["cargar_pdf"]) . '">Descargar</a>
                    </li>';
        }

        echo '
              <script>
            function downloadPdf(pdf){
              pdf.click();
            }

            function downloadVigenteAll(){
              const enlaces = document.getElementsByClassName("downloadVigenteAll-pdf");
              const enlaces2 = document.getElementsByClassName("downloadProximoAvencereAll-pdf");
              for(let i = 0; i <= enlaces.length; i++){
                downloadPdf(enlaces[i]);
              }
              for(let i = 0; i <= enlaces2.length; i++){
                downloadPdf(enlaces2[i]);
              }
            }

            function downloadProximoVencerAll(){
              const enlaces = document.getElementsByClassName("downloadProximoAvencereAll-pdf");
              for(let i = 0; i <= enlaces.length; i++){
                downloadPdf(enlaces[i]);
              }
            }
            function downloadVencidosAll(){
              const enlaces = document.getElementsByClassName("downloadVencidosAll-pdf");
              for(let i = 0; i <= enlaces.length; i++){
                downloadPdf(enlaces[i]);
              }
            }
          </script>
          ';


        // Mostrar el "card" de convenios próximos a vencer
        echo '<div class="col">
            <div class="card mb-3" style="width: 15rem; height: 8rem;" id="my-border1">
              <div class="card-body">
                <h5 class="card-title text-warning">⏳ Próximos a vencer</h5>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="descarga">
                    <button onClick="downloadProximoVencerAll()" class="btn"><i class="fas fa-download" style="margin-right: 6px;"></i>Descargar</button>
                  </div>
                  <div class="valor">
                    <p class="card-text text-end fs-2 text-success">' . $cantidad_vigencia . '</p>
                  </div>
                </div>

              </div>
            </div>
            </div>';


        // Mostrar el "card" de convenios vencidos
        echo '<div class="col">
            <div class="card mb-3" style="width: 15rem; height: 8rem;" id="my-border1">
              <div class="card-body">
                <h5 class="card-title text-danger">🔴 Vencidos</h5>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="descarga">
                    <button onClick="downloadVencidosAll()" class="btn"><i class="fas fa-download" style="margin-right: 6px;"></i>Descargar</button>
                  </div>
                  <div class="valor">
                    <p class="card-text text-end fs-2 text-success">' . $cantidad_vencidos . '</p>
                  </div>
                </div>
                
              </div>
            </div>
            </div>';
        // Verificar si se obtuvieron resultados
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            // Mostrar el valor de la nacionalidad y la cantidad en el "card"
            $icono = ($row["nacionalidad"] === "Nacional") ? '<img src="../../assets/img/colombia.png" alt="Colombia" style="margin-right: 6px; height: 24px; vertical-align: middle;"> ' : '🌎';

            echo '<div class="col">
            <div class="card mb-3" style="width: 15rem; height: 8rem;" id="my-border1">
              <div class="card-body">
                <h5 class="card-title text-primary">' . $icono . '' . $row["nacionalidad"] . '</h5>
                <div class="valor">
                  <p class="card-text text-end fs-2 text-primary">' . $row["cantidad"] . '</p>
                </div>
                <div class="descarga">
                  <a href="#" class="btn btn-secondary"<i class="fas fa-download" style="margin-right: 6px;"></i>Descargar</a>
                </div>
              </div>
            </div>
          </div>';
          }
        }

        ?>
      </div>
    </div>


  </section>

  <div class="container">
    <div class="separador "></div>

    <div class="row row-cols-1 row-cols-md-6 g-3">

      <?php

      require_once '../../conexion.php';

      // Obtener el valor ingresado en el campo de búsqueda y convertirlo a minúsculas
      $busqueda = $_GET['busqueda'] ?? '';
      $busqueda = mysqli_real_escape_string($conn, $busqueda);
      $busqueda_lower = strtolower($busqueda);

      $sql = "SELECT c.nombre_institucion, c.fecha_inscripcion, c.fecha_expiracion, e.name estado, c.slug, c.habilitado
      FROM convenio c 
      INNER JOIN convenio_estados e ON e.id = c.id_estado 
      WHERE LOWER(nombre_institucion) LIKE '%$busqueda_lower%'
      OR LOWER(e.name) LIKE '%$busqueda_lower%'
      OR fecha_inscripcion LIKE '%$busqueda_lower%'";


      // Agrega la parte de paginación a la consulta SQL
      $offset = ($current_page - 1) * $records_per_page;
      $sql .= " LIMIT $offset, $records_per_page";

      $result = $conn->query($sql);

      // Resto del código para mostrar las tarjetas de convenio
      

      $colors = array(
        "Vigente" => "green",
        "Próximo a vencer" => "orange",
        "Vencido" => "red"
      );

      $iconos = array(
        "Vigente" => "✅",
        "Próximo a vencer" => "⏳",
        "Vencido" => "🔴",
      );

      // Verificar si hay resultados y mostrar el nombre del convenio en la tarjeta HTML
      $fecha_actual = new DateTime();
      $estado = "";

      if ($result->num_rows > 0) {
        $cards = array(); // Array to store card information
      
        while ($row = $result->fetch_assoc()) {
          if ($row["habilitado"] == 1) {
            $nombre = $row["nombre_institucion"];
            $fecha_expiracion = new DateTime($row["fecha_expiracion"]);

            // Calcular la diferencia entre la fecha actual y la fecha de expiración
            $diferencia = $fecha_actual->diff($fecha_expiracion);

            
            $estado = $row["estado"];

            $estado_color = isset($colors[$estado]) ? $colors[$estado] : "gray";
            $nombre_abreviado = mb_strlen($nombre) > 40 ? mb_substr($nombre, 0, 40) . '...' : $nombre;

            $cards[] = array(
                'estado' => $estado,
                'info' => '<div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h7 class="card-title" style="color: black;">
                                        <span data-toggle="tooltip" title="' . htmlspecialchars($nombre) . '">' . htmlspecialchars($nombre_abreviado) . '</span>
                                    </h7>
                                    <br>
                                    <h6 class="card-text" style="color: gray;">Estado</h6>
                                    <p class="card-text" style="color: ' . $estado_color . '; ">' . $iconos[$estado] . " " . $estado . '</p>
                                    <h6 class="card-text" style="color: gray;">Fecha expiración</h6>
                                    <p class="card-text " style="color: gray;">' . $fecha_expiracion->format("Y-m-d") . '</p>
                                    <a href="./detalleConvenio.php?convenio=' . $row["slug"] . '" class="btn" id="boton">
                                        <i class="fas fa-info-circle" style="color: #DF6914; margin-right: 6px;"></i>
                                        Ver detalles...
                                    </a>
                                </div>
                            </div>
                        </div>'
            );
            
          
          }
        }

        // Función personalizada de ordenamiento y ordenar las tarjetas
        function customSort($a, $b)
        {
          $stateOrder = array("Vigente", "Próximo a vencer", "Vencido");
          return array_search($a['estado'], $stateOrder) - array_search($b['estado'], $stateOrder);
        }

        // Ordenar las tarjetas usando la función de clasificación personalizada
        usort($cards, 'customSort');
        // Mostrar las tarjetas ordenadas
        foreach ($cards as $card) {
          echo $card['info'];
        }
      } else {
        echo "No se encontró ningún convenio.";
      }

      // Cerrar la conexión
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
  <script src="../js/logout.js"></script>
  <footer>
    <div class="container">
      <p style="color: gray;">Hecho con ❤️ por el estudiante: José Alirio Cabrera Palacios...</p>
    </div>
  </footer>

</body>

</html>