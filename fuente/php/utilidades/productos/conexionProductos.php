<?php
    require_once '../../utilidades/conexiones.php';
    function insertarProducto($nombre, $descripcion, $categoria, $modelo, $precioUnitario, $iva, $stock){
        $configuracion = leerConfig(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $ins = "INSERT INTO productos(nombre, descripcion, categoria, modelo, precioUnitario, iva, stock) VALUES ('$nombre', '$descripcion', $categoria, '$modelo', $precioUnitario, $iva, 0)";
        $resul = $db->query($ins);
        if (!$resul) {
            return false; 
        }
        return true;
    }

    function eliminarProducto($idProducto) {
        $configuracion = leerConfig(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $del = "DELETE FROM productos WHERE idProducto = $idProducto";
        $resul = $db->query($del);
        if (!$resul) {
            return false;
        }
        return true;
    }

    function actualizarProducto($idProducto, $stock) {
        $configuracion = leerConfig(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $update = "UPDATE productos set stock = $stock WHERE idProducto = $idProducto";
        $resul = $db->query($update);
        if (!$resul) {
            return false;
        }
        return true;
    }