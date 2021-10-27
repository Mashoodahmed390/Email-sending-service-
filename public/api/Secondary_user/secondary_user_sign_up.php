<?php 
require_once '../../../config/db/database.php';
require_once '../../model/Secondary_user/secondary_user.php';
require_once '../../../php-jwt-master/JwtHandler.php';

header("Access-Control-Allow-Methods: POST");

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;

$sec_user = new secondary_user();

$db = new Database();
$db = $db->get_connection();


$result = $sec_user->sec_sign_in($email,$password,$db);

if($result)
{
    $response = array(
        "message"=>"Secondary user account login in sussecfully",
        "status"=>"200"
                     );
            http_response_code(200);
            echo $sec_user->get_token()."\n";
            echo  json_encode($response);
}
else
{
    $response = array(
        "message"=>"Secondary user account login in Failed",
        "status"=>"409"
                     );
            http_response_code(409);
            echo  json_encode($response);
}
?>