<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
	<style>
		table{
        border: 1px solid black;
        width:80%;
        margin: auto;
    }

    tr, td{
        border: 1px solid black;
        width: 9%;
        text-align: left;
        vertical-align: top;
        border-spacing: 0;
        border-collapse: collapse;
        padding: 0.3em;
    }
	</style>
</head>

<body>
<h1>COMPROBAR STOCK DE PRODUCTOS - Samuel Villar</h1>
<?php
include "session.php";

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 

    //obtenemos la categoria
	$productos=obtenerProducto($db);
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">STOCK PRODUCTOS</div>
<div class="card-body">
	<div class="form-group">
	<label>Producto:</label>
	<select name="producto">
    <?php foreach($productos as $producto) : ?>
			<option> <?php echo $producto ?> </option>
		<?php endforeach; ?>
	</select>
	</div>
	<BR>
<?php
	echo '<div><input type="submit" value="VER STOCK DEL PRODUCTO"></div>
	</form>';
} else { 

    //RECOGIDA DE DATOS
    //COGEMOS EL VALOR DE PRODUCTO
	$producto=$_POST['producto'];
	$sql = "SELECT ID_PRODUCTO FROM PRODUCTO WHERE NOMBRE= '$producto' ";
	$resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
    $row=mysqli_fetch_assoc($resultado);    
    $idProducto=$row['ID_PRODUCTO'];
	
	$sql = "SELECT * FROM ALMACENA WHERE ID_PRODUCTO = '$idProducto'";
    $resultado = mysqli_query($db, $sql);
	
	echo "<h1>STOCK DEL PRODUCTO " . $producto . "</h1>";
    echo "<br><table>
                <tr><td><b>ID PRODUCTO</b></td><td><b>ALMACEN</b></td>
                <td><b>CANTIDAD</b></td>
                </tr>";
    while($mostrar=mysqli_fetch_array($resultado)){

        echo "<tr>
                <td>" . $mostrar['ID_PRODUCTO'] . "</td>
                <td>" . $mostrar['NUM_ALMACEN'] . "</td>
                <td>" . $mostrar['CANTIDAD'] . "</td>
            </tr>";
    }
    echo "</table>";

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




?>

<h2><a href = "index.php">Volver</a></h2>

</body>

</html>