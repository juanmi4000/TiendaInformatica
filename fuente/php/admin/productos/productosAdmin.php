<?php
    include_once "../../utilidades/conexiones.php";
    include "../../utilidades/sesiones.php";
    comprobarSesion();
    $productos = cargarTodosProductos();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idProducto = $_POST['id'];
        if (isset($_POST['eliminar'])) {
            $_SESSION['eliminar'] = $idProducto;
        } elseif (isset($_POST['cambiarStock'])) {
            $_SESSION['idProducto'] = $idProducto;
            header("Location: cambiarStock.php");
            return;
        }
        header("Location: modificarProductos.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modificar productos</title>
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
            <button onclick="location.href = 'crearProducto.php'">
                <img class="img-header" src="../../../multimedia/img/mas.png">
                Nuevo Producto
            </button>
            <?php
                if (isset($_GET['eleminado'])) {
                    if ($_GET['eleminado']) {
                        echo "<p><b>El producto se ha eliminado correctamente</b></p>";
                    } else {
                        echo "<p><b>Ha ocurrido un error. El producto no se ha eliminado</b></p>";
                    }
                } 
                if (isset($_GET['insertado'])) {
                    if ($_GET['insertado']) {
                        echo "<p><b>El producto se ha insertado correctamente</b></p>";
                    } else {
                        echo "<p><b>Ha ocurrido un error. El producto no se ha eliminado</b></p>";
                    }
                }
                if (isset($_GET['actualizado'])) {
                    if ($_GET['actualizado']) {
                        echo "<p><b>La compra se ha realizado correctamente. Se ha añadido el stock.</b></p>";
                    } else {
                        echo "<p><b>Ha ocurrido un error. La compra no se ha llevado a cabo</b></p>";
                    }
                }
                
            ?>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoria</th>
                    <th>Modelo</th>
                    <th>Peso (kg)</th>
                    <th>Precio Unitario</th>
                    <th>IVA</th>
                    <th>Stock</th>
                    <th>Eliminar</th>
                    <th>Cambiar Stock</th>
                </tr>
                <?php
                    foreach ($productos as $producto) {
                        $idProducto = $producto['idProducto'];
                        $nombre = $producto['nombre'];
                        $descripcion = $producto['descripcion'];
                        $categoria = $producto['categoria'];
                        $modelo = $producto['modelo'];
                        $peso = $producto['peso'];
                        $precioUnitario = $producto['precioUnitario'];
                        $iva = $producto['iva'];
                        $stock = $producto['stock'];

                        echo "<tr>
                            <td>$nombre</td>
                            <td>$descripcion</td>
                            <td>$categoria</td>
                            <td>$modelo</td>
                            <td>$peso</td>
                            <td>$precioUnitario</td>
                            <td>$iva</td>
                            <td>$stock</td>
                            <td>";
                ?>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='post'>
                                    <input type='submit' name = "eliminar" value='Eliminar'>
                                    <input type='hidden' name='id' value="<?php echo $idProducto;?>">
                                </form>
                <?php
                            echo "</td><td>";
                ?>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='post'>
                                <input type='submit' name = "cambiarStock" value='Comprar'>
                                <input type='hidden' name='id' value="<?php echo $idProducto;?>">
                            </form>
                <?php
                        echo "</td></tr>";

                    }
                ?>
            </table>
        </div>
    </body>
</html>