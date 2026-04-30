 <?php

class AdminController {

  public static function createDepartment($conn,$data){

    $name = $data['name'] ?? '';

    $conn->query("INSERT INTO departments(name) VALUES('$name')");

    echo json_encode(["status"=>"success","message"=>"Department created"]);
  }

  public static function getDepartments($conn){

    $res = $conn->query("SELECT * FROM departments");

    $arr=[];
    while($row=$res->fetch_assoc()) $arr[]=$row;

    echo json_encode($arr);
  }

  public static function createUser($conn,$data){


    if(!$data){
        echo json_encode([
            "status"=>"error",
            "message"=>"No data received"
        ]);
        return;
    }

    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $password = password_hash($data['password'] ?? '', PASSWORD_DEFAULT);
    $role = $data['role'] ?? 'student';
    $department_id = $data['department_id'] ?? null;

    if($department_id === "") $department_id = null;

    $sql = "INSERT INTO users(name,email,password,role,department_id)
            VALUES('$name','$email','$password','$role',".($department_id ? $department_id : "NULL").")";

    if($conn->query($sql)){
        echo json_encode([
            "status"=>"success",
            "message"=>"User created"
        ]);
    } else {
        echo json_encode([
            "status"=>"error",
            "message"=>$conn->error
        ]);
    }
  }

  public static function getAllRequests($conn){

    $sql = "SELECT cr.id, u.name as student_name, cr.status
            FROM clearance_requests cr
            JOIN users u ON cr.student_id = u.id";

    $res = $conn->query($sql);

    $arr=[];
    while($r=$res->fetch_assoc()) $arr[]=$r;

    echo json_encode($arr);
  }
} 
