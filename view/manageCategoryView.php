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
          <h1> Category Master </h1>
      </div>
      <!-- Category Form -->
      <!-- <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body"> -->
            <form class="forms-sample" method="POST" action="save_category.php" enctype="multipart/form-data">
              <!-- Category Title -->
              <div class="form-group">
                <label for="categoryTitle">Category Title</label>
                <input type="text" class="form-control" id="categoryTitle" name="title" placeholder="Enter category title" required>
              </div>

              <!-- Category Status -->
              <div class="form-group">
                <label for="categoryStatus">Status</label>
                <select class="form-control" id="categoryStatus" name="status">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>

              <!-- Submit Button -->
              <button type="submit" class="btn btn-gradient-primary me-2">Save</button>
            </form>
          <!-- </div>
        </div>
      </div> -->

      <!-- Category List Table -->
      <!-- <div class="col-12 grid-margin stretch-card"> -->
        <!-- <div class="card"> -->
          <div class="card-body">
            <!-- <h4 class="card-title">Category List</h4> -->
            <h2 class="mt-5">Category List</h2>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Category Title</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <!-- Example of a category row. Loop through the categories in your database -->
                <tr>
                  <td>HealthCare</td>
                  <td><button class="btn btn-gradient-warning btn-sm" id="toggle-1" onclick="toggleCategoryStatus(1)">Disable</button></td>
                  <td>
                    <a href="edit_category.php?id=1" class="btn btn-gradient-primary btn-sm">Edit</a>
                    <a href="delete_category.php?id=1" class="btn btn-gradient-danger btn-sm">Delete</a>
                    
                  </td>
                </tr>
                <tr>
                  <td>Web Development</td>
                  <td><button class="btn btn-gradient-success btn-sm" id="toggle-2" onclick="toggleCategoryStatus(2)">Enable</button></td>
                  <td>
                    <a href="edit_category.php?id=2" class="btn btn-gradient-primary btn-sm">Edit</a>
                    <a href="delete_category.php?id=2" class="btn btn-gradient-danger btn-sm">Delete</a>
                    
                  </td>
                </tr>
                <!-- Add more rows dynamically as per your database categories -->
              </tbody>
            </table>
          </div>
        <!-- </div> -->
      <!-- </div> -->

    </div>
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php");
    ?>
    <script>
      // Toggle the status of the category between Active and Inactive
      function toggleCategoryStatus(categoryId) {
        var button = document.getElementById("toggle-" + categoryId);
        
        // Check the current text and toggle it
        if (button.innerHTML === "Enable") {
          button.innerHTML = "Disable";
          button.classList.remove("btn-gradient-success");
          button.classList.add("btn-gradient-warning");
        } else {
          button.innerHTML = "Enable";
          button.classList.remove("btn-gradient-warning");
          button.classList.add("btn-gradient-success");
        }
      }

      tinymce.init({
        selector: '#shortDescription, #longDescription', // Target the description fields
        plugins: 'image link lists table code preview fullscreen',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image table | code preview fullscreen',
        height: 300
      });
    </script>
  </div>
</div>
