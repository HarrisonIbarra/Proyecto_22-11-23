<?php
include_once '../Models/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $conn->real_escape_string($_POST['correo']);
    $token = bin2hex(random_bytes(32)); // Generar un token único para el enlace de restablecimiento

    // Almacenar el token en la base de datos junto con el correo electrónico y una marca de tiempo

    $sql = "INSERT INTO usuarios (correo, token, tokenExpiracion) VALUES ('$correo', '$token', NOW())";
    if ($conn->query($sql) === TRUE) {
        // Enviar correo electrónico con el enlace de restablecimiento usando la función mail() de PHP
        $to = $correo;
        $subject = "Recuperación de Contraseña";
        $message = "Haz clic en el siguiente enlace para restablecer tu contraseña: http://tu-sitio.com/restablecerContrasena.php?token=$token";
        $headers = "From: harrisonibarra80@gmail.com";

        mail($to, $subject, $message, $headers);

        echo "Se ha enviado un correo electrónico con las instrucciones para restablecer tu contraseña.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>