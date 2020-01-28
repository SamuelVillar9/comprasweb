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
      <title>PANEL DE ADMIN</title>
	  <meta charset="UTF-8">
   </head>
   
   <body>
      <h1>Bienvenido <?php echo $login_session; ?></h1> 
	  
	  
	  <nav class="dropdownmenu">
  <ul>
    <li><a href="comaltacat.php">Dar de alta categoria</a></li>
    <li><a href="comaltapro.php">Dar de alta producto</a></li>
	<li><a href="comaltacli.php">Dar de alta cliente</a></li>
	<li><a href="comaltaalm.php">Dar de alta almacen</a></li>
	<li><a href="comaprpro.php">Aprovisionar productos</a></li>
	<li><a href="compro.php">Comprar Productos</a></li>
	<li><a href="comconstock.php">Comprobar Stock</a></li>
	<li><a href="comconsalm.php">Comprobar Almacenes</a></li>
	<li><a href="comconscom.php">Comprobar Compras</a></li>
  </ul>
</nav>
	  
	  
	  
      <h2><a href = "logout.php">Cerrar Sesion</a></h2>
   </body>
   
</html>