<?php
    include "../utilidades/sesiones.php";
    comprobarSesion();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administrador</title>
        <link rel="stylesheet" href="../../style/style.css">
        <style>
            .codigo{
                display: grid;
                place-items: center;
            }
        </style>
    </head>
    <body>
        <?php include 'cabeceraAdmin.php';?>
        <div class="codigo">
            <h3>Opciones</h3>
            <ul>
                <li><a href="categorias/categoriasAdmin.php">Modificar categorías</a></li>
                <li><a href="productos/productosAdmin.php">Modificar productos</a></li>
                <li><a href="proveedores/proveedoresAdmin.php">Modificar proveedores</a></li>
            </ul>
        </div>
    </body>
</html>