<?php

include('config.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];

$password = strrev($apellido);

//INSERTAMOS EN TABLA DEPARTAMENTO
$sql = "INSERT INTO ADMIN (USERNAME, PASSWORD) VALUES ('$nombre', '$password')";

// COMPROBAR CONEXION
if (mysqli_query($db, $sql)) {
    echo "USUARIO CREADO CORRECTAMENTE<br>
					<b>USUARIO:</b> $nombre <br> 
					<b>PASSWORD:</b> $password<br>";

echo "<div>
		<p><a href='login.php'>INICIA SESION</a></p>
	</div>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
}

//CERRAMOS CONEXION CON LA BASE DE DATOS
mysqli_close($db);

?>