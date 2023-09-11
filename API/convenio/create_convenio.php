<?php
// Resto del código anterior...
require_once '../../conexion.php';

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica que se hayan enviado los campos requeridos
    $camposRequeridos = array(
        'nombre_institucion',
        'id',
        'nacionalidad',
        'caracteristica',
        'fecha_inscripcion',
        'fecha_expiracion',
        'numero_convenio',
        'tipo_convenio',
        'objeto_descripcion'
    );

    $camposFaltantes = array();

    foreach ($camposRequeridos as $campo) {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            $camposFaltantes[] = $campo;
        }
    }

    if (!empty($camposFaltantes)) {
        echo "Faltan campos requeridos en el formulario: " . implode(', ', $camposFaltantes);
    } else {
        // Verifica si el número de convenio ya existe
        $stmt = mysqli_prepare($conn, "SELECT numero_convenio FROM convenio WHERE numero_convenio = ?");
        mysqli_stmt_bind_param($stmt, "s", $_POST['numero_convenio']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            session_start();
            $_SESSION['nuemeroExiste'] = 'Numero ya existe';
            header("Location: ../../UI/convenio/listarConvenios.php");
           
            mysqli_stmt_close($stmt);
        } else {
            mysqli_stmt_close($stmt);

            $nombre_institucion = $_POST['nombre_institucion'];
        $slug = crearSlug($nombre_institucion);
        $id = $_POST['id'];
        $nacionalidad = $_POST['nacionalidad'];
        $caracteristica = $_POST['caracteristica'];
        $fecha_inscripcion = $_POST['fecha_inscripcion'];
        $fecha_expiracion = $_POST['fecha_expiracion'];
        $numero_convenio = $_POST['numero_convenio'];
        $tipo_convenio = $_POST['tipo_convenio'];
        $objeto_descripcion = $_POST['objeto_descripcion'];

        // Procesa el archivo adjunto (PDF) si se ha enviado
        if (isset($_FILES['archivo']['name']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            $cargar_pdf = time() . "_" . $_FILES['archivo']['name'];
            $archivo_temporal = $_FILES['archivo']['tmp_name'];
            $carpeta_destino = "../../PDF_Convenio/";

            // Movemos el archivo a la carpeta deseada
            if (move_uploaded_file($archivo_temporal, $carpeta_destino . $cargar_pdf)) {
                echo "¡El archivo se ha subido correctamente!\n";
            } else {
                echo "Error al subir el archivo.\n";
            }
        } else {
            $cargar_pdf = ""; // Si no se ha enviado un archivo, dejar el nombre vacío
        }

        $fecha_actual = new DateTime();
        $fecha_expiracion_format = new DateTime($fecha_expiracion);
        $diferencia = $fecha_actual->diff($fecha_expiracion_format);
        $id_estado = 0;

        if ($diferencia->days > 365) {
            $id_estado = 1;
        } else if ($diferencia->days >= 1 && $diferencia->days <= 365) {
            $id_estado = 2;
        } else if ($fecha_actual > $fecha_expiracion_format) {
            $id_estado = 3;
        }


        // Realiza la conexión a la base de datos
        require_once '../../conexion.php';

        // Utilizar sentencias preparadas para evitar inyección de SQL
        $stmt = mysqli_prepare($conn, "INSERT INTO convenio (nombre_institucion, id,id_estado, nacionalidad, caracteristica, fecha_inscripcion, fecha_expiracion, numero_convenio, tipo_convenio, objeto_descripcion, cargar_pdf, slug) VALUES (?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        mysqli_stmt_bind_param($stmt, "ssssssssssss", $nombre_institucion, $id,$id_estado, $nacionalidad, $caracteristica, $fecha_inscripcion, $fecha_expiracion, $numero_convenio, $tipo_convenio, $objeto_descripcion, $cargar_pdf, $slug);

        // Ejecuta la consulta y verifica si se realizó correctamente
        if (mysqli_stmt_execute($stmt)) {
            session_start();
            $_SESSION['createConvenio'] = 'Convenio creado';

            sendMail($conn, $nombre_institucion, $objeto_descripcion);
            header("Location: ../../UI/convenio/listarConvenios.php");
            exit();


        } else {
            echo "Error al registrar el convenio: " . mysqli_error($conn);
        }
            // Cierra la conexión y el statement
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }
}

function sendMail($conn, $nombre, $descripcion)
{

    $query = "SELECT correo FROM usuarios WHERE estado = 1 AND alerta = 1";
    $result = mysqli_query($conn, $query);

    if ($result) {

        if ($result->num_rows > 0) {
            $infoToSendEmail = array(
                'subject' => 'Se ha creado el convenio: ' . $nombre,
                'message' => $descripcion
            );

            $destinatarios = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $destinatarios[] = $row['correo'];
            }

            $infoToSendEmail['emails'] = $destinatarios;

            // Cierra la conexión
            mysqli_free_result($result);

            // Envía el correo
            require_once('../utilities/send-mail.php');
        }
    } else {
        echo "Error al obtener los correos de los usuarios: " . mysqli_error($conn);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
}


function crearSlug($texto)
{
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $texto);
    $slug = strtolower($slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}
?>
