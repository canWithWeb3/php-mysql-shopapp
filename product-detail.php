

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
  
?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_navbar.php"; ?>


<section id="product-detail" class="container">

  <div class="row">

    <div class="col-md-3">
      <img src="img/<?php echo $product["image"]; ?>" alt="" class="img-fluid">
    </div>

    <div class="col-md-7">
      <h2><?php echo $product["name"]; ?></h2>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Optio modi, vitae in, nobis blanditiis sunt, a ad alias laborum omnis temporibus autem pariatur? Unde at odio, atque similique itaque saepe autem quisquam est ab possimus deleniti! Necessitatibus, ipsa.</p>
      <div class="card-product-prices fs-3 mb-5">
        <span>$<?php echo $product["originalPrice"]; ?></span>
        <?php if($product["discountPrice"] != 0 ): ?>
          <span class="text-secondary text-decoration-line-through">$<?php echo $product["discountPrice"]; ?></span>
        <?php endif; ?>
      </div>
      <a href="addProductToCart.php?productId=<?php echo $product["id"]; ?>" class="btn btn-outline-dark">Sepete Ekle</a>
    </div>

  </div>

</section>


<?php require "views/_head-finish.php"; ?>