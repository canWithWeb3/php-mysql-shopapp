

<?php 
  require "libs/functions.php";

  $username = $email = $password = "";
  $username_err = $email_err = $password_err = $error = "";

  // control post
  if(isset($_POST["register"])){
    // validation username
    if(empty(trim($_POST["username"]))){
      $username_err = "Kullanıcı adı boş geçilemez.";
    }elseif(strlen($_POST["username"]) < 3 || strlen($_POST["username"]) > 15){
      $username_err = "Kullanıcı adı 3 ile 15 karakter içerebilir.";
    }else{
      $username = $othersClass->control_input($_POST["username"]);
    }
    // validation email
    if(empty(trim($_POST["email"]))){
      $email_err = "Email boş geçilemez.";
    }elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $email_err = "Hatalı email girdiniz.";
    }else{
      $email = $othersClass->control_input($_POST["email"]);
    }
    // validation password
    if(empty(trim($_POST["password"]))){
      $password_err = "Parola boş geçilemez.";
    }elseif(strlen($_POST["password"]) < 5){
      $password_err = "Parola 5 karakterden fazla içerebilir.";
    }elseif($_POST["password"] != $_POST["repassword"]){
      $password_err = "Parolalar uyuşmuyor";
    }else{
      $password = $othersClass->control_input($_POST["password"]);
    }

    // send infos
    if(empty($username_err) && empty($email_err) && empty($password_err)){
      $getUsers = $usersClass->getUsers();
      while($users = mysqli_fetch_assoc($getUsers)){
        if($users["email"] == $email){
          $error = "Bu email kullanılmaktadır.";
        }
      }

      if(empty($error)){
        if($usersClass->addUser($username, $email, $password)){
          $_SESSION["username"] = $username;
          $_SESSION["email"] = $email;
          $_SESSION["type"] = "user";
  
          header("Location: index.php");
        }else{
          $error = "Bilinmeyen Hata.";
        }
      }
    }

  }
?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_navbar.php"; ?>

<section id="register" class="container">
  
  <div class="col-md-6 mx-auto">
    <div class="card">
      <div class="card-body">
        <h3 class="mb-4">Kayıt Ol</h3>
        <!-- show error -->
        <?php if(!empty($error)): ?>
          <div class="alert alert-danger">
            <?php echo $error; ?>
          </div>
        <?php endif; ?>

        <!-- register form -->
        <form method="POST">
          <!-- username -->
          <div class="form-floating mb-3">
            <input name="username" type="text" class="form-control <?php if(!empty($username_err)){ echo "is-invalid"; } ?>" id="username"
              value="<?php if(!empty($username)){ echo $username; } ?>">
            <label for="username">Kullanıcı Adı</label>
            <?php if(!empty($username_err)): ?>
              <span class="text-danger">
                <?php echo $username_err; ?>
              </span>
            <?php endif; ?>
          </div>
          <!-- email -->
          <div class="form-floating mb-3">
            <input name="email" type="text" class="form-control <?php if(!empty($email_err)){ echo "is-invalid"; } ?>" id="email"
              value="<?php if(!empty($email)){ echo $email; } ?>">
            <label for="email">Email</label>
            <?php if(!empty($email_err)): ?>
              <span class="text-danger">
                <?php echo $email_err; ?>
              </span>
            <?php endif; ?>
          </div>
          <!-- password -->
          <div class="form-floating mb-3">
            <input name="password" type="password" class="form-control <?php if(!empty($password_err)){ echo "is-invalid"; } ?>" id="password"
              value="<?php if(!empty($password)){ echo $password; } ?>">
            <label for="password">Parola</label>
            <?php if(!empty($password_err)): ?>
              <span class="text-danger">
                <?php echo $password_err; ?>
              </span>
            <?php endif; ?>
          </div>
          <!-- repasword -->
          <div class="form-floating mb-3">
            <input name="repassword" type="password" class="form-control <?php if(!empty($repassword_err)){ echo "is-invalid"; } ?>" id="repassword">
            <label for="repassword">Parola (Tekrar)</label>
            <?php if(!empty($repassword_err)): ?>
              <span class="text-danger">
                <?php echo $repassword_err; ?>
              </span>
            <?php endif; ?>
          </div>

          <!-- submit button -->
          <button name="register" class="btn btn-dark">Kayıt Ol</button>
        </form>
      </div>
    </div>
  </div>

</section>


<?php require "views/_head-finish.php"; ?>