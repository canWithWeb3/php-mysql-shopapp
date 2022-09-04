

<?php 
  require "libs/functions.php";

  $userResult = $usersClass->getLogged();
  $user = mysqli_fetch_assoc($userResult);

  $userCart = $cartsClass->getUserCart($user["id"]);
  
?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_navbar.php"; ?>

<section id="sales" class="container">

  <div class="row">
    <div class="col-md-9">
      <div class="card">
        <div class="card-header">Adres Bilgisi</div>
        <div class="card-body">
          <div class="mb-3">
            <h5>Adı ve Soyadı: <span class="fw-normal"><?php echo $user["nameSurname"]; ?></span></h5>
          </div>
          <div>
            <h5>Telefon: <span class="fw-normal"><?php echo $user["phone"]; ?></span></h5>
          </div>
          <div>
            <h5>Şehir: <span class="fw-normal"><?php echo $user["city"]; ?></span></h5>
          </div>
          <div>
            <h5>İlçe: <span class="fw-normal"><?php echo $user["district"]; ?></span></h5>
          </div>
          <div>
            <h5>Adres: <span class="fw-normal"><?php echo $user["address"]; ?></span></h5>
          </div>
          <a href="profile.php" class="btn btn-warning">Düzenle</a>
        </div>
      </div>
    </div>
    
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <h5 class="mb-3">Sepet Detayı</h5>
          <p class="mb-0">Toplam Miktar: 
            <span>
              <?php $count = 0; ?>
              <?php $total = 0; ?>
              <?php foreach($userCart as $uc){
                $count += 1;
                if($uc["discountPrice"] != 0){
                  $total += $uc["discountPrice"];
                }else{
                  $total += $uc["originalPrice"];
                }
              } ?>
              <?php echo $count; ?>
            </span>
          </p>
          <p>Toplam Fiyat: <span>$ <?php echo $total; ?></span></p>

          <a href="clearCart.php" class="btn btn-outline-success d-block">Satın Al</a>
        </div>
      </div>
    </div>

  </div>

</section>

<?php require "views/_footer.php"; ?>
<?php require "views/_head-finish.php"; ?>