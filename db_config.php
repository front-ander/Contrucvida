<?php
// ─────────────────────────────────────────────────────────────────────────────
// db_config.php — Configuración de base de datos y PDO
// Construcvida | Solo uso interno — NO exponer en producción pública
// ─────────────────────────────────────────────────────────────────────────────

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'construcvida');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');          // Contraseña vacía por defecto en XAMPP
define('DB_CHARSET', 'utf8mb4');

// Clave secreta para firmar tokens de tiempo anti-bot.
// Extraída de variables de entorno (altamente recomendado en Producción).
define('FORM_SECRET_KEY', getenv('FORM_SECRET_KEY') ?: 'ConstrucVida_2026_S3cr3t_K3y!_Cambiar_En_Produccion');

/**
 * Devuelve una instancia PDO singleton.
 * Lanza PDOException si no se puede conectar.
 */
function getDB(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            DB_HOST,
            DB_NAME,
            DB_CHARSET
        );
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    }
    return $pdo;
}
