<?php 

require_once '../../../config/db/database.php';
require_once '../../../php-jwt-master/JwtHandler.php';
require_once '../../model/Merchants/merchant.php';

header("Access-Control-Allow-Methods: POST");

$header = getallheaders();
$jwt = $header["Authorization"];
$jwt_token = new JwtHandler;
$current_user = $jwt_token->_jwt_decode_data($jwt);

$data = json_decode(file_get_contents("php://input"));
 
 $from = $data->from;
 $send_name = $data->send_name;
 $to = $data->to;
 $to_name = $data->to_name;
 $subject = $data->subject;
 $body1 = $data->body;
 $cc = $data->cc;
 $cc_name = $data->cc_name;


 $curr_email = $current_user->email;
 $curr_id = $current_user->id;

 $mer =  new Merchant();

 $db = new Database();
 $db = $db->get_connection();

 $result = $mer->send_mail($from,$send_name,$to,$to_name,$subject,$body1,$curr_email,$curr_id,$cc,$cc_name,$db);

 if($result)
 {
    $response = array(
        'message'=>'sign in successfully',
        'status_code'=>'200'
    );
    http_response_code(200);
    echo json_encode($response);
 }
 else
 {

    $response = array(
        'message'=>'sign in failed',
        'status_code'=>'409'
    );
    http_response_code(409);
    echo json_encode($response);
 
}
?>