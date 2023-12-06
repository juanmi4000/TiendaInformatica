<?php
    include "../../utilidades/sesiones.php";
    comprobarSesion();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $datos = [];
        $datos[] = $_POST['nombre'];
        $datos[] = $_POST['descripcion'];
        $datos[] = $_POST['categoria'];
        $datos[] = $_POST['modelo'];
        $datos[] = $_POST['precioUnitario'];
        $datos[] = $_POST['iva'];
        $datos[] = $_POST['stock'];
        $_SESSION['crear'] = $datos;
        header("Location: modificarProductos.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nuevo Producto</title>
        <link rel="stylesheet" href="../../style/style.css">
    </head>
    <body>
        <?php
            require '../cabecera.php';
        ?>
        <h1>Nuevo Producto</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <table>
                <tr>
                    <td><label for="nombre">Nombre: </label></td>
                    <td><input type="text" name="nombre" id="nombre" required></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;"><label for="descripcion">Descripción: </label></td>
                    <td><textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea></td>
                </tr>
                <tr>
                    <td><label for="categoria">Categoria: </label></td>
                    <td><input type="text" name="categoria" id="categoria" required></td>
                </tr>
                <tr>
                    <td><label for="modelo">Modelo: </label></td>
                    <td><input type="text" name="modelo" id="modelo" required></td>
                </tr>
                <tr>
                    <td><label for="precioUnitario">Precio Unitario: </label></td>
                    <td><input type="text" name="precioUnitario" id="precioUnitario" required></td>
                </tr>
                <tr>
                    <td><label for="iva">IVA: </label></td>
                    <td><input type="text" name="iva" id="iva" required></td>
                </tr>
                <tr>
                    <td><label for="stock">Stock: </label></td>
                    <td><input type="text" name="stock" id="stock" required></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Añadir"></td>
                </tr>
            </table>
        </form>
    </body>
</html>