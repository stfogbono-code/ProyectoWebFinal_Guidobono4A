<?php
// Ejecutar UNA VEZ desde la terminal: php scripts/crear_admin.php
if (PHP_SAPI !== 'cli') exit("Solo se puede ejecutar desde la terminal.\n");
require dirname(__DIR__) . '/conexion.php';
function preguntar(string $texto): string {echo $texto;return trim((string)fgets(STDIN));}
$nombre=preguntar('Nombre del administrador: ');
$apellido=preguntar('Apellido: ');
$dni=preguntar('DNI (7 a 9 números): ');
$correo=preguntar('Correo: ');
$clave=preguntar('Contraseña (mínimo 8 caracteres): ');
if (!$nombre||!$apellido||!preg_match('/^[0-9]{7,9}$/',$dni)||!filter_var($correo,FILTER_VALIDATE_EMAIL)||strlen($clave)<8){exit("Datos inválidos.\n");}
$st=$pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE rol='admin'");
if((int)$st->fetchColumn()!==0)exit("Ya existe un administrador. No se permite crear otro desde este instalador.\n");
try{$st=$pdo->prepare("INSERT INTO usuarios (nombre,apellido,dni,correo,clave_hash,rol) VALUES (?,?,?,?,?,'admin')");$st->execute([$nombre,$apellido,$dni,$correo,password_hash($clave,PASSWORD_DEFAULT)]);echo "Administrador creado. Ya podés iniciar sesión.\n";}catch(PDOException $e){exit("Error: DNI o correo duplicado u otro problema con MySQL.\n");}
