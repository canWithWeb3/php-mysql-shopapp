<?php if(isset($_SESSION["message"])): ?>

  <div class="alert alert-<?php echo $_SESSION["type"]; ?> text-center">
    <?php echo $_SESSION["message"]; ?>

    <?php unset($_SESSION["message"]); ?>
    <?php unset($_SESSION["type"]); ?>
  </div>

<?php endif; ?>