<?php
require 'funciones.php';
exigir_admin();
require 'conexion.php';

$id = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : null;
if (isset($_GET['id']) && !$id) { http_response_code(400); exit('ID inválido.'); }
$datos = ['marca'=>'', 'modelo'=>'', 'talle'=>'', 'precio'=>'', 'descripcion'=>'', 'imagen'=>null];
if ($id) {
    $st = $pdo->prepare('SELECT * FROM botines WHERE id=? AND archivado_en IS NULL');
    $st->execute([$id]);
    $datos = $st->fetch();
    if (!$datos) { http_response_code(404); exit('Producto no encontrado.'); }
}
$errores=[];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validar_csrf();
    foreach (['marca','modelo','talle','precio','descripcion'] as $campo) {
        $datos[$campo] = trim((string)($_POST[$campo] ?? ''));
    }
    if ($datos['marca']==='' || mb_strlen($datos['marca'])>70 || $datos['modelo']==='' || mb_strlen($datos['modelo'])>70) {
        $errores[]='Completá marca y modelo (máximo 70 caracteres).';
    }
    if (!filter_var($datos['talle'], FILTER_VALIDATE_INT, ['options'=>['min_range'=>20,'max_range'=>55]])) $errores[]='Ingresá un talle válido (20 a 55).';
    if (!is_numeric($datos['precio']) || (float)$datos['precio']<0 || (float)$datos['precio']>999999999999) $errores[]='Ingresá un precio válido.';
    if (mb_strlen($datos['descripcion'])>1000) $errores[]='La descripción es muy extensa.';

    // No se modifica la foto anterior si no se elige una nueva.
    $foto = $_FILES['foto'] ?? null;
    $imagenNueva = null;
    if ($foto && $foto['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($foto['error'] !== UPLOAD_ERR_OK || $foto['size'] > 3*1024*1024 || $foto['size'] <= 0) {
            $errores[]='La foto debe pesar menos de 3 MB.';
        } elseif (!is_uploaded_file($foto['tmp_name'])) {
            $errores[]='No se pudo validar el archivo subido.';
        } else {
            $info = @getimagesize($foto['tmp_name']);
            $mime = (new finfo(FILEINFO_MIME_TYPE))->file($foto['tmp_name']);
            $tipos = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
            if (!$info || !isset($tipos[$mime]) || ($info['mime'] ?? '') !== $mime) {
                $errores[]='Elegí una imagen JPG, PNG o WebP válida.';
            } else {
                $imagenNueva = 'img/' . bin2hex(random_bytes(16)) . '.' . $tipos[$mime];
            }
        }
    }
    if (!$errores) {
        $rutaCreada = null;
        try {
            if ($imagenNueva !== null) {
                $destino = __DIR__ . '/' . $imagenNueva;
                if (!move_uploaded_file($foto['tmp_name'], $destino)) throw new RuntimeException('No se pudo subir la foto.');
                $rutaCreada = $destino;
            }
            $imagenFinal = $imagenNueva ?? $datos['imagen'];
            if ($id) {
                $st=$pdo->prepare('UPDATE botines SET marca=?,modelo=?,talle=?,precio=?,descripcion=?,imagen=? WHERE id=? AND archivado_en IS NULL');
                $st->execute([$datos['marca'],$datos['modelo'],$datos['talle'],$datos['precio'],$datos['descripcion'],$imagenFinal,$id]);
            } else {
                $st=$pdo->prepare('INSERT INTO botines (marca,modelo,talle,precio,descripcion,imagen) VALUES (?,?,?,?,?,?)');
                $st->execute([$datos['marca'],$datos['modelo'],$datos['talle'],$datos['precio'],$datos['descripcion'],$imagenFinal]);
            }
            aviso($id ? 'Producto actualizado.' : 'Producto agregado al catálogo.');
            ir('admin_botines.php');
        } catch (Throwable $e) {
            if ($rutaCreada !== null && is_file($rutaCreada)) unlink($rutaCreada);
            $errores[]='No se pudo guardar el producto. Revisá la base de datos y los permisos de la carpeta img.';
        }
    }
}
$titulo=$id ? 'Editar botines' : 'Nuevos botines';
require 'encabezado.php';
?>
<section class="form-centro"><div class="panel">
<span class="etiqueta">PANEL ADMIN</span>
<h1><?= $id ? 'Editar botines' : 'Agregar botines' ?></h1>
<p>Los cambios se guardan en MySQL.</p>
<?php foreach($errores as $e): ?><div class="error"><?= escapar($e) ?></div><?php endforeach; ?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>">
<div class="dos-columnas">
<label>Marca<input required maxlength="70" name="marca" value="<?= escapar($datos['marca']) ?>"></label>
<label>Modelo<input required maxlength="70" name="modelo" value="<?= escapar($datos['modelo']) ?>"></label>
</div>
<div class="dos-columnas">
<label>Talle<input type="number" min="20" max="55" name="talle" required value="<?= escapar($datos['talle']) ?>"></label>
<label>Precio en pesos<input type="number" step="0.01" min="0" name="precio" required value="<?= escapar($datos['precio']) ?>"></label>
</div>
<label>Descripción<textarea name="descripcion" rows="4" maxlength="1000"><?= escapar($datos['descripcion']) ?></textarea></label>
<label>Foto del botín (JPG, PNG o WebP, hasta 3 MB)
<input type="file" name="foto" accept="image/jpeg,image/png,image/webp">
</label>
<?php if(!empty($datos['imagen'])): ?>
<p>Foto actual:</p><img class="foto-actual" src="<?= escapar($datos['imagen']) ?>" alt="Foto actual del botín">
<p>Si no elegís otra imagen, se conserva esta.</p>
<?php endif; ?>
<button class="boton ancho">Guardar producto</button>
</form></div></section>
<?php require 'pie.php'; ?>
