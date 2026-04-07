<?php
/**
 * enviar.php — Guarda los datos en la base de datos (Backend/API)
 */
declare(strict_types=1);
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false]);
    exit;
}

// ── 1. SEGURIDAD: HONEYPOT (Trampa para Bots) ───────────────────────────
if (!empty($_POST['seguridad_bot'])) {
    echo json_encode(['ok' => true]); // Engañar al bot simulando éxito
    exit;
}

// ── 2. SEGURIDAD: SANITIZACIÓN DE DATOS (Anti XSS) ──────────────────────
$nombre = htmlspecialchars(strip_tags(trim($_POST['nombre'] ?? '')), ENT_QUOTES, 'UTF-8');
$telefono = htmlspecialchars(strip_tags(trim($_POST['telefono'] ?? '')), ENT_QUOTES, 'UTF-8');
$correo = filter_var(trim($_POST['correo'] ?? ''), FILTER_SANITIZE_EMAIL);
$siniestro = htmlspecialchars(strip_tags(trim($_POST['siniestro'] ?? '')), ENT_QUOTES, 'UTF-8');
$mensaje = htmlspecialchars(strip_tags(trim($_POST['mensaje'] ?? '')), ENT_QUOTES, 'UTF-8');
$ip_origen = $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';

if (empty($nombre) || empty($telefono) || empty($mensaje)) {
    echo json_encode(['ok' => false]);
    exit;
}

// ── 3. SEGURIDAD: RESPALDO EN BASE DE DATOS ──────────────────────────────
require_once __DIR__ . '/db_config.php';

try {
    $pdo = getDB();

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS solicitudes (
            id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nombre      VARCHAR(100)  NOT NULL,
            telefono    VARCHAR(20)   NOT NULL,
            correo      VARCHAR(150)  DEFAULT NULL,
            siniestro   VARCHAR(50)   NOT NULL,
            mensaje     TEXT          NOT NULL,
            ip_origen   VARCHAR(45)   DEFAULT NULL,
            estado      ENUM('nuevo','en_gestion','resuelto') NOT NULL DEFAULT 'nuevo',
            created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    $stmt = $pdo->prepare("
        INSERT INTO solicitudes (nombre, telefono, correo, siniestro, mensaje, ip_origen)
        VALUES (:nombre, :telefono, :correo, :siniestro, :mensaje, :ip)
    ");
    $stmt->execute([
        ':nombre' => $nombre,
        ':telefono' => $telefono,
        ':correo' => !empty($correo) ? $correo : null,
        ':siniestro' => $siniestro,
        ':mensaje' => $mensaje,
        ':ip' => $ip_origen,
    ]);

    echo json_encode(['ok' => true]);
} catch (Exception $e) {
    error_log("[Construcvida] Error DB: " . $e->getMessage());
    echo json_encode(['ok' => false]);
}
exit;
