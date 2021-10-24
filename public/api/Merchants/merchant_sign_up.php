<?php 

require_once '../../../config/db/database.php';
require_once '../../model/Merchants/merchant.php';


$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$email = $data->email;
$password = $data->password;
$confirm_pass = $data->confirm_pass;
$valid = true;
if(!filter_var($email,FILTER_VALIDATE_EMAIL))
{
    $response = array(
        'message'=>'Invalid email format',
        'status_code'=>'409'
    );
    http_response_code(409);
    echo json_encode($response);
}
if($password != $confirm_pass)
{
    $valid = false;
    $response = array(
        'message' => 'Password does not match',
        'status_code'=> '409'
    );
    http_response_code(409);
    echo json_encode($response);
}

if((isset($email)&&isset($password)&&isset($confirm_pass)&&($valid==true)))
{

     $db = new DataBase();
     $db = $db->get_connection();

     $mer=new Merchant();
     
     $result = $mer->sign_up($name,$email,$password,$db);
     
     if($result==true)
     {
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