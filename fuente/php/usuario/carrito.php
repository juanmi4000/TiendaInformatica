<?php
    require_once '../utilidades/sesiones.php';
    require_once '../utilidades/conexiones.php';
    comprobarSesion();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Carrito</title>
        <link rel="stylesheet" href="../../style/style.css">
    </head>
    <body>
        <?php
            require 'cabecera.php';
            $productos = cargarProductos(array_keys($_SESSION['carrito']));
            if ($productos === false) {
                echo "<p>No hay productos en el pedido</p>";
                exit;
            }
        ?>
        <h2>Carrito de la compra</h2>;
        <table>
            <tr>
                <th>Nombre</th>
                <th>Modelo</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Precio Unidad</th>
                <th>Stock</th>
                <th>Eliminar</th>
            </tr>
            <?php
                foreach ($productos as $productos) {
                    $codigo = $producto['idProducto'];
                    $nombre = $producto['nombre'];
                    $modelo = $producto['modelo'];
                    $descripcion = $producto['descripción'];
                    $categoria = $producto['categoria'];
                    $precio = $producto['precio'] * ($producto ['iva'] / 100);
                    $unidades = $_SESSION['carrito'][$cod];

                    echo "
                        <tr>
                            <td>$nombre</td>
                            <td>$modelo</td>
                            <td>$descripción</td>
                            <td>$categoria</td>
                            <td>$precio</td>
                            <td>$unidades</td>
                            <td>
                                <form action = 'eliminar.php' method = 'post'>
                                    <input type='number' name='unidades' min = '1' value = '1'>
                                    <input type='submit' value = 'Eliminar'>
                                    <input type='hidden' name = 'cod' value = '$cod'>
                                </form>
                            </td>
                        </tr>
                    ";

                }
            ?>
        </table>
        <hr>
        <a href="procesarPedido.php">Realizar pedido</a>
    </body>
</html>