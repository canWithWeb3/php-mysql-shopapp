<?php 
  require "libs/functions.php";

  if($usersClass->isAdmin() && isset($_GET["id"])){
    if($categoriesClass->deleteCategory($_GET["id"])){
      header("Location: admin-categories.php");
    }else{
      header("Location: admin-categories.php");
    }
  }else{
    header("Location: index.php");
    exit;
  }

?>