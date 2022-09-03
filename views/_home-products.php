

<div id="homeProducts" class="container my-5">
  <h3 class="mb-5">Son Eklenenler</h3>

  <div class="row g-5">
    
    <?php $getHomeProducts = $productsClass->getHomeProducts(); ?>
    <?php while($product = mysqli_fetch_assoc($getHomeProducts)): ?>
      <div class="col-lg-3 col-md-4 col-6 d-flex align-items-stretch">
        <a href="product-detail.php?id=<?php echo $product["id"]; ?>" class="text-decoration-none text-dark d-flex align-items-stretch">
          <div class="card position-relative border-0 d-flex align-items-stretch">
            <div class="h-75">
              <img src="img/<?php echo $product["image"]; ?>" alt="" class="mx-auto img-fluid">
            </div>
            <h4 class="fw-bold my-3"><?php echo $product["name"]; ?></h4>
            <p class="mb-2">Lorem ipsum dolor sit amet.</p>
            <div class="card-product-prices">
              <?php if($product["discountPrice"] != 0 ): ?>
                <span class="text-secondary text-decoration-line-through">$<?php echo $product["originalPrice"]; ?></span>
                <span>$<?php echo $product["discountPrice"]; ?></span>
              <?php else: ?>
                <span>$<?php echo $product["originalPrice"]; ?></span>
              <?php endif; ?>
            </div>
          </div>
        </a>
      </div>
    <?php endwhile; ?>

  </div>
</div>