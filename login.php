<?php
require 'funciones.php';
if (usuario_actual()) ir('panel.php');
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    validar_csrf();
    $correo=trim((string)($_POST['correo'] ?? ''));
    $clave=(string)($_POST['clave'] ?? '');
    require 'conexion.php';
    $st=$pdo->prepare('SELECT id,nombre,apellido,dni,correo,rol,clave_hash,archivado_en FROM usuarios WHERE correo = ? LIMIT 1');
    $st->execute([$correo]);$u=$st->fetch();
    if ($u && $u['archivado_en']===null && password_verify($clave,$u['clave_hash'])) {
        session_regenerate_id(true);
        unset($u['clave_hash'],$u['archivado_en']);
        $_SESSION['usuario']=$u;
        ir('panel.php');
    }
    $error='Correo o contraseña incorrectos, o cuenta no disponible.';
}
$titulo='Ingresar';require 'encabezado.php'; ?>
<section class="form-centro"><div class="panel"><span class="etiqueta">ELITE BOOTS · ACCESO</span><h1>Log in</h1><p>Accedé con tu correo electrónico y contraseña.</p>
<?php if($error): ?><div class="error"><?= escapar($error) ?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>"><label>Correo electrónico<input type="email" name="correo" required></label><label>Contraseña<input type="password" name="clave" required></label><button class="boton ancho">Ingresar</button></form><p class="nota">¿No tenés cuenta? <a href="registro.php">Registrate</a></p></div></section>
<?php require 'pie.php'; ?>
