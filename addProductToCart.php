

<?php 
  require "libs/functions.php";

  if(isset($_GET["productId"])){
    if($usersClass->isLogged()){
      $userResult = $usersClass->getLogged();
      $user = mysqli_fetch_assoc($userResult);

      $getUserCartResult = $cartsClass->getUserCart($user["id"]);
      $exist = false;
      if(mysqli_num_rows($getUserCartResult) > 0){
        foreach($getUserCartResult as $userCart){
          if($userCart["id"] == $_GET["productId"]){
            $exist = true;
          }
        }
      }

      if(!$exist){
        if($cartsClass->addProductToCart($user["id"], $_GET["productId"])){
          header("Location: product-detail.php?id=".$_GET["productId"]."&alertMessage=productSuccess");
        }
      }else{
        header("Location: product-detail.php?id=".$_GET["productId"]."&alertMessage=productError");
      }
    }else{
      header("Location: login.php");
    }
  }else{
    header("Location: index.php");
  }
  
?>