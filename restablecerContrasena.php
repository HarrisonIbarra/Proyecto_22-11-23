<?php
include_once '../Models/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $conn->real_escape_string($_POST['token']);
    $nuevaContrasena = $conn->real_escape_string($_POST['contrasena']);
    $confirmarContrasena = $conn->real_escape_string($_POST['confirmarContrasena']);

    // Verificar que la nueva contraseña y la confirmación sean iguales
    if ($nuevaContrasena === $confirmarContrasena) {
        // Las contraseñas son iguales, puedes proceder a actualizar la contraseña
        $contrasenaHash = password_hash($nuevaContrasena, PASSWORD_BCRYPT);

        // Actualizar la contraseña en la base de datos basándose en el token proporcionado
        $sql = "UPDATE usuarios SET contrasena = '$contrasenaHash' WHERE token = '$token'";
        if ($conn->query($sql) === TRUE) {
            // Contraseña restablecida con éxito, redirigir a index.html
            header("Location: index.html");
            exit(); // salir del script después de la redirección
        } else {
            echo "Error al restablecer la contraseña: " . $conn->error;
        }
    } else {
        // Las contraseñas no coinciden, mostrar un mensaje de error
        echo "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    }
}
?>
