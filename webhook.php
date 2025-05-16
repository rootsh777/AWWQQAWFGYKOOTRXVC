<?php
// webhook.php
$input = json_decode(file_get_contents('php://input'), true);
$text = $input['message']['text'] ?? '';
$chat_id = $input['message']['chat']['id'] ?? '';
$archivo = __DIR__ . '/solicitudes.json';

// Carga o inicializa
$data = file_exists($archivo)
  ? json_decode(file_get_contents($archivo), true)
  : [];

// Procesa comandos
if (preg_match('/^\/(aprobar|rechazar)_(.+)$/', $text, $m)) {
  $action = $m[1];       // 'aprobar' o 'rechazar'
  $id = $m[2];           // el ID de la solicitud
  $status = $action === 'aprobar' ? 'aprobado' : 'rechazado';

  // Actualiza JSON
  $data[$id]['status'] = $status;
  file_put_contents($archivo, json_encode($data, JSON_PRETTY_PRINT));

  // Envía mensaje de confirmación
  $reply = "Solicitud *$id* fue *" . strtoupper($status) . "*.";
  file_get_contents("https://api.telegram.org/bot7732026260:AAGS1T29BwTra3Sc2ic9hoKfF4iuIcgMUwo/sendMessage?"
    . http_build_query([
        'chat_id'    => $chat_id,
        'text'       => $reply,
        'parse_mode' => 'Markdown'
    ]));
}
