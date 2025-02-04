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
        <h1>User Category Form</h1>

        <!-- User Category Form -->
        <form method="POST" action="" id="category">
          <div class="form-group">
            <label for="Category_name">Category Name:</label>
            <input type="text" id="Category_name" name="Category_name" class="form-control" placeholder="Enter Category Name" required>
            <small class="text-danger" id="Category_name_error"></small>
          </div>

          <div class="form-group">
            <label for="Category_description">Category Description:</label>
            <textarea id="Category_description" name="Category_description" class="form-control" placeholder="Enter Category Description" rows="4"></textarea>
            <small class="text-danger" id="Category_description_error"></small>
          </div>

          <button type="submit" id="btnSave" name="btnSave" class="btn btn-primary">Save</button>

          <input type="hidden" id="catid" name="catid">
        </form>

        <div>
          <small class="text-danger" id="msg"></small>
        </div>

        <!-- Existing Category List -->
        <h2 class="mt-5">Existing Categorys</h2>
        <div id="tableContainer" class="table table-bordered">
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php");
    ?>
    <script src="../view/assets/js/postCategory.js"></script>
  </div>
</div>