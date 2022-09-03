

<?php 
  require "libs/functions.php";

  if(!$usersClass->isAdmin()){
    header("Location: index.php");
    exit;
  }

  $getCategories = $categoriesClass->getCategories();

  $categories = [];
  $name = $image = $description = $originalPrice = $discountPrice = "";
  $name_err = $image_err = $description_err = $originalPrice_err = $discountPrice_err = $categories_err = $error = "";

  if(isset($_POST["addProduct"])){
    // validation name
    if(empty(trim($_POST["name"]))){
      $name_err = "Kategori adı boş bırakılamaz.";
    }elseif(strlen($_POST["name"]) < 3 || strlen($_POST["name"]) > 15){
      $name_err = "Kategori adı 3 ile 15 karakter içerebilir.";
    }else{
      $name = $othersClass->control_input($_POST["name"]);
    }

    // validation image
    if (empty($_FILES["image"]["name"])) {
      if(empty($_POST["oldImage"])){
        $image_err = "dosya seçiniz";
      }else{
        $image = $_POST["oldImage"];
      }
    } else {
        $result = $othersClass->saveImage($_FILES["image"]);

        if($result["isSuccess"] == 0) {
            $image_err = $result["message"];
        } else {
            $image = $result["image"];
        }
    }

    // validation description
    if(empty(trim($_POST["description"]))){
      $description_err = "Ürün açıklama boş geçilemez.";
    }elseif(strlen($_POST["description"]) > 350){
      $description_err = "Ürün açıklama en fazla 350 karakter içerebilir.";
    }else{
      $description = $othersClass->control_input($_POST["description"]);
    }

    // validation original price
    if(empty(trim($_POST["originalPrice"]))){
      $originalPrice_err = "Orjinal fiyat boş geçilemez.";
    }elseif(!is_numeric($_POST["originalPrice"])){
      $originalPrice_err = "Orjinal fiyat sayı içermelidir.";
    }else{
      $originalPrice = $othersClass->control_input($_POST["originalPrice"]);
    }

    // validation discount price
    if(!empty(trim($_POST["discountPrice"]))){
      if(!is_numeric($_POST["discountPrice"])){
        $discountPrice_err = "Orjinal fiyat sayı içermelidir.";
      }elseif(trim($_POST["originalPrice"]) < trim($_POST["discountPrice"])){
        $discountPrice_err = "İndirimli fiyat, orjinal fiyattan büyük olamaz.";
      }else{
        $discountPrice = $othersClass->control_input($_POST["discountPrice"]);
      }
    }

    
    if(empty($_POST["categories"])){
      $categories_err = "Kategori seçmediniz";
    }else{
      $categories = $_POST["categories"];
    }

    if(empty($name_err) && empty($image_err) && empty($description_err) && empty($originalPrice_err) && empty($discountPrice_err && empty($categories_err))){
      if($productsClass->addProduct($name, $image, $description, $originalPrice, $discountPrice)){
        $getLastProduct = $productsClass->getLastProduct();
        $lastProduct = mysqli_fetch_assoc($getLastProduct);

        if($productCategoriesClass->addCategoriesToProduct($lastProduct["id"], $categories)){
          header("Location: admin-products.php");
        }else{
          $productsClass->deleteProduct($lastProduct["id"]);
          $error = "Kategori ekleme hatası";
        }

      }else{
        $error = "Ürün Eklenemedi.";
      }
    }
  }


?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_admin-navbar.php"; ?>


<section id="add-product" class="container">
  
  <div class="col-md-10 mx-auto">
    <div class="card">
      <div class="card-header">Ürün Ekle</div>
      <div class="card-body">
          <?php if(!empty($error)): ?>
            <div class="alert alert-danger">
              <?php echo $error; ?>
            </div>
          <?php endif; ?>  
          <form method="POST" enctype="multipart/form-data">
            <div class="row">

              <div class="col-md-9">
                  <div class="mb-3">
                    <label for="name" class="form-label">Ürün Adı:</label>
                    <input type="hidden" value="<?php echo $image; ?>" name="oldImage">
                    <input name="name" id="name" type="text" 
                      class="form-control <?php if(!empty($name_err)){ echo "is-invalid"; } ?>"
                      value="<?php if(!empty($name)){ echo $name; } ?>">
                    <?php if(!empty($name_err)): ?>
                      <span class="text-danger">
                        <?php echo $name_err; ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <div class="mb-3">
                    <label for="image" class="form-label">Ürün Image:</label>
                    <input type="file" name="image" id="image" 
                      class="form-control <?php if(!empty($name_err)){ echo "is-invalid"; } ?>"
                      value="<?php if(!empty($image)){ echo $image; } ?>">
                    <?php if(!empty($image_err)): ?>
                      <span class="text-danger">
                        <?php echo $image_err; ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <div class="mb-3">
                    <label for="description" class="form-label">Ürün Açıklama:</label>
                    <textarea name="description" id="description" type="text" 
                      class="form-control <?php if(!empty($name_err)){ echo "is-invalid"; } ?>"><?php if(!empty($description)){ echo $description; } ?></textarea>
                    <?php if(!empty($description_err)): ?>
                      <span class="text-danger">
                        <?php echo $description_err; ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <div class="d-flex gap-3 mb-3">
                    <div>
                      <label for="originalPrice" class="form-label">Orjinal Fiyatı:</label>
                      <input type="text" name="originalPrice" id="originalPrice" 
                        class="form-control"
                        value="<?php if(!empty($originalPrice)){ echo $originalPrice; } ?>">
                      <?php if(!empty($originalPrice_err)): ?>
                      <span class="text-danger">
                        <?php echo $originalPrice_err; ?>
                      </span>
                    <?php endif; ?>
                    </div>
                    <div>
                      <label for="discountPrice" class="form-label">İndirimli Fiyatı:</label>
                      <input type="text" name="discountPrice" id="discountPrice" 
                        class="form-control"
                        value="<?php if(!empty($discountPrice)){ echo $discountPrice; } ?>">
                      <?php if(!empty($discountPrice_err)): ?>
                        <span class="text-danger">
                          <?php echo $discountPrice_err; ?>
                        </span>
                      <?php endif; ?>
                    </div>
                  </div>

              </div>

              <div class="col-md-3">
                <div class="card">
                  <div class="card-header">Kategoriler</div>
                  <div class="card-body">
                      <?php foreach ($getCategories as $c): ?>
                        <div class="form-check mb-2">
                            <label for="category_<?php echo $c["id"]?>"><?php echo $c["name"]?></label>
                            <input type="checkbox" name="categories[]"
                            id="category_<?php echo $c["id"]?>" 
                            class="form-check-input" 
                            value="<?php echo $c["id"]?>" 
                            >
                        </div>
                    <?php endforeach; ?>  
                    <?php if(!empty($categories_err)): ?>
                        <span class="text-danger">
                          <?php echo $categories_err; ?>
                        </span>
                      <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" name="addProduct" class="btn btn-dark">Ekle</button>
          </form>
      </div>
    </div>
  </div>

</section>



<?php require "views/_head-finish.php"; ?>