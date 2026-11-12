<?php
require 'funciones.php';exigir_admin();require 'conexion.php';
$datos=['nombre'=>'','apellido'=>'','dni'=>'','correo'=>''];$errores=[];
if($_SERVER['REQUEST_METHOD']==='POST') {
 validar_csrf();foreach($datos as $k=>$v)$datos[$k]=trim((string)($_POST[$k]??''));
 $errores=validar_usuario_form($datos);$clave=(string)($_POST['clave']??'');
 if(strlen($clave)<8)$errores[]='La contraseña debe tener al menos 8 caracteres.';
 if(!$errores && existe_identidad($pdo,$datos['dni'],$datos['correo']))$errores[]='El DNI o correo ya existe.';
 if(!$errores){try{$st=$pdo->prepare("INSERT INTO usuarios (nombre,apellido,dni,correo,clave_hash,rol) VALUES (?,?,?,?,?,'usuario')");$st->execute([$datos['nombre'],$datos['apellido'],$datos['dni'],$datos['correo'],password_hash($clave,PASSWORD_DEFAULT)]);aviso('Usuario registrado correctamente.');ir('admin_usuarios.php');}catch(PDOException $e){$errores[]='No se pudo registrar el usuario.';}}
}
$titulo='Nuevo usuario';require 'encabezado.php'; ?>
<section class="form-centro"><div class="panel"><span class="etiqueta">PANEL ADMIN</span><h1>Nuevo usuario</h1><p>Los usuarios nuevos se crean con rol cliente.</p><?php foreach($errores as $e): ?><div class="error"><?= escapar($e) ?></div><?php endforeach; ?>
<form method="post"><input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>"><div class="dos-columnas"><label>Nombre<input required name="nombre" maxlength="80" value="<?= escapar($datos['nombre']) ?>"></label><label>Apellido<input required name="apellido" maxlength="80" value="<?= escapar($datos['apellido']) ?>"></label></div><label>DNI<input required name="dni" maxlength="9" value="<?= escapar($datos['dni']) ?>"></label><label>Correo<input type="email" name="correo" required maxlength="150" value="<?= escapar($datos['correo']) ?>"></label><label>Contraseña<input type="password" name="clave" required minlength="8"></label><button class="boton ancho">Registrar</button></form></div></section>
<?php require 'pie.php'; ?>
