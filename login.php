<?php
function conectar()
{
    $user = "root";
    $pass = "";
    $server = "localhost";
    $db = "academiaunad";

    try {
        $con = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $con;
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
}

$mensaje = ""; // Inicializar la variable mensaje

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["username"];
    $password = $_POST["password"];

    $conexion = conectar();

    // Consulta para verificar si las credenciales son válidas
    $query = "SELECT * FROM login WHERE user = :usuario AND pass = :password";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->bindParam(":password", $password);
    $stmt->execute();

    // Verificar si se encontraron registros
    if ($stmt->rowCount() > 0) {
        // Inicio de sesión exitoso
        // Redirigir a la página deseada (por ejemplo, Menu.html)
        header("Location: http://localhost/universidad/Menu.html");
        exit(); // Asegura que el script se detenga después de redirigir
    } else {
        $mensaje = "Credenciales incorrectas. Inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/loginc.css">
    <title> Formulario de Acceso </title>
</head>
<body>
    <div class="login-page">
        <div class="form">
            <div class="login">
                <div class="login-header">
                    <h3>INICIAR SESIÓN</h3>
                    <p>Por favor, introduzca sus credenciales para iniciar sesión.</p>
                </div>
            </div>
            <form class="login-form" method="post" action="">
                <input type="text" name="username" placeholder="username" required/>
                <input type="password" name="password" placeholder="password" required/>
                <button type="submit">login</button>
                <a class="message" href="#"><?php echo $mensaje; ?></a>
            </form>
            <div class="pie-form">
                <a href="#">¿Perdiste tu contraseña?</a>
                <a href="Formulario.php">¿No tienes Cuenta? Registrate</a>
            </div>
        </div>
    </div>
</body>
</html>

