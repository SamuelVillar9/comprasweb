<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>COMPRAR PRODUCTO - Samuel Villar</h1>
<?php
include "session.php";

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 

    //obtenemos los datos con funciones
	$productos=obtenerProducto($db);
	$almacenes=obtenerAlmacen($db);
	$dni=obtenerDni($db);
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">COMPRAR PRODUCTOS</div>
<div class="card-body">
		<div class="form-group">
        NIF CLIENTE<select name="nif">
		<?php foreach($dni as $dni) : ?>
					<option> <?php echo $dni ?> </option>
				<?php endforeach; ?></select><br>
		</select>
    </div>
	<div class="form-group">
		<label for="nombreProducto">PRODUCTO:</label>
		<select name="nombreProducto">
		<?php foreach($productos as $productos) : ?>
					<option> <?php echo $productos ?> </option>
				<?php endforeach; ?></select><br>
		</select>
	</div>
		<div class="form-group">
        UNIDADES DEL PRODUCTO <input type="number" name="unidades" placeholder="0" class="form-control">
        </div>
	<BR>
<?php
	echo '<div><input type="submit" value="Comprar"></div>
	</form>';
} else { 

    //RECOGIDA DE DATOS
    $nombreProducto=$_POST['nombreProducto'];
	$fechaCompra=date("Y-m-d H:m:s"); //fecha actual
	$nif=limpiar_campo($_POST['nif']);
	$unidades=limpiar_campo($_POST['unidades']);
	
	insert($db, $nombreProducto, $unidades, $nif, $fechaCompra);

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
	
function obtenerDni($db) {
	$dni = array();
	
	$sql = "SELECT NIF FROM CLIENTE";
	
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$dni[] = $row['NIF'];
		}
	}
	return $dni;
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

function insert($db, $nombreProducto, $unidades, $nif, $fechaCompra){

    $sql="SELECT ID_PRODUCTO from PRODUCTO where NOMBRE= '$nombreProducto'";
    $resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
	$row=mysqli_fetch_assoc($resultado);
	$idProducto=$row['ID_PRODUCTO'];
	
	$sql="SELECT SUM(CANTIDAD) as cantidad from ALMACENA where ID_PRODUCTO= '$idProducto'";//Ponerle un alias para el SUM
    $resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
	$row=mysqli_fetch_assoc($resultado);
	$cantidad=$row['cantidad'];//Cantidad del producto de todos los almacenes
	
	$sql="SELECT NIF from CLIENTE where NIF= '$nif'";//Ponerle un alias para el SUM
    $resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
	$row=mysqli_fetch_assoc($resultado);
	$nifExiste=$row['NIF'];

	if($nifExiste){
		if($unidades<$cantidad){  

			$sql="INSERT INTO COMPRA (NIF, ID_PRODUCTO, FECHA_COMPRA, UNIDADES) VALUES ('$nifExiste','$idProducto','$fechaCompra','$unidades')";
			if(mysqli_query($db, $sql)){
				
				$cont=0;
				$numAlmancen=10;//numero del primer almacen
				
				while($unidades>$cont){

					$sql="SELECT CANTIDAD FROM ALMACENA WHERE  NUM_ALMACEN='$numAlmancen' AND ID_PRODUCTO='$idProducto'";
					$resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
					$row=mysqli_fetch_assoc($resultado);
					$cantidadAlmacen=$row['CANTIDAD'];

					if($cantidadAlmacen>0){
						$sql="UPDATE ALMACENA SET CANTIDAD=CANTIDAD-1 WHERE NUM_ALMACEN='$numAlmancen' AND ID_PRODUCTO='$idProducto'";
						$resultado=mysqli_query($db, $sql);
						$cont++;
					}
					else{
						$numAlmancen=$numAlmancen+10;
					}
					
				}

				echo "Compra realizada<br>";
			}
			else {
				echo "Error: ".$sql."<br>".mysqli_error($db)."<br>";
			}

			
			
		}
		else{
			trigger_error("NO hay suficiente stock");
		}
	}
	else{
		trigger_error("NIF incorrecto o no existente");
	}

}

function errores ($error_level, $error_message, $error_file, $error_line, $error_context){
	echo "<b>Codigo error: </b> $error_level - <b> Mensaje: $error_message </b><br>";
	echo "<b>Fichero: $error_file</b><br>";
	echo "<b>Linea: $error_line</b><br>";
	//var_dump($error_context);
	echo "Finalizando script <br>";
	die(); 
//set_error_handler("errores"); // Establecemos la funcion que va a tratar los errores
//trigger_error('El DNI '.$DNI.' ya existe previamente');	
}

?>

</body>

</html>