<?php
    include "../../utilidades/sesiones.php";
    comprobarSesion();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $datos = [];
        $datos[] = $_POST['nombre'];
        $datos[] = $_POST['razonSocial'];
        $datos[] = $_POST['direccion'];
        $datos[] = $_POST['telefono'];
        $datos[] = $_POST['email'];
        $_SESSION['crear'] = $datos;
        if (isset($_SESSION['eliminar'])) {
            unset($_SESSION['eliminar']);
        }
        header("Location: modificarProveedores.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nuevo Proveedor</title>
        <link rel="stylesheet" href="../../style/style.css">
    </head>
    <body>
        <?php
            require '../cabecera.php';
        ?>
        <h1>Nuevo Proveedor</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <table>
                <tr>
                    <td><label for="nombre">Nombre: </label></td>
                    <td><input type="text" name="nombre" id="nombre" required></td>
                </tr>
                <tr>
                    <td><label for="razonSocial">Razón Social: </label></td>
                    <td><input type="text" name="razonSocial" id="razonSocial" required></td>
                </tr>
                <tr>
                    <td><label for="direccion">Dirección: </label></td>
                    <td><input type="text" name="direccion" id="direccion" required></td>
                </tr>
                <tr>
                    <td><label for="telefono">Teléfono: </label></td>
                    <td><input type="text" name="telefono" id="telefono" required></td>
                </tr>
                <tr>
                    <td><label for="email">Correo: </label></td>
                    <td><input type="text" name="email" id="email" required></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Añadir"></td>
                </tr>
            </table>
        </form>
    </body>
</html>