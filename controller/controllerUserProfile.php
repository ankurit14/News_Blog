<?php 
require_once('../view/connection.inc.php');
// $pdo = new PDO("mysql:host=localhost;dbname=tishha", "root", "");
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 // Check if form is submitted
 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_picture'])) {
     // Sanitize and validate form data
     $first_name = htmlspecialchars(trim($_POST['first_name']));
     $last_name = htmlspecialchars(trim($_POST['last_name']));
     $gender = htmlspecialchars(trim($_POST['gender']));
     $dob = htmlspecialchars(trim($_POST['dob']));
     $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
     $phone = htmlspecialchars(trim($_POST['phone']));
     $address_line1 = htmlspecialchars(trim($_POST['address_line1']));
     $address_line2 = htmlspecialchars(trim($_POST['address_line2']));
     $city = htmlspecialchars(trim($_POST['city']));
     $state = htmlspecialchars(trim($_POST['state']));
     $zip_code = htmlspecialchars(trim($_POST['zip_code']));
     $country = htmlspecialchars(trim($_POST['country']));
     $username = htmlspecialchars(trim($_POST['username']));
    //  $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Password hashing
     $password = htmlspecialchars(trim($_POST['password']));
     $role = htmlspecialchars(trim($_POST['role']));
 
     // Handle file upload for profile picture
     $profile_picture = '';
     // Check if a file was uploaded
     $fileName = '';
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
    // Define the allowed file types and max file size
    $allowedTypes = ['image/jpeg', 'image/png'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    // Validate file type
    if (!in_array($_FILES['profile_picture']['type'], $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPEG and PNG are allowed.']);
        exit;
    }

    // Validate file size
    if ($_FILES['profile_picture']['size'] > $maxSize) {
        echo json_encode(['status' => 'error', 'message' => 'File size exceeds the limit of 5MB.']);
        exit;
    }

    // Move file to uploads directory
    $uploadDir = '../assets/uploads/';
    $fileName = uniqid() . '.' . pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
    $filePath = $uploadDir . $fileName;
    
    if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $filePath)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload file.']);
        exit;
    }
}
     
     $sql = "INSERT INTO user_profiles 
             (first_name, last_name, gender, dob, email, phone, address_line1, address_line2, city, state, zip_code, country, profile_picture, username, password, role) 
             VALUES 
             (:first_name, :last_name, :gender, :dob, :email, :phone, :address_line1, :address_line2, :city, :state, :zip_code, :country, :profile_picture, :username, :password, :role)";
     
     try {
         // Prepare the statement
         $stmt = $pdo->prepare($sql);
         // Array of parameters (key => value)
         $params = [
             ':first_name' => $first_name,
             ':last_name' => $last_name,
             ':gender' => $gender,
             ':dob' => $dob,
             ':email' => $email,
             ':phone' => $phone,
             ':address_line1' => $address_line1,
             ':address_line2' => $address_line2,
             ':city' => $city,
             ':state' => $state,
             ':zip_code' => $zip_code,
             ':country' => $country,
             ':profile_picture' => $fileName,
             ':username' => $username,
             ':password' => $password,
             ':role' => $role
         ];
 
         // Execute the query with parameters
         if ($stmt->execute($params)) {
            echo json_encode(['status' => 'success', 'message' => 'User profile created successfully!']);
         } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: Could not create user profile.']);
         }
     } catch (PDOException $e) {
         // Catch and display errors
         echo json_encode(array('status' => 'error', 'message' => "Error! Record not saved. " . $e->getMessage()));
    exit;
     }
 }

?>