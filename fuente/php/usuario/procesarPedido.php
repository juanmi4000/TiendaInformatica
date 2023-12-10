<?php
	/*comprueba que el usuario haya abierto sesión o redirige*/
	require '../utilidades/sesiones.php';
	require_once '../utilidades/ventasCompras/conexionVentasCompras.php';
    require_once '../utilidades/productos/conexionProductos.php';
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
		$carrito = $_SESSION['carrito'];
		foreach ($carrito as $idProducto => $unidades) {
			$producto = cargarProducto($idProducto);
			$resul = insertarVenta($_SESSION['usuario']['idPersona'], $producto, $unidades);
			if($resul == FALSE || $producto == false){
				echo "No se ha podido realizar el pedido<br>";	
				exit;		
			}
		}	
		echo "<b>Pedido realizado con exito. Resumen del pedido:</b> </br>";
		$productos = cargarProductos(array_keys($carrito));
		echo "<table>"; //abrir la tabla
		echo "<tr><th>Nombre</th><th>Modelo</th><th>Descripción</th><th>Peso Total(kg)</th><th>Precio Unitario(€)</th><th>IVA(%)</th><th>Unidades</th><th>Precio Total(€)*</th></tr>";
		foreach($productos as $producto){
			$idProducto = $producto['idProducto'];
			$nombre = $producto['nombre'];
			$descripcion = $producto['descripcion'];
			$modelo = $producto['modelo'];
			$unidades = $_SESSION['carrito'][$idProducto];
			$peso = $producto['peso'] * $unidades;
			$iva = $producto['iva'];
			$precioUnitario = $producto['precioUnitario'];
			$precio = $unidades * ($precioUnitario * (1 + ($iva / 100)));							
			echo "<tr>
				<td>$nombre</td>
				<td>$modelo</td>
				<td>$descripcion</td>					
				<td>$peso</td>
				<td>$precioUnitario</td>
				<td>$iva</td>
				<td>$unidades</td>
				<td>$precio</td>
			</tr>";
		}
		echo "</table>";

		$_SESSION['carrito'] = [];
		
	?>		
	</body>
</html>
	