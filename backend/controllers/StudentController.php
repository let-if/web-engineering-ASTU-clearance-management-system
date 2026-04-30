 <?php
class StudentController {

  public static function apply($conn,$data){
    $student_id = $data['student_id'];

    // 1. Create clearance request
    $conn->query("INSERT INTO clearance_requests(student_id,status) VALUES($student_id,'pending')");
    $request_id = $conn->insert_id;

    // 2. Get departments
    $res = $conn->query("SELECT id FROM departments");

    // 3. Create approvals for each department
    while($dept = $res->fetch_assoc()){
      $conn->query("INSERT INTO approvals(request_id,department_id,status)
                    VALUES($request_id,{$dept['id']},'pending')");
    }

    echo json_encode([
      "status"=>"success",
      "message"=>"Request submitted to all departments"
    ]);
  }


public static function getRequests($conn,$id){

    $sql = "SELECT cr.id, cr.status
            FROM clearance_requests cr
            WHERE cr.student_id=$id";

    $res = $conn->query($sql);

    $arr = [];

    while($r = $res->fetch_assoc()){

        $request_id = $r['id'];

        
        $dept_sql = "SELECT d.name, a.status, a.comment
                     FROM approvals a
                     JOIN departments d ON a.department_id = d.id
                     WHERE a.request_id = $request_id";

        $dept_res = $conn->query($dept_sql);

        $departments = [];
        $approvedCount = 0;
        $totalCount = 0;

        while($d = $dept_res->fetch_assoc()){

            $departments[] = $d;

            $totalCount++;

            if($d['status'] === 'approved'){
                $approvedCount++;
            }
        }

        // ✔ keep status consistent
        if($totalCount > 0 && $approvedCount === $totalCount){
            $r['status'] = "approved";
        }

        $r['departments'] = $departments;
        $r['approved'] = $approvedCount;
        $r['total'] = $totalCount;

        $arr[] = $r;
    }

    echo json_encode($arr);
}

} 
