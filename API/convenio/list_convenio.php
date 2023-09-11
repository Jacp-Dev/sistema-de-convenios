<?php
require_once '../../conexion.php';
include '../../library/consulSQL.php';

// Verificar que se esté utilizando el método GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(array('error' => 'Método no permitido'));
    exit();
}

$response = array();

$query = "SELECT * FROM convenio";
$result = $conn->query($query);

if ($result) {
    $convenios = array();

    while ($row = $result->fetch_assoc()) {
        $convenio = array(
            'numero_convenio' => $row['numero_convenio'],
            'nombre_institucion' => $row['nombre_institucion'],
            'id' => $row['id'],
            'tipo_convenio' => $row['tipo_convenio'],
            'caracteristica' => $row['caracteristica'],
            'fecha_inscripcion' => $row['fecha_inscripcion'],
            'fecha_expiracion' => $row['fecha_expiracion'],
            'cargar_pdf' => $row['cargar_pdf'],
            'objeto_descripcion' => $row['objeto_descripcion']
        );

        $convenios[] = $convenio;
    }

    $response['success'] = true;
    $response['convenios'] = $convenios;
} else {
    $response['success'] = false;
    $response['error'] = "Error al obtener el listado de convenios";
}

header('Content-Type: application/json');

echo json_encode($response);

$conn->close();
?>
