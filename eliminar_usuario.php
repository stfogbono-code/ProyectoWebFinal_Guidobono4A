
<?php
require 'funciones.php';
exigir_admin();
require 'conexion.php';
validar_csrf();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id || $id == usuario_actual()['id']) {
    exit('Usuario inválido.');
}

$st = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
$st->execute([$id]);

ir('admin_usuarios.php');
