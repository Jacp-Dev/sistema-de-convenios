<?php

require_once '../../conexion.php';


$fecha_actual = new DateTime();

$query = "SELECT * FROM convenio";
$result = $conn->query($query);

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $fecha_expiracion = new DateTime($row["fecha_expiracion"]);

        $diferencia = $fecha_actual->diff($fecha_expiracion);



        $fecha_actual = new DateTime();
        $fecha_expiracion_format = new DateTime($row["fecha_expiracion"]);
        $diferencia = date_diff($fecha_actual, $fecha_expiracion_format );
    
        $diferencia = $diferencia->format('%R%a');

        if ($fecha_expiracion >  $fecha_actual && $diferencia > 365 && $row['id_estado'] != 1) {
           

            actualizar_estado($row['id_convenio'], 1, $conn);
            sendEmail($conn, $row['nombre_institucion'], $row['objeto_descripcion'], "Vigente");

        } else if ($fecha_expiracion >  $fecha_actual && $diferencia >= 0 && $diferencia <= 365 && $row['id_estado'] != 2) {
           

            actualizar_estado($row['id_convenio'], 2, $conn);
            sendEmail($conn, $row['nombre_institucion'], $row['objeto_descripcion'], "Próximo a vencer");

        } else if ( $fecha_expiracion <  $fecha_actual && $row['id_estado'] != 3) {
            
            actualizar_estado($row['id_convenio'], 3, $conn);
            sendEmail($conn, $row['nombre_institucion'], $row['objeto_descripcion'], "Vencido");
        }
    }
}

function actualizar_estado($id_convenio, $id_estado, $conn)
{
    $query = "UPDATE convenio SET id_estado = ? WHERE id_convenio = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_estado, $id_convenio);
    $stmt->execute();
    $stmt->close();
}

function sendEmail($conn, $nombre, $descripcion, $estado)
{

    $query = "SELECT correo FROM usuarios WHERE estado = 1 AND alerta = 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $infoToSendEmail = array(
            'subject' => 'El convenio: ' . $nombre . ' está ' . $estado,
            'message' => $descripcion
        );

        $destinatarios = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $destinatarios[] = $row['correo'];
        }

        $infoToSendEmail['emails'] = $destinatarios;

        mysqli_free_result($result);

        require_once('../utilities/send-mail.php');
    } else {
        echo "Error al obtener los correos de los usuarios: " . mysqli_error($conn);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
}


?>