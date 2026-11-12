<?php
require 'funciones.php';exigir_admin();validar_csrf();require 'conexion.php';
$id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
$accion=$_POST['accion']??'';
if(!$id||!in_array($accion,['archivar','reactivar'],true)){http_response_code(400);exit('Datos inválidos.');}
$sql=$accion==='archivar'?'UPDATE botines SET archivado_en=NOW() WHERE id=? AND archivado_en IS NULL':'UPDATE botines SET archivado_en=NULL WHERE id=? AND archivado_en IS NOT NULL';
$st=$pdo->prepare($sql);$st->execute([$id]);aviso($accion==='archivar'?'Producto archivado.':'Producto reactivado.');ir('admin_botines.php');
