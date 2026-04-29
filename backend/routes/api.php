 <?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit(0);

require_once __DIR__."/../config/db.php";
require_once __DIR__."/../controllers/AuthController.php";
require_once __DIR__."/../controllers/StudentController.php";
require_once __DIR__."/../controllers/DepartmentController.php";
require_once __DIR__."/../controllers/AdminController.php";

// ✅ ALWAYS READ JSON FIRST (FIXED)
$data = json_decode(file_get_contents("php://input"), true) ?? [];
$action = $_GET['action'] ?? '';

switch($action){

    // AUTH
    case 'register':
        AuthController::register($conn,$data);
        break;

    case 'login':
        AuthController::login($conn,$data);
        break;

    // STUDENT
    case 'apply':
        StudentController::apply($conn,$data);
        break;

    case 'requests':
        StudentController::getRequests($conn,$_GET['student_id']);
        break;

    // DEPARTMENT
    case 'dept_requests':
        DepartmentController::getRequests($conn,$_GET['department_id']);
        break;

    case 'dept_update':
        DepartmentController::updateStatus($conn,$data);
        break;

    // ADMIN
    case 'admin_create_department':
        AdminController::createDepartment($conn,$data);
        break;

    case 'admin_departments':
        AdminController::getDepartments($conn);
        break;

    case 'admin_create_user':
        AdminController::createUser($conn,$data);
        break;

    case 'admin_requests':
        AdminController::getAllRequests($conn);
        break;

        echo json_encode([
            "status"=>"error",
            "message"=>"Invalid API route"
        ]);
} 


