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
        <h2 class="mt-5">Existing Users</h2>
          <div id="tableContainer" class="table table-bordered">
          </div>
      <!-- </div> -->
    </div>
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php");
    ?>
    <script src="../view/assets/js/manageUser.js"></script>
  </div>
</div>

