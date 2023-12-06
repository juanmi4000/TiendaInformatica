<?php
    require_once '../../utilidades/conexiones.php';
    function insertarCategoria($nombre, $descripcion){
        $configuracion = leerConfig(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $ins = "INSERT INTO categorias(nombre, descripcion) VALUES ('$nombre', '$descripcion')"; //! puede ser que me haga falta poner ambos entre comillas simples
        $resul = $db->query($ins);
        if (!$resul) {
            return false;
        }
        return true;
    }

    function eliminarCategoria($idCategoria) {
        $configuracion = leerConfig(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $del = "DELETE FROM categorias WHERE idCategoria = $idCategoria";
        $resul = $db->query($del);
        if (!$resul) {
            return false;
        }
        return true;
    }