<?php
require_once("../view/template/top.inc.php");
?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_sidebar.html -->
  <?php
  require_once("../view/template/sidebar.inc.php");
  ?>
  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="container">
        <h1>User Tag Form</h1>
        <?php if (!empty($msg)) : ?>
          <div class="alert"><?= $msg; ?></div>
        <?php endif; ?>

        <!-- User Tag Form -->
        <form method="POST" action="" id="tag">
          <div class="form-group">
            <label for="tag_name">Tag Name:</label>
            <input type="text" id="tag_name" name="tag_name" class="form-control" placeholder="Enter Tag Name" required>
             <small class="text-danger" id="tag_name_error"></small>
          </div>
          <div class="form-group">
            <label for="tag_description">Tag Description:</label>
            <textarea id="tag_description" name="tag_description" class="form-control" placeholder="Enter Tag Description" rows="4"></textarea>
            <small class="text-danger" id="tag_description_error"></small>
          </div>
          <button type="submit" id="btnSave" name="btnSave" class="btn btn-primary">Save</button>
          <input type="hidden" id="catid" name="catid">
        </form>
        <div>
          <small class="text-danger" id="msg"></small>
        </div>


        <!-- Existing Tag List -->
        <h2 class="mt-5">Existing Tags</h2>
          <div id="tableContainer" class="table table-bordered">
          </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php");
    ?>
    <script src="../view/assets/js/postTag.js"></script>
  </div>
</div>

