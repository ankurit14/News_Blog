<?php
    require_once('../view/connection.inc.php');
    $action = htmlspecialchars(trim($_POST['action']));
    if($action == "submit"){
    $tagName = htmlspecialchars(trim($_POST['tag_name']));
    $tagDescription = htmlspecialchars($_POST['tag_description']);
    $sql = "INSERT INTO tbl_tag(tag_name,tag_description) values(:tag_name,:tag_description)";
    try{
        $stmt = $pdo->prepare($sql);
        $params = [
            ":tag_name" => $tagName,
            ":tag_description" => $tagDescription,
        ];
        if($stmt->execute($params)){
            echo json_encode(["status" => "success", "message" => "Record inserted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Record not inserted successfully!"]);
        }
    }catch(PDOException $e){
            echo json_encode(["status" => "error", "message" => "Error!" . $e->getMessage()]);
    }
    }else if($action == "load"){
        try{
        $sql = "SELECT * from tbl_tag";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $table = '<table class="table table-bordered table-responsive">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>';

// Loop through the tags and create table rows
foreach ($tags as $key => $tag) {
    $recid = $tag['id'];
    $statusClass = ($tag['status'] == 1) ? 'btn-success' : 'btn-warning';
    $statusText = ($tag['status'] == 1) ? 'Active' : 'Inactive';
    $toggleStatus = ($tag['status'] == 1) ? 0 : 1; // Toggle between 1 and 0

    $table .= '<tr id="row_' . $tag['id'] . '">
                  <td>' . ($key + 1) . '</td>
                  <td>' . htmlspecialchars($tag['tag_name']) . '</td>
                  <td>' . htmlspecialchars($tag['tag_description']) . '</td>
                  <td>
                    <!-- Use button for status toggle -->
                    <button id="status"  class="btn ' . $statusClass . ' btn-sm" data-id="' . $tag['id'] . '" onclick="toggleStatus(' . $tag['id'] . ')">
                        ' . $statusText . '
                    </button>
                  </td>
                  <td>
                    <button id="btnEdit" class="btn btn-info btn-sm" data-value ="' . $tag['id'] .'">Edit</button>
                    <button id="btnDelete" class="btn btn-danger btn-sm" data-value ="' . $tag['id'] .'">Delete</button>
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
    $id = htmlspecialchars($_POST['catid']);
    $tagName = htmlspecialchars(trim($_POST['tag_name']));
    $tagDescription = htmlspecialchars($_POST['tag_description']);
    $sql = "update tbl_tag set tag_name = :tag_name,tag_description = :tag_description where id = :id";
    try{
        $stmt = $pdo->prepare($sql);
        $params = [
            ':id' => $id,
            ':tag_name' => $tagName,
            ':tag_description' => $tagDescription 
        ];
        if($stmt->execute($params)){
            echo json_encode(['status' => 'success', 'message' => 'Record updated successfully']);
            
        }else{
            echo json_encode(['status' => 'error', 'message' => 'Record not updated']);
        }
    }catch(PDOException $e){
        echo json_encode(['status' => 'error', 'message' => "Error!" . $e->getMessage()]);
    }
}





?>