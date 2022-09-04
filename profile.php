

<?php 
  require "libs/functions.php";

  if(!$usersClass->isLogged()){
    header("login.php");
    exit;
  }

  $getUserResult = $usersClass->getLogged();
  $user = mysqli_fetch_assoc($getUserResult);

  $nameSurname = $user["nameSurname"];
  $phone = $user["phone"];
  $city = $user["city"];
  $district = $user["district"];
  $address = $user["address"];
  $error = "";

  if(isset($_POST["changeImage"])){
    // validation image
    if (empty($_FILES["image"]["name"])) {
      $error = "Resim seçmediniz.";
    } else {
      $result = $othersClass->saveImage($_FILES["image"]);
      if($result["isSuccess"] == 0) {
          $image_err = $result["message"];
      } else {
          $image = $result["image"];
      }
    }

    if(empty($error)){
      if($usersClass->changeImage($user["id"], $image)){
        header("Location: profile.php");
      }else{
        $error = "Resim güncelleme hatası";
      }
    }
  }

  if(isset($_POST["deleteImage"])){
    if($usersClass->deleteImage($user["id"])){
      header("Location: profile.php");
    }else{
      $error = "Kullanıcı resmi silme hatası";
    }
  }

  if(isset($_POST["updateUserInfos"])){
    // validation nameSurname
    if(empty($_POST["nameSurname"])){
      $error = "Adı ve Soyadı boş bırakılamaz.";
    }elseif(strlen($_POST["nameSurname"]) < 3 || strlen($_POST["nameSurname"]) > 30){
      $error = "Adı ve soyadı 3 ile 30 karakter içerebilir.";
    }else{
      $nameSurname = $othersClass->control_input($_POST["nameSurname"]);
    }

    // validation phone
    if(empty($_POST["phone"])){
      $error = "Telefon boş bırakılamaz.";
    }elseif(strlen($_POST["phone"]) != 11){
      $error = "Telefon toplamda 11 karakter içerebilir.";
    }else{
      $phone = $othersClass->control_input($_POST["phone"]);
    }

    // validation city
    if(empty($_POST["city"])){
      $error = "Şehir boş bırakılamaz.";
    }else{
      $city = $othersClass->control_input($_POST["city"]);
    }

    // validation district
    if(empty($_POST["district"])){
      $error = "İlçe boş bırakılamaz.";
    }else{
      $district = $othersClass->control_input($_POST["district"]);
    }

    // validation address
    if(empty($_POST["address"])){
      $error = "Adres boş bırakılamaz.";
    }else{
      $address = $othersClass->control_input($_POST["address"]);
    }

    if(empty($error)){
      if($usersClass->changeUserInfos($user["id"],$nameSurname,$phone,$city,$district,$address)){
        header("Location: index.php");
      }else{
        $error = "Kullanıcı bilgi güncelleme hatası";
      }
    }
  }

?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_navbar.php"; ?>

<section id="profile" class="container">

  <h3><?php echo $user["username"]; ?></h3>
  <hr>
  <div class="row">
    <?php if(!empty($error)): ?>
      <div class="alert alert-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>  

    <div class="col-md-2">
      <form method="POST" enctype="multipart/form-data">
        <img src="img/<?php echo $user["image"]; ?>" alt="" class="img-fluid">
        <input type="file" class="form-control my-3" name="image" value="Resim Seç">
        <button type="submit" name="changeImage" class="btn btn-primary my-2">Resmi Değiştir</button>
        <?php if($user["image"] != "profile.png"): ?>
          <button type="submit" name="deleteImage" class="btn btn-danger my-2">Resmi Sil</button>
        <?php endif; ?>  
      </form>
    </div>
    <div class="col-md-9">
      <form method="POST">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="mb-3">
              <label for="nameSurname" class="form-label">Adı ve Soyadı:</label>
              <input type="text" name="nameSurname" class="form-control"
                value="<?php echo $nameSurname; ?>">
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Telefon:</label>
              <input type="text" name="phone" class="form-control"
                value="<?php echo $phone; ?>">
            </div>
            <div class="mb-3">
              <label for="city" class="form-label">Şehir:</label>
              <input type="text" name="city" class="form-control"
                value="<?php echo $city; ?>">
            </div>
            <div class="mb-3">
              <label for="district" class="form-label">İlçe:</label>
              <input type="text" name="district" class="form-control"
                value="<?php echo $district; ?>">
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Adres:</label>
              <input type="text" name="address" class="form-control"
                value="<?php echo $address; ?>">
            </div>
            <button name="updateUserInfos" class="btn btn-dark">Kaydet</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</section>

<?php require "views/_footer.php"; ?>
<?php require "views/_head-finish.php"; ?>