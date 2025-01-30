<?php
require_once("../view/template/top.inc.php")
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
    <div class="container">
          <h2> Post List </h2>
      </div>
      <!-- <div class="page-header">
        <h3 class="page-title">
          <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-pencil-plus"></i>
          </span> Post List
        </h3>
      </div> -->

      <!-- Post List Table -->
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <!-- Post List Table -->
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Date Published</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <!-- Example of a post row. Loop through the posts in your database -->
                <tr>
                  <td>How to Set Up a Category in PHP</td>
                  <td>Programming</td>
                  <td>January 1, 2025</td>
                  <td>Published</td>
                  <td>
                    <a href="edit_post.php?id=1" class="btn btn-gradient-primary btn-sm">Edit</a>
                    <a href="delete_post.php?id=1" class="btn btn-gradient-danger btn-sm">Delete</a>
                    <button class="btn btn-gradient-warning btn-sm" id="toggle-1" onclick="toggleStatus(1)">Disable</button>
                  </td>
                </tr>
                <tr>
                  <td>Introduction to Laravel</td>
                  <td>Web Development</td>
                  <td>December 25, 2024</td>
                  <td>Draft</td>
                  <td>
                    <a href="edit_post.php?id=2" class="btn btn-gradient-primary btn-sm">Edit</a>
                    <a href="delete_post.php?id=2" class="btn btn-gradient-danger btn-sm">Delete</a>
                    <button class="btn btn-gradient-success btn-sm" id="toggle-2" onclick="toggleStatus(2)">Enable</button>
                  </td>
                </tr>
                <!-- Add more rows dynamically as per your database posts -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php")
    ?>
    <script>
      // Toggle the status of the post between Enabled and Disabled
      function toggleStatus(postId) {
        var button = document.getElementById("toggle-" + postId);
        
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
        // $.post('update_status.php', { post_id: postId, status: button.innerHTML });
      }

      tinymce.init({
        selector: '#description1,#description2',
        plugins: 'image link table lists code fullscreen textcolor colorpicker paste searchreplace autolink preview anchor insertdatetime media charmap emoticons',
        menubar: false,
        toolbar: 'undo redo | cut copy paste | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link image media | code preview fullscreen',
        file_picker_callback: function(callback, value, meta) {
          var input = document.createElement('input');
          input.setAttribute('type', 'file');
          input.setAttribute('accept', 'image/*');
          input.click();
          input.onchange = function() {
            var file = input.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
              callback(e.target.result, { alt: file.name });
            };
            reader.readAsDataURL(file);
          };
        }
      });
    </script>
  </div>
</div>
