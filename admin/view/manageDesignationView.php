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
        <h1>User Role</h1>
        <?php if (!empty($msg)) : ?>
          <div class="alert"><?= $msg; ?></div>
        <?php endif; ?>

        <!-- User Designation Form -->
        <form method="POST" action="" id="designation">
          <div class="form-group">
            <label for="designation_name">Role :</label>
            <input type="text" id="designation_name" name="designation_name" class="form-control" placeholder="Enter Role" required>
             <small class="text-danger" id="designation_name_error"></small>
          </div>
          <div class="form-group">
            <label for="designation_description">Description:</label>
            <textarea id="designation_description" name="designation_description" class="form-control" placeholder="Enter Role Description" rows="4"></textarea>
            <small class="text-danger" id="designation_description_error"></small>
          </div>
          <button type="submit" id="btnSave" name="btnSave" class="btn btn-primary">Save</button>
          <input type="hidden" id="desgid" name="desgid">
        </form>
        <div>
          <small class="text-danger" id="msg"></small>
        </div>


        <!-- Existing Designation List -->
        <h2 class="mt-5">Existing Role</h2>
        <?php
        // Example of fetching data from the database
        // Make sure to replace this query with your actual database code
        $designations = [
          ['name' => 'Manager', 'description' => 'Responsible for overseeing teams', 'status' => 'active'],
          ['name' => 'Developer', 'description' => 'Responsible for coding and development', 'status' => 'inactive'],
          ['name' => 'HR', 'description' => 'Responsible for human resources management', 'status' => 'active']
        ];
        ?>

        <table class="table table-bordered">
          <!-- <thead>
            <tr>
              <th>#</th>
              <th>Designation Name</th>
              <th>Description</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead> -->
          <tbody>
          <div id="tableContainer">
    <!-- The table will be inserted here by AJAX -->
</div>
          </tbody>
        </table>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php");
    ?>
    <script src="../view/assets/js/userDesignation.js"></script>
  </div>
</div>

