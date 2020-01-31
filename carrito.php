<?php
session_start();
$estado="";
if (isset($_POST['action']) && $_POST['action']=="borrar"){
if(!empty($_SESSION["carritoCompra"])) {
	foreach($_SESSION["carritoCompra"] as $key => $value) {
		if($_POST["codigo"] == $key){
		unset($_SESSION["carritoCompra"][$key]);
		$estado = "<div style='color:red;'>
		El producto ha sido borrado del carrito</div>";
		}
		if(empty($_SESSION["carritoCompra"]))
		unset($_SESSION["carritoCompra"]);
			}		
		}
}

if (isset($_POST['action']) && $_POST['action']=="change"){
  foreach($_SESSION["carritoCompra"] as &$value){
    if($value['codigo'] === $_POST["codigo"]){
        $value['cantidad'] = $_POST["cantidad"];
        break;
    }

}
}
?>
<html>
<head>
<title>CARRITO DE LA COMPRA</title>
<meta charset="UTF-8">
<style>
	
	table{
		text-align:center;
		border: 1px solid black;
	}

</style>
</head>
<body>
<div style="width:700px; margin:50 auto;">

<h2>CARRITO DE LA COMPRA</h2>   

<?php
if(!empty($_SESSION["carritoCompra"])) {
$contadorCarrito = count(array_keys($_SESSION["carritoCompra"]));
?>
<div>
Productos en Carrito:
<span><?php echo $contadorCarrito; ?></span></a><br>

<span><a href='compro2.php'>Seguir Comprando</a></span></a>
</div>
<?php
}
?>

<div>
<?php
if(isset($_SESSION["carritoCompra"])){
    $total_precio = 0;
?>
<br>	
<table>
<tbody>
<tr>
<td>PRODUCTO</td>
<td>CANTIDAD</td>
<td>PRECIO UNITARIO</td>
<td>TOTAL PRODUCTOS</td>
</tr>	
<?php		
foreach ($_SESSION["carritoCompra"] as $producto){
?>
<tr>
<td><?php echo $producto["nombre"]; ?><br />
<form method='post' action=''>
<input type='hidden' name='codigo' value="<?php echo $producto["codigo"]; ?>" />
<input type='hidden' name='action' value="borrar" />
<button type='submit'>Borrar producto</button>
</form>
</td>
<td>
<form method='post' action=''>
<input type='hidden' name='codigo' value="<?php echo $producto["codigo"]; ?>" />
<input type='hidden' name='action' value="change" />
<select name='cantidad' onchange="this.form.submit()">
<option selected="true" disabled="disabled">CANTIDAD A COMPRAR</option>
<option <?php if($producto["cantidad"]==1);?> value="1">1</option>
<option <?php if($producto["cantidad"]==2);?> value="2">2</option>
<option <?php if($producto["cantidad"]==3);?> value="3">3</option>
<option <?php if($producto["cantidad"]==4);?> value="4">4</option>
<option <?php if($producto["cantidad"]==5);?> value="5">5</option>
</select>
</form>
</td>
<td><?php echo $producto["precio"] . "€"; ?></td>
<td><?php echo $producto["precio"]*$producto["cantidad"] . "€"; ?></td>
</tr>
<?php
$total_precio += ($producto["precio"]*$producto["cantidad"]);
}
?>
<tr>
<td colspan="5" align="right">
<strong>TOTAL: <?php echo "€".$total_precio; ?></strong>
</td>
</tr>
</tbody>
</table>
<form method='post' action = 'validarCompra.php'>
<input type='submit' value='Acabar Pedido'>
</form>		
  <?php
}else{
	echo "<h3>Tu carrito esta vacio</h3>";
	}
?>
</div>

<div></div>

<div style="margin:10px 0px;">
<?php echo $estado; ?>
</div>

<h2><a href = "index2.php">Volver</a></h2>

<br /><br />
</div>
</body>
</html>