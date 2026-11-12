<?php
require 'funciones.php'; exigir_login(); require 'conexion.php';
$buscar=trim((string)($_GET['buscar'] ?? ''));
$st=$pdo->prepare('SELECT id,marca,modelo,talle,precio,descripcion,imagen FROM botines WHERE archivado_en IS NULL AND (marca LIKE ? OR modelo LIKE ?) ORDER BY id DESC');
$st->execute(['%'.$buscar.'%','%'.$buscar.'%']); $botines=$st->fetchAll();
$titulo='Catálogo'; require 'encabezado.php'; ?>
<section class="cabecera"><span class="etiqueta">CATÁLOGO ELITE BOOTS</span><h1>Botines disponibles.</h1><p>Descubrí los modelos publicados en nuestra tienda.</p></section>
<form class="buscador" method="get"><input type="search" name="buscar" placeholder="Buscar marca o modelo" value="<?= escapar($buscar) ?>"><button class="boton">Buscar</button></form>
<?php if(!$botines): ?><div class="panel">No se encontraron botines.</div><?php else: ?>
<div class="tarjetas autos">
<?php foreach($botines as $botin): ?>
<article class="tarjeta auto">
<div class="auto-imagen">
<?php if(!empty($botin['imagen'])): ?>
<img class="foto-botin" src="<?= escapar($botin['imagen']) ?>" alt="<?= escapar($botin['marca'].' '.$botin['modelo']) ?>">
<?php else: ?><span><?= escapar(strtoupper($botin['marca'])) ?></span><div class="auto-icono">EB</div><span>IMAGEN PRÓXIMAMENTE</span><?php endif; ?>
</div>
<div class="auto-info"><span class="etiqueta">TALLE <?= escapar((string)$botin['talle']) ?></span><h2><?= escapar($botin['marca'].' '.$botin['modelo']) ?></h2><p><?= escapar($botin['descripcion']) ?></p><strong>$ <?= escapar(number_format((float)$botin['precio'],0,',','.')) ?></strong></div>
</article>
<?php endforeach; ?></div><?php endif; ?>
<?php require 'pie.php'; ?>
