 <?php
class DepartmentController {

  // Get requests assigned to this department
  public static function getRequests($conn, $department_id) {

    $sql = "SELECT a.id as approval_id, cr.id as request_id, u.name as student_name, a.status
            FROM approvals a
            JOIN clearance_requests cr ON a.request_id = cr.id
            JOIN users u ON cr.student_id = u.id
            WHERE a.department_id = $department_id";

    $res = $conn->query($sql);

    $data = [];
    while($row = $res->fetch_assoc()){
      $data[] = $row;
    }

    echo json_encode($data);
  }

 
  public static function updateStatus($conn, $data) {

    $approval_id = $data['approval_id'];
    $status = $data['status'];
    $comment = $data['comment'] ?? null;

    // 1. Update approval WITH comment
    $stmt = $conn->prepare("
        UPDATE approvals 
        SET status=?, comment=? 
        WHERE id=?
    ");
    $stmt->bind_param("ssi", $status, $comment, $approval_id);
    $stmt->execute();

    // 2. Get request_id
    $res = $conn->query("SELECT request_id FROM approvals WHERE id=$approval_id");
    $row = $res->fetch_assoc();
    $request_id = $row['request_id'];

    // 3. Check all approvals
    $check = $conn->query("SELECT 
        SUM(status='approved') as approved,
        COUNT(*) as total,
        SUM(status='rejected') as rejected
        FROM approvals
        WHERE request_id=$request_id");

    $c = $check->fetch_assoc();

    // 4. Update final request status
    if($c['rejected'] > 0){
        $conn->query("UPDATE clearance_requests SET status='rejected' WHERE id=$request_id");
    } elseif($c['approved'] == $c['total']){
        $conn->query("UPDATE clearance_requests SET status='approved' WHERE id=$request_id");
    } else {
        $conn->query("UPDATE clearance_requests SET status='pending' WHERE id=$request_id");
    }

    echo json_encode(["status"=>"success"]);
}
 
} 
