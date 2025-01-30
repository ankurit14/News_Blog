<?php
header('Content-Type: application/json');

if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    
    // Specify the upload directory (use $_SERVER['DOCUMENT_ROOT'] for an absolute path)
    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/tishha_news/view/assets/uploads/';
    
    // Create the upload path
    $uploadPath = $uploadDirectory . basename($file['name']);
    
    // Move the uploaded file
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // Return the path to the uploaded file
        echo json_encode(['location' => 'views/assets/uploads/' . basename($file['name'])]);
    } else {
        echo json_encode(['error' => 'File upload failed']);
    }
} else {
    echo json_encode(['error' => 'No file uploaded']);
}
?>
