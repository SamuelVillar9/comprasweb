<meta charset="UTF-8">
<?php
   session_start();
   
   if(session_destroy()) {
      header("Location: login.php");
   }
?>