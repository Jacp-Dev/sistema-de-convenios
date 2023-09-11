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
  <title>Gestión de usuarios</title>
</head>

<body style="background: #E1E8EE;">

  <?php
  require_once '../../header.php';

  ?>

  <div class="container mt-3">
    <p class="fs-4"> <i class="fas fa-users" style="color: #DF6914"></i> Gestión de usuarios
    </p>
    <nav class="navbar navbar-expand-lg">
      <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
        <form class="d-flex" method="GET" action="./gestiondeusuario.php">
          <input class="form-control me-2" type="search" name="busqueda" placeholder="Ingresar búsqueda..."
            aria-label="Search" maxlength="50">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>


        <?php
        if ($_SESSION['rol_id'] === 1) {
          echo '<a href="./nuevoUsuario.php" class="btn btn-warning" style="color: black; margin-left: 5px;">
      <i class="fa fa-user-plus" style="color: blue;"></i> Crear Usuario';
        }
        ?>
        </a>

        <?php
        if ($_SESSION['rol_id'] === 1) {
          echo '<a href="./rol.php" class="btn btn-secondary" style="color: #fff; margin-left: 5px;">
      <i class="fa fa-user-cog" style="color: #fff;"></i> Asignar Rol';
        }
        ?>
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


    <table class="table">
      <thead>
        <tr>
          <th >ESTADO</th>
          <th >ALERTAS</th>
          <th >NOMBRE USUARIO</th>
          <th >CORREO</th>
          <th >TIPO DE USUARIO</th>
          <th >ACCIONES</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Conexión a la base de datos (reemplaza con tus datos de conexión)
        require_once '../../conexion.php';
        $records_per_page = 10;
        // Obtener la página actual desde la URL
        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        // Calcular el desplazamiento para la consulta SQL
        $offset = ($current_page - 1) * $records_per_page;

        // Obtener el valor ingresado en el campo de búsqueda
        $busqueda = $_GET['busqueda'] ?? '';
        $busqueda = mysqli_real_escape_string($conn, $busqueda); // Prevenir SQL injection
        
        // Consulta SELECT con INNER JOIN y cláusula WHERE para filtrar por búsqueda
        $query = "SELECT u.id_usuario, u.nombre, u.correo, u.estado,u.alerta, r.nombre AS rol_nombre
          FROM usuarios u
          INNER JOIN usuarios_rol ur ON u.id_usuario = ur.id_usuario
          INNER JOIN roles r ON ur.id_roles = r.id_roles
          WHERE u.nombre LIKE ? OR
          u.correo LIKE ? OR
          r.nombre LIKE ?
          LIMIT $offset, $records_per_page";

        $total_records_query = "SELECT COUNT(*) AS total FROM convenio";
        $total_records_result = mysqli_query($conn, $total_records_query);
        $total_records_row = mysqli_fetch_assoc($total_records_result);
        $total_records = $total_records_row['total'];
        $total_pages = ceil($total_records / $records_per_page);


        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $query);

        // Comprobar si la preparación de la consulta fue exitosa
        if ($stmt) {
          // Vincular parámetros a la consulta
          $param = "%{$busqueda}%"; // El comodín % se utiliza para buscar coincidencias parciales
          mysqli_stmt_bind_param($stmt, "sss", $param, $param, $param);

          // Ejecutar la consulta
          mysqli_stmt_execute($stmt);

          // Obtener resultados de la consulta
          $resultado = mysqli_stmt_get_result($stmt);

          // Procesar los resultados de la consulta
          while ($row = mysqli_fetch_assoc($resultado)) {
            echo '<tr>';
            echo '<td>';
            if ($_SESSION['rol_id'] === 1) {
              echo '<div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="estadoCheckbox' . $row["id_usuario"] . '"';
              if ($row["estado"] == 1) {
                echo ' checked';
              }
              echo ' onchange="cambiarEstado(' . $row["id_usuario"] . ', this.checked);">
                          <label class="form-check-label" for="estadoCheckbox' . $row["id_usuario"] . '"></label>
                        </div>';
            } else {
              // Mostrar el estado actual en colores diferentes si no es administrador
              if ($row["estado"] == 1) {
                echo '<span style="color: green;">Habilitado</span>';
              } else {
                echo '<span style="color: red;">Deshabilitado</span>';
              }
            }


            echo '<td>';
            if ($_SESSION['rol_id'] === 1) {
              echo '<div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"';
              if ($row["alerta"] == 1) {
                echo ' checked';
              }
              echo ' onchange="cambiarAlerta(' . $row["id_usuario"] . ', this.checked);">
        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
      </div>';
              echo '</td>';
            } else {
              // Mostrar el estado actual en colores diferentes si no es administrador
              if ($row["alerta"] == 1) {
                echo '<span  style="font-family: Arial; font-size: 13px; color: green;">Enviar alertas</span>';
              } else {
                echo '<span style="font-family: Arial; font-size: 13px; color: red;">No enviar alertas</span>';
              }
            }




            echo '<td style="font-family: Arial; font-size: 13px;">' . htmlspecialchars($row["nombre"]) . '</td>'; // Aquí mostramos el nombre del usuario
            echo '<td style="font-family: Arial; font-size: 13px;">' . htmlspecialchars($row["correo"]) . '</td>'; // Aquí mostramos el correo del usuario
            echo '<td style="font-family: Arial; font-size: 13px;">' . htmlspecialchars($row["rol_nombre"]) . '</td>'; // Aquí mostramos el nombre del rol del usuario
            // Columna de acciones con botones Editar y Eliminar
        
            echo '<td class="icon-container">';
            if ($_SESSION['rol_id'] === 1) {
              echo '<a href="actualizarRolUsuario.php?id_usuario=' . htmlspecialchars($row["id_usuario"]) . '" class="btn "style="color:#0a6aa2 ;"><i class="fa fa-pencil"></i></a>';
              echo '<a onclick="confirmarEliminarUsario(event, ' . htmlspecialchars($row["id_usuario"]) . ')" class="btn "style="color: #FF0000 ;"><i class="fas fa-trash-alt"></i></a>';
            } else {
              echo '<span class="btn disabled" style="color: gray;"><i class="fa fa-pencil"></i></span>';
              echo '<span class="btn disabled" style="color: gray;"><i class="fas fa-trash-alt"></i></span>';
            }
            echo '</td>';
            echo '</tr>';


          }

          // Cerrar el statement
          mysqli_stmt_close($stmt);
        } else {
          echo "Error en la preparación de la consulta: " . mysqli_error($conn);
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conn);

        ?>
        <script>
          function cambiarEstado(idUsuario, estado) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
              if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                  // Éxito en la solicitud
                  if (estado) {
                    Swal.fire({
                      icon: 'success',
                      title: 'Usuario habilitado',
                      text: '¡Se ha habilitado el usuario exitosamente!',
                      showConfirmButton: false, // Ocultar el botón "OK"
                      timer: 1500 // Cerrar automáticamente después de 1.5 segundos


                    }).then(() => {
                      location.reload();
                    });
                  } else {
                    Swal.fire({
                      icon: 'warning',
                      title: 'Usuario deshabilitado',
                      text: '¡Se ha deshabilitado el usuario exitosamente!',
                      showConfirmButton: false, // Ocultar el botón "OK"
                      timer: 1500 // Cerrar automáticamente después de 1.5 segundos

                    }).then(() => {
                      location.reload();
                    });
                  }
                } else {
                  // Error en la solicitud
                  alert("Error al cambiar el estado del usuario.");
                }
              }
            };

            xhr.open("GET", "cambiar_estado.php?id_usuario=" + idUsuario + "&estado=" + (estado ? 1 : 0), true);
            xhr.send();
          }
        </script>
        <script>
          function confirmarEliminarUsario(event, id_usuario) {
            event.preventDefault(); // Detiene el comportamiento predeterminado del enlace

            Swal.fire({
              title: "¿Estás seguro?",
              text: "Esta acción eliminará este usuario.",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Sí, eliminar",
              cancelButtonText: "Cancelar"
            }).then((result) => {
              if (result.isConfirmed) {

                window.location.href = "../../API/usuario/delete_usuario.php?id_usuario=" + id_usuario;
              } else {

              }
            });
          }
        </script>

        <script>
          function cambiarAlerta(idUsuario, isChecked) {
            var alerta = isChecked ? 1 : 0; // Convertir isChecked a 1 (checked) o 0 (unchecked)

            // Realizar una solicitud AJAX para actualizar el estado en la base de datos
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
              if (this.readyState === 4 && this.status === 200) {
                // Aquí puedes manejar la respuesta si es necesario
                console.log("Estado actualizado con éxito.");
              }
            };

            xhttp.open("GET", "cambiar_alerta.php?id_usuario=" + idUsuario + "&alerta=" + alerta, true);
            xhttp.send();
          }
        </script>


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
</body>





</table>
</div>


<script src="https://kit.fontawesome.com/4b93f520b2.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>
<?php
if (isset($_SESSION['detetedUserAlert'])) {
  echo "<script>
    swal({
      title: '¿Está seguro(a) de elimiar este usuario?',
      text: '',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        swal('El usuario se ha eliminado!', {
          icon: 'success',
        });
      } else {
        swal('Acción cancelada');
      }
    });
      </script>";
  unset($_SESSION['detetedUserAlert']);
}

if (isset($_SESSION['addUserSuccess'])) {
  echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Registro exitoso',
        text: '¡Debe asignar un rol al usuario!',
        showConfirmButton: false,
        timer: 3000
        
    }).then(() => {
       
    });
    </script>";
  unset($_SESSION['addUserSuccess']);
}

if (isset($_SESSION['rolUserAlert'])) {

  echo "
<script>
    Swal.fire({
        icon: 'success',
        title: 'Asinación exitosa',
        text: '¡Debe habilitar el usuario!',
        showConfirmButton: false,
        timer: 2000
    });
</script>";
  unset($_SESSION['rolUserAlert']);
}
if (isset($_SESSION['updateRolSuccess'])) {
  echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Actualización exitosa',
        text: '¡El rol ha sido actualizado exitosamente!',
        showConfirmButton: false,
        timer: 3000
        
    }).then(() => {
       
    });
    </script>";
  unset($_SESSION['updateRolSuccess']);
}
if (isset($_SESSION['notDetetedUserAdmin'])) {
  echo "<script>
    Swal.fire({
        icon: 'warning',
        title: 'Acción no permitida',
        text: '¡No se puede eliminar un usuario administrador!',
        showConfirmButton: false,
        timer: 3000
        
    }).then(() => {
       
    });
    </script>";
  unset($_SESSION['notDetetedUserAdmin']);
}

?>