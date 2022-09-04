<?php 
  require "libs/functions.php";

  if(isset($_GET["productId"]) && $usersClass->isLogged()){
    $userResult = $usersClass->getLogged();
    $user = mysqli_fetch_assoc($userResult);
    
    if($cartsClass->deleteCartProduct($user["id"],$_GET["productId"])){
      header("Location: cart.php");
    }
  }else{
    header("Location: index.php");
    exit;
  }
?>