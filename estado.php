<?php
header('Content-Type: application/json; charset=UTF-8');
$id = $_GET['id'] ?? '';
$archivo = __DIR__ . '/solicitudes.json';

// Carga el JSON existente (o array vacío si no existe)
if (file_exists($archivo)) {
    $data = json_decode(file_get_contents($archivo), true);
} else {
    $data = [];
}

// Si existe la solicitud, devuelve su estado, si no, “pendiente”
$status = $data[$id]['status'] ?? 'pendiente';
echo json_encode(['status' => $status]);