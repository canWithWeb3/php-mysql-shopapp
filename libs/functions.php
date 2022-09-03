<?php 

session_start();

class Users{

  function isLogged(){
    $checked = false;
    if(isset($_SESSION["email"])){
      $checked = true;
    }elseif(isset($_COOKIE["email"])){
      $checked = true;
    }
    return $checked;
  }

  function getLogged(){
    require "ayar.php";

    if(isset($_SESSION["email"])){
      $email = $_SESSION["email"];
      $query = "SELECT * FROM users WHERE email='$email'";
    }elseif(isset($_COOKIE["email"])){
      $email = $_COOKIE["email"];
      $query = "SELECT * FROM users WHERE email='$email'";
    }else{
      return false;
    }

    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function isAdmin(){
    $checked = false;
    if(isset($_SESSION["type"]) && $_SESSION["type"] == "admin"){
      $checked = true;
    }elseif(isset($_COOKIE["type"]) && $_COOKIE["type"] == "admin"){
      $checked = true;
    }
    return $checked;
  }

  function getUsers(){
    require "ayar.php";

    $query = "SELECT * FROM users";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function addUser(string $username, string $email, string $password){
    require "ayar.php";

    $query = "INSERT INTO users(username, email, password) VALUES ('$username', '$email', '$password')";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function getUserById($id){
    require "ayar.php";

    $query = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function getUserByEmail(string $email){
    require "ayar.php";

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function changeImage($id, $image){
    require "ayar.php";

    $query = "UPDATE users SET image='$image' WHERE id='$id'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function deleteImage($id){
    require "ayar.php";

    $query = "UPDATE users SET image='profile.png' WHERE id='$id'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function changeUserInfos($id, $nameSurname, $phone, $city, $district, $address){
    require "ayar.php";

    $query = "UPDATE users SET nameSurname='$nameSurname', phone='$phone', city='$city', district='$district', address='$address' WHERE id='$id'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

}

class Categories{

  function getCategories(){
    require "ayar.php";

    $query = "SELECT * FROM categories ORDER BY name ASC";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function addCategory(string $name){
    require "ayar.php";

    $query = "INSERT INTO categories(name) VALUES ('$name')";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function editCategory(int $id, string $name){
    require "ayar.php";

    $query = "UPDATE categories SET name='$name' WHERE id=$id";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function deleteCategory(int $id){
    require "ayar.php";

    $query = "DELETE FROM categories WHERE id=$id";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function getCategoryById($id){
    require "ayar.php";

    $query = "SELECT * FROM categories WHERE id='$id'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }


}

class Products{

  function getProducts(){
    require "ayar.php";

    $query = "SELECT * FROM products ORDER BY id DESC";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function getHomeProducts(){
    require "ayar.php";

    $query = "SELECT * FROM products ORDER BY id DESC LIMIT 0,8";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function getProductById(string $id){
    require "ayar.php";

    $query = "SELECT * FROM products WHERE id='$id'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function addProduct($name, $image, $description, $originalPrice, $discountPrice){
    require "ayar.php";

    $query = "INSERT INTO products(name,image,description,originalPrice,discountPrice) VALUES ('$name','$image','$description','$originalPrice','$discountPrice')";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function editProduct($id, $name, $image, $description, $originalPrice, $discountPrice){
    require "ayar.php";

    $query = "UPDATE products SET name='$name', image='$image', description='$description', originalPrice='$originalPrice', discountPrice='$discountPrice' WHERE id=$id";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function deleteProduct($id){
    require "ayar.php";

    $query = "DELETE FROM products WHERE id=$id";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function getLastProduct(){
    require "ayar.php";

    $query = "SELECT * FROM products ORDER BY id DESC LIMIT 0,1";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

}

class ProductCategories{

  function getProductsByCategoryId($categoryId){
    require "ayar.php";

    $query = "SELECT * FROM product_category pc inner join products p on pc.product_id=p.id WHERE pc.category_id='$categoryId'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function getProductCategoriesByProductId($productId){
    require "ayar.php";

    $query = "SELECT * FROM product_category pc inner join categories c on pc.category_id=c.id WHERE pc.product_id=$productId";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function addCategoriesToProduct($product_id, $categories){
    require "ayar.php";

    $query = "";
    foreach($categories as $category){
      $query .= "INSERT INTO product_category(product_id, category_id) VALUES ($product_id, $category);";
    }
    $result = mysqli_multi_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function clearProductCategoriesByProductId($productId){
    require "ayar.php";

    $query = "DELETE FROM product_category WHERE product_id=$productId";;
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

}

class Carts{

  function getUserCart($userId){
    require "ayar.php";

    $query = "SELECT * FROM user_product up inner join products p on up.product_id=p.id WHERE up.user_id='$userId'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function addProductToCart($userId, $productId){
    require "ayar.php";

    $query = "INSERT INTO user_product(user_id, product_id) VALUES ('$userId', '$productId')";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function deleteCartProduct($userId, $productId){
    require "ayar.php";

    $query = "DELETE FROM user_product WHERE user_id='$userId' AND product_id='$productId'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function clearCartByUserId($userId){
    require "ayar.php";

    $query = "DELETE FROM user_product WHERE user_id='$userId'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

}

class Comments{

  function addComment($username, $email, $image, $comment){
    require "ayar.php";

    $query = "INSERT INTO comments(username,email,image,comment) VALUES ('$username','$email','$image','$comment')";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function getLastComment(){
    require "ayar.php";

    $query = "SELECT * FROM comments ORDER BY id DESC LIMIT 0,1";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

}

class ProductComments{

  function addCommentToProduct($productId, $commentId){
    require "ayar.php";

    $query = "INSERT INTO product_comment(product_id,comment_id) VALUES ('$productId','$commentId')";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

  function getCommentsByProductId($productId){
    require "ayar.php";

    $query = "SELECT * FROM product_comment pc inner join comments c on pc.comment_id=c.id WHERE pc.product_id='$productId' ORDER BY id DESC";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);
    return $result;
  }

}

class Others{
  function control_input($data){
    // $data = strip_tags($data);
    $data = htmlspecialchars($data);
    // $title = htmlentities($data);
    $data = trim(stripslashes($data)); # sql injection

    return $data;
  }

  function saveImage($file) {
    $message = ""; 
    $uploadOk = 1;
    $fileTempPath = $file["tmp_name"];
    $fileName = $file["name"];
    $fileSize = $file["size"];
    $maxfileSize = ((1024 * 1024) * 1);
    $dosyaUzantilari = array("jpg","jpeg","png");
    $uploadFolder = "./img/";

    if($fileSize > $maxfileSize) {
        $message = "Dosya boyutu fazla.<br>";
        $uploadOk = 0;
    }

    $dosyaAdi_Arr = explode(".", $fileName);
    $dosyaAdi_uzantisiz = $dosyaAdi_Arr[0];
    $dosyaUzantisi = $dosyaAdi_Arr[1];

    if(!in_array($dosyaUzantisi, $dosyaUzantilari)) {
        $message .= "dosya uzantısı kabul edilmiyor.<br>";
        $message .= "kabul edilen dosya uzantıları : ".implode(", ", $dosyaUzantilari)."<br>";
        $uploadOk = 0;
    }

    $yeniDosyaAdi = md5(time().$dosyaAdi_uzantisiz).'.'.$dosyaUzantisi;
    $dest_path = $uploadFolder.$yeniDosyaAdi;

    if($uploadOk == 0) {
        $message .= "Dosya yüklenemedi.<br>";
    } else {
        if(move_uploaded_file($fileTempPath, $dest_path)) {
            $message .="dosya yüklendi.<br>";
        }
    }

    return array(
        "isSuccess" => $uploadOk,
        "message" => $message,
        "image" => $yeniDosyaAdi
    );
}
}


$usersClass = new Users();
$categoriesClass = new Categories();
$productsClass = new Products();
$productCategoriesClass = new ProductCategories();
$cartsClass = new Carts();
$commentsClass = new Comments();
$productCommentsClass = new ProductComments();
$othersClass = new Others();

?>