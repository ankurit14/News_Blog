<?php
    require_once('../view/connection.inc.php');
    
    $action = htmlspecialchars(trim($_POST['action']));
    if($action == "submit"){
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars($_POST['description']);
    $shortDescription = htmlspecialchars($_POST['shortDescription']);
    $longDescription = htmlspecialchars($_POST['longDescription']);
    $stmt = $pdo->prepare("INSERT INTO tbl_post_field_limits (field_name, word_limit) VALUES (?, ?)");
    try{
       // Insert title limit
       $stmt->execute(['Title', $title]);

       // Insert description limit
       $stmt->execute(['Description', $description]);

       // Insert short description limit
       $stmt->execute(['Short Description', $shortDescription]);

       // Insert long description limit
       $stmt->execute(['Long Description', $longDescription]);

       echo json_encode(["status" => "success", "message" => "Record inserted successfully"]);
    }catch(PDOException $e){
            echo json_encode(["status" => "error", "message" => "Error!" . $e->getMessage()]);
    }
}else if($action == "load"){
        try{
        $sql = "SELECT * from tbl_post_field_limits";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Return the table as part of the JSON response
echo json_encode(['status' => 'success', 'result' => $result]);

} catch (PDOException $e) {
// Handle any exceptions and return an error message
echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
}else if($action == "active"){
    $id = htmlspecialchars($_POST['id']);
    $status = htmlspecialchars($_POST['status']);
    $sql = "update tbl_tag set status = :status WHERE id = :id";
    try{
        $stmt = $pdo->prepare($sql);
        $params = [
            ":id" => $id,
            ":status" => $status,
        ];
        if($stmt->execute($params)) {
            echo json_encode(['status' => 'success', 'message' => 'Record updated succesfully', 'newStatus' => $status]);
        }else {
            echo json_encode(['status' => 'error', 'message' => 'Record not inserted successfully!']);
        }   
    } catch(PDOException $e){
        echo json_encode(["status" => "error", "message" => "Error!" . $e->getMessage()]);
    }
}else if($action == "delete"){
    $id = htmlspecialchars($_POST['id']);
    $sql = "DELETE from tbl_tag where id = :id";
    try{
        $stmt = $pdo->prepare($sql);
        $params = [
            ':id' => $id,
        ];
        if($stmt->execute($params)){
            echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully']);
        }else{
            echo json_encode(['status' => 'error', 'message' => 'Record not deleted']);
        }
    }catch(PDOException $e){
        echo json_encode(['status' => 'error', 'message' => "Error!" . $e->getMessage()]);
    }
}else if($action == "show"){
    $id = htmlspecialchars($_POST['id']);
    $sql = "select * from tbl_tag where id = :id";
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
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars($_POST['description']);
    $shortDescription = htmlspecialchars($_POST['shortDescription']);
    $longDescription = htmlspecialchars($_POST['longDescription']);
    try {
        // Prepare the update statement
        $stmt = $pdo->prepare("UPDATE tbl_post_field_limits SET word_limit = ? WHERE field_name = ?");
    
        // Update Title limit
        $stmt->execute([$title, 'Title']);
    
        // Update Description limit
        $stmt->execute([$description, 'Description']);
    
        // Update Short Description limit
        $stmt->execute([$shortDescription, 'Short Description']);
    
        // Update Long Description limit
        $stmt->execute([$longDescription, 'Long Description']);
    
        echo json_encode(["status" => "success", "message" => "Record updated successfully"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error! " . $e->getMessage()]);
    }
}





?>