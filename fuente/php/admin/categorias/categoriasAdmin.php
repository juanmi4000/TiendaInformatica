<?php
    include_once "../../utilidades/conexiones.php";
    include "../../utilidades/sesiones.php";
    comprobarSesion();
    $categorias = cargarCategorias();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idCategoria = $_POST['id'];
        $_SESSION['eliminar'] = $idCategoria;
        header("Location: modificarCategorias.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modificar categorías</title>
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
            <button onclick="location.href = 'crearCategoria.php'">
                <img class="img-header" src="../../../multimedia/img/mas.png">
                Nueva Categoria
            </button>
            <?php
                if (isset($_GET['eleminado'])) {
                    if ($_GET['eleminado']) {
                        echo "<p><b>La categoría se ha eliminado correctamente</b></p>";
                    } else {
                        echo "<p><b>Ha ocurrido un error. La categoría no se ha eliminado</b></p>";
                    }
                } elseif (isset($_GET['insertado'])) {
                    if ($_GET['insertado']) {
                        echo "<p><b>La categoría se ha insertado correctamente</b></p>";
                    } else {
                        echo "<p><b>Ha ocurrido un error. La categoría no se ha eliminado</b></p>";
                    }
                }
                
            ?>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Eliminar</th>
                </tr>
                <?php
                    foreach ($categorias as $categoria) {
                        $idCategoria = $categoria['idCategoria'];
                        $nombre = $categoria['nombre'];
                        $descripcion = $categoria['descripcion'];
                        echo "<tr>
                            <td>$nombre</td>
                            <td>$descripcion</td>
                            <td>";
                ?>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='post'>
                                    <input type='submit' value='Eliminar'>
                                    <input type='hidden' name='id' value='<?php echo $idCategoria; ?>'>
                                </form>
                <?php
                            echo "</td>
                        </tr>";

                    }
                ?>
            </table>
        </div>
    </body>
</html>