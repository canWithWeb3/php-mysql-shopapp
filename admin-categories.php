

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

<section id="admin-categories" class="container">

  <div class="card mb-3">
    <div class="card-body text-end">
      <a href="add-category.php" class="btn btn-success"><i class="fas fa-plus me-2"></i>Ekle</a>
    </div>
  </div>

  <table class="table table-striped table-bordered table-sm mb-0">
    <thead>
      <tr>
        <th>Adı</th>
        <th style="width: 98px;"></th>
      </tr>
    </thead>
    <tbody>
      <?php $getCategories = $categoriesClass->getCategories(); ?>
      <?php while($category = mysqli_fetch_assoc($getCategories)): ?>
        <tr>
          <td><?php echo $category["name"]; ?></td>
          <td>
            <a href="edit-category.php?id=<?php echo $category["id"]; ?>" class="btn btn-warning btn-sm me-3"><i class="fas fa-edit"></i></a>
            <a href="delete-category.php?id=<?php echo $category["id"]; ?>" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>
          </td>
        </tr>
      <?php endwhile; ?>  
    </tbody>
  </table>

</section>


<?php require "views/_head-finish.php"; ?>