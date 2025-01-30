<?php
require_once("../view/template/top.inc.php");


function uploadImage($fileInput, $targetDir = "uploads/") {
  if (!empty($_FILES[$fileInput]['name'])) {
      $fileName = basename($_FILES[$fileInput]['name']);
      $targetFilePath = $targetDir . $fileName;
      $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

      // Allow certain file formats
      $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
      if (in_array(strtolower($fileType), $allowedTypes)) {
          if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $targetFilePath)) {
              return $targetFilePath;
          }
      }
  }
  return null;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Database connection
  $conn = new mysqli('localhost', 'root', '', 'your_database');
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Get form inputs
  $title = $conn->real_escape_string($_POST['title']);
  $shortDescription = $conn->real_escape_string($_POST['content1']); // short description
  $longDescription = $conn->real_escape_string($_POST['content2']); // long description
  $status = $conn->real_escape_string($_POST['status']);
  $author = $conn->real_escape_string($_POST['author']);

  // Upload images
  $postImage = uploadImage('post_image');
  $facebookImage = uploadImage('facebook_image');
  $instagramImage = uploadImage('instagram_image');
  $whatsappImage = uploadImage('whatsapp_image');

  // Insert into database
  $sql = "INSERT INTO posts (title, short_description, long_description, status, post_image, facebook_image, instagram_image, whatsapp_image, author)
          VALUES ('$title', '$shortDescription', '$longDescription', '$status', '$postImage', '$facebookImage', '$instagramImage', '$whatsappImage', '$author')";

  if ($conn->query($sql)) {
      echo "Post added successfully!";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}

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
      <!-- <div class="page-header">
        <h3 class="page-title">
          <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-pencil-plus"></i>
          </span> New Post
        </h3>
      </div> -->
      <div class="container">
          <h2> Edit New Post </h2>
      </div>
      <!-- <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body"> -->
            <form class="forms-sample">
              <div class="form-group">
                <label for="exampleInputName1">Title</label>
                <input type="text" class="form-control" id="exampleInputName1" placeholder="Name">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail3">Description</label>
                <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Description">
              </div>

              <div class="form-group">
                <label for="editor">Short Description</label>
                <textarea id="description1" name="content" class="form-control"></textarea>
              </div>

              <div class="form-group">
                <label for="editor">Long Description</label>
                <textarea id="description2" name="content" class="form-control"></textarea>
              </div>

              <div class="form-group">
                <label>Post Image</label>
                <input type="file" id="post_image" name="post_image" class="form-control" accept="image/*" required>
                <!-- <input type="file" name="img[]" class="file-upload-default"> -->
                <!-- <div class="input-group col-12">
                  <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-gradient-primary py-3" type="button">Upload</button>
                  </span>
                </div> -->
              </div>

              <div class="form-group">
                <label>Facebook Image</label>
                <input type="file" id="facebook_image" name="facebook_image" class="form-control" accept="image/*" required>
                <!-- <input type="file" name="img[]" class="file-upload-default"> -->
                <!-- <div class="input-group col-12">
                  <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-gradient-primary py-3" type="button">Upload</button>
                  </span>
                </div> -->
              </div>

              <div class="form-group">
                <label>Instagram Image</label>
                <input type="file" id="instagram_image" name="instagram_image" class="form-control" accept="image/*" required>
                <!-- <input type="file" name="img[]" class="file-upload-default">
                <div class="input-group col-12">
                  <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-gradient-primary py-3" type="button">Upload</button>
                  </span>
                </div> -->
              </div>

              <div class="form-group">
                <label>WhatsApp Image</label>
                <input type="file" id="whatsapp_image" name="whatsapp_image" class="form-control" accept="image/*" required>
                <!-- <input type="file" name="img[]" class="file-upload-default">
                <div class="input-group col-12">
                  <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-gradient-primary py-3" type="button">Upload</button>
                  </span>
                </div> -->
              </div>

              <div class="form-group">
                <label>Status and Visibility</label>
                <select class="js-example-basic-single" style="width:100%">
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
                      <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios1" value="" checked> Yes </label>
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2" value="option2"> No </label>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Publish</label>
                <div class="col-sm-4">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="membershipRadios" id="Immediately" value="immediately" checked>
                      Immediately
                    </label>
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="membershipRadios" id="Scheduled" value="scheduled">
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
                    <input type="text" class="form-control" id="datepicker" placeholder="Choose a date">
                  </div>
                  <div class="col-sm-5">
                    <input type="time" class="form-control" id="timepicker">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="editor">Post Content</label>
                <textarea id="myeditor" name="content" class="form-control"></textarea>
              </div>

              <div class="form-group">
                <label>AMP</label>
                <select class="js-example-basic-single" style="width:100%">
                  <option>Enable</option>
                  <option>Disable</option>
                </select>
              </div>

              <div class="form-group">
                <label>Tags</label>
                <select class="js-example-basic-multiple" multiple="multiple" style="width:100%">
                  <option value="AL">HealthCare</option>
                  <option value="WY">Global HealthCare</option>
                  <option value="AM">WHO</option>
                  <option value="CA">Hospital Jobs</option>
                  <option value="RU">Hiring</option>
                  <option value="RU">Public Health</option>
                  <option value="RU">Patient Care</option>
                  <option value="RU">Hospital</option>
                </select>
              </div>

              <div class="form-group">
                <label for="exampleInputCity1">Tagged By</label>
                <input type="text" class="form-control" id="exampleInputCity1" placeholder="Tagged By">
              </div>
              <div class="form-group">
                <label for="exampleTextarea1">Author</label>
                <input type="text" class="form-control" id="exampleInputCity1" placeholder="Author">
              </div>
              <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
              <button class="btn btn-light">Cancel</button>
            </form>
          </div>
        <!-- </div>
      </div>
    </div> -->
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php")
    ?>
    <script>
      $(document).ready(function() {
        $('#datepicker').datepicker({
          format: 'mm/dd/yyyy',
          autoclose: true,
          todayHighlight: true
        });

        $('input[name="membershipRadios"]').change(function() {
          if ($('#Scheduled').is(':checked')) {
            $('#datetime-container').show();
          } else {
            $('#datetime-container').hide();
          }
        });
      });

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
