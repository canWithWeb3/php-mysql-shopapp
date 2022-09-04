

<?php 
  require "libs/functions.php";

  if(!$usersClass->isLogged()){
    header("Location: login.php");
    exit;
  }
  
  $userResult = $usersClass->getLogged();
  $user = mysqli_fetch_assoc($userResult);

  $userCart = $cartsClass->getUserCart($user["id"]);

?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_navbar.php"; ?>

<section id="cart" class="container">

  <?php if(isset($_GET["alertMessage"])): ?>
    <div class="type" data-type="<?php echo $_GET["alertType"] ?>" data-message="<?php echo $_GET["alertMessage"]; ?>"></div>
  <?php endif; ?> 

  <div class="row">

    <!-- cart table -->
    <div class="col-md-9">
      <table class="table table-striped table-sm table-bordered mb-0">
        <thead>
          <tr>
            <th style="width: 80px;">Resim</th>
            <th>Ürün</th>
            <th style="width: 66px;">Fiyat</th>
            <th style="width: 48px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php if(mysqli_num_rows($userCart) > 0): ?>
            <?php while($product = mysqli_fetch_assoc($userCart)): ?>
              <tr>
                <td class="p-0"><img src="img/<?php echo $product["image"]; ?>" alt="" class="img-fluid"></td>
                <td><?php echo $product["name"]; ?></td>
                <td class="cart-product-prices">
                  <?php if($product["discountPrice"] != 0 ): ?>
                    <span class="text-secondary text-decoration-line-through">$ <?php echo $product["originalPrice"]; ?></span>
                    <br>
                    <span>$ <?php echo $product["discountPrice"]; ?></span>
                  <?php else: ?>  
                    <span>$ <?php echo $product["originalPrice"]; ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="deleteCartProduct.php?productId=<?php echo $product["id"]; ?>" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php endif; ?>  
        </tbody>
      </table>
    </div>

    <!-- cart details -->
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

          <a href="sales.php" class="btn btn-outline-success d-block <?php if($count == 0){ echo "disabled"; } ?>">Satın Al</a>
        </div>
      </div>
    </div>

  </div>

</section>

<?php include "views/_cdns.php"; ?>

<script type="text/javascript">
  const type = $(".type").data("type");
  const message = $(".type").data("message");
  if(type){
    if(type == "success"){
      swal({
        title: `${message}`,
        icon: "success",
      })
    }
    if(type == "error"){
      swal({
        title: `${message}`,
        icon: "error",
      })
    }
  }else{
    console.log("no")
  }
</script>

<?php require "views/_footer.php"; ?>
<?php require "views/_head-finish.php"; ?>