<?php
require 'funciones.php';
if (usuario_actual()) ir('panel.php');
$errores=[]; $datos=['nombre'=>'','apellido'=>'','dni'=>'','correo'=>''];
if ($_SERVER['REQUEST_METHOD']==='POST') {
    validar_csrf();
    foreach ($datos as $clave=>$valor) $datos[$clave]=trim((string)($_POST[$clave] ?? ''));
    $errores=validar_usuario_form($datos);
    $clave=(string)($_POST['clave'] ?? '');
    if (strlen($clave)<8) $errores[]='La contraseña debe tener al menos 8 caracteres.';
    if (!$errores) {
        require 'conexion.php';
        if (existe_identidad($pdo,$datos['dni'],$datos['correo'])) $errores[]='El DNI o correo ya está registrado.';
        else {
            try {
                $st=$pdo->prepare("INSERT INTO usuarios (nombre,apellido,dni,correo,clave_hash,rol) VALUES (?,?,?,?,?,'usuario')");
                $st->execute([$datos['nombre'],$datos['apellido'],$datos['dni'],$datos['correo'],password_hash($clave,PASSWORD_DEFAULT)]);
                aviso('Cuenta creada. Ahora podés iniciar sesión.');ir('login.php');
            } catch (PDOException $e) { $errores[]='No se pudo crear la cuenta. Revisá los datos.'; }
        }
    }
}
$titulo='Registro';require 'encabezado.php'; ?>
<section class="form-centro"><div class="panel"><span class="etiqueta">NUEVA CUENTA</span><h1>Registrate</h1><p>Completá tus datos para ingresar como cliente.</p>
<?php foreach($errores as $error): ?><div class="error"><?= escapar($error) ?></div><?php endforeach; ?>
<form method="post"><input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>">
<div class="dos-columnas"><label>Nombre<input required maxlength="80" name="nombre" value="<?= escapar($datos['nombre']) ?>"></label><label>Apellido<input required maxlength="80" name="apellido" value="<?= escapar($datos['apellido']) ?>"></label></div>
<label>DNI<input required inputmode="numeric" maxlength="9" name="dni" value="<?= escapar($datos['dni']) ?>"></label>
<label>Correo electrónico<input type="email" required maxlength="150" name="correo" value="<?= escapar($datos['correo']) ?>"></label>
<label>Contraseña<input type="password" required minlength="8" name="clave"></label><button class="boton ancho">Crear cuenta</button></form><p class="nota">¿Ya tenés cuenta? <a href="login.php">Ingresá acá</a>.</p></div></section>
<?php require 'pie.php'; ?>
