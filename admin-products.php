

<?php 
  require "libs/functions.php";

  if(!$usersClass->isAdmin()){
    header("Location: index.php");
    exit;
  }
  
?>

<?php require "views/_head-start.php"; ?>
<?php require "views/_message.php"; ?>
<?php require "views/_admin-navbar.php"; ?>

<section id="admin-products" class="container">

  <div class="card mb-3">
    <div class="card-body text-end">
      <a href="add-product.php" class="btn btn-success"><i class="fas fa-plus me-2"></i>Ekle</a>
    </div>
  </div>

  <table class="table table-striped table-bordered table-sm mb-0">
    <thead>
      <tr>
        <th style="width: 80px;">Image</th>
        <th>Adı</th>
        <th class="table-description">Açıklama</th>
        <th style="width: 98px;">Orjinal<br>fiyatı</th>
        <th style="width: 98px;">İndirimli<br>fiyatı</th>
        <th class="table-categories" style="width: 98px;">Kategori</th>
        <th style="width: 98px;"></th>
      </tr>
    </thead>
    <tbody>
      <?php $getProducts = $productsClass->getProducts(); ?>
      <?php while($product = mysqli_fetch_assoc($getProducts)): ?>
        <tr>
          <td class="p-0"><img src="img/<?php echo $product["image"]; ?>" alt="" class="img-fluid"></td>
          <td><?php echo $product["name"]; ?></td>
          <td class="table-description"><?php echo $product["description"]; ?></td>
          <td><?php echo $product["originalPrice"]; ?></td>
          <td><?php echo $product["discountPrice"]; ?></td>
          <td class="table-categories">
            <ul class="list-unstyled">
            <?php $productCategories = $productCategoriesClass->getProductCategoriesByProductId($product["id"]); ?>
            <?php foreach($productCategories as $pc): ?>
              <li><?php echo $pc["name"]; ?></li>
            <?php endforeach; ?>  
            </ul>
          </td>
          <td>
            <a href="edit-product.php?id=<?php echo $product["id"]; ?>" class="btn btn-warning btn-sm w-100 mb-3"><i class="fas fa-edit"></i></a>
            <a data-name="<?php echo $product["name"]; ?>" href="delete-product.php?id=<?php echo $product["id"]; ?>" class="btn btn-danger btn-sm w-100"><i class="fas fa-times"></i></a>
          </td>
        </tr>
      <?php endwhile; ?>  
    </tbody>
  </table>

</section>

<?php include "views/_cdns.php"; ?>

<script type="text/javascript">
  $(".btn-danger").click(function(e){
    e.preventDefault();
    const name = $(this).data("name");
    const href = $(this).attr("href");

    swal({
      title: `Silmek istiyor musunuz?`,
      text: `${name} ürününü silmek istiyor musunuz?`,
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        document.location.href = href;    
      }
    });
  })
</script>

<?php require "views/_head-finish.php"; ?>