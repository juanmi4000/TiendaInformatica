<?php
    require_once '../utilidades/sesiones.php';
    require_once '../utilidades/productos/conexionProductos.php';
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
        <h2>Carrito de la compra</h2> 
        <table>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Modelo</th>
                <th>Peso</th>
                <th>Precio(€)*</th>
                <th>IVA</th>
                <th>Unidades</th>
                <th>Eliminar</th>
            </tr>
            <?php
                foreach ($productos as $producto) {
                    $idProducto = $producto['idProducto'];
			        $nombre = $producto['nombre'];
			        $descripcion = $producto['descripcion'];
			        $catego = $producto['categoria'];
			        $modelo = $producto['modelo'];
			        $peso = $producto['peso'];
			        $iva = $producto['iva'];
                    $precio = $producto['precioUnitario'] * (1 + ($iva / 100));
                    $unidades = $_SESSION['carrito'][$idProducto];

                    echo "
                        <tr>
                            <td>$nombre</td>
                            <td>$descripcion</td>
                            <td>$catego</td>
                            <td>$modelo</td>
                            <td>$peso</td>
                            <td>$precio</td>
                            <td>$iva</td>   
                            <td>$unidades</td>
                            <td>
                                <form action = 'eliminar.php' method = 'POST'>
                                    <input type='number' name='unidades' min = '1' value = '1' max = '$unidades'>
                                    <input type='submit' value = 'Eliminar'>
                                    <input type='hidden' name = 'id' value = '$idProducto'>
                                </form>
                            </td>
                        </tr>";
                }
            ?>
        </table>
        <hr>
        <a href="procesarPedido.php">Realizar pedido</a>
    </body>
</html>