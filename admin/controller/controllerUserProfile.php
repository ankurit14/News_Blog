<?php 
require_once('../view/connection.inc.php');
// $pdo = new PDO("mysql:host=localhost;dbname=tishha", "root", "");
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 // Check if form is submitted
 $action = htmlspecialchars(trim($_POST['action']));
 if($action == "load"){
    try{
    $sql = "SELECT * from user_profiles";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $table = '<table class="table table-bordered table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>User Name</th>
            <th>Mobile No</th>
            <th>Password</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>';

// Loop through the Categorys and create table rows
foreach ($users as $key => $user) {
$recid = $user['id'];
$statusClass = ($user['status'] == 1) ? 'btn-success' : 'btn-warning';
$statusText = ($user['status'] == 1) ? 'Active' : 'Inactive';
$toggleStatus = ($user['status'] == 1) ? 0 : 1; // Toggle between 1 and 0

$table .= '<tr id="row_' . $user['id'] . '">
              <td>' . ($key + 1) . '</td>
              <td>' . htmlspecialchars($user['first_name']) . '</td>
              <td>' . htmlspecialchars($user['username']) . '</td>
              <td>' . htmlspecialchars($user['phone']) . '</td>
              <td>' . htmlspecialchars($user['password']) . '</td>
              <td>' . htmlspecialchars($user['role']) . '</td>
              <td>
                <!-- Use button for status toggle -->
                <button id="status"  class="btn ' . $statusClass . ' btn-sm" data-id="' . $user['id'] . '" onclick="toggleStatus(' . $user['id'] . ')">
                    ' . $statusText . '
                </button>
              </td>
              <td>
                <button id="btnEdit" class="btn btn-info btn-sm" data-value ="' . $user['id'] .'">Edit</button>
                <button id="btnDelete" class="btn btn-danger btn-sm" data-value ="' . $user['id'] .'">Delete</button>
              </td>
            </tr>';
}

// End the table HTML
$table .= '</tbody></table>';

// Return the table as part of the JSON response
echo json_encode(['status' => 'success', 'table' => $table]);

} catch (PDOException $e) {
// Handle any exceptions and return an error message
echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
}else if($action == "show"){
    $id = htmlspecialchars($_POST['id']);
    $sql = "select * from user_profiles where id = :id";
    try{
        $stmt = $pdo->prepare($sql);
        $params = [
            ':id' => $id,
        ];
        if($stmt->execute($params)){
            $result = $stmt->fetch(PDO:: FETCH_ASSOC);
            echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully', 'record' => $result]);
        }else{
            echo json_encode(['status' => 'error', 'message' => 'Record not deleted']);
        }
    }catch(PDOException $e){
        echo json_encode(['status' => 'error', 'message' => "Error!" . $e->getMessage()]);
    }
}else if($action == "update"){
    // Get POST data and sanitize it
    $id = htmlspecialchars($_POST['userId']);
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $gender = htmlspecialchars($_POST['gender']);
    $dob = htmlspecialchars($_POST['dob']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address_line1 = htmlspecialchars($_POST['address_line1']);
    $address_line2 = htmlspecialchars($_POST['address_line2']);
    $city = htmlspecialchars($_POST['city']);
    $state = htmlspecialchars($_POST['state']);
    $zip_code = htmlspecialchars($_POST['zip_code']);
    $country = htmlspecialchars($_POST['country']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);
    $role = htmlspecialchars($_POST['role']);

    // Handle file upload (profile picture)
    $profile_picture = ''; // Default to empty, no new file uploaded yet

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        // Define the allowed file types and max file size
        $allowedTypes = ['image/jpeg', 'image/png'];
        $maxSize = 1 * 1024 * 1024; // 5MB

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

        // Move the file to the uploads directory
        $uploadDir = '../assets/uploads/';
        $fileName = uniqid() . '.' . pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $filePath = $uploadDir . $fileName;
        
        // Move the uploaded file to the destination folder
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $filePath)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload file.']);
            exit;
        }

        // Set the profile picture file path to store in the database
        $profile_picture = $fileName;
    }

    // Update query
    $sql = "UPDATE user_profiles 
            SET first_name = :first_name, 
                last_name = :last_name, 
                gender = :gender, 
                dob = :dob, 
                email = :email, 
                phone = :phone, 
                address_line1 = :address_line1, 
                address_line2 = :address_line2, 
                city = :city, 
                state = :state, 
                zip_code = :zip_code, 
                country = :country, 
                profile_picture = :profile_picture, 
                username = :username, 
                password = :password, 
                role = :role 
            WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        // Bind parameters to prevent SQL injection
        $params = [
            ':id' => $id,
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
            ':profile_picture' => $profile_picture,
            ':username' => $username,
            ':password' => $password,
            ':role' => $role
        ];

        // Execute the query
        if ($stmt->execute($params)) {
            echo json_encode(['status' => 'success', 'message' => 'Record updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Record not updated']);
        }
    } catch(PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => "Error! " . $e->getMessage()]);
    }
}else if($action == "submit"){
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
    $maxSize = 1 * 1024 * 1024; // 5MB

    // Validate file type
    if (!in_array($_FILES['profile_picture']['type'], $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPEG and PNG are allowed.']);
        exit;
    }

    // Validate file size
    if ($_FILES['profile_picture']['size'] > $maxSize) {
        // echo json_encode(['status' => 'success', 'message' => 'User profile created successfully!']);
        echo json_encode(['status' => 'error', 'message' => 'File size exceeds the limit of 5MB.']);
        exit;
    }
    list($width, $height) = getimagesize($_FILES['profile_picture']['tmp_name']);
    $maxWidth = 1000;  // Define maximum allowed width (in pixels)
    $maxHeight = 1000; // Define maximum allowed height (in pixels)

    if ($width > $maxWidth || $height > $maxHeight) {
        echo json_encode(['status' => 'error', 'message' => 'Image dimensions exceed the allowed limits of 1000x1000 pixels.']);
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
}
?>