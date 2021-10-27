<?php 
require_once '../../../config/db/database.php';
require_once '../../../php-jwt-master/JwtHandler.php';
require_once '../../model/Merchants/merchant.php';

$header = getallheaders();
if($header["Authorization"])
{
$jwt = $header["Authorization"];
    if (!empty($jwt)) {
        if (preg_match('/Bearer\s(\S+)/', $jwt, $matches)) {
            $jwt_token = new JwtHandler;
            $current_user = $jwt_token->_jwt_decode_data($matches[1]);
        }
    }
}
else{
    echo "token is required";
    exit;
}
$data = json_decode(file_get_contents("php://input"));



$name = $data->name;
$email = $data->email;
$password = $data->password;

$checking_listing = $data->check;
$billing_info = $data->info;

$db = new Database();
$db = $db->get_connection();

$mer = new Merchant();

$result = $mer->add_secondary_user($name,$email,$password,$checking_listing,$billing_info,$db,$current_user->id);
 
  if($result)
  {
    $response = array(
        'message'=>'Secondary user added successfully',
        'status_code'=>'200'
    );
    http_response_code(200);
    echo json_encode($response);
  }
  else
  {
    $response = array(
        'message'=>'FAILED',
        'status_code'=>'409'
    );
    http_response_code(409);
    echo json_encode($response);
  }

?>