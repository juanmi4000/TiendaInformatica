<?php

    /**
    * Se va encargar de leer un xml y lo va a validar mediante un xsd. Saca la información del xml como la ip, nombre, usuario y la clave
    * @param string $nombre Nombre del xml
    * @param string $esquema Nombre del xsd
    * @return array Devuelve un array que contiene la cadena, el usuario y la clave para conectarse a una base de datos
    */
    function leerConfigVentasCompras($nombre, $esquema) {
        // crea un nuevo obejto DOMDocument
        $config = new DOMDocument();

        // carga el xml
        $config->load($nombre);

        // valida el xml con el esquema: true si ha ido bien o false si no
        $resultado = $config->schemaValidate($esquema);

        // si es falso lanza un error
        if ($resultado === false) {
            throw new InvalidArgumentException("ERROR: compruebe el fichero de configuración");
        }

        // lee el xml
        $datos = simplexml_load_file($nombre);

        // inicializamos en variables los datos del xml
        $ip = $datos->xpath("//ip");
        $nombre = $datos->xpath("//nombre");
        $usuario = $datos->xpath("//usuario");
        $clave = $datos->xpath("//clave");
        $cad = sprintf("mysql:dbname=%s;host=%s", $nombre[0], $ip[0]);
        
        // un array para almacenar los datos anteriores
        $resul = [];
        $resul[] = $cad;
        $resul[] = $usuario[0];
        $resul[] = $clave[0];

        return $resul;
    }
    /**
     * Se realizará una compra de un producto a un proveedor. Después actualizará el stock
     * @param int $idProducto Id del producto 
     * @return bool Devuelve false en caso de error, si lo ha actualizado correctamente devuelve true
     */
    function realizarCompra($productoId, $proveedorId, $cantidadComprada, $precioUnitario, $stock) {
        $configuracion = leerConfigVentasCompras(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $db->beginTransaction();
        $update = "UPDATE productos set stock = $stock WHERE idProducto = $productoId";
        $resul = $db->query($update);
        if (!$resul) {
            $db->rollBack();
            return false;
        }
        $precioTotal = $cantidadComprada * $precioUnitario;
        $insert = "INSERT INTO compras (productoId, proveedorId, cantidadComprada, precioUnitario, precioTotal) VALUES ($productoId, $proveedorId, $cantidadComprada, $precioUnitario, $precioTotal)";
        $resul2 = $db->query($insert);
        if (!$resul2) {
            $db->rollBack();
            return false;
        }
        $db->commit();
        return true;
    }

    /**
     * Se realizará una venta de uno/varios productos a un cliente. Después actualizará el stock
     * @param array $carrito todo el carrito
     * @param int $idPersona el id de la sesión, osea el usuario
     * @return bool Devuelve false en caso de error y hace un rollback, si lo ha actualizado correctamente devuelve true y hace un commit
     */
    function insertarVenta($idPersona, $producto, $unidades){
        $configuracion = leerConfigPro(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $db->beginTransaction();
        $idProducto = $producto['idProducto'];
        $precioUnitario = $producto['precioUnitario']; 
        $precioTotal = $unidades * ($precioUnitario * (1 + ($producto['iva'] / 100)));

        $insert = "INSERT INTO ventas(productoId, personaId, cantidadVendida, precioUnitario, precioTotal) VALUES ($idProducto, $idPersona, $unidades, $precioUnitario, $precioTotal)";
        $resul = $db->query($insert);

        $update = "UPDATE productos set stock = stock - $unidades WHERE idProducto = $idProducto";
        $resul2 = $db->query($update);
        if(!$resul || !$resul2){
            $db->rollBack();
            return false;
        }
        $db->commit();
        return true;
    }