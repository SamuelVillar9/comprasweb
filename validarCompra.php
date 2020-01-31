<?php

include('config.php');
session_start();
	
	//recuperamos las variables de sesion para hacer el insert
	$nif = $_SESSION['nifUsuario']; //nif del usuario logueado
	foreach($_SESSION["carritoCompra"] as &$value){ //sacamos del array las variables idproducto y cantidad
		$idProducto = $value['codigo'];
		$unidades = $value['cantidad'];
    }
	$fechaCompra=date("Y-m-d H:m:s"); //fecha actual
	
	//select para coger la suma total del producto de todos los almacenes
	$sql="SELECT SUM(CANTIDAD) as cantidad from ALMACENA where ID_PRODUCTO= '$idProducto'";//Ponerle un alias para el SUM
    $resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
	$row=mysqli_fetch_assoc($resultado);
	$cantidad=$row['cantidad'];//Cantidad del producto de todos los almacenes
	
	if($nif){
		foreach($_SESSION["carritoCompra"] as &$value){
		if($value['cantidad']<$cantidad){  

			$sql="INSERT INTO COMPRA (NIF, ID_PRODUCTO, FECHA_COMPRA, UNIDADES) VALUES ('$nif','$idProducto','$fechaCompra','$unidades')";
			if(mysqli_query($db, $sql)){
				
				$cont=0;
				$numAlmancen=10;//numero del primer almacen
				
				while($unidades>$cont){

					$sql="SELECT CANTIDAD FROM ALMACENA WHERE  NUM_ALMACEN='$numAlmancen' AND ID_PRODUCTO='$idProducto'";
					$resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
					$row=mysqli_fetch_assoc($resultado);
					$cantidadAlmacen=$row['CANTIDAD'];

					if($cantidadAlmacen>0){
						$sql="UPDATE ALMACENA SET CANTIDAD=CANTIDAD-1 WHERE NUM_ALMACEN='$numAlmancen' AND ID_PRODUCTO='$idProducto'";
						$resultado=mysqli_query($db, $sql);
						$cont++;
					}
					else{
						$numAlmancen=$numAlmancen+10;
					}
					
				}

				echo "<script>alert('Compra realizada');</script>";
				foreach($_SESSION["carritoCompra"] as $key => $value) {
					unset($_SESSION["carritoCompra"][$key]);
					
				}
				$_SESSION['nifUsuario'];
				echo "<h2><a href = 'index2.php'>Volver</a></h2>";
			}
			else {
				echo "Error: ".$sql."<br>".mysqli_error($db)."<br>";
			}

			
			
		}
		else{
			trigger_error("NO hay suficiente stock");
		}
	}
	}else{
		trigger_error("NIF incorrecto o no existente");
	}
	
	function actualizar($db, $fechaCompra){
	
		$nif = $_SESSION['nifUsuario'];

			foreach ($_SESSION['carritoCompra'] as $idProducto => $unidades){
			
				$sql = "INSERT INTO COMPRA (NIF, ID_PRODUCTO, FECHA_COMPRA, UNIDADES) VALUES ()
			
			}
	
	
	}
	
//CERRAMOS CONEXION CON LA BASE DE DATOS
mysqli_close($db);

?>