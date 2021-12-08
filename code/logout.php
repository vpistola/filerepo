<?php
   // ob_start();

   // session_start();
   // $_SESSION = array();
   // setcookie(session_name(), '', time() - 2592000, '/');
   // session_destroy();

   // header("Location : ./login.php");

   // ob_end_flush();

   session_start();
   
   if(session_destroy()) {
      header("Location: ./login.php");
   }
?>