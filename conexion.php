<?php
// Configuración local de MySQL para XAMPP.
$host = '127.0.0.1';
$base = 'eliteboots';
$usuario_db = 'root';
$clave_db = ''; // Cambiar si MySQL tiene contraseña.
try {
    $pdo = new PDO("mysql:host=$host;dbname=$base;charset=utf8mb4", $usuario_db, $clave_db, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    exit('No se pudo conectar con la base de datos. Revisá conexion.php y el archivo SQL.');
}
