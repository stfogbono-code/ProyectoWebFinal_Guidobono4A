<?php
require 'funciones.php';exigir_admin();validar_csrf();require 'conexion.php';
$id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
if(!$id){http_response_code(400);exit('ID inválido.');}
if($id===(int)usuario_actual()['id']){http_response_code(403);exit('No podés archivar tu propia cuenta.');}
$st=$pdo->prepare('UPDATE usuarios SET archivado_en=NOW() WHERE id=? AND archivado_en IS NULL');
$st->execute([$id]);aviso('Cuenta archivada.');ir('admin_usuarios.php');
