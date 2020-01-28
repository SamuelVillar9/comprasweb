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
?>

<html">
   
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
  </ul>
</nav>
	  
	  
	  
      <h2><a href = "logout.php">Cerrar Sesion</a></h2>
   </body>
   
</html>