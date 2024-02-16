<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['archivo'])) {
        $archivo = $_FILES['archivo'];
        
        $handle = fopen($archivo['tmp_name'], "rb"); 
        $primerosBytes = fread($handle, 2); 
        fclose($handle);
        if ($primerosBytes === "\xFF\xD8") {
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $nombreSinExtension = pathinfo($archivo['name'], PATHINFO_FILENAME);
            $nombreHashMD5 = md5($nombreSinExtension);
            $destino = $nombreHashMD5 . '.' . $extension;
            if (move_uploaded_file($archivo['tmp_name'], $destino)) {
                echo "¡Archivo subido exitosamente! ";
                
            } else {
                echo "Error al subir el archivo.";
            }
        } else {
            echo "Error: El archivo no es JPEG.";
        }
         
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <label for="archivo">Elija un archivo para subir:</label>
    <input type="file" name="archivo" id="archivo">
    <input type="submit" value="Subir Archivo">
</form>
