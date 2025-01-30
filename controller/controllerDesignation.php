<?php
    require_once('../view/connection.inc.php');
    $action = htmlspecialchars(trim($_POST['action']));
    if($action == "submit"){
    $designationName = htmlspecialchars(trim($_POST['designation_name']));
    $designationDescription = htmlspecialchars($_POST['designation_description']);
    $sql = "INSERT INTO designations(designation_name,designation_description) values(:designation_name,:designation_description)";
    try{
        $stmt = $pdo->prepare($sql);
        $params = [
            ":designation_name" => $designationName,
            ":designation_description" => $designationDescription,
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
        $sql = "SELECT * from designations";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $designations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $table = '<table class="table">
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

// Loop through the designations and create table rows
foreach ($designations as $key => $designation) {
    $recid = $designation['id'];
    $statusClass = ($designation['status'] == 1) ? 'btn-success' : 'btn-warning';
    $statusText = ($designation['status'] == 1) ? 'Active' : 'Inactive';
    $toggleStatus = ($designation['status'] == 1) ? 0 : 1; // Toggle between 1 and 0

    $table .= '<tr id="row_' . $designation['id'] . '">
                  <td>' . ($key + 1) . '</td>
                  <td>' . htmlspecialchars($designation['designation_name']) . '</td>
                  <td>' . htmlspecialchars($designation['designation_description']) . '</td>
                  <td>
                    <!-- Use button for status toggle -->
                    <button id="status"  class="btn ' . $statusClass . ' btn-sm" data-id="' . $designation['id'] . '" onclick="toggleStatus(' . $designation['id'] . ')">
                        ' . $statusText . '
                    </button>
                  </td>
                  <td>
                    <button id="btnEdit" class="btn btn-info btn-sm" data-value ="' . $designation['id'] .'">Edit</button>
                    <button id="btnDelete" class="btn btn-danger btn-sm" data-value ="' . $designation['id'] .'">Delete</button>
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
    $sql = "update designations set status = :status WHERE id = :id";
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
    $sql = "DELETE from designations where id = :id";
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
    $sql = "select * from designations where id = :id";
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
    $id = htmlspecialchars($_POST['desgid']);
    $designationName = htmlspecialchars(trim($_POST['designation_name']));
    $designationDescription = htmlspecialchars($_POST['designation_description']);
    $sql = "update designations set designation_name = :designation_name,designation_description = :designation_description where id = :id";
    try{
        $stmt = $pdo->prepare($sql);
        $params = [
            ':id' => $id,
            ':designation_name' => $designationName,
            ':designation_description' => $designationDescription 
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