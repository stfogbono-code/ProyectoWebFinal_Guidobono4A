<?php
require 'funciones.php';exigir_admin();require 'conexion.php';
$buscar=trim((string)($_GET['buscar'] ?? ''));
$st=$pdo->prepare('SELECT id,nombre,apellido,dni,correo,rol,creado_en FROM usuarios WHERE archivado_en IS NULL AND (nombre LIKE ? OR apellido LIKE ? OR dni LIKE ? OR correo LIKE ?) ORDER BY id DESC');
$st->execute(array_fill(0,4,'%'.$buscar.'%'));$usuarios=$st->fetchAll();
$titulo='Administrar usuarios';require 'encabezado.php'; ?>
<section class="cabecera"><span class="etiqueta">PANEL ADMIN</span><h1>Gestión de usuarios.</h1><p></p><div class="acciones"><a class="boton" href="nuevo_usuario.php">+ Nuevo usuario</a><a class="boton secundario" href="usuarios_archivados.php">Ver archivados</a></div></section>
<form class="buscador" method="get"><input type="search" name="buscar" value="<?= escapar($buscar) ?>" placeholder="Buscar por nombre, apellido, DNI o correo"><button class="boton">Buscar</button></form>
<div class="tabla-contenedor"><table><thead><tr><th>ID</th><th>Nombre</th><th>DNI</th><th>Correo</th><th>Rol</th><th>Acciones</th></tr></thead><tbody>
<?php foreach($usuarios as $u): ?><tr><td><?= escapar($u['id']) ?></td><td><?= escapar($u['nombre'].' '.$u['apellido']) ?></td><td><?= escapar($u['dni']) ?></td><td><?= escapar($u['correo']) ?></td><td><span class="estado"><?= escapar($u['rol']) ?></span></td><td class="acciones-tabla"><a href="editar_usuario.php?id=<?= (int)$u['id'] ?>">Editar</a><?php if((int)$u['id']!==(int)usuario_actual()['id']): ?><form method="post" action="archivar_usuario.php" onsubmit="return confirm('¿Archivar esta cuenta?')"><input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>"><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><button class="enlace-peligro">Archivar</button></form><?php endif; ?></td></tr><?php endforeach; ?>
<?php if(!$usuarios): ?><tr><td colspan="6">No se encontraron usuarios activos.</td></tr><?php endif; ?></tbody></table></div>
<?php require 'pie.php'; ?>
