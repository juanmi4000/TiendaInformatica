<?php
    include_once "../../utilidades/categorias/conexionCategorias.php";
    include_once "../../utilidades/conexiones.php";
    include "../../utilidades/sesiones.php";
    comprobarSesion();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $contrasenaCorrecta = comprobarContrasena($_SESSION['usuario']['email'], $_POST['clave']);
        if ($contrasenaCorrecta) {
            if (isset($_SESSION['eliminar'])) {
                $id = $_SESSION['eliminar'];
                $resul = eliminarCategoria($id);
                if ($resul) {
                    header("Location: categoriasAdmin.php?eleminado=true");
                    unset($_SESSION['eliminar']);
                    return;
                } else {
                    header("Location: categoriasAdmin.php?eleminado=false");
                    unset($_SESSION['eliminar']);
                    return;
                }
            } elseif (isset($_SESSION['crear'])) {
                $nombre = $_SESSION['crear'][0];
                $descripcion = $_SESSION['crear'][1];
                $resul = insertarCategoria($nombre, $descripcion);
                if ($resul) {
                    header("Location: categoriasAdmin.php?insertado=true");
                    unset($_SESSION['crear']);
                    return;
                } else {
                    header("Location: categoriasAdmin.php?insertado=false");
                    unset($_SESSION['crear']);
                    return;
                }
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
                <h5><?php echo $_SESSION['usuario']['nombre']?></h5>
                <input type="password" name="clave" required>
                <label>Contraseña: </label>
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