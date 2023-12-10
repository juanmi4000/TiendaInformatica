<?php 
	/*comprueba que el usuario haya abierto sesión o redirige*/
	require '../utilidades/sesiones.php';
	require_once '../utilidades/conexiones.php';
	comprobarSesion();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset = "UTF-8">
		<title>Productos</title>
		<link rel="stylesheet" href="../../style/style.css">		
	</head>
	<body>
		<?php 
		require 'cabecera.php';
		$categoria=$_GET['categoria'];
		$cat = cargarCategoria($categoria);
		$productos = cargarProductosCategoria($categoria);		
		if($cat === false or $productos === false){
			echo "<p class='error'>Error al conectar con la base datos</p>";
			exit;
		}
		if ($productos === -1) {
			echo "<p class='error'>No tenemos o no hay stock de productos de esa categoría</p>";
			exit;
		}
		echo "<h2>". $cat['nombre']. "</h2>";
		echo "<p>". $cat['descripcion']."</p>";		
		echo "<table>"; //abrir la tabla
		echo "<tr><th>Nombre</th><th>Descripción</th><th>Categoría</th><th>Modelo</th><th>Peso</th><th>Precio(€)*</th><th>IVA</th><th>Stock</th><th>Comprar</th></tr>";
		foreach($productos as $producto){
			$idProducto = $producto['idProducto'];
			$nombre = $producto['nombre'];
			$descripcion = $producto['descripcion'];
			$catego = $producto['categoria'];
			$modelo = $producto['modelo'];
			$peso = $producto['peso'];
			$iva = $producto['iva'];
			$precio = $producto['precioUnitario'] * (1 + ($iva / 100));
			$stock = $producto['stock'];							
			echo "<tr>
				<td>$nombre</td>
				<td>$descripcion</td>
				<td>$catego</td>
				<td>$modelo</td>
				<td>$peso</td>
				<td>$precio</td>
				<td>$iva</td>
				<td>$stock</td>
				<td> 
					<form action = 'anadir.php' method = 'POST'>

						<input name = 'categoria' type='hidden' value = '$categoria'>

						<input name = 'unidades' type='number' min = '1' value = '1' max= '$stock'>
						<input type = 'submit' value='Comprar'>
						<input name = 'id' type='hidden' value = '$idProducto'>
						
					</form>
				</td>
			</tr>";
		}
		echo "</table>";	
		echo "<p>* El precio ya incluye el IVA</p>";
		?>
		
	</body>
</html>