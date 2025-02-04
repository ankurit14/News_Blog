<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="assets/images/faces/face1.jpg" alt="profile" />
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">User</span>
                  <span class="text-secondary text-small">Admin</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="viewCompanyProfile.php">
                <span class="menu-title">Company</span>
                <i class="mdi mdi-office-building menu-icon"></i>
              </a>
            </li>


            <li class="nav-item">
  <a class="nav-link" data-bs-toggle="collapse" href="#userMaster" aria-expanded="false" aria-controls="userMaster">
    <span class="menu-title">User Management</span>
    <i class="menu-arrow"></i>
    <i class="mdi mdi-account-multiple-outline menu-icon"></i>
  </a>
  <div class="collapse" id="userMaster">
    <ul class="nav flex-column sub-menu">
      <li class="nav-item">
        <a class="nav-link" href="viewUserProfile.php"> User Profiles </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="viewUserManage.php"> Manage Users </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#"> User Activity Logs </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"> User Permissions </a>
      </li> -->
    </ul>
  </div>
</li>

            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#auth1" aria-expanded="false" aria-controls="auth1">
                <span class="menu-title"> Master Management </span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-view-grid-outline menu-icon"></i>
              </a>
              <div class="collapse" id="auth1">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="manageDesignationView.php"> Manage Role </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="manageCategoryView.php"> Manage Categories </a>
                  </li>
                 
                  <li class="nav-item">
                    <a class="nav-link" href="manageTagView.php"> Manage Tags </a>
                  </li>
                  <!-- <li class="nav-item">
                    <a class="nav-link" href="manageSessionView.php"> Manage Sessions </a>
                  </li> -->
                  <li class="nav-item">
                    <a class="nav-link" href="managePostSettingView.php"> Manage Post Settings </a>
                  </li>
                  
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#auth2" aria-expanded="false" aria-controls="auth2">
                <span class="menu-title">Post</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-folder-cog-outline menu-icon"></i>
              </a>
              <div class="collapse" id="auth2">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="newPostView.php"> New Post </a>
                  </li>
                  <!-- <li class="nav-item">
                    <a class="nav-link" href="newPostView1.php"> New Post 1 </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="editPostView.php"> Edit Post </a>
                  </li> -->
                  <li class="nav-item">
                    <a class="nav-link" href="viewPostList.php">Post List </a>
                  </li>
                 
                  <!-- <li class="nav-item">
                    <a class="nav-link" href="pages/samples/register.html"> Tags </a>
                  </li> -->
                  
                </ul>
              </div>
            </li>
          </ul>
        </nav>