<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../view/connection.inc.php');
require_once("../view/template/top.inc.php");

$id = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;

// If there's no post ID, redirect to another page (or show an error message)
if ($id === null) {
    header("Location: viewPostList.php");
    exit();
}

if ($id !== null && $action === 'delete') {
    $sql = "DELETE FROM posts WHERE id = :id";
    try {
        $stmt = $pdo->prepare($sql);
        $params = [':id' => $id];

        if ($stmt->execute($params)) {
            // Redirect to post list page if delete is successful
            header('Location: viewPostList.php');
            exit(); // Ensure no further code is executed
        } else {
            // If the deletion failed (no rows affected)
            echo "Post not found.";
            header('Location: viewPostList.php');
            exit(); // Ensure no further code is executed
        }
    } catch (PDOException $e) {
        // If there was an error with the query or connection
        header('Location: viewPostList.php');
        exit(); // Make sure the script stops executing after the header
    }
}
?>
