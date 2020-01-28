<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA PRODUCTOS - Samuel Villar</h1>
<?php
include "session.php";

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 

    //obtenemos la categoria
	$idcategoria=obtenerCategoria($db);
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Datos Producto</div>
<div class="card-body">
		<div class="form-group">
        ID PRODUCTO <input type="text" name="idproducto" placeholder="idproducto" class="form-control">
        </div>
		<div class="form-group">
        NOMBRE PRODUCTO <input type="text" name="nombre" placeholder="nombre" class="form-control">
        </div>
		<div class="form-group">
        PRECIO PRODUCTO <input type="text" name="precio" placeholder="precio" class="form-control">
        </div>
	<div class="form-group">
	<label for="categoria">Categorías:</label>
	<select name="categoria">
    <?php foreach($idcategoria as $idcategoria) : ?>
			<option> <?php echo $idcategoria ?> </option>
		<?php endforeach; ?>
	
	</select>
	</div>
	<BR>
<?php
	echo '<div><input type="submit" value="Dar de Alta Producto"></div>
	</form>';
} else { 

    //RECOGIDA DE DATOS
    $idproducto=limpiar_campo($_POST['idproducto']);
    $nombre=limpiar_campo($_POST['nombre']);
    $precio=limpiar_campo($_POST['precio']);

    $idcategoria=$_POST['categoria'];
	$sql = "SELECT ID_CATEGORIA FROM categoria WHERE NOMBRE= '$idcategoria' ";
	$resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
    $row=mysqli_fetch_assoc($resultado);    
    $id=$row['ID_CATEGORIA'];
	$sql = "INSERT INTO producto (ID_PRODUCTO, NOMBRE, PRECIO, ID_CATEGORIA) VALUES ('$idproducto', '$nombre', '$precio', '$id')";

    // COMPROBAR CONEXION
    if (mysqli_query($db, $sql)) {
        echo "Datos del producto introducidos correctamente<br>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }

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

function obtenerCategoria($db) {
	$categoria = array();
	
	$sql = "SELECT NOMBRE FROM categoria";
	
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$categoria[] = $row['NOMBRE'];
		}
	}
	return $categoria;
}
	




?>

<h2><a href = "index.php">Volver</a></h2>

</body>

</html>