<?php 
require_once '../../../config/db/database.php';
require_once '../../model/Merchants/merchant.php';
require_once '../../../php-jwt-master/JwtHandler.php';

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

     $mer = new Merchant();

     $result = $mer->sign_in($email,$password,$db);
          if($result){    
               
               $response = array(
                   'message'=>'sign in successfully',
                   'status_code'=>'200'
               );
               http_response_code(200);
               echo $mer->get_token()."\n";
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