<?php

    /**
    * Se va encargar de leer un xml y lo va a validar mediante un xsd. Saca la información del xml como la ip, nombre, usuario y la clave
    * @param string $nombre Nombre del xml
    * @param string $esquema Nombre del xsd
    * @return array Devuelve un array que contiene la cadena, el usuario y la clave para conectarse a una base de datos
    */
    function leerConfigCat($nombre, $esquema) {
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
     * Lee el fichero XML y lo valida. Despues lo inserta en la base de datos
     * @param string $nombre Nombre de la categoría
     * @param string $descripcion Breve descripción de la categoría
     * @return bool Devuelve true si lo ha insertado correctamente, sino devuelve falso
     */
    function insertarCategoria($nombre, $descripcion){
        $configuracion = leerConfigCat(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $ins = "INSERT INTO categorias(nombre, descripcion) VALUES ('$nombre', '$descripcion')"; 
        $resul = $db->query($ins);
        if (!$resul) {
            return false;
        }
        return true;
    }

    /**
     * Lee el fichero XML y lo valida. Despues lo elimina de la base de datos
     * @param string $idCategoria Id de la categoría
     * @return bool Devuelve true si lo ha eliminado correctamente, sino devuelve falso
     */
    function eliminarCategoria($idCategoria) {
        $configuracion = leerConfigCat(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $del = "DELETE FROM categorias WHERE idCategoria = $idCategoria";
        $resul = $db->query($del);
        if (!$resul) {
            return false;
        }
        return true;
    }