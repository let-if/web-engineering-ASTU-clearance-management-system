 <?php
class AuthController {

  public static function register($conn,$data){
    $name=$data['name'];
    $email=$data['email'];
    $password=password_hash($data['password'],PASSWORD_DEFAULT);

    $conn->query("INSERT INTO users(name,email,password,role) VALUES('$name','$email','$password','student')");

    echo json_encode(["status"=>"success","message"=>"Registered"]);
  }

  public static function login($conn,$data){
    $email=$data['email'];
    $password=$data['password'];

    $res=$conn->query("SELECT * FROM users WHERE email='$email'");
    $user=$res->fetch_assoc();

    if($user && password_verify($password,$user['password'])){
      echo json_encode(["status"=>"success","user"=>$user]);
    } else {
      echo json_encode(["status"=>"error","message"=>"Invalid credentials"]);
    }
  }
} 
