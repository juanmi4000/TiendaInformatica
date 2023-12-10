<?php
    // Pongo aquí leerConfig y en los demás porque me estaba dando error a la hora de importarlo
    /**
    * Se va encargar de leer un xml y lo va a validar mediante un xsd. Saca la información del xml como la ip, nombre, usuario y la clave
    * @param string $nombre Nombre del xml
    * @param string $esquema Nombre del xsd
    * @return array Devuelve un array que contiene la cadena, el usuario y la clave para conectarse a una base de datos
    */
    function leerConfigPer($nombre, $esquema) {
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
     * Inserta un usuario a la base de datos
     * @param string $nombre Nombre del usuario
     * @param string $apellidos Apellidos del usuario
     * @param string $direccion Dirección donde vive el usuario
     * @param string $telefono Teléfono de contacto del usuario
     * @param string $contrasena Contraseña del usuario
     * @param string $email Correo del usuario
     * @param string $fechaNac Fecha de nacimiento del usuario
     */
    function insertarUsuario($nombre, $apellidos, $direccion, $telefono, $contrasena, $email, $fechaNac){
        $configuracion = leerConfigPer(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $fecha = date("Y-m-d", strtotime($fechaNac)); // creo una fecha con la que me pasan
        // Cifro la contraseña
        $contrasenaCifrada = password_hash($contrasena, PASSWORD_DEFAULT);
        $ins = "insert into personas(nombre, apellidos, direccion, telefono, contrasena, email, fechaNac, rol) values ('$nombre', '$apellidos', '$direccion', '$telefono', '$contrasenaCifrada', '$email', '$fecha', 'usuario')";
        $db->query($ins);
    }