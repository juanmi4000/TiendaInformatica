<?php

    /**
    * Se va encargar de leer un xml y lo va a validar mediante un xsd. Saca la información del xml como la ip, nombre, usuario y la clave
    * @param string $nombre Nombre del xml
    * @param string $esquema Nombre del xsd
    * @return array Devuelve un array que contiene la cadena, el usuario y la clave para conectarse a una base de datos
    */
    function leerConfigProv($nombre, $esquema) {
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
     * Carga todos los proveedores de la base de datos
     * @return PDOStatement|bool Devuelve todos los proveedores que tenga la base de datos, si ha ocurrido un problema o tiene 0 filas devuelve false
     */
    function cargarProveedores(){
        $configuracion = leerConfigProv(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
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

    /**
     * Inserta un proveedor
     * @param string $nombre Nombre del proveedor
     * @param string $razonSocial Razon Social del proveedor
     * @param string $direccion Dirección del proveedor
     * @param string $telefono Teléfono de contacto del proveedor
     * @param string $email Correo del proveedor
     * @return bool Devuelve true si se ha insertado correctamente, por el contrario devuelve false
     */
    function insertarProveedor($nombre, $razonSocial, $direccion, $telefono, $email){
        $configuracion = leerConfigProv(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $ins = "INSERT INTO proveedores(nombre, razonSocial, direccion, telefono, email) VALUES ('$nombre', '$razonSocial', '$direccion', '$telefono', '$email')";
        $resul = $db->query($ins);
        if (!$resul) {
            return false;
        }
        return true;
    }

    /**
     * Elimina un proveedor
     * @param string $idProveedor Id del proveedor que se va a borrar
     * @return bool Devuelve true si se ha insertado correctamente, por el contrario devuelve false
     */
    function eliminarProveedor($idProveedor) {
        $configuracion = leerConfigProv(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $del = "DELETE FROM proveedores WHERE idProveedor = $idProveedor";
        $resul = $db->query($del);  
        if (!$resul) {
            return false;
        }
        return true;
    }