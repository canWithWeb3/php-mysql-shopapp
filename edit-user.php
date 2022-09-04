

<?php 
  require "libs/functions.php";

  if(!$usersClass->isAdmin() || !isset($_GET["id"])){
    header("Location: index.php");
    exit;
  }

  $getUserResult = $usersClass->getUserById($_GET["id"]);
  $user = mysqli_fetch_assoc($getUserResult);


  


?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_admin-navbar.php"; ?>


<section id="edit-user" class="container">
  
  <div class="card">
    <div class="card-header">Kullanıcı Bilgileri</div>
    <div class="card-body">
      <div class="row">
        <!-- user image -->
        <div class="col-lg-2 col-md-3 col-sm-5 mx-auto">
          <img src="img/<?php echo $user["image"]; ?>" alt="" class="img-fluid">
        </div>
        <!-- user infos -->
        <div class="col-lg-10 col-md-9">
          <div class="mb-3">
            <h5>Kullanıcı Adı: <span class="fw-normal"><?php echo $user["username"]; ?></span></h5>
          </div>
          <div class="mb-3">
            <h5>Email: <span class="fw-normal"><?php echo $user["email"]; ?></span></h5>
          </div>
          <div class="mb-3">
            <h5>Telefon: <span class="fw-normal"><?php echo $user["phone"]; ?></span></h5>
          </div>
          <div class="mb-3">
            <h5>Şehir: <span class="fw-normal"><?php echo $user["city"]; ?></span></h5>
          </div>
          <div class="mb-3">
            <h5>İlçe: <span class="fw-normal"><?php echo $user["district"]; ?></span></h5>
          </div>
          <div class="mb-3">
            <h5>Adres: <span class="fw-normal"><?php echo $user["address"]; ?></span></h5>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>



<?php require "views/_head-finish.php"; ?>