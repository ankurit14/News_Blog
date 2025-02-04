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
        <h2>Company Master Form</h2>

        <form id="companyProfile" method="POST" action="" enctype="multipart/form-data">
          <div class="form-group">
            <label for="owner_name">Company Owner's Name:</label>
            <input type="text" id="owner_name" name="owner_name" class="form-control" placeholder="Enter Owner's Name" required>
          </div>
          <div class="form-group">
            <label for="company_name">Company Name:</label>
            <input type="text" id="company_name" name="company_name" class="form-control" placeholder="Enter Company Name" required>
          </div>
          <div class="form-group">
            <label for="company_logo">Company Logo:</label>
            <input type="file" id="company_logo" name="company_logo" class="form-control" accept="image/*" required>
            <img src="" id="companyLogo" name="companyLogo" height="100" width="100" style="display: none;">
            <small id="company_logo_error" class="form-text text-danger" style="display:none;"></small>
          </div>

          <div class="form-group">
            <label for="company_icon">Company Icon (for Browser Tab):</label>
            <input type="file" id="company_icon" name="company_icon" class="form-control" accept="image/*" required>
            <img src="" id="companyIcon" name="companyIcon" height="100" width="100" style="display: none;">
            <small id="company_icon_error" class="form-text text-danger" style="display:none;"></small>
          </div>
          <div class="form-group">
            <label for="browser_title">Browser Title:</label>
            <input type="text" id="browser_title" name="browser_title" class="form-control" placeholder="Enter Browser Title" required>
          </div>
          <div class="form-group">
            <label for="meta_description">Meta Description:</label>
            <textarea id="meta_description" name="meta_description" class="form-control" placeholder="Enter Meta Description" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label for="meta_keywords">Meta Keywords:</label>
            <textarea id="meta_keywords" name="meta_keywords" class="form-control" placeholder="Enter Meta Keywords (comma-separated)" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label for="gst_number">GST Number:</label>
            <input type="text" id="gst_number" name="gst_number" class="form-control" placeholder="Enter GST Number">
          </div>
          <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" class="form-control" placeholder="Enter Address" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label for="email">Mail ID:</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter Mail ID">
          </div>
          <div class="form-group">
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" class="form-control" placeholder="Enter Contact Number">
            <small id="contact_error" class="form-text text-danger" style="display:none;">Please enter a valid 10-digit contact number.</small>
          </div>
          <button type="submit" id="btnSave" name="btnSave" class="btn btn-primary">Save</button>
          <div>
            <input type="hidden" id="compid" name="compid">
          </div>
        </form>
        <div>
          <small class="text-danger" id="msg"></small>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php");
    ?>
    <script src="../view/assets/js/companyProfile.js"></script>
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
        // Optionally, make an AJAX call to update the status in the database
        // Example:
        // $.post('update_category_status.php', { category_id: categoryId, status: button.innerHTML });
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