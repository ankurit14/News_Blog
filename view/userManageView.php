
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
        <h2>User List</h2>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Username</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Example User Row (Dummy Data) -->
            <tr>
              <td>johndoe</td>
              <td>John Doe</td>
              <td>johndoe@example.com</td>
              <td>
              <button class="btn btn-gradient-warning btn-sm" id="toggle-1" onclick="toggleUserStatus(1)">Disable</button>
              </td>
              <td>
                <a href="edit_user.php?id=1" class="btn btn-gradient-primary btn-sm">Edit</a>
                <a href="delete_user.php?id=1" class="btn btn-gradient-danger btn-sm">Delete</a>
                
              </td>
            </tr>
            <tr>
              <td>janedoe</td>
              <td>Jane Doe</td>
              <td>janedoe@example.com</td>
              <td>
              <button class="btn btn-gradient-success btn-sm" id="toggle-2" onclick="toggleUserStatus(2)">Enable</button>
              </td>
              <td>
                <a href="edit_user.php?id=2" class="btn btn-gradient-primary btn-sm">Edit</a>
                <a href="delete_user.php?id=2" class="btn btn-gradient-danger btn-sm">Delete</a>
                
              </td>
            </tr>
            <tr>
              <td>michael123</td>
              <td>Michael Smith</td>
              <td>michael123@example.com</td>
              <td>
              <button class="btn btn-gradient-warning btn-sm" id="toggle-3" onclick="toggleUserStatus(3)">Disable</button>
              </td>
              <td>
                <a href="edit_user.php?id=3" class="btn btn-gradient-primary btn-sm">Edit</a>
                <a href="delete_user.php?id=3" class="btn btn-gradient-danger btn-sm">Delete</a>
                
              </td>
            </tr>
            <tr>
              <td>emily45</td>
              <td>Emily Johnson</td>
              <td>emily45@example.com</td>
              <td>
              <button class="btn btn-gradient-success btn-sm" id="toggle-4" onclick="toggleUserStatus(4)">Enable</button>
              </td>
              <td>
                <a href="edit_user.php?id=4" class="btn btn-gradient-primary btn-sm">Edit</a>
                <a href="delete_user.php?id=4" class="btn btn-gradient-danger btn-sm">Delete</a>
                
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- content-wrapper ends -->

    <?php
    require_once("../view/template/footer.inc.php");
    ?>

    <script>
      // Toggle the status of the user between Enabled and Disabled
      function toggleUserStatus(userId) {
        var button = document.getElementById("toggle-" + userId);

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
        // $.post('update_user_status.php', { user_id: userId, status: button.innerHTML });
      }
    </script>
  </div>
</div>


<?php
// require_once("../view/template/footer.inc.php");
?>


