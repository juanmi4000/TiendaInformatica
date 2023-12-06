<?php 
/*comprueba que el usuario haya abierto sesión o redirige*/
require '../utilidades/sesiones.php';
comprobarSesion();
$idProducto = $_POST['idProducto'];
$unidades = (int)$_POST['unidades'];
$categoria=$_POST['categoria'];
/*si existe el código sumamos las unidades*/
if(isset($_SESSION['carrito'][$idProducto])){
	$_SESSION['carrito'][$idProducto] += $unidades;
}else{
	$_SESSION['carrito'][$idProducto] = $unidades;		
}
header("Location: productos.php?categoria=$categoria");