<?php
	
	require("session.php");
	
	$username = $_POST['username'];
   $password = $_POST['password'];
   
   $sql2=mysql_query("SELECT * FROM ADMIN WHERE USERNAME='$usename'");
	if($f2=mysql_fetch_array($sql2)){
		if($password=="admin"){
			$_SESSION['id']=$f2['ID'];
			$_SESSION['user']=$f2['USERNAME'];
			echo "<script>alert('BIENVENIDO ADMIN')</script>";
			echo "<script>location.href='index.php'</script>";
		}
   }

?>