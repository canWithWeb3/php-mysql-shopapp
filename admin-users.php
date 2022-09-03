

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

<section id="admin-users" class="container">

  <table class="table table-striped table-bordered table-sm mb-0">
    <thead>
      <tr>
        <th>Email</th>
        <th style="width: 88px;">Admin</th>
        <th style="width: 88px;"></th>
      </tr>
    </thead>
    <tbody>
      <?php $getUsersResult = $usersClass->getUsers(); ?>
      <?php while($user = mysqli_fetch_assoc($getUsersResult)): ?>
        <tr>
          <td><?php echo $user["email"]; ?></td>
          <td>
            <?php if($user["type"] == "admin"): ?>
              <?php echo "<i class='fas fa-check text-success fs-5'></i>" ?>
            <?php else: ?>
              <?php echo "<i class='fas fa-times text-danger fs-5'></i>" ?>
            <?php endif; ?>  
          </td>
          <td>
            <a href="edit-user.php?id=<?php echo $user["id"]; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
            <a data-email="<?php echo $user["email"]; ?>" href="delete-user.php?id=<?php echo $user["id"]; ?>" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>
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
    const email = $(this).data("email");
    const href = $(this).attr("href");

    swal({
      title: `Silmek istiyor musunuz?`,
      text: `${email} kullanıcısını silmek istiyor musunuz?`,
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