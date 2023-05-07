<?php
  include_once "connections/connection.php";
  $conn = connection();

  if (!isset($_SESSION)) {
    session_start();
  }
  
  if (isset($_SESSION['User'])) {
    header("Location: php/home.php");
  } elseif (isset($_GET['view'])) {
    
  } else {
    header("Location: php/login.php");
  }
?>