<?php
    require_once '../utilidades/sesiones.php';
    comprobarSesion();
    $usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../style/style.css">
        <title>Tienda Informática</title>
    </head>
    <body>
        <?php require './cabecera.php';?>
        <h2><?php echo $usuario['apellidos'] . ", " .  $usuario['nombre'];?></h2>
        <a href="../../index.php?cerrarSesion=true">Cerrar sesión</a>
    </body>
</html>