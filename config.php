<meta charset="UTF-8">
<?php
   define('DB_SERVER', 'localhost'); //cambiar a IP si vas a subir a servidor
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'rootroot');
   define('DB_DATABASE', 'COMPRASWEB'); //cambiar base de datos por la que vayas a utilizar
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   
	if (!$db) {
		die("Error conexión: " . mysqli_connect_error());
	}
  
?>