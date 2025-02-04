<?php
require_once("../view/template/top.inc.php");
?>

<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_sidebar.html -->
  <?php
  require_once("../view/template/sidebar.inc.php")
  ?>
  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <div class="container">
          <h2> Manage Post Setting </h2>
        </div>
      </div>
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <form class="forms-sample" method="POST" action="" id="postSetting">
              <div class="form-group">
                <label for="exampleInputName1">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter the word limit for the title" required>
                <small id="titleWordLimit" class="form-text text-muted" style="display: none;">Max 10 words</small> <!-- Initially hidden -->
              </div>

              <div class="form-group">
                <label for="exampleInputEmail3">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter the word limit for the description" required>
                <small id="descriptionWordLimit" class="form-text text-muted" style="display: none;">Max 10 words</small> <!-- Initially hidden -->
              </div>

              <div class="form-group">
                <label for="description1">Short Description</label>
                <input type="text" id="shortDescription" name="shortDescription" class="form-control" placeholder="Enter the word limit for the short description" required>
                <small id="shortDescriptionWordLimit" class="form-text text-muted" style="display: none;">Max 10 words</small> <!-- Initially hidden -->
              </div>

              <div class="form-group">
                <label for="description2">Long Description</label>
                <input type="text" id="longDescription" name="longDescription" class="form-control" placeholder="Enter the word limit for the long description" required>
                <small id="longDescriptionWordLimit" class="form-text text-muted" style="display: none;">Max 10 words</small> <!-- Initially hidden -->
              </div>

              <button type="submit" id="btnSave" name="btnSave" class="btn btn-gradient-primary me-2">Submit</button>
              <button type="button" id="btnCancel" name="btnCancel" class="btn btn-light" style="display: none;">Cancel</button> <!-- Initially hidden -->
            </form>
            <div>
              <small class="text-danger" id="msg"></small>
            </div>


          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php")
    ?>
    <script src="../view/assets/js/postSetting.js"></script>
  </div>
</div>