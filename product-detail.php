

<?php 
  require "libs/functions.php";

  if(!isset($_GET["id"])){
    header("Location: index.php");
    exit;
  }

  $getProduct = $productsClass->getProductById($_GET["id"]);
  $product = mysqli_fetch_assoc($getProduct);
  if($product["name"] == null){
    header("Location: index.php");
  }

  $image = "";
  $error = "";

  if(isset($_POST["addComment"])){
    if(!$usersClass->isLogged()){
      // validation email
      if(empty(trim($_POST["username"]))){
        $username_err = "Kullanıcı adı boş geçilemez.";
      }elseif(strlen($_POST["username"]) < 3 || strlen($_POST["username"]) > 15){
        $username_err = "Kullanıcı adı 3 ile 15 karakter içerebilir.";
      }else{
        $username = $othersClass->control_input($_POST["username"]);
      }

      // validation email
      if(empty(trim($_POST["email"]))){
        $email_err = "Email boş geçilemez.";
      }elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Hatalı email girdiniz.";
      }else{
        $email = $othersClass->control_input($_POST["email"]);
      }

      $image = "profile.png";
    }else{
      $userResult = $usersClass->getLogged();
      $user = mysqli_fetch_assoc($userResult);

      $username = $user["username"];
      $email = $user["email"];
      $image = $user["image"];
    }

    // validation comment
    if(empty(trim($_POST["comment"]))){
      $error = "Yorum girmediniz.";
    }elseif(strlen(trim($_POST["comment"])) > 350){
      $error = "Yorum en fazla 350 karakter içerebilir.";
    }else{
      $comment = $othersClass->control_input($_POST["comment"]);
    }

    if(empty($error)){
      if($commentsClass->addComment($username, $email, $image, $comment)){
        $getLastCommentResult = $commentsClass->getLastComment();
        $lastComment = mysqli_fetch_assoc($getLastCommentResult);
        if($productCommentsClass->addCommentToProduct($product["id"], $lastComment["id"])){
          header("Location: product-detail.php?id=".$_GET["id"]."&alertMessage=commentSuccess");
        }else{
          header("Location: product-detail.php?id=".$_GET["id"]."&alertMessage=commentError");
        }
      }else{
        header("Location: product-detail.php?id=".$_GET["id"]."&alertMessage=commentError");
      }
    }
  }
  
?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_navbar.php"; ?>

<!-- for alert -->
<?php if(isset($_GET["alertMessage"])): ?>
  <div class="type" data-type="<?php echo $_GET["alertMessage"]; ?>"></div>
<?php endif; ?>  

<section id="product-detail" class="container">

  <div class="row">
    <!-- product image -->
    <div class="col-md-3">
      <img src="img/<?php echo $product["image"]; ?>" alt="" class="img-fluid">
    </div>
    <!-- product details -->
    <div class="col-md-7">
      <h2><?php echo $product["name"]; ?></h2>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Optio modi, vitae in, nobis blanditiis sunt, a ad alias laborum omnis temporibus autem pariatur? Unde at odio, atque similique itaque saepe autem quisquam est ab possimus deleniti! Necessitatibus, ipsa.</p>
      <div class="card-product-prices fs-3 mb-5">
        <?php if($product["discountPrice"] != 0 ): ?>
          <span class="text-secondary text-decoration-line-through">$<?php echo $product["originalPrice"]; ?></span>
          <span>$<?php echo $product["discountPrice"]; ?></span>
        <?php else: ?>
          <span>$<?php echo $product["originalPrice"]; ?></span>
        <?php endif; ?>
      </div>
      
      <!-- add to cart link -->
      <a href="addProductToCart.php?productId=<?php echo $product["id"]; ?>" class="btn btn-outline-dark">Sepete Ekle</a>
    </div>

  </div>

  <hr>

  <!-- add comment form -->
  <div class="card">
    <div class="card-body">
      <div class="row">
        <form method="POST">
          <?php if(!$usersClass->isLogged()): ?>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="username" class="form-label">Kullanıcı Adı:</label>
              <input type="text" name="username" class="form-control">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="text" name="email" class="form-control">
            </div>
          </div>
          <?php endif; ?>
          <div class="col">
            <div class="mb-3">
              <label for="comment" class="form-label">Yorumunuz:</label>
              <textarea name="comment" id="" rows="5" class="form-control"></textarea>
            </div>
            <button type="submit" name="addComment" class="btn btn-dark">Yorum yap</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- show comments -->
  <?php $getComments = $productCommentsClass->getCommentsByProductId($product["id"]); ?>
  <?php if(mysqli_num_rows($getComments) > 0): ?>
    <?php while($comment = mysqli_fetch_assoc($getComments)): ?>
      <div class="card my-3">
        <div class="card-body">
          <div class="row">
            <div class="col-md-1">
              <img src="img/<?php echo $comment["image"]; ?>" alt="" class="img-fluid me-5">
            </div>
            <div class="col-md-11">
              <h5><?php echo $comment["username"]; ?></h5>
              <hr>
              <p><?php echo $comment["comment"]; ?></p>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>

</section>


<?php include "views/_cdns.php"; ?>

<script type="text/javascript">
  const type = $(".type").data("type");
  if(type){
    if(type == "productSuccess"){
      swal({
        title: `Ürün eklendi`,
        icon: "success",
      })
    }
    if(type == "productError"){
      swal({
        title: `Ürün zaten eklenmiş`,
        icon: "error",
      })
    }
    if(type == "commentSuccess"){
      swal({
        title: `Yorum eklendi.`,
        icon: "success",
      })
    }
    if(type == "commentError"){
      swal({
        title: `Yorum eklenemedi.`,
        icon: "error",
      })
    }
  }else{
    console.log("no")
  }
</script>

<?php require "views/_head-finish.php"; ?>