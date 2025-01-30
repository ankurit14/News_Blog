<?php
require_once 'connection.inc.php';
$db = new dbConnector();
$msg = "";
$userName = "";
$userPassword = "";
// Check if the request is POST and the btnsave is clicked
if (isset($_POST['btnsave'])) {
  $userName = $_POST['username'];
  $userPassword = $_POST['password'];
  if(!empty($username) && !empty($password)){
   try{
     $sql = "select id from tbl_users where username=:username and password=:password";
     $params = ["username"=>$username,"password"=>$password];
     $userid = $db->getID($sql,$params);
     if($userid > 0){
     // if($userExists === true){
        session_start();
        $_SESSION['userid'] = $userid;
        $_SESSION['username'] = $username;
        $_SESSION['islogin'] = true;
        // print_r($_SESSION);
        header("location:view/index.php");
     }
     else{
        $msg = 'login failed! Enter valid username and password';
     }
      
   } 
   catch(PDOException $e){
     echo 'data error'.$e->getMessage();
   } 
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tishha Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="assets/images/logo.jpg">
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <form class="pt-3" method="POST" action="">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password">
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <!-- <a class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" id='btnsave' name='btnsave'>SIGN IN</a> -->
                    <button type="submit" id='btnsave' name='btnsave' class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                  </div>
                 
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <script>
      $(document).ready(function () {
      $('#btnsave').on('click', function (e) {
        e.preventDefault(); // Prevent the form from submitting the traditional way

        // Get form data
        const username = $('#username').val();
        const password = $('#password').val();

        // Check credentials
        if (username === 'ankur' && password === '12345') {
            window.location.href = 'index.php'; // Redirect to index.php
        } else {
            alert('Invalid username or password'); // Show an error message
        }
    });
});

    </script>
    <!-- endinject -->
  </body>
</html>