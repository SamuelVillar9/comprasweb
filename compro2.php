<?php

session_start();
include('config.php');
$estado="";
if (isset($_POST['codigo']) && $_POST['codigo']!=""){
$codigo = $_POST['codigo'];
$result = mysqli_query($db,"SELECT * FROM `PRODUCTO` WHERE `ID_PRODUCTO`='$codigo'");
$row = mysqli_fetch_assoc($result);
$nombre = $row['NOMBRE'];
$codigo = $row['ID_PRODUCTO'];
$precio = $row['PRECIO'];

$cartArray = array(
	$codigo=>array(
	'nombre'=>$nombre,
	'codigo'=>$codigo,
	'precio'=>$precio,
	'cantidad'=>1)
);

if(empty($_SESSION["carritoCompra"])) {
	$_SESSION["carritoCompra"] = $cartArray;
	$estado = "<div>Producto annadido al carrito</div>";
}else{
	$array_keys = array_keys($_SESSION["carritoCompra"]);
	if(in_array($codigo,$array_keys)) {
		$estado = "<div style='color:red;'>
		Producto annadido al carrito</div>";	
	} else {
	$_SESSION["carritoCompra"] = array_merge($_SESSION["carritoCompra"],$cartArray);
	$estado = "<div>Producto annadido al carrito</div>";
	}

	}
}

?>
<html>
<head>
<title>REALIZAR PEDIDO</title>
<meta charset="UTF-8">
</head>
<body>
<div style="width:700px; margin:50 auto;">

<h2>REALIZAR PEDIDO</h2>   

<?php
if(!empty($_SESSION["carritoCompra"])) {
$contadorCarrito = count(array_keys($_SESSION["carritoCompra"]));
?>
<div>
<a href="carrito.php">Productos en carrito: <span><?php echo $contadorCarrito; ?></span></a>
</div>
<?php
}

$result = mysqli_query($db,"SELECT * FROM `PRODUCTO` ORDER BY 'NOMBRE'");
while($row = mysqli_fetch_assoc($result)){
		echo "<br><div>
			  <form method='post' action=''>
			  <input type='hidden' name='codigo' value=".$row['ID_PRODUCTO']." />
			  <div>".$row['NOMBRE']."</div>
		   	  <div>".$row['PRECIO']."€</div>
			  <button type='submit'>ANNADIR A CARRITO</button>
			  </form>
		   	  </div>";
        }
mysqli_close($db);
?>

<div></div>

<div style="margin:10px 0px;">
<?php echo $estado; ?>
</div>

<br /><br />

	<h2><a href = "index2.php">Volver</a></h2>

</div>
</body>
</html>

