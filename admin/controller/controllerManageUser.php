<?php
    require_once('../view/connection.inc.php');
    $action = htmlspecialchars(trim($_POST['action']));
    if($action == "submit"){
    $CategoryName = htmlspecialchars(trim($_POST['Category_name']));
    $CategoryDescription = htmlspecialchars($_POST['Category_description']);
    $sql = "INSERT INTO categories(category_name,category_description) values(:category_name,:category_description)";
    try{
        $stmt = $pdo->prepare($sql);
        $params = [
            ":category_name" => $CategoryName,
            ":category_description" => $CategoryDescription,
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
}else if($action == "active"){
    $id = htmlspecialchars($_POST['id']);
    $status = htmlspecialchars($_POST['status']);
    $sql = "update user_profiles set status = :status WHERE id = :id";
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
    $sql = "DELETE from user_profiles where id = :id";
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
    $id = htmlspecialchars($_POST['catid']);
    $CategoryName = htmlspecialchars(trim($_POST['Category_name']));
    $CategoryDescription = htmlspecialchars($_POST['Category_description']);
    $sql = "update categories set category_name = :category_name,category_description = :category_description where id = :id";
    try{
        $stmt = $pdo->prepare($sql);
        $params = [
            ':id' => $id,
            ':category_name' => $CategoryName,
            ':category_description' => $CategoryDescription 
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