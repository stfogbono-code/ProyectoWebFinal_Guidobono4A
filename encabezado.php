<?php
require_once 'funciones.php';
$titulo = $titulo ?? 'Elite Boots';
$actual = usuario_actual();
?><!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= escapar($titulo) ?> | Elite Boots</title><link rel="stylesheet" href="css/estilos.css"></head>
<body><header class="barra"><div class="contenedor barra-interior"><a class="logo" href="index.php"><span class="logo-icono">E</span> ELITE <span>BOOTS</span></a>
<nav><?php if ($actual): ?><a href="catalogo.php">Catálogo</a><?php endif; ?>
<?php if ($actual): ?><a href="panel.php">Mi panel</a><?php if ($actual['rol'] === 'admin'): ?><a href="admin_usuarios.php">Usuarios</a><a href="admin_botines.php">Productos</a><?php endif; ?><a class="nav-destacado" href="cerrar_sesion.php">Salir</a>
<?php else: ?><a href="login.php">Ingresar</a><a class="nav-destacado" href="registro.php">Registrarse</a><?php endif; ?></nav></div></header>
<main class="contenedor contenido">
<?php if (!empty($_SESSION['aviso'])): ?><div class="aviso"><?= escapar($_SESSION['aviso']) ?></div><?php unset($_SESSION['aviso']); endif; ?>
