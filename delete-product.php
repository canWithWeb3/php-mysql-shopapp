<?php 
  require "libs/functions.php";

  if($usersClass->isAdmin() && isset($_GET["id"])){
    if($productsClass->deleteProduct($_GET["id"])){
      header("Location: admin-products.php?alertType=success&alertMessage=Ürün+silindi");
    }else{
      header("Location: admin-products.php?alertType=success&alertMessage=Ürün+silinemedi");
    }
  }else{
    header("Location: index.php");
    exit;
  }

?>