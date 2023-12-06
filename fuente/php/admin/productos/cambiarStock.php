<?php
    include_once "../../utilidades/conexiones.php";
    include "../../utilidades/sesiones.php";
    comprobarSesion();
    $producto = cargarProducto($_SESSION['cambiarStock']);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nuevoStock = $_POST['$nuevoStock'];
        $nuevoStock += $producto['stock'];
        $datos = [];
        $datos[] = $producto['idProducto'];
        $datos[] = $nuevoStock;
        $_SESSION['cambiarStock'] = $datos;
        header("Location: productosAdmin.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cambiar Stock</title>
        <link rel="stylesheet" href="../../style/style.css">
    </head>
    <body>
        <?php require '../cabecera.php'; ?>
        <h4>Cuantas unidades quieres añadir al producto <?php echo $producto['nombre'] . $producto['modelo']?></h4>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <label for="nuevoStock">Nuevo stock: </label>
            <input type="number" name="nuevoStock" id="nuevoStock">
            <input type="submit" value="Añadir Stock">
        </form>
    </body>
</html>