<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>COMPROBAR COMPRAS DE CLIENTES - Samuel Villar</h1>
<?php
include "session.php";

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 

    //obtenemos la categoria
	$clientes=obtenerCliente($db);
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">COMPROBAR COMPRAS</div>
<div class="card-body">
	<div class="form-group">
		<label for="cliente">CLIENTE:</label>
		<select name="cliente">
		<?php foreach($clientes as $clientes) : ?>
					<option> <?php echo $clientes ?> </option>
				<?php endforeach; ?></select><br><br>
		</select>
		</div>
		<div class="form-group">
        FECHA DESDE<input type="date" name="fechaDesde" class="form-control">
    </div></br>
    <div class="form-group">
        FECHA HASTA<input type="date" name="fechaHasta" class="form-control">
    </div>
	<BR>
<?php
	echo '<div><input type="submit" value="CONSULTAR COMPRAS"></div>
	</form>';
	
	echo "<h2><a href = 'index2.php'>Volver</a></h2>";
} else { 

   $fechaDesde=strtotime($_POST['fechaDesde']);
	$fechaDesde=date("Y-m-d", $fechaDesde);
	$fechaHasta=strtotime($_POST['fechaHasta']);
	$fechaHasta=date("Y-m-d", $fechaHasta);
	$nifCliente=$_POST['cliente'];
    
    listar($db, $nifCliente, $fechaDesde, $fechaHasta);
	
	
	echo "<h3><a href='index2.php'>VOLVER</a></h3>";
	

    //CERRAMOS CONEXION CON LA BASE DE DATOS
    mysqli_close($db);

}
?>

<?php
// Funciones utilizadas en el programa
function limpiar_campo($campoformulario) {
    $campoformulario = trim($campoformulario); //elimina espacios en blanco por izquierda/derecha
    $campoformulario = stripslashes($campoformulario); //elimina la barra de escape "\", utilizada para escapar caracteres
    $campoformulario = htmlspecialchars($campoformulario);  
  
    return $campoformulario;  
}

function listar($db, $nifCliente, $fechaDesde, $fechaHasta){

	$fechaCompras = array();
	$sql="SELECT FECHA_COMPRA FROM COMPRA WHERE DATE_FORMAT(FECHA_COMPRA,'%Y-%m-%d')>='$fechaDesde' AND DATE_FORMAT(FECHA_COMPRA,'%Y-%m-%d')<='$fechaHasta' AND NIF='$nifCliente'";
	$resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
            $fechaCompras[] = $row['FECHA_COMPRA'];
		}
	}
	//var_dump($fechaCompras);
	if(count($fechaCompras)==0){
        echo "No ha hecho ninguna compra en estas fechas";
	}
	else{
		$totalCompras=0;
		foreach($fechaCompras as $fechaCompra) {
			$sql = "SELECT ID_PRODUCTO, UNIDADES FROM COMPRA WHERE FECHA_COMPRA='$fechaCompra'";
			$resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
			$row=mysqli_fetch_assoc($resultado);
			$idProducto=$row['ID_PRODUCTO'];
			$cantidad=$row['UNIDADES'];

			$sql="SELECT ID_PRODUCTO, NOMBRE, PRECIO FROM PRODUCTO WHERE ID_PRODUCTO='$idProducto'";
			$resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
			$row=mysqli_fetch_assoc($resultado);
			$producto=$row['ID_PRODUCTO'];
			$nombreProducto=$row['NOMBRE'];
			$precioProducto=$row['PRECIO'];

			$totalCompras++;

			echo "<b>CLIENTE:</b> ".$nifCliente." || <b>PRODUCTO:</b> ".$producto." || <b>NOMBRE PRODUCTO:</b> ".$nombreProducto." ||  <b>PRECIO:</b> ".$precioProducto." || <b>CANTIDAD COMPRADA:</b> ".$cantidad."</br>";
		}
		echo "<br>Total de compras del cliente: ".$totalCompras;	
	}	
	

}

function obtenerProducto($db) {
	$producto = array();
	
	$sql = "SELECT NOMBRE FROM PRODUCTO";
	
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$producto[] = $row['NOMBRE'];
		}
	}
	return $producto;
}
	
function obtenerAlmacen($db) {
	$almacenes = array();
	
	$sql = "SELECT NUM_ALMACEN FROM ALMACEN";
	
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$almacenes[] = $row['NUM_ALMACEN'];
		}
	}
	return $almacenes;
}

function obtenerCliente($db){
    $clientes = array();

    $sql = "SELECT NIF FROM CLIENTE";

    $resultado = mysqli_query($db, $sql);
    if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$clientes[] = $row['NIF'];
		}
	}
	return $clientes;
}


?>
</body>

</html>