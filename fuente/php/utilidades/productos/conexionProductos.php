<?php
    /**
    * Se va encargar de leer un xml y lo va a validar mediante un xsd. Saca la información del xml como la ip, nombre, usuario y la clave
    * @param string $nombre Nombre del xml
    * @param string $esquema Nombre del xsd
    * @return array Devuelve un array que contiene la cadena, el usuario y la clave para conectarse a una base de datos
    */
    function leerConfigPro($nombre, $esquema) {
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
     * Inserta un producto
     * @param string $nombre Nombre del producto
     * @param string $descripcion Descripción del producto
     * @param int $categoria Una de las categorías que esté en la tabla categoría
     * @param string $modelo Modelo del producto
     * @param float $peso Peso específico del producto
     * @param float $precioUnitario Precio sin IVA
     * @param int $iva Iva del producto
     * @param int $stock Stock que se le quiere poner al principio
     * @return bool Si ha ocurrido algún error devuelve false, si lo ha insertado correctamente devuelve true
     */
    function insertarProducto($nombre, $descripcion, $categoria, $modelo, $peso, $precioUnitario, $iva, $stock){
        $configuracion = leerConfigPro(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $ins = "INSERT INTO productos(nombre, descripcion, categoria, modelo, peso, precioUnitario, iva, stock) VALUES ('$nombre', '$descripcion', $categoria, '$modelo', $peso, $precioUnitario, $iva, $stock)";
        $resul = $db->query($ins);
        if (!$resul) {
            return false; 
        }
        return true;
    }

    /**
     * Elimina un producto 
     * @param int $idProducto Id del producto a eliminar
     * @return bool Devuelve false en caso de algún error, si lo ha eliminado correctamente devuelve true
     */
    function eliminarProducto($idProducto) {
        $configuracion = leerConfigPro(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $del = "DELETE FROM productos WHERE idProducto = $idProducto";
        $resul = $db->query($del);
        if (!$resul) {
            return false;
        }
        return true;
    }

    /**
    * Carga los datos del producto que le hemos pasado por parámetro 
    * @param array $idProductos Id del producto
    * @return mixed Devuelve false si no ha salido bien la consulta, sino devuelve el producto
    */
    function cargarProducto($idProducto){
        $configuracion = leerConfigPro(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
        $db = new PDO($configuracion[0], $configuracion[1], $configuracion[2]);
        $consulta = "SELECT * FROM productos WHERE idProducto = :idProd";
        $resul = $db->prepare($consulta);
        $resul->bindParam(':idProd', $idProducto, PDO::PARAM_STR);
        $resul->execute();
        $fila = $resul->fetch(PDO::FETCH_ASSOC);	
        if (!$fila) {
            return false;
        }
        //si hay 1 o más
        return $fila;
    }

    
    /**
     * Se va a encargar de cargar todos los productos que se pasen como parámetro.
     * @param array $codigosProductos Array con todos los códigos de los productos
     * @return PDOStatement|bool Devuelve los productos según los ids que se le pasen o false si algo no ha salido bien durante la consulta
     */
    function cargarProductos($codigosProductos){
        $configuracion = leerConfigPro(dirname(__FILE__)."/../../../xml/configuracion.xml", dirname(__FILE__)."/../../../xml/squema.xsd");
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