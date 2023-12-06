<?php
    require_once '../../utilidades/conexiones.php';
    /**
     * @param array $codigosProductos todos los productos 
     */
    function cargarProveedores(){
        $configuracion = leerConfig(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $consulta = "SELECT * FROM proveedores";
        $resul = $db->query($consulta);	
        if (!$resul) {
            return false;
        }
        if ($resul->rowCount() === 0) {    
            return false;
        }
        //si hay 1 o más
        return $resul;
    }
    function insertarProveedor($nombre, $razonSocial, $direccion, $telefono, $email){
        $configuracion = leerConfig(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $ins = "INSERT INTO proveedores(nombre, razonSocial, direccion, telefono, email) VALUES ('$nombre', '$razonSocial', '$direccion', '$telefono', '$email')";
        $resul = $db->query($ins);
        if (!$resul) {
            return false; 
        }
        return true;
    }

    function eliminarProveedor($idProveedor) {
        $configuracion = leerConfig(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $del = "DELETE FROM proveedores WHERE idProveedor = $idProveedor";
        $resul = $db->query($del);  
        if (!$resul) {
            return false;
        }
        return true;
    }