<?php 
require_once '../../../config/db/database.php';
require_once '../../model/Admin/admin.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
{
     $response = array(
         'message' =>'invalid email format',
         'status_code' => '409'
     );
     http_response_code(409);
     echo json_encode($response);
}
else{
     
     $database = new Database();
     
     $db = $database->get_Connection();

     $admin = new Admin();

     $result = $admin->sign_in($email,$password,$db);
          if($result->num_rows > 0){    
               $row = $result->fetch_assoc();

               $response = array(
                   'message'=>'sign in successfully',
                   'status_code'=>'200'
               );
               http_response_code(200);
               echo json_encode($response);
          }
          else{
          $response = array(
               "status" => 406,
               "message" => "Invalid Username or Password!",
          );
              http_response_code(406);
              echo json_encode($response);
          }
     }
?>