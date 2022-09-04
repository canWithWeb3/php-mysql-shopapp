<?php 
  require "libs/functions.php";

  if($usersClass->isLogged()){
    $userResult = $usersClass->getLogged();
    $user = mysqli_fetch_assoc($userResult);

    
    if(!empty($user["nameSurname"]) && !empty($user["phone"]) && !empty($user["city"]) && !empty($user["district"]) && !empty($user["address"])){
      $cartsClass->clearCartByUserId($user["id"]);
      header("Location: cart.php?alertType=success&alertMessage=Siparişiniz+Alındı.");
    }else{
      header("Location: cart.php?alertType=error&alertMessage=Adres+bilgilerinizi+girmediniz.");
    }

  }else{
    header("Location: index.php");
    exit;
  }

?>