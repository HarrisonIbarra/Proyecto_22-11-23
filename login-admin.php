<?php
include_once '../Models/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = filter_var($_POST['documento'], FILTER_SANITIZE_STRING);
    $contrasena = $_POST['contrasena'];

    // Consulta preparada para evitar la inyección SQL
    $stmt = $mysqli->prepare("SELECT id, usuDocumento, usuContrasena FROM usuarios WHERE usuDocumento = ?");
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $documento_bd, $hashed_password);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($contrasena, $hashed_password)) {
            // Iniciar sesión
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['documento'] = $documento_bd;

            // Regenerar el ID de sesión para evitar ataques de fijación de sesión
            session_regenerate_id(true);

            // Redirigir a la página de inicio del usuario
            header('Location: ../Views/Cliente/index.php');
            exit();
        } else {
            $error = "Contraseña incorrecta. Por favor, intenta nuevamente.";
        }
    } else {
        $error = "No existe ningún usuario registrado con ese número de documento.";
    }

    // Cerrar la consulta preparada
    $stmt->close();
    $mysqli->close();
} else {
    // Si el método de solicitud no es POST, redirigir a la página de inicio
    header('Location: ../index.html');
    exit();
}
?>






/* include_once'../Models/conexion.php';
$documento = $_POST['documento'];
$contrasena = $_POST['contrasena'];


$sql = "SELECT * FROM usuarios WHERE usuDocumento = '$documento' AND usuContrasena = '$contrasena' ";
 $result = $mysqli->query($sql);

 if($result->num_rows == 0){
    $mensaje = 'Consulta no valida:'. mysqli_error($mysqli). "\n";
    header("Location: ../index.html");
 }

    echo "Exito"; */

