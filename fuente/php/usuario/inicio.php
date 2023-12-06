<?php 
	require '../utilidades/sesiones.php';
	require_once '../utilidades/conexiones.php';
	comprobarSesion();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tienda Informática</title>
        <link rel="stylesheet" href="../../style/style.css">
    </head>
	<body>
		<?php require 'cabecera.php';?>
		<h1>Lista de categorías</h1>		
		<!--lista de vínculos con la forma 
		productos.php?categoria=1-->
		<?php
		$categorias = cargarCategorias();
		if($categorias===false){
			echo "<p class='error'>Error al conectar con la base datos</p>";
		}else{
			echo "<ol>"; //abrir la lista
			foreach($categorias as $cat){				
				$url = "productos.php?categoria=".$cat['idCategoria'];
				echo "<li><a href='$url'>".$cat['nombre']."</a></li>";
			}
			echo "</ol>";
		}
		?>
	</body>
</html>