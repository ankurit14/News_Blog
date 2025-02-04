<?php
require_once('../view/connection.inc.php');
// $pdo = new PDO("mysql:host=localhost;dbname=tishha", "root", "");
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Check if form is submitted
$action = htmlspecialchars(trim($_POST['action']));

if ($action === 'delete') {
    $id = htmlspecialchars(trim($_POST['id']));
    $sql = "DELETE FROM posts WHERE id = :id";
    try {
        $stmt = $pdo->prepare($sql);
        $params = [':id' => $id];
        if ($stmt->execute($params)) {
            // Redirect to post list page if delete is successful
            echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Record not deleted']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => "Error!" . $e->getMessage()]);
    }
}else if ($action == "load") {
    try {
        $sql = "SELECT * from posts";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $table = '<table class="table table-bordered table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Post Title</th>
            <th>Status/Visibility</th>
            <th>Publish</th>
            <th>Tagby</th>
            <th>Author</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>';

        // Loop through the Categorys and create table rows
        foreach ($posts as $key => $post) {
            $recid = $post['id'];
            // $statusClass = ($post['status'] == 1) ? 'btn-success' : 'btn-warning';
            // $statusText = ($post['status'] == 1) ? 'Active' : 'Inactive';
            // $toggleStatus = ($post['status'] == 1) ? 0 : 1; // Toggle between 1 and 0

            $table .= '<tr id="row_' . $post['id'] . '">
              <td>' . ($key + 1) . '</td>
              <td>' . htmlspecialchars($post['title']) . '</td>
              <td>' . htmlspecialchars($post['status_visibility']) . '</td>
              <td>' . htmlspecialchars($post['publish']) . '</td>
              <td>' . htmlspecialchars($post['tagby']) . '</td>
              <td>' . htmlspecialchars($post['author']) . '</td>
              <td>' .
                '<button class="btn btn-info btn-sm" onclick="window.location.href=\'viewEditPost.php?id=' . $post['id'] . '\'">Edit</button> ' .
                '<button id="btnDelete" class="btn btn-danger btn-sm" data-id =' . $post['id'] .'>Delete</button>' .
                '</td>
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
} else if ($action == "editor") {
    try {
        // SQL to get the word limits for each field
        $sql = "SELECT field_name, word_limit FROM tbl_post_field_limits WHERE field_name in('Short Description','Long Description')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        // Fetch data as an associative array
        $wordLimits = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $wordLimits[$row['field_name']] = $row['word_limit'];
        }

        // Return the result as JSON
        echo json_encode([
            'status' => 'success',
            'data' => $wordLimits
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else if ($action == "show") {
    $id = htmlspecialchars($_POST['id']);
    $sql = "select * from posts where id = :id";
    try {
        $stmt = $pdo->prepare($sql);
        $params = [
            ':id' => $id,
        ];
        if ($stmt->execute($params)) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully', 'record' => $result]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Record not deleted']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => "Error!" . $e->getMessage()]);
    }
} else if ($action == "update") {
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
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => "Error! " . $e->getMessage()]);
    }
} else if ($action == "submit") {
    // Sanitize and validate form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $shortDescription = $_POST['shortDescription'];  // This will contain HTML content from TinyMCE
    $longDescription = $_POST['longDescription'];   // This will contain HTML content from TinyMCE
    $statusVisibility = $_POST['statusVisibility'];
    $stickyRadios = $_POST['stickyRadios'];
    $publishRadios = $_POST['publishRadios'];
    $dateString = $_POST['datepicker'];

    // Check if date is not empty
    if (!empty($dateString)) {
        // Try to create DateTime object with provided format
        $date = DateTime::createFromFormat('d/m/Y', $dateString);

        if ($date) {
            // If the date is valid, format it as YYYY-MM-DD
            $datepicker = $date->format('Y-m-d');
        } else {
            // If the date format is invalid, return an error
            echo json_encode(['status' => 'error', 'message' => 'Invalid date format']);
            exit;
        }
    } else {
        // If no date is provided, set the date to null or handle accordingly
        $datepicker = null;  // Or you can set a default date, e.g., '1970-01-01'
    }
    $timepicker = $_POST['timepicker'];
    $amp = $_POST['amp'];
    // $tag = $_POST['tag'];
    $tagby = $_POST['tagby'];
    $author = $_POST['author'];
    $tags = isset($_POST['tag']) ? $_POST['tag'] : [];

    // Convert array to comma-separated string
    $tagsString = implode(',', $tags);

    // Handle file upload for images
    $uploadDir = '../assets/uploads/';
    $allowedTypes = ['image/jpeg', 'image/png'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    $files = [
        'postImage' => '',
        'facebookImage' => '',
        'instagramImage' => '',
        'whatsappImage' => ''
    ];

    // Image size restrictions (height, width in pixels)
    $maxWidth = 4000;  // Max width in pixels
    $maxHeight = 4000;  // Max height in pixels

    foreach ($files as $key => &$fileName) {
        if (isset($_FILES[$key]) && $_FILES[$key]['error'] == 0) {
            // Validate file type
            if (!in_array($_FILES[$key]['type'], $allowedTypes)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid file type for ' . $key . '. Only JPEG and PNG are allowed.']);
                exit;
            }

            // Validate file size
            if ($_FILES[$key]['size'] > $maxSize) {
                echo json_encode(['status' => 'error', 'message' => 'File size exceeds the limit for ' . $key . '.']);
                exit;
            }

            // Get image dimensions
            list($width, $height) = getimagesize($_FILES[$key]['tmp_name']);

            // Check if image dimensions are within the allowed size
            if ($width > $maxWidth || $height > $maxHeight) {
                echo json_encode(['status' => 'error', 'message' => 'Image dimensions exceed the allowed limit for ' . $key . '. Max width: ' . $maxWidth . 'px, Max height: ' . $maxHeight . 'px.']);
                exit;
            }

            // Generate unique file name and move the uploaded file
            $fileName = uniqid() . '.' . pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION);
            $filePath = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES[$key]['tmp_name'], $filePath)) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload ' . $key . '.']);
                exit;
            }
        }
    }



    // Insert data into the database
    $sql = "INSERT INTO posts
                (title, description, short_description, long_description, status_visibility, sticky, publish, datepicker, timepicker, amp, tag, tagby, author, post_image, facebook_image, instagram_image, whatsapp_image)
                VALUES
                (:title, :description, :short_description, :long_description, :status_visibility, :sticky, :publish, :datepicker, :timepicker, :amp, :tag, :tagby, :author, :post_image, :facebook_image, :instagram_image, :whatsapp_image)";

    try {
        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Array of parameters (key => value)
        $params = [
            ':title' => $title,
            ':description' => $description,
            ':short_description' => $shortDescription,
            ':long_description' => $longDescription,
            ':status_visibility' => $statusVisibility,
            ':sticky' => $stickyRadios,
            ':publish' => $publishRadios,
            ':datepicker' => $datepicker,
            ':timepicker' => $timepicker,
            ':amp' => $amp,
            ':tag' =>  $tagsString,  // Convert tags array to string
            ':tagby' => $tagby,
            ':author' => $author,
            ':post_image' => $files['postImage'],
            ':facebook_image' => $files['facebookImage'],
            ':instagram_image' => $files['instagramImage'],
            ':whatsapp_image' => $files['whatsappImage']
        ];
        // Execute the query with parameters
        if ($stmt->execute($params)) {
            echo json_encode(['status' => 'success', 'message' => 'Post created successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: Could not create post.']);
        }
    } catch (PDOException $e) {
        // Catch and display errors
        echo json_encode(['status' => 'error', 'message' => "Error! Record not saved. " . $e->getMessage()]);
        exit;
    }
}
