<?php
    /* Importa utilidades el fichero conexiones.php */
    require_once "../utilidades/personas/conexionPersonas.php";
    require_once "../utilidades/conexiones.php";
    require '../utilidades/sesiones.php';
    comprobarSesion();
    /* Verifica si la solicitud HTTP actual se realizó utilizando el método POST */
    if ($_SERVER["REQUEST_METHOD"] == "POST") { // REQUEST_METHOD --> es un indice específico de $_SERVER: POST/GET
        $usuario = comprobarUsuarioNoExiste($_POST['correo']);
        if ($usuario) { // el usuario no existe
            if($_POST['contra'] == $_POST['contra2']){
                insertarUsuario($_POST['nombre'], $_POST['apellidos'], $_POST['direccion'], $_POST['telefono'], $_POST['contra'], $_POST['correo'], $_POST['fechaNac']);
                header("Location: ../../index.php?noExiste=true");
                return;
            } else {
                $err = true;
            }
        } else { // el usuario existe
            header("Location: ../../index.php?existe=true");
            return; 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrarse</title>
    </head>
    <body>

        <!-- Formulario para registrase -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" placeholder="Introduce tu nombre">

            <br>

            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellido" placeholder="Introduce tus apellidos">

            <br>

            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" id="direccion"placeholder="Introduce tu dirección">

            <br>

            <label for="telefono">Telefono</label>
            <input type="text" name="telefono" id="telefono" placeholder="699999999">

            <br>

            <label for="correo">Correo</label>
            <input type="text" name="correo" id="correo" placeholder="usuario@gmail.com">

            <br>

            <label for="fechaNac">Fecha de nacimiento</label>
            <!-- max => no puede pasarse del día actual - min => que no se más pequeño de 1940-01-01 -->
            <input type="date" name="fechaNac" id="fechaNac" value="2000-01-01" max="<?php echo date("Y-m-d");?>" min="1940-01-01">

            <br>

            <label for="contra">Contraseña</label>
            <input type="password" name="contra" id="contra" placeholder="Introduce tu contraseña">

            <br>

            <label for="contra2">Repita la contaseña</label>
            <input type="password" name="contra2" id="contra2" placeholder="Introduce tu contraseña">
            
            <?php
                if (isset($err) and $err) {
                    echo "<p>Las contraseñas no son iguales</p>";
                }
            ?>

            <br>

            <input type="submit" value="Registrarse">
        </form>

        <a href="../../index.php">Volver al Inicio de Sesión</a>
    </body>
</html>