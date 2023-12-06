<?php
	/*comprueba que el usuario haya abierto sesión o redirige*/
	require_once '../utilidades/sesiones.php';
    require_once '../utilidades/conexiones.php';
    comprobarSesion();
?>	
<!DOCTYPE html>
<html>
	<head>
		<meta charset = "UTF-8">
		<title>Pedidos</title>	
        <link rel="stylesheet" href="../../style/style.css">	
	</head>
	<body>
	<?php 
	require 'cabecera.php';			
	$resul = insertarPedido($_SESSION['carrito'], $_SESSION['usuario']['idPersona']);
	if($resul === FALSE){
		echo "No se ha podido realizar el pedido<br>";			
	}else{
		$compra=$_SESSION['carrito'];
		
		echo "Pedido realizado con exito. Resumen del pedido: </BR>";
		echo "<h1>Pedido nº $resul</h1>";
		$productos = cargarProductos(array_keys($compra));
		echo "<table>"; //abrir la tabla
		echo "<tr><th>Nombre</th><th>Descripción</th><th>Peso</th><th>Unidades</th></tr>";
		foreach ($productos as $producto) {
			$cod=$producto['CodProd'];
			$nom=$producto['Nombre'];	
			$des=$producto['Descripcion'];
			$peso=$producto['Peso'];
			$unidades=$_SESSION['carrito'][$cod];
			
			echo "<tr><td>$nom</td><td>$des</td><td>$peso</td><td>$unidades</td>";
		}
		echo "</table>";

		$_SESSION['carrito'] = [];

		}		
	?>		
	</body>
</html>
	