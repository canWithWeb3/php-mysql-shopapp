

<?php 
  require "libs/functions.php";

  $title = "";

  if(isset($_GET["categoryId"])){
    $getProducts = $productCategoriesClass->getProductsByCategoryId($_GET["categoryId"]);
    $categoryResult = $categoriesClass->getCategoryById($_GET["categoryId"]);
    $category = mysqli_fetch_assoc($categoryResult);
    $title = $category["name"];
  }else{
    $getProducts = $productsClass->getProducts();
  }
  
?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_navbar.php"; ?>

<div id="products" class="container my-5">
  <?php if(!empty($title)): ?>
  <div class="alert alert-info">
    <span><?php echo $title; ?></span>
  </div>
  <?php endif; ?>

  <h3 class="mb-5">Ürünler</h3>

  <div class="row g-5">
    
    <?php if(mysqli_num_rows($getProducts) > 0): ?>
      <?php while($product = mysqli_fetch_assoc($getProducts)): ?>
        <div class="col-md-3">
          <a href="product-detail.php?id=<?php echo $product["id"]; ?>" class="text-decoration-none text-dark">
            <div class="card position-relative border-0">
            <div class="h-75">
              <img src="img/<?php echo $product["image"]; ?>" alt="" class="img-fluid">
            </div>
            <h4 class="fw-bold my-2"><?php echo $product["name"]; ?></h4>
              <p class="mb-2">Lorem ipsum dolor sit amet.</p>
              <div class="card-product-prices">
                <span>$<?php echo $product["originalPrice"]; ?></span>
                <?php if($product["discountPrice"] != 0): ?>
                  <span class="text-secondary text-decoration-line-through">$<?php echo $product["discountPrice"]; ?></span>
                <?php endif; ?>
              </div>
              <button class="btn btn-dark d-inline-block position-absolute bottom-0 end-0"><i class="fas fa-shopping-cart"></i></button>
            </div>
          </a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="alert alert-warning">
        Ürün bulunamadı.
      </div>
    <?php endif; ?>  
  </div>
</div>




<?php require "views/_head-finish.php"; ?>