<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['archivo'])) {
        $archivo = $_FILES['archivo'];
        if (preg_match('/\.jpg/i', $archivo['name']) && $archivo['type'] == 'image/jpeg') {
            $handle = fopen($archivo['tmp_name'], "rb"); 
            $primerosBytes = fread($handle, 2); 
            fclose($handle);
            if ($primerosBytes === "\xFF\xD8") {
                $destino = $archivo['name'];
                if (move_uploaded_file($archivo['tmp_name'], $destino)) {
                    echo "¡Archivo subido exitosamente! ";
                    echo "<a href='" . htmlspecialchars($destino) . "'>Haga clic aquí para acceder al archivo</a>";
                } else {
                    echo "Error al subir el archivo.";
                }
            } else {
                echo "Error: El archivo no es JPEG.";
            }
        } else {
            echo "Error: Solo se permiten archivos .jpg";
        }
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <label for="archivo">Elija un archivo para subir:</label>
    <input type="file" name="archivo" id="archivo">
    <input type="submit" value="Subir Archivo">
</form>
