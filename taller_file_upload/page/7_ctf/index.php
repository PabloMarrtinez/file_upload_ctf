<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['archivo'])) {
        $archivo = $_FILES['archivo'];
        $contenidoArchivo = file_get_contents($archivo['tmp_name']);
        $longitudMaxima = strlen('solo_tienes_23_letras:)');
        if (strlen($contenidoArchivo) > $longitudMaxima) {
            echo "Error: El archivo excede la longitud máxima permitida.";
        } else {
            $destino = $archivo['name'];
            if (move_uploaded_file($archivo['tmp_name'], $destino)) {
                echo "Archivo subido exitosamente! ";
                echo "<a href='" . htmlspecialchars($destino) . "'>Haga clic aquí para acceder al archivo</a>";
            } else {
                echo "Error al subir el archivo.";
            }
        }
    }
}
?>
<form method="post" enctype="multipart/form-data">
    <label for="archivo">Elija un archivo para subir:</label>
    <input type="file" name="archivo" id="archivo">
    <input type="submit" value="Subir Archivo">
</form>
