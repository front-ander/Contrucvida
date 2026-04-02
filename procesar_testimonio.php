<?php
// ─────────────────────────────────────────────────────────────────────────────
// procesar_testimonio.php — Backend seguro de testimonios
// Protecciones: CSRF · Honeypot · Anti-bot tiempo · XSS · SQL Injection · Rate Limit
// ─────────────────────────────────────────────────────────────────────────────
session_start();
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
require_once __DIR__ . '/db_config.php';


$response = ['ok' => false, 'msg' => ''];

// ── Solo HTTP POST ───────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $response['msg'] = 'Método no permitido.';
    echo json_encode($response);
    exit;
}

// ── 3.6 Rate Limiting (sesión PHP) ───────────────────────────────────────────
$cooldown_seg = 60;
$ultimo_envio = (int)($_SESSION['cv_last_testimonio'] ?? 0);
if ($ultimo_envio > 0 && (time() - $ultimo_envio) < $cooldown_seg) {
    $restante = $cooldown_seg - (time() - $ultimo_envio);
    $response['msg'] = "Espera {$restante} segundos antes de enviar otro testimonio.";
    echo json_encode($response);
    exit;
}

// ── 3.2 Validación CSRF ───────────────────────────────────────────────────────
$token_recv = $_POST['csrf_token'] ?? '';
$token_sess = $_SESSION['csrf_token'] ?? '';
if (empty($token_sess) || !hash_equals($token_sess, $token_recv)) {
    http_response_code(403);
    $response['msg'] = 'Token de seguridad inválido. Recarga la página e inténtalo de nuevo.';
    echo json_encode($response);
    exit;
}
// Rotar el token tras cada uso
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// ── Anti-Bot: Honeypot ────────────────────────────────────────────────────────
// El campo "website" es invisible para humanos. Si está lleno, es un bot.
if (!empty($_POST['website'])) {
    // Fingimos éxito para no alertar al bot
    $response['ok']  = true;
    $response['msg'] = '¡Gracias! Tu testimonio fue registrado.';
    echo json_encode($response);
    exit;
}

// ── Anti-Bot: Validación de tiempo ────────────────────────────────────────────
// Los bots envían el formulario de forma instantánea. Exigimos mínimo 3 segundos.
$form_time   = (int)($_POST['form_timestamp'] ?? 0);
$form_secret = (string)($_POST['form_secret'] ?? '');
$esperado    = hash_hmac('sha256', (string)$form_time, FORM_SECRET_KEY);

if (!hash_equals($esperado, $form_secret)) {
    $response['msg'] = 'Token de formulario inválido. Recarga e inténtalo de nuevo.';
    echo json_encode($response);
    exit;
}
$transcurrido = time() - $form_time;
if ($transcurrido < 3) {
    $response['msg'] = 'Formulario enviado demasiado rápido. ¿Eres un robot?';
    echo json_encode($response);
    exit;
}
if ($transcurrido > 7200) {
    $response['msg'] = 'El formulario expiró. Recarga la página e inténtalo de nuevo.';
    echo json_encode($response);
    exit;
}

// ── 3.3 Sanitización estricta (prevención XSS) ───────────────────────────────
$nombre     = htmlspecialchars(trim($_POST['t_nombre']     ?? ''), ENT_QUOTES, 'UTF-8');
$ciudad     = htmlspecialchars(trim($_POST['t_ciudad']     ?? ''), ENT_QUOTES, 'UTF-8');
$comentario = htmlspecialchars(trim($_POST['t_comentario'] ?? ''), ENT_QUOTES, 'UTF-8');

// Validaciones de longitud
if (mb_strlen($nombre) < 2 || mb_strlen($nombre) > 100) {
    $response['msg'] = 'El nombre debe tener entre 2 y 100 caracteres.';
    echo json_encode($response);
    exit;
}
if (mb_strlen($comentario) < 10 || mb_strlen($comentario) > 500) {
    $response['msg'] = 'El comentario debe tener entre 10 y 500 caracteres.';
    echo json_encode($response);
    exit;
}
if (mb_strlen($ciudad) > 100) {
    $ciudad = mb_substr($ciudad, 0, 100);
}

// IP hasheada — privacidad + anti-spam, sin almacenar la IP directa
$ip_hash = hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . '_cv_salt_2026');

// ── 3.4 PDO Prepared Statements + 3.5 Transacción ───────────────────────────
try {
    $pdo = getDB();
    $pdo->beginTransaction();

    // INSERT nuevo testimonio
    $stmt = $pdo->prepare(
        "INSERT INTO testimonios (nombre, ciudad, comentario, ip_hash)
         VALUES (:nombre, :ciudad, :comentario, :ip_hash)"
    );
    $stmt->bindParam(':nombre',     $nombre,     PDO::PARAM_STR);
    $stmt->bindParam(':ciudad',     $ciudad,     PDO::PARAM_STR);
    $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
    $stmt->bindParam(':ip_hash',    $ip_hash,    PDO::PARAM_STR);
    $stmt->execute();

    // ✅ NO se borran registros anteriores.
    // La BD conserva TODOS los testimonios para revisión interna.
    // El sitio web muestra solo los 2 más recientes via SELECT ... LIMIT 2.

    $pdo->commit();

    // Registrar envío en sesión (rate limiting)
    $_SESSION['cv_last_testimonio'] = time();

    $response['ok']  = true;
    $response['msg'] = "¡Gracias, {$nombre}! Tu testimonio fue publicado.";

} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    // Loguear sin exponer detalles técnicos al usuario
    error_log('[Construcvida] Error PDO en testimonios: ' . $e->getMessage());
    $response['msg'] = 'Error al guardar el testimonio. Inténtalo más tarde.';
}

echo json_encode($response);
