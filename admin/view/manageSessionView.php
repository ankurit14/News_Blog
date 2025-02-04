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
          <h2>Financial Year</h2>
      </div>
      
      <!-- Financial Year Form -->
      <div class="form-container">
        <form method="POST" action="save_financial_year.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="financialYearName">Financial Year Name</label>
            <input type="text" id="financialYearName" name="financial_year_name" class="form-control" placeholder="Enter Financial Year Name" required>
          </div>
          
          <div class="form-group">
            <label for="financialYearStart">Start Date</label>
            <input type="date" id="financialYearStart" name="start_date" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="financialYearEnd">End Date</label>
            <input type="date" id="financialYearEnd" name="end_date" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="financialYearStatus">Status</label>
            <select id="financialYearStatus" name="status" class="form-control" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </div>

      <!-- Financial Year List -->
      <div class="list-container mt-5">
        <h2>Financial Year List</h2>
        <?php
        // Example of fetched financial years (replace with your database fetching logic)
        $financialYears = [
          ['id' => 1, 'name' => '2023-2024', 'status' => 'active', 'start_date' => '2023-04-01', 'end_date' => '2024-03-31'],
          ['id' => 2, 'name' => '2022-2023', 'status' => 'inactive', 'start_date' => '2022-04-01', 'end_date' => '2023-03-31']
        ];
        ?>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Financial Year Name</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($financialYears as $financialYear) : ?>
              <tr>
                <td><?= htmlspecialchars($financialYear['name']); ?></td>
                <td><?= htmlspecialchars($financialYear['start_date']); ?></td>
                <td><?= htmlspecialchars($financialYear['end_date']); ?></td>
                <td>
                  <span id="status-<?= $financialYear['id']; ?>" class="badge <?= $financialYear['status'] === 'active' ? 'badge-success' : 'badge-warning'; ?>">
                    <?= ucfirst($financialYear['status']); ?>
                  </span>
                </td>
                <td>
                  <a href="edit_financial_year.php?id=<?= $financialYear['id']; ?>" class="btn btn-gradient-primary btn-sm">Edit</a>
                  <a href="delete_financial_year.php?id=<?= $financialYear['id']; ?>" class="btn btn-gradient-danger btn-sm">Delete</a>
                  <button class="btn btn-gradient-<?= $financialYear['status'] === 'active' ? 'warning' : 'success'; ?> btn-sm" id="toggle-<?= $financialYear['id']; ?>" onclick="toggleFinancialYearStatus(<?= $financialYear['id']; ?>)">
                    <?= $financialYear['status'] === 'active' ? 'Disable' : 'Enable'; ?>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>
    <!-- content-wrapper ends -->
    <?php
    require_once("../view/template/footer.inc.php");
    ?>
  </div>
</div>

<script>
  // Toggle the status of the financial year between Active and Inactive
  function toggleFinancialYearStatus(financialYearId) {
    var statusElement = document.getElementById('status-' + financialYearId);
    var toggleButton = document.getElementById('toggle-' + financialYearId);

    // Check current status and toggle it
    if (statusElement.innerHTML === 'Active') {
      statusElement.innerHTML = 'Inactive';
      statusElement.classList.remove('badge-success');
      statusElement.classList.add('badge-warning');

      toggleButton.innerHTML = 'Enable';
      toggleButton.classList.remove('btn-gradient-warning');
      toggleButton.classList.add('btn-gradient-success');
    } else {
      statusElement.innerHTML = 'Active';
      statusElement.classList.remove('badge-warning');
      statusElement.classList.add('badge-success');

      toggleButton.innerHTML = 'Disable';
      toggleButton.classList.remove('btn-gradient-success');
      toggleButton.classList.add('btn-gradient-warning');
    }
  }

  tinymce.init({
    selector: '#shortDescription, #longDescription', // Target the description fields
    plugins: 'image link lists table code preview fullscreen',
    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image table | code preview fullscreen',
    height: 300
  });
</script>
