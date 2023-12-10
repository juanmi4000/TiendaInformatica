<?php 
/*comprueba que el usuario haya abierto sesión o redirige*/
require_once '../utilidades/sesiones.php';
comprobarSesion();
$idProducto = $_POST['id'];
$unidades = $_POST['unidades'];
/* si existe el código restamos las unidades, con mínimo de 0 */
if(isset($_SESSION['carrito'][$idProducto])){		
	$_SESSION['carrito'][$idProducto] -= $unidades;
	if($_SESSION['carrito'][$idProducto] <= 0){
		unset($_SESSION['carrito'][$idProducto]);
	}
	
}
header("Location: carrito.php");
