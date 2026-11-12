<?php
require 'funciones.php';exigir_admin();require 'conexion.php';
$usuarios=$pdo->query('SELECT id,nombre,apellido,dni,correo,archivado_en FROM usuarios WHERE archivado_en IS NOT NULL ORDER BY archivado_en DESC')->fetchAll();
$titulo='Usuarios archivados';require 'encabezado.php'; ?>
<section class="cabecera"><span class="etiqueta">PANEL ADMIN</span><h1>Usuarios archivados.</h1><p>Las cuentas se conservan y pueden reactivarse.</p><a class="boton secundario" href="admin_usuarios.php">Volver a activos</a></section>
<div class="tabla-contenedor"><table><thead><tr><th>ID</th><th>Nombre</th><th>DNI</th><th>Correo</th><th>Archivado</th><th>Acción</th></tr></thead><tbody><?php foreach($usuarios as $u): ?><tr><td><?= (int)$u['id'] ?></td><td><?= escapar($u['nombre'].' '.$u['apellido']) ?></td><td><?= escapar($u['dni']) ?></td><td><?= escapar($u['correo']) ?></td><td><?= escapar($u['archivado_en']) ?></td><td><form method="post" action="reactivar_usuario.php"><input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>"><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><button class="enlace-accion">Reactivar</button></form></td></tr><?php endforeach; ?><?php if(!$usuarios): ?><tr><td colspan="6">No hay usuarios archivados.</td></tr><?php endif; ?></tbody></table></div>
<?php require 'pie.php'; ?>
