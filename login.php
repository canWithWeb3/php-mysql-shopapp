

<?php 
  require "libs/functions.php";

  $rememberMe = false;
  $email = $password = "";
  $email_err = $password_err = $error = "";

  if(isset($_POST["login"])){

    if(empty(trim($_POST["email"]))){
      $email_err = "Email boş geçilemez.";
    }elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $email_err = "Hatalı email girdiniz.";
    }else{
      $email = $othersClass->control_input($_POST["email"]);
    }

    if(empty(trim($_POST["password"]))){
      $password_err = "Parola boş geçilemez.";
    }else{
      $password = $othersClass->control_input($_POST["password"]);
    }

    $rememberMe = isset($_POST["rememberMe"]) ? true : false;

    if(empty($email_err) && empty($password_err)){
      $getUsers = $usersClass->getUsers();
      $checked = false;
      foreach($getUsers as $user){
        if($user["email"] == $email && $user["password"] == $password){
          if($rememberMe){
            setcookie("username", $user["username"], time() + 36400 * 30);
            setcookie("email", $user["email"], time() + 36400 * 30);
            setcookie("type", $user["type"], time() + 36400 * 30);
  
            $_SESSION["message"] = "Giriş yapıldı.";
            $_SESSION["type"] = "success";

            header("Location: index.php");
          }else{
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            $_SESSION["type"] = $user["type"];
  
            header("Location: index.php");
          }

          $checked = true;
        }
      }

      if(!$checked){
        $error = "Email veya parola hatalı";
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
        <h3 class="mb-4">Giriş Yap</h3>

        <?php if(!empty($error)): ?>
          <div class="alert alert-danger">
            <?php echo $error; ?>
          </div>
        <?php endif; ?>

        <div class="alert alert-warning">
          <h5 class="text-decoration-underline">Admin girişi için:</h5>
          <p class="mb-0 fw-bold">Email: <span class="fw-normal">admin@gmail.com</span></p>
          <p class="mb-0 fw-bold">Parola: <span class="fw-normal">admin1</span></p>
        </div>

        <form method="POST" enctype="multipart/form-data">
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

          <div class="form-check mb-3">
            <label for="rememberMe" class="form-check-label">Beni hatırla</label>
            <input type="checkbox" name="rememberMe" id="rememberMe" class="form-check-input">
          </div>

          <button type="submit" name="login" class="btn btn-dark">Giriş Yap</button>
          <!-- <button id="udemy" type="button" class="btn btn-primary">Swal</button> -->
        </form>
      </div>
    </div>
  </div>

</section>



<?php require "views/_head-finish.php"; ?>

<script type="text/javascript">

  $("#udemy").click(function(){
    swal("Merhaba World","Can Oğuzorhan","success");
  })
</script>