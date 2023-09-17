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
  <title>Detalle de red</title>
</head>

<body style="background: #E1E8EE;">
  <?php
  require_once '../../header.php';

  ?>

  <div class="container">
    <nav class="navbar navbar-expand-lg ">
      <ul class="nav justify-content-center">
        <li class="nav-item">
          <p class="text-primary fs-3">
            <a href="./dashboardRedes.php"><i class="fa fa-arrow-left" style="color: #DF6914"></i></a>
            Detalles
          </p>
        </li>
      </ul>
      <?php
      require_once '../../conexion.php';

      $id_redes = $_GET['id_redes']; // Supongo que obtienes el id_redes de la URL
      
      // Consulta para obtener la información de la red
      $sql = "SELECT r.*, c.nombre_institucion FROM redes r
        INNER JOIN convenio c ON r.id_convenio = c.id_convenio
        WHERE r.id_redes = $id_redes";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_redes = $row['id_redes'];
        $nombre_red = $row['nombre_red']; // Reemplaza "campo1" con el nombre real del campo
        $fecha_inscripcion = $row['fecha_inscripcion'];
        $tipo_red = $row['tipo_red'];
        $caractistica_red = $row['caractistica_red'];
        $enlace = $row['enlace'];
        $objeto = $row['objeto'];
        $nombre_institucion = $row['nombre_institucion']; // Reemplaza "campo2" con el nombre real del campo
        // Agrega más variables para los otros campos de la tabla
      } else {
        session_start();
        $_SESSION['urlNot'] = 'url incorrecta';

        header("Refresh: 0; url=../../index.php");
        exit;
      }

      $conn->close();
      ?>

      <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
        <p class="text-dark fs-3">
          Numero
        <p class="mt-2 text-warning fs-5" style="margin-left: 5px;">
        <p>
          <?php echo $id_redes; ?>
        </p>
        </p>
        </p>
      </div>
    </nav>
  </div>


  <div class="container">
    <h6 class="card-text" style="color: gray;">NOMBRE DE LA RED</h6>
    <p>
      <?php echo $nombre_red; ?>
    </p>
    <br>
    <br>

    <div class="row">
          <div class="col  text-primary fs-4">
              <h6 class="card-text" style="color: gray;">CONVENIO</h6>
          </div>
          <div class="col  text-primary fs-4">
              <h6 class="card-text" style="color: gray;">NACIONALIDAD</h6>
          </div>
          <div class="col  text-primary fs-4">
              <h6 class="card-text" style="color: gray;">AÑO DE SUSCRIPCIÓN</h6>
          </div>
          <div class="col  text-primary fs-4">
             <h6 class="card-text" style="color: gray;">ENLACE DE ACCESO</h6>
          </div>

    </div>
    <div class="row">
      <div class="col">
        <p>
          <?php echo $nombre_institucion; ?>
        </p>
      </div>
      <div class="col">
        <p>
          <?php echo $caractistica_red; ?>
        </p>
      </div>
      <div class="col">
        <p>
          <?php echo $fecha_inscripcion; ?>
        </p>
      </div>
      <div class="col">
        <?php
        // Supongamos que $enlace contiene el enlace que deseas utilizar
        echo '<a href="' . $enlace . '" class="fas fa-external-link-alt class="btn btn-link" target="_blank"> </a>';
        ?>
      </div>
    </div>
    <div>
      <br>
      <h6 class="card-text" style="color: gray;">TIPO RED</h6>
      <p>
        <?php echo $tipo_red; ?>
      </p>
    </div>

    <div class="row">
      <div class="col-10">
        <br>
        <h6 class="card-text" style="color: gray;">OBJETO</h6>
        <div class="card border-0 " style="width: 50rem; background-color: transparent;">
          <p>
            <?php echo $objeto; ?>
          </p>
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
