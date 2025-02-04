<?php
require_once('../view/connection.inc.php');
// $pdo = new PDO("mysql:host=localhost;dbname=tishha", "root", "");
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Check if form is submitted
$action = htmlspecialchars(trim($_POST['action']));
if ($action == "loadtag") {
    try {
        $sql = "SELECT * from tbl_tag";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $table = '';
        // Loop through the Categorys and create table rows
        foreach ($tags as $key => $tag) {
            $table .= '<option value=' . htmlspecialchars($tag['tag_name']) . '>' . htmlspecialchars($tag['tag_name']) . '</option>';
        }
        // End the table HTML
        $table .= '</select>';
        // Return the table as part of the JSON response
        echo json_encode(['status' => 'success', 'table' => $table]);
    } catch (PDOException $e) {
        // Handle any exceptions and return an error message
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else if ($action == "get_limt") {
    try {
        $sql = "SELECT * from tbl_tag";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $table = '';
        // Loop through the Categorys and create table rows
        foreach ($tags as $key => $tag) {
            $table .= '<option value=' . htmlspecialchars($tag['tag_name']) . '>' . htmlspecialchars($tag['tag_name']) . '</option>';
        }
        // End the table HTML
        $table .= '</select>';
        // Return the table as part of the JSON response
        echo json_encode(['status' => 'success', 'table' => $table]);
    } catch (PDOException $e) {
        // Handle any exceptions and return an error message
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else if ($action == "fetchlimit") {
    try {
        // SQL to get the word limits for each field
        $sql = "SELECT field_name, word_limit FROM tbl_post_field_limits";
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
    $sql = "select * from user_profiles where id = :id";
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
    $id = $_POST['postid'];  // Make sure to get the post ID for updating
    $title = $_POST['title'];
    $description = $_POST['description'];
    $shortDescription = $_POST['shortDescription'];  // This will contain HTML content from TinyMCE
    $longDescription = $_POST['longDescription'];   // This will contain HTML content from TinyMCE
    $statusVisibility = $_POST['statusVisibility'];
    $stickyRadios = $_POST['stickyRadios'];
    $publishRadios = $_POST['publishRadios'];
    $datepicker = $_POST['datepicker'];
    $timepicker = $_POST['timepicker'];
    $amp = $_POST['amp'];
    $tagby = $_POST['tagby'];
    $author = $_POST['author'];
    $tags = isset($_POST['tag']) ? $_POST['tag'] : [];
    // Convert array to comma-separated string for tags
    $tagsString = implode(',', $tags);
    $oldPostImage = isset($_POST['postImage']) ? $_POST['postImage'] : null;
$oldFacebookImage = isset($_POST['facebookImage']) ? $_POST['facebookImage'] : null;
$oldInstagramImage = isset($_POST['instagramImage']) ? $_POST['instagramImage'] : null;
$oldWhatsappImage = isset($_POST['whatsappImage']) ? $_POST['whatsappImage'] : null;

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
    // foreach ($_FILES as $key => $file) {
    //     if (!empty($file['name'])) {
            foreach ($files as $key => &$fileName) {
                if (isset($_FILES[$key]) && $_FILES[$key]['error'] == 0) {
            // If a new file is uploaded
            if ($_FILES[$key]['error'] === 0) {
                // Validate file type
                // if (!in_array($file['type'], $allowedTypes)) {
                //     echo json_encode(['status' => 'error', 'message' => 'Invalid file type for ' . $key . '. Only JPEG and PNG are allowed.']);
                //     exit;
                // }
                if ($_FILES[$key]['size'] > $maxSize) {
                    echo json_encode(['status' => 'error', 'message' => 'File size exceeds the limit for ' . $key . '.']);
                    exit;
                }
    
                // Validate file size
                // if ($file['size'] > $maxSize) {
                //     echo json_encode(['status' => 'error', 'message' => 'File size exceeds the limit for ' . $key . '.']);
                //     exit;
                // }
    
                // // Get image dimensions
                // list($width, $height) = getimagesize($file['tmp_name']);
                // if ($width > 4000 || $height > 4000) {
                //     echo json_encode(['status' => 'error', 'message' => 'Image dimensions exceed the allowed limit for ' . $key . '.']);
                //     exit;
                // }
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
                // $fileName = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                // $filePath = $uploadDir . $fileName;
    
                // // Move uploaded file to target directory
                // if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                //     echo json_encode(['status' => 'error', 'message' => 'Failed to upload ' . $key . '.']);
                //     exit;
                // }
                $fileName = uniqid() . '.' . pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION);
            $filePath = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES[$key]['tmp_name'], $filePath)) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload ' . $key . '.']);
                exit;
            }
                // $$key = $fileName; // Save the new file name in a variable like postImage, facebookImage, etc.
            }
        } else {
            // If no new file was uploaded, use the old image
            $$key = $_POST[$key]; // Use the old image file name from the POST data
        }
    }
    
    // Update query
    $sql = "UPDATE posts 
            SET title = :title, 
                description = :description, 
                short_description = :shortDescription, 
                long_description = :longDescription, 
                status_visibility = :statusVisibility, 
                sticky = :stickyRadios, 
                publish = :publishRadios, 
                datepicker = :datepicker, 
                timepicker = :timepicker, 
                amp = :amp, 
                tag = :tags, 
                tagby = :tagby, 
                author = :author, 
                post_image = :postImage, 
                facebook_image = :facebookImage, 
                instagram_image = :instagramImage, 
                whatsapp_image = :whatsappImage
            WHERE id = :id";

try {
    $stmt = $pdo->prepare($sql);
    
    // Prepare parameters for the query
    $params = [
        ':id' => $id,
        ':title' => $title,
        ':description' => $description,
        ':shortDescription' => $shortDescription,
        ':longDescription' => $longDescription,
        ':statusVisibility' => $statusVisibility,
        ':stickyRadios' => $stickyRadios,
        ':publishRadios' => $publishRadios,
        ':datepicker' => $datepicker,
        ':timepicker' => $timepicker,
        ':amp' => $amp,
        ':tags' => $tagsString,
        ':tagby' => $tagby,
        ':author' => $author,
        // Check if a new postImage is uploaded or use the existing image name
        ':postImage' => isset($_FILES['postImage']) && $_FILES['postImage']['error'] === 0 ? $files['postImage'] : $oldPostImage, 
        // Similarly for other images
        ':facebookImage' => isset($_FILES['facebookImage']) && $_FILES['facebookImage']['error'] === 0 ? $files['facebookImage'] : $oldFacebookImage,
        ':instagramImage' => isset($_FILES['instagramImage']) && $_FILES['instagramImage']['error'] === 0 ? $files['instagramImage'] : $oldInstagramImage,
        ':whatsappImage' => isset($_FILES['whatsappImage']) && $_FILES['whatsappImage']['error'] === 0 ?$files['whatsappImage'] : $oldWhatsappImage
    ];

    // Execute the update query
   

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
    $datepicker = $_POST['datepicker'];
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
