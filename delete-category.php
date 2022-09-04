<?php 
  require "libs/functions.php";

  if($usersClass->isAdmin() && isset($_GET["id"])){
    if($categoriesClass->deleteCategory($_GET["id"])){
      header("Location: admin-categories.php?alertType=success&alertMessage=Kategori+silindi");
    }else{
      header("Location: admin-categories.php?alertType=error&alertMessage=Kategori+silinemedi");
    }
  }else{
    header("Location: index.php");
    exit;
  }

?>