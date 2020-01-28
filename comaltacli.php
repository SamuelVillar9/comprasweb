<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA CLIENTE - Samuel Villar</h1>
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
<div class="card-header">Datos Cliente</div>
<div class="card-body">
		<div class="form-group">
        NIF <input type="text" name="nif" placeholder="NIF" class="form-control" required maxlength="9" minlength="9">
        </div>
		<div class="form-group">
        NOMBRE <input type="text" name="nombre" placeholder="Nombre" class="form-control">
        </div>
		<div class="form-group">
        APELLIDO <input type="text" name="apellido" placeholder="Apellido" class="form-control">
        </div>
		<div class="form-group">
        CODIGO POSTAL <input type="text" name="cp" placeholder="Codigo Postal" class="form-control">
        </div>
		<div class="form-group">
        DIRECCION <input type="text" name="direccion" placeholder="Direccion" class="form-control">
        </div>
		<div class="form-group">
        CIUDAD <input type="text" name="ciudad" placeholder="Ciudad" class="form-control">
        </div>

		<BR>
<?php
	echo '<div><input type="submit" value="Dar de Alta Cliente"></div>
	</form>';
} else { 

    $nif=limpiar_campo($_POST['nif']);
    $nombre=limpiar_campo($_POST['nombre']);
	$apellido=limpiar_campo($_POST['apellido']);
    $cp=limpiar_campo($_POST['cp']);
	$direccion=limpiar_campo($_POST['direccion']);
    $ciudad=limpiar_campo($_POST['ciudad']);

    //INSERTAMOS EN TABLA CATEGORIA
    $sql = "INSERT INTO CLIENTE (NIF, NOMBRE, APELLIDO, CP, DIRECCION, CIUDAD) VALUES ('$nif', '$nombre', '$apellido', '$cp', '$direccion', '$ciudad')";

    // COMPROBAR CONEXION
    if (mysqli_query($db, $sql)) {
        echo "Datos del cliente introducidos correctamente";
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