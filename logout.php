<?php 
  require "libs/functions.php";

  if(isset($_SESSION["email"])){
    unset($_SESSION["username"]);
    unset($_SESSION["email"]);
    unset($_SESSION["type"]);

    header("Location: login.php");
  }elseif(isset($_COOKIE["email"])){
    setcookie("username", $_COOKIE["username"], time() - 36400 * 30);
    setcookie("email", $_COOKIE["email"], time() - 36400 * 30);
    setcookie("type", $_COOKIE["type"], time() - 36400 * 30);

    header("Location: login.php");
  }

  header("Location: index.php");
?>