<?php
    include_once "../../utilidades/proveedores/conexionProveedores.php";
    include "../../utilidades/sesiones.php";
    comprobarSesion();
    $proveedores = cargarProveedores();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idProveedor = $_POST['id'];
        if (isset($_POST['eliminar'])) {
            $_SESSION['eliminar'] = $idProveedor;
        } elseif (isset($_POST['cambiarStock'])) {
            $_SESSION['cambiarStock'] = $idProducto;
            header("Location: cambiarStock.php");
            return;
        }
        header("Location: modificarProveedores.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modificar proveedores</title>
        <link rel="stylesheet" href="../../../style/style.css">
    </head>
    <body>
        <?php
            require '../cabecera.php';
        ?>
        <button onclick="location.href = 'crearProveedor.php'">
            <img class="img-header" src="../../../multimedia/img/mas.png">
            Nuevo Proveedor
        </button>
        <?php
            if (isset($_GET['eleminado'])) {
                if ($_GET['eleminado']) {
                    echo "<p>El producto se ha eliminado correctamente</p>";
                } else {
                    echo "<p>Ha ocurrido un error. El producto no se ha eliminado</p>";
                }
            } 
            if (isset($_GET['insertado'])) {
                if ($_GET['insertado']) {
                    echo "<p>El producto se ha insertado correctamente</p>";
                } else {
                    echo "<p>Ha ocurrido un error. El producto no se ha eliminado</p>";
                }
            }
            
        ?>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Razón Social</th>
                <th>Dirección</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Eliminar</th>
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
                        <td>$nombre</td>
                        <td>$razonSocial</td>
                        <td>$direccion</td>
                        <td>$telefono</td>
                        <td>$email</td>
                        <td>";
            ?>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='post'>
                                <input type='submit' name = "eliminar" value='Eliminar'>
                                <input type='hidden' name='id' value="<?php echo $idProveedor;?>">
                            </form>
            <?php
                        echo "</td></tr>";
                }
            ?>
        </table>
    </body>
</html>