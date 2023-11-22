<?php

include_once'../Models/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = validarCampo($_POST["nombre"], "Nombre");
    $apellido = validarCampo($_POST["apellido"], "Apellido");
    $tipoDocumento = validarCampo($_POST["tipoDocumento"], "Tipo de Documento");
    $documento = validarCampo($_POST["documento"], "Documento");
    $correo = validarCampo($_POST["correo"], "Correo Electrónico");
    $telefono = validarCampo($_POST["telefono"], "Teléfono");
    $contrasena = validarCampo($_POST["contrasena"], "Contraseña");
    $confirmarContrasena = validarCampo($_POST["confirmarContrasena"], "Confirmar Contraseña");

    // Validar si la contraseña y la confirmación coinciden
    if ($contrasena !== $confirmarContrasena) {
        echo "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    } else {
        // Las contraseñas coinciden, puedes proceder con el registro en la base de datos

        // Conectar a la base de datos
        $mysqli = new mysqli("localhost", "root", "1023974256", "proyectogpa");
        if ($mysqli->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        // Escapar los datos para evitar inyección de SQL
        $nombre = $mysqli->real_escape_string($nombre);
        $apellido = $mysqli->real_escape_string($apellido);
        $tipoDocumento = $mysqli->real_escape_string($tipoDocumento);
        $documento = $mysqli->real_escape_string($documento);
        $correo = $mysqli->real_escape_string($correo);
        $telefono = $mysqli->real_escape_string($telefono);
        $contrasena = $mysqli->real_escape_string($contrasena);
        $confirmarContrasena = $mysqli->real_escape_string($confirmarContrasena);
        
        // Escapar otros campos del formulario

        // Hash de la contraseña para almacenarla de forma segura en la base de datos
        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

        // Consulta SQL para insertar los datos en la base de datos
        $sql = "INSERT INTO usuarios (usuNombre, usuApellido, usutipoDocumento, usudocumento, usucorreo, usutelefono, usucontrasena) 
                VALUES ('$nombre', '$apellido', '$tipoDocumento', '$documento', '$correo', '$telefono', '$hashedPassword')";

        if ($mysqli->query($sql)) {
            echo "Registro exitoso.";
        } else {
            echo "Error al registrar: " . $mysqli->error;
        }

        // Cerrar la conexión
        $mysqli->close();
    }
}

function validarCampo($campo, $nombreCampo) {
    // Verificar si el campo está vacío
    if (empty($campo)) {
        echo "El campo $nombreCampo está vacío. Por favor, inténtalo de nuevo.";
        exit(); // Terminar el script si hay campos vacíos
    }
    // Limpiar y validar el campo antes de usarlo en la consulta SQL
    return filter_var($campo, FILTER_SANITIZE_STRING);
}
?>




/* $usuNombre=isset($_POST['usuNombre']) ? $_POST['usuNombre'] : '';
$usuApellido=isset($_POST['usuApellido']) ? $_POST['usuApellido'] : '';
$usuTipoDocumento=isset($_POST['usuTipoDocumento']) ? $_POST['usuTipoDocumento'] : '';
$usuDocumento=isset($_POST['usuDocumento']) ? $_POST['usuDocumento'] : '';
$usuTelefono=isset($_POST['usuTelefono']) ? $_POST['usuTelefono'] : '';
$usuCorreo=isset($_POST['usuCorreo']) ? $_POST['usuCorreo'] : '';
$usuDireccion=isset($_POST['usuDireccion']) ? $_POST['usuDireccion'] : '';
$usuGenero=isset($_POST['usuGenero']) ? $_POST['usuGenero'] : '';
$idCiudad=isset($_POST['idCiudad']) ? $_POST['idCiudad'] : '';
$usuContrasena=isset($_POST['usuContrasena']) ? $_POST['usuContrasena'] : '';

try{
    $conexion = new PDO('mysql:host=localhost; port=3306; dbname=proyectogpa;', 'root', '1023974256');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $pdo = $conexion->prepare('INSERT INTO usuarios (usuNombre,usuApellido,usuTipoDocumento,usuDocumento,usuTelefono,usuCorreo,usuDireccion,usuGenero,usuContrasena)
    values (:usuNombre,:usuApellido,:usuTipoDocumento,:usuDocumento,:usuTelefono,:usuCorreo,:usuDireccion,:usuGenero,:usuContrasena)');
    
    $pdo->bindParam(':usuNombre',$usuNombre);
    $pdo->bindParam(':usuApellido',$usuApellido);
    $pdo->bindParam(':usuTipoDocumento',$usuTipoDocumento);
    $pdo->bindParam(':usuDocumento',$usuDocumento);
    $pdo->bindParam(':usuTelefono',$usuTelefono);
    $pdo->bindParam(':usuCorreo',$usuCorreo);
    $pdo->bindParam(':usuDireccion',$usuDireccion);
    $pdo->bindParam(':usuGenero',$usuGenero);
    $pdo->bindParam(':usuContrasena',$usuContrasena);
    $pdo->execute();

    echo json_encode('true');
    
}catch(PDOException $error){
    echo "Error: ".$e->getMessage();
    die();
} */

