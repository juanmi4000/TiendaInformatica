<?php
    include_once "../../utilidades/productos/conexionProductos.php";
    include_once "../../utilidades/proveedores/conexionProveedores.php";
    include "../../utilidades/sesiones.php";
    comprobarSesion();
    $producto = cargarProducto($_SESSION['idProducto']);
    $proveedores = cargarProveedores();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cantidadComprada = $_POST['nuevoStock'];
        $nuevoStock = $cantidadComprada + $producto['stock'];
        $datos = [];
        $datos[] = $producto['idProducto'];
        $datos[] = $_POST['eleccion']; // esto tiene el id del proveedor
        $datos[] = $cantidadComprada;
        $datos[] = $_POST['precioUnitario'];
        $datos[] = $nuevoStock;
        $_SESSION['compra'] = $datos;
        // unset($_SESSION['idProducto']);
        header("Location: modificarProductos.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cambiar Stock</title>
        <link rel="stylesheet" href="../../../style/style.css">
        <style>
            .codigo{
                display: grid;
                place-items: center;
            }
        </style>
    </head>
    <body>
        <?php require '../cabecera.php'; ?>
        <div class="codigo">
            <h3>Selecciona uno de los siguientes pobredores para llevar a cabo la compra</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <table>
                    <tr>
                        <th>Elección</th>
                        <th>Nombre</th>
                        <th>Razón Social</th>
                        <th>Dirección</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                    </tr>
                    <?php
                        foreach ($proveedores as $proveedor) {
                            $idProveedor = $proveedor['idProveedor'];
                            $nombre = $proveedor['nombre'];
                            $razonSocial = $proveedor['razonSocial'];
                            $direccion = $proveedor['direccion'];
                            $telefono = $proveedor['telefono'];
                            $email = $proveedor['email'];

                            echo "<tr>
                                <td><input type='radio' name='eleccion' value='$idProveedor'></td>
                                <td>$nombre</td>
                                <td>$razonSocial</td>
                                <td>$direccion</td>
                                <td>$telefono</td>
                                <td>$email</td>
                                </tr>";
                        }
                    ?>
                </table>
                <h4>Datos necesarios para realizar la compra al proveedor del producto <?php echo $producto['nombre'] . " ". $producto['modelo']?></h4>
                <label for="nuevoStock">Cantidad para comprar: </label>
                <input type="number" name="nuevoStock" id="nuevoStock" min="1" required>
                <br>
                <label for="precioUnitario">Precio unitario del proveedor: </label>
                <input type="number" name="precioUnitario" id="precioUnitario" min="1" required>
                <br>
                <input type="submit" value="Realizar compra">
            </form>
        </div>
    </body>
</html>