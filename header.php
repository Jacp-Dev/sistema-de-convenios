
<?php
require_once '../../session_timeout.php';
// Configura los encabezados para evitar vulnerabilidad de seguridad.
header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: no-referrer");
header("Feature-Policy: none");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<header>
  <nav class="navbar navbar-expand-lg" style="background-color: #fff;">
    <div class="container-fluid">
      <a class="navbar-brand" href="../convenio/convenios.php"><img src="../../assets/img/logo-fucla.png"
          alt="Logo Fucla"></a>
      <div class="separador-vertical"></div>
      <a class="navbar-brand text-warning fs-1" href="../convenio/convenios.php">Gestión de convenios</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
          <ul class="menu">
            <li><a href="../convenio/grafico.php"><i class="fas fa-chart-bar" style="color: #DF6914"></i> Ver
                gráfico</a></li>
            <li><a href="../usuario/gestiondeusuario.php"><i class="fas fa-users" style="color: #DF6914"></i> Gestión
                de usuarios</a></li>
            <li><a href="../convenio/listarConvenios.php"><i class="fas fa-folder" style="color: #DF6914"></i> Gestión
                de
                convenios</a></li>
            <li><a href="../redes/dashboardRedes.php"><i class="fas fa-network-wired" style="color: #DF6914"></i>
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

              <form action="../../API/login/logout.php" method="post" style="display: flex; align-items: center;">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <button type="submit" id="logout" style="border: none; background: none; cursor: pointer;">
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

<body>

</body>

</html>
