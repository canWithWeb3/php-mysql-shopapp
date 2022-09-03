<?php 
  
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);  
  
?>

<div id="admin-navbar">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img src="img/dark-logo.png" alt="" class="logo-img"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto me-3 mb-2 mb-lg-0">
          <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fas fa-bars"></i></button>
        </ul>
      </div>
    </div>
  </nav>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasRightLabel">Admin Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    
    <div class="list-group">
      <a href="admin-products.php" class="list-group-item list-group-item-action <?php if($url=="admin-products.php"){ echo "active"; } ?>">Ürünler</a>
      <a href="admin-categories.php" class="list-group-item list-group-item-action <?php if($url=="admin-categories.php"){ echo "active"; } ?>">Kategoriler</a>
      <a href="admin-users.php" class="list-group-item list-group-item-action <?php if($url=="admin-users.php"){ echo "active"; } ?>">Kullanıcılar</a>
      <a href="logout.php" class="list-group-item list-group-item-action">Çıkış yap</a>
    </div>

  </div>
</div>
