<?php
require_once '../../../config/db/database.php';
require_once '../../model/Merchants/merchant.php';
require_once '../../model/Secondary_user/secondary_user.php';
require_once '../../../php-jwt-master/JwtHandler.php';

$header = getallheaders();
$jwt = $header["Authorization"];
$jwt_token = new JwtHandler();
$current_sec_user = $jwt_token->_jwt_decode_data($jwt);

if($current_sec_user->billing_info == 1)
{
    $db = new Database();
    $db = $db->get_connection();
    
    $mer = new Merchant();
    
    $result = $mer->view_bill_list($db,$current_sec_user->merchant_id);
if($result)
{
    http_response_code(200);
while($row = mysqli_fetch_assoc($result))
{
    
    echo json_encode($row);
    
}
}
else
{
    $response = array(
        'message'=> 'Table is empty',
        'status_code'=>'406'
    );
    http_response_code(406);
    echo json_encode($response);
}
}
else{
    $response = array(
        "message"=>"Your merchant has not authorise you for this task",
        "status_code"=>"409"
    );
    http_response_code(409);
    echo json_encode($response);
}
?>