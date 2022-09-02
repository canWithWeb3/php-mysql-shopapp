

<?php 
  require "libs/functions.php";

  if(!$usersClass->isAdmin()){
    header("Location: index.php");
    exit;
  }

  $name = "";
  $name_err = $error = "";

  if(isset($_POST["addCategory"])){
    if(empty(trim($_POST["name"]))){
      $name_err = "Kategori adı boş bırakılamaz.";
    }elseif(strlen($_POST["name"]) < 3 || strlen($_POST["name"]) > 15){
      $name_err = "Kategori adı 3 ile 15 karakter içerebilir.";
    }else{
      $name = $othersClass->control_input($_POST["name"]);
    }

    if(empty($name_err)){
      if($categoriesClass->addCategory($name)){
        header("Location: admin-categories.php");
      }else{
        $error = "Kategori Eklenemedi.";
      }
    }
  }


?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_admin-navbar.php"; ?>


<section id="add-category" class="container">
  
  <div class="col-md-8 mx-auto">
    <div class="card">
      <div class="card-header">Kategori Ekle</div>
      <div class="card-body">
        <div class="row">
          
          <div class="col-md-7">
            <form method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">Kategori Adı:</label>
                <input name="name" id="name" type="text" class="form-control <?php if(!empty($name_err)){ echo "is-invalid"; } ?>">
                <?php if(!empty($name_err)): ?>
                  <span class="text-danger">
                    <?php echo $name_err; ?>
                  </span>
                <?php endif; ?>
              </div>

              <button type="submit" name="addCategory" class="btn btn-dark">Kategori Ekle</button>
            </form>
          </div>
          <div class="col-md-5"></div>

        </div>
      </div>
    </div>
  </div>

</section>



<?php require "views/_head-finish.php"; ?>