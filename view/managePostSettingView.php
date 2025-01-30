<?php
require_once("../view/template/top.inc.php");

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

    // Insert into database (adjust your SQL query accordingly)
    $sql = "INSERT INTO posts (title, short_description, long_description, status, author)
            VALUES ('$title', '$shortDescription', '$longDescription', '$status', '$author')";

    if ($conn->query($sql)) {
        echo "Post added successfully!";
    } else {
        echo "Error: " . $conn->error;
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
      <div class="page-header">
        <div class="container">
          <h2> Manage Post Setting </h2>
        </div>
      </div>
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <form class="forms-sample" method="POST" action="">
              <div class="form-group">
                <label for="exampleInputName1">Title</label>
                <input type="number" class="form-control" id="exampleInputName1" name="title" placeholder="Enter the title words limit">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail3">Description</label>
                <input type="number" class="form-control" id="description" name="description" placeholder="Enter a brief description words limit">
              </div>

              <div class="form-group">
                <label for="description1">Short Description</label>
                <input type="number" id="description1" name="content1" class="form-control" placeholder="Enter a short description words limit">
              </div>

              <div class="form-group">
                <label for="description2">Long Description</label>
                <input type="number" id="description2" name="content2" class="form-control" placeholder="Enter a long description words limit">
              </div>

              <!-- Other form elements here -->

              <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
              <button class="btn btn-light">Cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php")
    ?>
    <script>
      // Function to allow only digits for inputs
      function onlyAllowDigits(event) {
        var charCode = event.which ? event.which : event.keyCode;
        if (charCode < 48 || charCode > 57) {
          event.preventDefault();
        }
      }

      // Apply to input fields
      document.getElementById("exampleInputName1").addEventListener('keypress', onlyAllowDigits);
      document.getElementById("description").addEventListener('keypress', onlyAllowDigits);
      document.getElementById("description1").addEventListener('keypress', onlyAllowDigits);
      document.getElementById("description2").addEventListener('keypress', onlyAllowDigits);
    </script>
  </div>
</div>
