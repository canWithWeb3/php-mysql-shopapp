

<?php 
  require "libs/functions.php";

  // control
  if(isset($_GET["id"]) && $usersClass->isAdmin()){
    $getCategory = $categoriesClass->getCategoryById($_GET["id"]);
    $category = mysqli_fetch_assoc($getCategory);

    if($category["name"] == null){
      header("Location: admin-categories.php");
    }

  }else{
    header("Location: admin-categories.php");
  }

  $name = "";
  $name_err = $error = "";

  // control post
  if(isset($_POST["editCategory"])){
    // validation name
    if(empty(trim($_POST["name"]))){
      $name_err = "Kategori adı boş bırakılamaz.";
    }elseif(strlen($_POST["name"]) < 3 || strlen($_POST["name"]) > 15){
      $name_err = "Kategori adı 3 ile 15 karakter içerebilir.";
    }else{
      $name = $othersClass->control_input($_POST["name"]);
    }

    // send infos
    if(empty($name_err)){
      if($categoriesClass->editCategory($category["id"], $name)){
        header("Location: admin-categories.php?alertType=success&alertMessage=Kategori güncellendi");
      }else{
        $error = "Kategori Düzenlenmedi.";
      }
    }
  }


?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_admin-navbar.php"; ?>


<section id="add-category" class="container">
  
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card">
      <div class="card-header">Kategori Düzenle</div>
      <div class="card-body">
        <div class="row">
          
          <div class="col-md-7">
            <!-- edit category form -->
            <form method="POST">
              <!-- name -->
              <div class="mb-3">
                <label for="name" class="form-label">Kategori Düzenle:</label>
                <input name="name" id="name" type="text" 
                  class="form-control <?php if(!empty($name_err)){ echo "is-invalid"; } ?>"
                  value="<?php echo $category["name"]; ?>">
                <?php if(!empty($name_err)): ?>
                  <span class="text-danger">
                    <?php echo $name_err; ?>
                  </span>
                <?php endif; ?>
              </div>

              <!-- submit button -->
              <button type="submit" name="editCategory" class="btn btn-dark">Düzenle</button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>

</section>



<?php require "views/_head-finish.php"; ?>