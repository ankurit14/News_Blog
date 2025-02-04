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
      <div class="container">
        <h2> New Post </h2>
      </div>
      <form class="forms-sample" method="POST" action="" id="newPost" enctype="multipart/form-data">
      <div class="form-group">
        <!-- <label for="title">Title (Max 10 words)</label> -->
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title words limit" required>
        <small id="titleWordLimit" class="form-text text-muted">Words: 0/10</small>
    </div>

    <div class="form-group">
        <!-- <label for="description">Description (Max 20 words)</label> -->
        <label for="description">Description</label>
        <input type="text" class="form-control" id="description" name="description" placeholder="Enter the description words limit" required>
        <small id="descriptionWordLimit" class="form-text text-muted">Words: 0/20</small>
    </div>

    <div class="form-group">
        <!-- <label for="shortDescription">Short Description (Max 30 words)</label> -->
        <label for="shortDescription">Short Description</label>
        <input type="text" id="shortDescription" class="form-control" placeholder="Enter the short description words limit">
        <small id="shortDescriptionWordLimit" class="form-text text-muted"></small>
    </div>

    <div class="form-group">
        <!-- <label for="longDescription">Long Description (Max 40 words)</label> -->
        <label for="longDescription">Long Description</label>
        <input type="text" id="longDescription" class="form-control" placeholder="Enter the long description words limit">
        <small id="longDescriptionWordLimit" class="form-text text-muted"></small>
    </div>

        <div class="form-group">
          <label>Post Image</label>
          <input type="file" id="postImage" name="postImage" class="form-control" required>
          <img src="" id="post_image" name="post_image" height="100" width="100" style="display: none;">
        </div>

        <div class="form-group">
          <label>Facebook Image</label>
          <input type="file" id="facebookImage" name="facebookImage" class="form-control" required>
          <img src="" id="facebook_image" name="facebook_image" height="100" width="100" style="display: none;">
        </div>

        <div class="form-group">
          <label>Instagram Image</label>
          <input type="file" id="instagramImage" name="instagramImage" class="form-control" required>
          <img src="" id="instagram_image" name="instagram_image" height="100" width="100" style="display: none;">
        </div>

        <div class="form-group">
          <label>WhatsApp Image</label>
          <input type="file" id="whatsappImage" name="whatsappImage" class="form-control" required>
          <img src="" id="whatsapp_image" name="whatsapp_image" height="100" width="100" style="display: none;">
        </div>

        <div class="form-group">
          <label>Status and Visibility</label>
          <select class="js-example-basic-single" style="width:100%" id="statusVisibility" name="statusVisibility">
            <option>Draft</option>
            <option>Pending</option>
            <option>Private</option>
            <option>Scheduled</option>
            <option>Published</option>
          </select>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Sticky</label>
          <div class="col-sm-4">
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="stickyRadios" id="stickyRadiosYes" value="Yes" checked > Yes </label>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="stickyRadios" id="stickyRadiosNo" value="No"> No </label>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Publish</label>
          <div class="col-sm-4">
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="publishRadios" id="immediately" value="immediately" checked>
                Immediately
              </label>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="publishRadios" id="scheduled" value="scheduled">
                Scheduled
              </label>
            </div>
          </div>
        </div>

        <!-- Date and Time Picker Container -->
        <div id="datetime-container" style="display: none;">
          <div class="form-group row mt-3">
            <label for="datepicker" class="col-sm-3 col-form-label">Select Date & Time</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Choose a date">
            </div>
            <div class="col-sm-5">
              <input type="time" class="form-control" id="timepicker" name="timepicker">
            </div>
          </div>
        </div>

        <!-- <div class="form-group">
          <label for="editor">Post Content</label>
          <textarea id="myeditor" name="content" class="form-control" required></textarea>
        </div> -->

        <div class="form-group">
          <label>AMP</label>
          <select class="js-example-basic-single" style="width:100%" id="amp" name="amp">
            <option>Enable</option>
            <option>Disable</option>
          </select>
        </div>

        <div class="form-group">
          <label>Tags</label>
          <select class="js-example-basic-multiple" id="tag" name="tag[]" multiple="multiple" style="width:100%" required>
            <!-- Tags will be dynamically inserted here -->
            <!-- Example: -->
            <!-- <option value="1">HealthCare</option> -->
            <!-- <option value="2">Public Health</option> -->
          </select>
        </div>

        <div class="form-group">
          <label for="exampleInputCity1">Tagged By</label>
          <input type="text" id="tagby" name="tagby" class="form-control" id="exampleInputCity1" placeholder="Tagged By" required>
        </div>
        <div class="form-group">
          <label for="Author">Author</label>
          <input type="text" id="author" name="author" class="form-control"  placeholder="Author" required>
        </div>
        <button type="submit" id="btnSave" name="btnSave" class="btn btn-gradient-primary me-2">Submit</button>
        <button class="btn btn-light">Cancel</button>
      </form>
      <div>
          <small class="text-danger" id="msg"></small>
        </div>
    </div>
    <?php
    require_once("../view/template/footer.inc.php")
    ?>
 <script src="../view/assets/js/newPost.js"></script>
    <script>
      jQuery.noConflict();
      jQuery(document).ready(function($){
      $(document).ready(function() {
        $('#datepicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          todayHighlight: true
        });

        $('input[name="publishRadios"]').change(function() {
          if ($('#scheduled').is(':checked')) {
            $('#datetime-container').show();
          } else {
            $('#datetime-container').hide();
          }
        });
      });
    });
    </script>

<!-- <script>
document.getElementById('postImage').addEventListener('change', function(event) {
    var file = event.target.files[0];

    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;

            img.onload = function() {
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');

                // Set desired dimensions for resizing (example: 300x300)
                var maxWidth = 300;
                var maxHeight = 300;
                var width = img.width;
                var height = img.height;

                // Calculate scaling
                if (width > maxWidth || height > maxHeight) {
                    var scale = Math.min(maxWidth / width, maxHeight / height);
                    width = Math.floor(width * scale);
                    height = Math.floor(height * scale);
                }

                // Resize the image using canvas
                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                // Convert the canvas to base64 image
                var resizedImageData = canvas.toDataURL('image/jpeg');  // You can change the format here

                // Show the resized image in the img tag
                document.getElementById('previewImage').src = resizedImageData;
                document.getElementById('previewImage').style.display = 'block';

                // You can also append this resized image data to your FormData object
                var formData = new FormData();
                formData.append('image', resizedImageData);

                // Send this FormData object to the server (AJAX or form submission)
            };
        };
        reader.readAsDataURL(file);  // Convert the file to a data URL
    }
});
</script> -->
  </div>
</div>