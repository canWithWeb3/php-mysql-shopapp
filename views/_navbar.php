<?php 
  
  $getCategoriesResult = $categoriesClass->getCategories();
  
?>

<div id="navbar">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img src="img/dark-logo.png" alt="" class="logo-img"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <?php if($usersClass->isAdmin()): ?>
            <ul class="navbar-nav me-auto me-3 mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="admin-products.php">Admin</a>
              </li>
            </ul>
          <?php endif; ?>
          
          <?php if($usersClass->isLogged()): ?>
            <ul class="navbar-nav ms-auto me-3 mb-2 mb-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="profile.php">Profilim</a></li>
                  <li><a class="dropdown-item" href="logout.php">Çıkış yap</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i></a>
              </li>
            </ul>
          <?php else: ?>  
            <ul class="navbar-nav ms-auto me-3 mb-2 mb-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="login.php">Giriş Yap</a></li>
                  <li><a class="dropdown-item" href="register.php">Kayıt Ol</a></li>
                </ul>
              </li>
            </ul>
          <?php endif; ?>  
        <!-- <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-dark" type="submit">Search</button>
        </form> -->
      </div>
    </div>
  </nav>

  <div style="height: 3px;" class="bg-secondary"></div>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Anasayfa</a>
          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Ürünler
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php while($category = mysqli_fetch_assoc($getCategoriesResult)): ?>
              <li><a class="dropdown-item" href="products.php?categoryId=<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></a></li>
            <?php endwhile; ?>  
          </ul>
        </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">İletişim</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

</div>


