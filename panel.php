<?php
require 'funciones.php';exigir_login();$u=usuario_actual();
require 'conexion.php';
$st=$pdo->query('SELECT marca, modelo, talle, precio, imagen FROM botines WHERE archivado_en IS NULL ORDER BY id DESC LIMIT 3');
$destacados=$st->fetchAll();
$titulo='Mi panel';require 'encabezado.php'; ?>
<section class="cabecera"><span class="etiqueta"></span><h1>Hola, <?= escapar($u['nombre']) ?>.</h1><p>Este es tu espacio personal en Elite Boots.</p></section>
<div class="tarjetas dos"><section class="panel"><h2>Mis datos</h2><div class="datos"><p><b>Nombre:</b> <?= escapar($u['nombre'].' '.$u['apellido']) ?></p><p><b>DNI:</b> <?= escapar($u['dni']) ?></p><p><b>Correo:</b> <?= escapar($u['correo']) ?></p><p><b>Rol:</b> <?= escapar($u['rol']==='admin'?'Administrador':'Cliente') ?></p></div></section><section class="panel"><h2>Accesos rápidos</h2><p>Explorá los botines disponibles en nuestra tienda.</p><a class="boton" href="catalogo.php">Ver catálogo</a><?php if($u['rol']==='admin'): ?><hr><p>Administrá usuarios y productos.</p><div class="acciones"><a class="boton secundario" href="admin_usuarios.php">Usuarios</a><a class="boton secundario" href="admin_botines.php">Botines</a></div><?php endif; ?></section></div>
<?php if($destacados): ?>
<h2 class="vitrina-titulo">Botines de la tienda</h2>
<p class="vitrina-nota">Una vista rápida de los productos disponibles.</p>
<div class="tarjetas autos">
<?php foreach($destacados as $botin): ?>
<article class="tarjeta auto">
<div class="auto-imagen"><?php if(!empty($botin['imagen'])): ?><img class="foto-botin" src="<?= escapar($botin['imagen']) ?>" alt="<?= escapar($botin['marca'].' '.$botin['modelo']) ?>"><?php else: ?><span><?= escapar(strtoupper($botin['marca'])) ?></span><span class="auto-icono">EB</span><span>FOTO PRÓXIMAMENTE</span><?php endif; ?></div>
<div class="auto-info"><span class="etiqueta">TALLE <?= escapar((string)$botin['talle']) ?></span><h2><?= escapar($botin['marca'].' '.$botin['modelo']) ?></h2><strong>$ <?= escapar(number_format((float)$botin['precio'],0,',','.')) ?></strong></div>
</article>
<?php endforeach; ?>
</div>
<p class="vitrina-pie"><a class="boton secundario" href="catalogo.php">Ver todos los botines</a></p>
<?php endif; ?>
<?php require 'pie.php'; ?>
