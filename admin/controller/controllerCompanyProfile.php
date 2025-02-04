<?php
require_once('../view/connection.inc.php');
// $pdo = new PDO("mysql:host=localhost;dbname=tishha", "root", "");
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Check if form is submitted

$action = htmlspecialchars(trim($_POST['action']));
if ($action == "load") {
    try {
        $sql = "select * from tbl_company";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $company_detail = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'record' => $company_detail]);
    } catch (PDOException $e) {
        // Handle any exceptions and return an error message
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}   else if ($action == "update") {
    // Get POST data and sanitize it
    $id = $_POST['compid'];
$owner_name = $_POST['owner_name'];
$company_name = $_POST['company_name'];
$browser_title = $_POST['browser_title'];
$meta_description = $_POST['meta_description'];
$meta_keywords = $_POST['meta_keywords'];
$gst_number = $_POST['gst_number'];
$address = $_POST['address'];
$email = $_POST['email'];
$contact_number = $_POST['contact_number'];
$oldcompany_logo = isset($_POST['companyLogo']) ? $_POST['companyLogo'] : null;
$oldcompany_icon = isset($_POST['companyIcon']) ? $_POST['companyIcon'] : null;

// Handle file upload for images
$uploadDir = '../assets/uploads/';
$companyLogoFile = isset($_FILES['companyLogo']) && $_FILES['companyLogo']['error'] === 0 ? $_FILES['companyLogo'] : null;
$companyIconFile = isset($_FILES['companyIcon']) && $_FILES['companyIcon']['error'] === 0 ? $_FILES['companyIcon'] : null;

$companyLogoName = $oldcompany_logo; // Default to old logo if no new file is uploaded
$companyIconName = $oldcompany_icon; // Default to old icon if no new file is uploaded

if ($companyLogoFile) {
    $companyLogoName = uniqid() . '.' . pathinfo($companyLogoFile['name'], PATHINFO_EXTENSION);
    if (!move_uploaded_file($companyLogoFile['tmp_name'], $uploadDir . $companyLogoName)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload company logo.']);
        exit;
    }
}

if ($companyIconFile) {
    $companyIconName = uniqid() . '.' . pathinfo($companyIconFile['name'], PATHINFO_EXTENSION);
    if (!move_uploaded_file($companyIconFile['tmp_name'], $uploadDir . $companyIconName)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload company icon.']);
        exit;
    }
}

// Update query
$sql = "UPDATE tbl_company 
        SET owner_name          = :owner_name, 
            company_name        = :company_name, 
            company_logo        = :company_logo, 
            company_icon        = :company_icon, 
            browser_title       = :browser_title, 
            meta_description    = :meta_description, 
            meta_keywords       = :meta_keywords, 
            gst_number          = :gst_number, 
            address             = :address, 
            email               = :email, 
            contact_number      = :contact_number
        WHERE id = :id";

try {
    $stmt = $pdo->prepare($sql);
    // Prepare parameters for the query
    $params = [
        ':id'               => $id,
        ':owner_name'       => $owner_name,
        ':company_name'     => $company_name,
        ':browser_title'    => $browser_title,
        ':meta_description' => $meta_description,
        ':meta_keywords'    => $meta_keywords,
        ':gst_number'       => $gst_number,
        ':address'          => $address,
        ':email'            => $email,
        ':contact_number'   => $contact_number,
        ':company_logo'     => $companyLogoName,   // Use the new or old logo name
        ':company_icon'     => $companyIconName,   // Use the new or old icon name
    ];

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
    $owner_name = $_POST['owner_name'];
    $company_name = $_POST['company_name'];
    $browser_title = $_POST['browser_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $gst_number = $_POST['gst_number'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    // $tag = $_POST['tag'];
    $contact_number = $_POST['contact_number'];
    // Handle file upload for images
    $uploadDir = '../assets/uploads/';
    $files = [
        'company_logo' => '',
        'company_icon' => '',
    ];

    foreach ($files as $key => &$fileName) {
        if (isset($_FILES[$key]) && $_FILES[$key]['error'] == 0) {
            $fileName = uniqid() . '.' . pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION);
            $filePath = $uploadDir . $fileName;
            if (!move_uploaded_file($_FILES[$key]['tmp_name'], $filePath)) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload ' . $key . '.']);
                exit;
            }
        }
    }
    // Insert data into the database
    $sql = "INSERT INTO tbl_company
                (owner_name, company_name, company_logo, company_icon, browser_title, meta_description, meta_keywords, gst_number, address, email, contact_number)
                VALUES
                (:owner_name, :company_name, :company_logo, :company_icon, :browser_title, :meta_description, :meta_keywords, :gst_number, :address, :email, :contact_number)";
    try {
        // Prepare the statement
        $stmt = $pdo->prepare($sql);
        // Array of parameters (key => value)
        $params = [
            ':owner_name' => $owner_name,
            ':company_name' => $company_name,
            ':company_logo' => $files['company_logo'],
            ':company_icon' => $files['company_icon'],
            ':browser_title' => $browser_title,
            ':meta_description' => $meta_description,
            ':meta_keywords' => $meta_keywords,
            ':gst_number' => $gst_number,
            ':address' => $address,
            ':email' => $email,
            ':contact_number' =>  $contact_number,  // Convert tags array to string
        ];
        // Execute the query with parameters
        if ($stmt->execute($params)) {
            echo json_encode(['status' => 'success', 'message' => 'Your company has been successfully registered!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: Could not create post.']);
        }
    } catch (PDOException $e) {
        // Catch and display errors
        echo json_encode(['status' => 'error', 'message' => "Error! Record not saved. " . $e->getMessage()]);
        exit;
    }
}
