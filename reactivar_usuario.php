<?php
require 'funciones.php';exigir_admin();validar_csrf();require 'conexion.php';
$id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
if(!$id){http_response_code(400);exit('ID inválido.');}
$st=$pdo->prepare('UPDATE usuarios SET archivado_en=NULL WHERE id=? AND archivado_en IS NOT NULL');
$st->execute([$id]);aviso('Cuenta reactivada.');ir('usuarios_archivados.php');
