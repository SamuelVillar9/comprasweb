<?php
   include('session.php');
   //Sesion de inactividad
   $inactividad = 999;
    if(isset($_SESSION["timeout"])){
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: login.php");
        }
    }
	$_SESSION["timeout"] = time();
		
	$_SESSION['idusuario'] = $login_session;
	
		//guardamos en variable de sesion el nif del cliente
	$cliente = $_SESSION['login_user'];
	$result = mysqli_query($db,"SELECT * FROM `CLIENTE` WHERE `NOMBRE`='$cliente'");
	$row = mysqli_fetch_assoc($result);
	$nif = $row['NIF'];
	$_SESSION['nifUsuario'] = $nif;
	
	
?>

<html>
   
   <head>
      <title>PANEL DE USUARIO</title>
	  <meta charset="UTF-8">
   </head>
   
   <body>
      <h1>Bienvenido <?php echo $login_session; ?></h1> 
	  
	  
	  <nav class="dropdownmenu">
  <ul>
	<li><a href="compro2.php">Comprar Productos</a></li>
	<li><a href="comconscom2.php">Comprobar Compras</a></li>
	<li><a href="carrito.php">Carrito de la compra</a></li>
  </ul>
</nav>
      <h2><a href = "logout.php">Cerrar Sesion</a></h2>
   </body>
   
</html>