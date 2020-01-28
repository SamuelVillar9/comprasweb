<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA ALMACEN - Samuel Villar</h1>
<?php
include "session.php";

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Datos Almacen</div>
<div class="card-body">
		<div class="form-group">
        LOCALIDAD ALMACEN <input type="text" name="localidad" placeholder="Localidad" class="form-control">
        </div>
		<BR>
<?php
	echo '<div><input type="submit" value="Dar de Almacen"></div>
	</form>';
} else { 

    $localidad=limpiar_campo($_POST['localidad']);

	$select="SELECT max(NUM_ALMACEN) as codFinal from ALMACEN";
    $resultado=mysqli_query($db, $select);//el resultado no es valido, hay que tratarlo
	$row=mysqli_fetch_assoc($resultado);
	$codFinal=$row['codFinal'];

	if($codFinal==NULL){
		$codFinal=10;
	}
	else{
		$codFinal=$codFinal+10;
	}
	
  //INSERTAMOS EN TABLA CATEGORIA
    $sql = "INSERT INTO ALMACEN (NUM_ALMACEN, LOCALIDAD) VALUES ('$codFinal', '$localidad')";

    // COMPROBAR CONEXION
    if (mysqli_query($db, $sql)) {
        echo "Datos del almacen introducidos correctamente";
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

?>

<h2><a href = "index.php">Volver</a></h2>


</body>

</html>