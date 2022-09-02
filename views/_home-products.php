

<div id="homeProducts" class="container my-5">
  <h3 class="mb-5">Son Eklenenler</h3>

  <div class="row g-5">
    
    <?php $getHomeProducts = $productsClass->getHomeProducts(); ?>
    <?php while($product = mysqli_fetch_assoc($getHomeProducts)): ?>
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
              <?php if($product["discountPrice"] != 0 ): ?>
                <span class="text-secondary text-decoration-line-through">$<?php echo $product["discountPrice"]; ?></span>
              <?php endif; ?>
            </div>
            <button class="btn btn-dark d-inline-block position-absolute bottom-0 end-0"><i class="fas fa-shopping-cart"></i></button>
          </div>
        </a>
      </div>
    <?php endwhile; ?>

  </div>
</div>