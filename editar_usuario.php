<?php
require 'funciones.php';exigir_admin();require 'conexion.php';
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
if(!$id){http_response_code(400);exit('ID inválido.');}
$st=$pdo->prepare('SELECT id,nombre,apellido,dni,correo,rol FROM usuarios WHERE id=? AND archivado_en IS NULL');$st->execute([$id]);$datos=$st->fetch();
if(!$datos){http_response_code(404);exit('Usuario no encontrado.');}
$errores=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
 validar_csrf();foreach(['nombre','apellido','dni','correo'] as $k)$datos[$k]=trim((string)($_POST[$k]??''));
 $errores=validar_usuario_form($datos);
 if(!$errores && existe_identidad($pdo,$datos['dni'],$datos['correo'],(int)$id))$errores[]='DNI o correo ya utilizados.';
 if(!$errores){try{$st=$pdo->prepare('UPDATE usuarios SET nombre=?,apellido=?,dni=?,correo=? WHERE id=? AND archivado_en IS NULL');$st->execute([$datos['nombre'],$datos['apellido'],$datos['dni'],$datos['correo'],$id]);aviso('Datos actualizados.');ir('admin_usuarios.php');}catch(PDOException $e){$errores[]='No se pudieron guardar los cambios.';}}
}
$titulo='Editar usuario';require 'encabezado.php'; ?>
<section class="form-centro"><div class="panel"><span class="etiqueta">PANEL ADMIN</span><h1>Editar usuario #<?= (int)$id ?></h1><p>El rol y la contraseña no se modifican desde este formulario.</p><?php foreach($errores as $e): ?><div class="error"><?= escapar($e) ?></div><?php endforeach; ?>
<form method="post" action="editar_usuario.php?id=<?= (int)$id ?>"><input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>"><div class="dos-columnas"><label>Nombre<input required maxlength="80" name="nombre" value="<?= escapar($datos['nombre']) ?>"></label><label>Apellido<input required maxlength="80" name="apellido" value="<?= escapar($datos['apellido']) ?>"></label></div><label>DNI<input required maxlength="9" name="dni" value="<?= escapar($datos['dni']) ?>"></label><label>Correo<input type="email" required maxlength="150" name="correo" value="<?= escapar($datos['correo']) ?>"></label><button class="boton ancho">Guardar cambios</button></form></div></section>
<?php require 'pie.php'; ?>
