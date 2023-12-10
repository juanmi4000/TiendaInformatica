<?php
    include_once "../../utilidades/productos/conexionProductos.php";
    include_once "../../utilidades/conexiones.php";
    include "../../utilidades/sesiones.php";
    comprobarSesion();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $contrasenaCorrecta = comprobarContrasena($_SESSION['usuario']['email'], $_POST['clave']);
        if ($contrasenaCorrecta) {
            if (isset($_SESSION['eliminar'])) {
                $id = $_SESSION['eliminar'];
                $resul = eliminarProducto($id);
                if ($resul) {
                    header("Location: productosAdmin.php?eleminado=true");
                } else {
                    header("Location: productosAdmin.php?eleminado=false");   
                }
                unset($_SESSION['eliminar']);
                return;
            } elseif (isset($_SESSION['crear'])) {
                $resul = insertarProducto($_SESSION['crear'][0], $_SESSION['crear'][1], $_SESSION['crear'][2], $_SESSION['crear'][3], $_SESSION['crear'][4], $_SESSION['crear'][5], $_SESSION['crear'][6], $_SESSION['crear'][7]);
                if ($resul) {
                    header("Location: productosAdmin.php?insertado=true");
                    unset($_SESSION['crear']);
                } else {
                    header("Location: productosAdmin.php?insertado=false");
                }
                unset($_SESSION['crear']);
                return;
            } elseif (isset($_SESSION['compra'])) {
                $resul = realizarCompra($_SESSION['compra'][0], $_SESSION['compra'][1], $_SESSION['compra'][2], $_SESSION['compra'][3], $_SESSION['compra'][4]);
                if ($resul) {
                    header("Location: productosAdmin.php?actualizado=true");
                } else {
                    header("Location: productosAdmin.php?actualizado=false");
                }
                unset($_SESSION['compra']);
            }
        } else {
            $contrasenaMal = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Comprobar Contraseña</title>
        <link rel="stylesheet" href="../../../style/style.css">
        <style>
            .codigo{
                display: grid;
                place-items: center;
            }
        </style>
    </head>
    <body>
        <?php
            require '../cabecera.php';
        ?>
        <div class="codigo">
            <h1>Comprobar contraseña</h1>
            <!-- formulario de inicio de sesión. Cuando se pulsa el botón se lo auto envía con el método post -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <h5><?php echo $_SESSION['usuario']['nombre'];?></h5>
                <label>Contraseña: </label>
                <input type="password" name="clave" required>
                <br>
                <input type="submit" value="Comprobar contraseña">
                <div class="erroresOtros">
                    <?php
                        if (isset($contrasenaMal)) {
                            echo "<p><b>La contraseña no es correcta</b></p>";
                        }
                    ?>
                </div>
            </form>
        </div>
    </body>
</html>