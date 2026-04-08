<?php
/**
 * enviar.php — Guarda los datos en la base de datos (Backend/API)
 */
declare(strict_types=1);
session_start();
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

require_once __DIR__ . '/db_config.php';

$response = ['ok' => false, 'msg' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $response['msg'] = 'Método no permitido.';
    echo json_encode($response);
    exit;
}

// ── Rate Limiting (sesión PHP) ───────────────────────────────────────────────
$cooldown_seg = 60;
$ultimo_envio = (int)($_SESSION['cv_last_contacto'] ?? 0);
if ($ultimo_envio > 0 && (time() - $ultimo_envio) < $cooldown_seg) {
    http_response_code(429);
    $restante = $cooldown_seg - (time() - $ultimo_envio);
    $response['msg'] = "Por favor espera {$restante} segundos antes de enviar otro mensaje.";
    echo json_encode($response);
    exit;
}

// ── Validación CSRF ───────────────────────────────────────────────────────────
$token_recv = $_POST['csrf_token'] ?? '';
$token_sess = $_SESSION['csrf_token'] ?? '';
if (empty($token_sess) || !hash_equals($token_sess, $token_recv)) {
    http_response_code(403);
    $response['msg'] = 'Token de seguridad inválido. Recarga la página e inténtalo de nuevo.';
    echo json_encode($response);
    exit;
}
// Opcional: Rotar el token si se requiere mayor seguridad rigurosa
// $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 

// ── SEGURIDAD: HONEYPOT (Trampa para Bots) ────────────────────────────────────
if (!empty($_POST['seguridad_bot'])) {
    $response['ok'] = true; // Engañar al bot simulando éxito
    $response['msg'] = '¡Mensaje enviado con éxito!';
    echo json_encode($response);
    exit;
}

// ── Anti-Bot: Validación de tiempo ────────────────────────────────────────────
$form_time   = (int)($_POST['form_timestamp'] ?? 0);
$form_secret = (string)($_POST['form_secret'] ?? '');
$esperado    = hash_hmac('sha256', (string)$form_time, FORM_SECRET_KEY);

if (!hash_equals($esperado, $form_secret)) {
    http_response_code(403);
    $response['msg'] = 'Token de formulario inválido. Recarga e inténtalo de nuevo.';
    echo json_encode($response);
    exit;
}
$transcurrido = time() - $form_time;
if ($transcurrido < 3 || $transcurrido > 7200) {
    http_response_code(400);
    $response['msg'] = 'El formulario expiró o fue enviado muy rápido. Recarga la página e inténtalo de nuevo.';
    echo json_encode($response);
    exit;
}

// ── SEGURIDAD: SANITIZACIÓN DE DATOS (Anti XSS) ───────────────────────────────
$nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
$telefono = htmlspecialchars(trim($_POST['telefono'] ?? ''), ENT_QUOTES, 'UTF-8');
$correo = filter_var(trim($_POST['correo'] ?? ''), FILTER_SANITIZE_EMAIL);
$siniestro = htmlspecialchars(trim($_POST['siniestro'] ?? ''), ENT_QUOTES, 'UTF-8');
$mensaje = htmlspecialchars(trim($_POST['mensaje'] ?? ''), ENT_QUOTES, 'UTF-8');

if (empty($nombre) || empty($telefono) || empty($mensaje) || empty($correo)) {
    http_response_code(400);
    $response['msg'] = 'Faltan campos obligatorios para procesar la solicitud.';
    echo json_encode($response);
    exit;
}

// IP hasheada — privacidad + anti-spam, sin almacenar la IP directa
$ip_hash = hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . '_cv_salt_contacto');

// ── SEGURIDAD: RESPALDO EN BASE DE DATOS ──────────────────────────────────────
try {
    $pdo = getDB();

    // Validar si el teléfono o correo ya existen (Evitar duplicados)
    $stmtCheck = $pdo->prepare("SELECT id FROM solicitudes WHERE telefono = :telefono OR (correo = :correo AND correo != '') LIMIT 1");
    $stmtCheck->execute([':telefono' => $telefono, ':correo' => $correo]);
    if ($stmtCheck->fetch()) {
        http_response_code(409); // 409 Conflict
        $response['msg'] = 'Ya hemos recibido una solicitud previa con este teléfono o correo. ¡Pronto nos comunicaremos contigo!';
        echo json_encode($response);
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO solicitudes (nombre, telefono, correo, siniestro, mensaje, ip_origen)
        VALUES (:nombre, :telefono, :correo, :siniestro, :mensaje, :ip)
    ");
    $stmt->execute([
        ':nombre' => $nombre,
        ':telefono' => $telefono,
        ':correo' => $correo,
        ':siniestro' => $siniestro,
        ':mensaje' => $mensaje,
        ':ip' => $ip_hash,
    ]);
    
    $_SESSION['cv_last_contacto'] = time();

    $response['ok'] = true;
    $response['msg'] = '¡Mensaje recibido correctamente! Nos comunicaremos contigo pronto.';
    echo json_encode($response);
} catch (Exception $e) {
    error_log("[Construcvida] Error DB: " . $e->getMessage());
    http_response_code(500);
    $response['msg'] = 'Ocurrió un error al procesar tu solicitud. Inténtalo más tarde.';
    echo json_encode($response);
}
exit;
