<html>
   
   <head>
      <title>REGISTRO</title>
      <meta charset="UTF-8">
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Registro</b></div>
				
            <div style = "margin:30px">
               
               <form action = "validarRegistro.php" method = "post">
                  <label>Nombre de Usuario  :</label><input type = "text" name = "nombre" class = "box"/><br /><br />
                  <label>Apellido  :</label><br><input type = "text" name = "apellido" class = "box" /><br/><br />
                  <input type = "submit" value = " ENVIAR "/><br />
               </form>
			   
			   <div>
				<p>¿Ya tienes una cuenta? <a href="login.php">Inicia Sesion</a></p>
			   </div>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>