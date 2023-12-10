<?php
    include "../../utilidades/sesiones.php";
    comprobarSesion();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $datos = [];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $datos[] = $nombre;
        $datos[] = $descripcion;
        $_SESSION['crear'] = $datos;
        header("Location: modificarCategorias.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nueva Categoria</title>
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
            <h1>Nueva Categoria</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <table>
                    <tr>
                        <td> <label for="nombre">Nombre: </label></td>
                        <td><input type="text" name="nombre" id="nombre" required></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;"><label for="descripcion">Descripción: </label></td>
                        <td><textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea></td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Añadir"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>