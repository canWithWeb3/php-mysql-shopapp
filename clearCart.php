<?php 
  require "libs/functions.php";

  if($usersClass->isLogged()){
    $userResult = $usersClass->getLogged();
    $user = mysqli_fetch_assoc($userResult);

    $cartsClass->clearCartByUserId($user["id"]);
    
    header("Location: index.php");
  }else{
    header("Location: index.php");
    exit;
  }

?>