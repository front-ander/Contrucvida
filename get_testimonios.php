<?php
// ─────────────────────────────────────────────────────────────────────────────
// get_testimonios.php — Endpoint AJAX: retorna los 2 últimos testimonios como JSON
// ─────────────────────────────────────────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
require_once __DIR__ . '/db_config.php';


try {
    $pdo  = getDB();
    $stmt = $pdo->query(
        "SELECT nombre, ciudad, comentario FROM testimonios ORDER BY id DESC LIMIT 2"
    );
    $rows = $stmt->fetchAll();
    echo json_encode(['ok' => true, 'data' => $rows]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'data' => [], 'msg' => 'Error al cargar testimonios.']);
}
