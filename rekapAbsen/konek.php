<?php
// Load .env from project root if available
$envFile = dirname(__DIR__) . '/.env';
if (!file_exists($envFile)) {
    $envFile = dirname(dirname(__DIR__)) . '/.env';
}
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $val) = explode('=', $line, 2);
            $key = trim($key);
            $val = trim($val, " \t\n\r\0\x0B\"'");
            if (getenv($key) === false) {
                putenv("$key=$val");
            }
        }
    }
}

$host = getenv('DB_HOST') ?: '127.0.0.1';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '';
$name = getenv('DB_DATABASE') ?: 'u317499974_absensiswa';
$db = mysqli_connect($host, $user, $pass, $name);
