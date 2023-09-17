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
 <link rel="icon" href="../../assets/img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
  <title>Detalle convenio</title>
</head>

<body style="background: #E1E8EE;">
  <?php
  require_once '../../header.php';

  ?>
  <?php

  if (isset($_GET["convenio"])) {
    require_once '../../conexion.php';

    $slug = $_GET["convenio"];

    $sql = "SELECT c.*, cat.nombre AS nombre_cat 
              FROM convenio c
              INNER JOIN cat ON c.id = cat.id
              WHERE c.slug = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $convenio = $result->fetch_assoc();
      // Obtener la fecha actual
      // Obtener la fecha actual sin la hora para evitar problemas de precisión.
      $fechaActual = new DateTime(date("Y-m-d"));

      // Obtener la fecha de expiración del convenio sin la hora.
      $fechaExpiracion = new DateTime($convenio["fecha_expiracion"]);
      $fechaExpiracion = new DateTime($fechaExpiracion->format("Y-m-d"));

      // Calcular la diferencia entre las fechas en meses (incluyendo el mes actual).
      $diferenciaMeses = $fechaActual->diff($fechaExpiracion)->m + ($fechaActual->diff($fechaExpiracion)->y * 12);

      // $diferenciaMeses contiene el número de meses entre la fecha actual y la fecha de expiración.
  


    } else {
      echo '<p> Convenio no encontrado.</p>';
    }
  }



  ?>

  <div class="container">
    <nav class="navbar navbar-expand-lg ">
      <ul class="nav justify-content-center">
        <li class="nav-item">
          <p class="text-primary fs-9">
            <a href="./convenios.php"><i class="fa fa-arrow-left" style="color: #DF6914"></i></a>
            Detalles
          </p>
        </li>
      </ul>




      <div class="navbar-nav  ms-auto ms-auto mb-2 mb-lg-0 " >
        <p class="text-dark fs-3">
          Número
          <?php echo '<p class="mt-2 text-warning fs-5" style="margin-left: 30px;">' . $convenio["numero_convenio"] . '</p>'; ?>

        </p>
      </div>





    </nav>
  </div>

  <div class="container">
    <h6 class="card-text" style="color: gray;">INSTITUCIÓN</h6>

    <?php echo '<p>' . $convenio["nombre_institucion"] . '</p>'; ?>
    </p>
    <br>
    <br>

    <div class="row">
      <div class="col  text-primary fs-4">
        <h6 class="card-text" style="color: gray;">CAT</h6>
      </div>
      <div class="col  text-primary fs-4">
        <h6 class="card-text" style="color: gray;">NACIONALIDAD</h6>
      </div>
      <div class="col  text-primary fs-4">
        <h6 class="card-text" style="color: gray;">CARACTERÍSTICA</h6>
      </div>
    
      <div class="col  text-primary fs-4">
        <h6 class="card-text" style="color: gray;">AÑO - SUSCRIPCIÓN</h6>
      </div>
      <div class="col  text-primary fs-4">
        <h6 class="card-text" style="color: gray;">AÑO - EXPIRACIÓN</h6>
      </div>
      <div class="col  text-primary fs-4">
        <h6 class="card-text" style="color: gray;">VIGENCIA</h6>
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <?php echo '<p>' . $convenio["nombre_cat"] . '</p>'; ?>
      </div>
      <div class="col">
        <?php echo '<p>' . $convenio["nacionalidad"] . '</p>'; ?>
      </div>
      <div class="col">
        <?php echo '<p>' . $convenio["caracteristica"] . '</p>'; ?>
      </div>
      
      <div class="col">
        <?php echo '<p>' . $convenio["fecha_inscripcion"] . '</p>'; ?>
      </div>
      <div class="col">
        <?php echo '<p>' . $convenio["fecha_expiracion"] . '</p>'; ?>
      </div>
      <div class="col">
        <?php echo '<p>' . $diferenciaMeses . ' meses</p>'; ?>
      </div>
    </div>
    <br>
    <div>
      <h6 class="card-text" style="color: gray;">TIPO</h6>
      <?php echo '<p>' . $convenio["tipo_convenio"] . '</p>'; ?>
    </div>
    <br>
    <br>
  

    <div class="row">
      <div class="col-10">
        <h6 class="card-text" style="color: gray;">OBJETO</h6>
        <div class="card border-0 " style="width: 50rem; background-color: transparent;">
          <?php echo '<p>' . $convenio["objeto_descripcion"] . '</p>'; ?>
        </div>
      </div>


      <div class="col-2">
        <div class="descarga">
          <br>


          <?php echo '<a download href="../../PDF_Convenio/' . ($convenio["cargar_pdf"]) . '" class="btn"><i class="fas fa-download" style="margin-right: 6px;"></i>Descargar</a>'
            ?>
        </div>
      </div>
    </div>
  </div>



  <script src="https://kit.fontawesome.com/4b93f520b2.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>

</body>

</html>
