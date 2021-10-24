<?php 
require_once '../../../config/db/database.php';
require_once '../../model/Admin/admin.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$email = $data->email;
$password = $data->password;
$confrim_pass = $data->confrim_pass;
$valid=true;

if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $valid = false;
    $response = array(
        'message' => 'Invalid email format',
        'status_code'=> '409'
    );
    http_response_code(409);
    echo json_encode($response);
}

if($password != $confrim_pass)
{
    $valid = false;
    $response = array(
        'message' => 'Password does not match',
        'status_code'=> '409'
    );
    http_response_code(409);
    echo json_encode($response);
}

if((isset($email)&&isset($password)&&isset($confrim_pass)&&($valid==true)))
{

     $d=new DataBase();
     $d=$d->get_connection();

     $admin=new Admin();
     
     $result = $admin->sign_up($name,$email,$password,$d);
     
     if($result==true)
     {
          //$jwt = new JwtHandler();
          //$token = $jwt->_jwt_encode_data('http://localhost/EMS-TEAM-B-main/ems/public/api/user/',array("email"=>$email,"password"=>$password));
          $response = array(
              'message' => 'Sign up Successfully',
              'status_code' =>'200'
          );
          http_response_code(200);
          echo json_encode($response);
     }
     
     if($result==false)
     {
          $response = array(
           'message'=>'sign up was unsuccessful',
           'status_code'=>'406'
          );
          http_response_code(406);
          echo json_encode($resposne);
     }
    }
    ?>