<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA CATEGORÍAS - Samuel Villar</h1>
<?php
include "conexion.php";


/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 

	
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Datos Categoría</div>
<div class="card-body">
		<div class="form-group">
        ID CATEGORIA <input type="text" name="idcategoria" placeholder="idcategoria" class="form-control">
        </div>
		<div class="form-group">
        NOMBRE CATEGORIA <input type="text" name="nombre" placeholder="nombre" class="form-control">
        </div>

		<BR>
<?php
	echo '<div><input type="submit" value="Alta Categoría"></div>
	</form>';
} else { 

    $idcategoria=limpiar_campo($_POST['idcategoria']);
    $nombre=limpiar_campo($_POST['nombre']);

    //INSERTAMOS EN TABLA CATEGORIA
    $sql = "INSERT INTO categoria (ID_CATEGORIA, NOMBRE) VALUES ('$idcategoria', '$nombre')";

    // COMPROBAR CONEXION
    if (mysqli_query($db, $sql)) {
        echo "Datos introducidos correctamente";
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



</body>

</html>
