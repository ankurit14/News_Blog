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
          <h2> Tag Master </h2>
      </div>
      <!-- Tag Form -->
      <!-- <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body"> -->
            <form class="forms-sample" method="POST" action="save_tag.php" enctype="multipart/form-data">
              <!-- Tag Title -->
              <div class="form-group">
                <label for="tagTitle">Tag Title</label>
                <input type="text" class="form-control" id="tagTitle" name="title" placeholder="Enter tag title" required>
              </div>

              <!-- Tag Status -->
              <div class="form-group">
                <label for="tagStatus">Status</label>
                <select class="form-control" id="tagStatus" name="status">
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

      <!-- Tag List Table -->
      <!-- <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body"> -->
            <!-- <h4 class="card-title">Tag List</h4> -->
            
            <h2 class="mt-5">Tag List</h2>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tag Title</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <!-- Example of a tag row. Loop through the tags in your database -->
                <tr>
                  <td>Health</td>
                  <td><button class="btn btn-gradient-warning btn-sm" id="toggle-1" onclick="toggleTagStatus(1)">Disable</button></td>
                  <td>
                    <a href="edit_tag.php?id=1" class="btn btn-gradient-primary btn-sm">Edit</a>
                    <a href="delete_tag.php?id=1" class="btn btn-gradient-danger btn-sm">Delete</a>
                    
                  </td>
                </tr>
                <tr>
                  <td>Technology</td>
                  <td><button class="btn btn-gradient-success btn-sm" id="toggle-2" onclick="toggleTagStatus(2)">Enable</button></td>
                  <td>
                    <a href="edit_tag.php?id=2" class="btn btn-gradient-primary btn-sm">Edit</a>
                    <a href="delete_tag.php?id=2" class="btn btn-gradient-danger btn-sm">Delete</a>
                    
                  </td>
                </tr>
                <!-- Add more rows dynamically as per your database tags -->
              </tbody>
            </table>
          <!-- </div>
        </div>
      </div> -->

    </div>
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php");
    ?>
    <script>
      // Toggle the status of the tag between Active and Inactive
      function toggleTagStatus(tagId) {
        var button = document.getElementById("toggle-" + tagId);
        
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

        // Optionally, make an AJAX call to update the status in the database
        // Example:
        // $.post('update_tag_status.php', { tag_id: tagId, status: button.innerHTML });
      }

      tinymce.init({
        selector: '#description', // Target the description field if used
        plugins: 'image link lists table code preview fullscreen',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image table | code preview fullscreen',
        height: 300
      });
    </script>
  </div>
</div>
