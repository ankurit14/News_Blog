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
                <label id="labelTitle" for="exampleInputName1">Title (Max 10 words)</label>
                <input type="text" class="form-control" id="exampleInputName1" name="title" placeholder="Title" oninput="checkWordLimit(this, 10, 'titleWordCount')">
                <small id="titleWordCount" class="form-text text-muted">Words: 0/10</small>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail3">Description (Max 20 words)</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description" oninput="checkWordLimit(this, 20, 'descriptionWordCount')">
                <small id="descriptionWordCount" class="form-text text-muted">Words: 0/20</small>
              </div>

              <div class="form-group">
                <label for="description1">Short Description (Max 30 words)</label>
                <textarea id="description1" name="content1" class="form-control" oninput="checkWordLimit(this, 30, 'shortDescriptionWordCount')"></textarea>
                <small id="shortDescriptionWordCount" class="form-text text-muted">Words: 0/30</small>
              </div>

              <div class="form-group">
                <label for="description2">Long Description (Max 100 words)</label>
                <textarea id="description2" name="content2" class="form-control" oninput="checkWordLimit(this, 100, 'longDescriptionWordCount')"></textarea>
                <small id="longDescriptionWordCount" class="form-text text-muted">Words: 0/100</small>
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
      // Function to check the word count and update the count text
      function checkWordLimit(input, limit, displayId) {
        // Split input by space and filter out empty entries
        var words = input.value.trim().split(/\s+/).filter(function(word) { return word.length > 0; });
        var wordCount = words.length;

        // Update the word count display text
        document.getElementById(displayId).textContent = "Words: " + wordCount + "/" + limit;

        // If word count exceeds the limit, slice the input to fit the word limit
        if (wordCount > limit) {
          input.value = words.slice(0, limit).join(" ");
          document.getElementById(displayId).textContent = "Words: " + limit + "/" + limit;
        }

        // Prevent typing more words, but allow text deletion/editing
        if (wordCount >= limit) {
          // Disallow adding more words beyond limit
          var trimmedValue = words.slice(0, limit).join(" ");
          input.value = trimmedValue;
        }
      }
    </script>
  </div>
</div>
