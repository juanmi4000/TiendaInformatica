<?php

    /**
     * Devuelve la configuración necesaria para conectarse a una base de datos 
     * @param string $nombre 
     * @param string $esquema
     * @return array devuelve un array que contiene la cadena para conectarse a una base de datos
     */
    function leerConfig($nombre, $esquema) {
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
     * Crea un Administrador por defecto si no existe, si existe no hace nada
     * Esto sirve por si es la primera vez que se inicia el proyecto que se cree
     */
    function crearAdminPredeterminado(){
        $correo = 'admin@gmail.com';
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $consulta = "SELECT idPersona FROM personas WHERE email = :email";
        $resul = $db->prepare($consulta);
        $resul->bindParam(':email', $correo, PDO::PARAM_STR);
        $resul->execute();
        $fila = $resul->fetch(PDO::FETCH_ASSOC);
        if (!$fila) {
            $contrasena = password_hash("admin", PASSWORD_DEFAULT);
            $fecha = date("Y-m-d", 964108022);
            $sql = "INSERT INTO personas (idPersona, nombre, apellidos, direccion, telefono, contrasena, fechaNac, email, rol) VALUES (1, 'admin', 'admin', 'Calle Admin, 23', '622222223', '$contrasena', '$fecha', 'admin@gmail.com', 'admin')";
            $db->query($sql);
        }
    }

    /**
     * Crea un usuario por defecto si no existe, si existe no hace nada
     * Esto sirve para que cuando se inicie por primera vez el proyecto se cree
     */
    function crearUsuarioPredeterminado(){
        $correo = 'usuario@gmail.com';
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $consulta = "SELECT idPersona FROM personas WHERE email = :email";
        $resul = $db->prepare($consulta);
        $resul->bindParam(':email', $correo, PDO::PARAM_STR);
        $resul->execute();
        $fila = $resul->fetch(PDO::FETCH_ASSOC);
        if (!$fila) {
            $contrasena = password_hash("1234", PASSWORD_DEFAULT);
            $fecha = date("Y-m-d", 964109999);
            $sql = "insert into personas (nombre, apellidos, direccion, telefono, contrasena, fechaNac, email) values ('Usuario', 'User', 'Calle Flores, 23', '622233333', '$contrasena', '$fecha', 'usuario@gmail.com')";
            $db->query($sql);
        }
    }

    /**
     * Comprueba si existe un usuario
     * @param string $email 
     * @param string $clave contraseña
     * @return mixed Devuelve el valor de la consulta o false si no exite el email o ha ocurrido algo inesperado
     */
    function comprobarUsuario($email, $clave){
        // dirname(__FILE__) --> devuelve la ruta hasta donde se escuenta
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd"); // hay que poner la / al principio
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);

        // Utiliza una consulta preparada con marcadores de posición para evitar ataques de SQL injection
        $consulta = "SELECT * FROM personas WHERE email = :email";
        $resul = $db->prepare($consulta);
        $resul->bindParam(':email', $email, PDO::PARAM_STR); // Se vincula el valor de $email al marcador de posición utilizando bindParam() para garantizar la seguridad y prevenir inyecciones SQL.
        $resul->execute();

        // Obtiene la primera fila del resultado de la consulta
        $fila = $resul->fetch(PDO::FETCH_ASSOC);    

        // Verifica si la contraseña es válida utilizando password_verify
        if ($fila && password_verify($clave, $fila['contrasena'])) {
            return $fila; // Devuelve la fila si el usuario y la contraseña son válidos
        } else {
            return false;
        }
    }

    /**
     * Comprueba si no existe un usuario
     * @param string $correo 
     * @return mixed true si no existe o false si exite el email 
     */
    function comprobarUsuarioNoExiste($correo){
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $consulta = "SELECT idPersona FROM personas WHERE email = :email";
        $resul = $db->prepare($consulta);
        $resul->bindParam(':email', $correo, PDO::PARAM_STR);
        $resul->execute();
        $fila = $resul->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Comprueba si no existe un usuario
     * @param string $correo 
     * @return mixed true si no existe o false si exite el email 
     */
    function comprobarContrasena($correo, $clave){
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $consulta = "SELECT contrasena FROM personas WHERE email = :email";
        $resul = $db->prepare($consulta);
        $resul->bindParam(':email', $correo, PDO::PARAM_STR);
        $resul->execute();
        $fila = $resul->fetch(PDO::FETCH_ASSOC);
        if ($fila && password_verify($clave, $fila['contrasena'])) {
            return true; // Devuelve la fila si el usuario y la contraseña son válidos
        } else {
            return false;
        }
    }

    /**
     * Carga todas las categorías que tenga la BD
     * @return PDOStatement|bool devuelve todas las categorías o falso si ha ocurrido algún fallo
     */
    function cargarCategorias(){
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $consulta = "SELECT * FROM categorias";
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
     * 
     */
    function cargarCategoria($idCategoria){
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $consulta = "SELECT nombre, descripcion FROM categorias WHERE idCategoria = :idCate";
        $resul = $db->prepare($consulta);
        $resul->bindParam(':idCate', $idCategoria, PDO::PARAM_STR);
        $resul->execute();
        $fila = $resul->fetch(PDO::FETCH_ASSOC);	
        if (!$fila) {
            return false;
        }
        //si hay 1 o más
        return $fila;	
    }
    /**
     * 
     */
    function cargarProductosCategoria($idCategoria){
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);	
        $sql = "SELECT * FROM productos WHERE categoria  = $idCategoria";	
        $resul = $db->query($sql);	
        if (!$resul) {
            return FALSE;
        }
        if ($resul->rowCount() === 0) {    
            return FALSE;
        }	
        //si hay 1 o más
        return $resul;			
    }

    /**
     * @param array $codigosProductos todos los productos 
     */
    function cargarTodosProductos(){
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $consulta = "SELECT * FROM productos";
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
     * @param array $idProductos producto en concreto
     */
    function cargarProducto($idProductos){
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $consulta = "SELECT * FROM productos WHERE idProducto = :idProd";
        $resul = $db->prepare($consulta);
        $resul->bindParam(':idProd', $idProductos, PDO::PARAM_STR);
        $resul->execute();
        $fila = $resul->fetch(PDO::FETCH_ASSOC);	
        if (!$fila) {
            return false;
        }
        //si hay 1 o más
        return $fila;
    }

    /**
     * @param array $codigosProductos todos los productos 
     */
    function cargarProductos($codigosProductos){
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $texto_in = implode(",", $codigosProductos);
        if($texto_in == null){
            return false;
        }
        $consulta = "SELECT * FROM productos WHERE idProducto IN($texto_in)";
        $resul = $db->query($consulta);
        if(!$resul){
            return false;
        }
        return $resul;
    }

    function insertarPedido($carrito, $idPersona){
        $configuracion = leerConfig(dirname(__FILE__)."/../../xml/configuracion.xml", dirname(__FILE__)."/../../xml/squema.xsd ");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $db->beginTransaction();
        $productoId = $carrito['idProducto'];
        
        // insertar el pedido
        $consulta = "INSERT INTO ventas(productoId, personaId, cantidadVendida, precioUnitario) 
                VALUES($productoId, $idPersona, )";
        $resul = $db->query($consulta);	
        if (!$resul) {
            return FALSE;
        }
        // coger el id del nuevo pedido para las filas detalle
        $pedido = $db->lastInsertId();
        // insertar las filas en pedidoproductos
    
        foreach($carrito as $codProd=>$unidades){
             $consulta = "insert into pedidosproductos(Pedido, Producto, Unidades) 
                         values( $pedido, $codProd, $unidades)";			
             $resul = $db->query($consulta);
        
    
             $sql1 = "update productos set stock=stock-$unidades
                         where codProd=$codProd";
    
                 $resul1 = $db->query($sql1);
    
            if (!$resul || !$resul1) {
                $db->rollback();
                return FALSE;
            }
        }
        $db->commit();
        return $pedido;
    }

    