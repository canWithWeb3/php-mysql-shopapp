<?php 
  require "libs/functions.php";

  if($usersClass->isAdmin() && isset($_GET["id"])){
    if($productsClass->deleteProduct($_GET["id"])){
      header("Location: admin-products.php");
    }else{
      header("Location: admin-products.php");
    }
  }else{
    header("Location: index.php");
    exit;
  }

?>