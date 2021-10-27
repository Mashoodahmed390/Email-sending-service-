<?php 
require_once('../../../Stripe/vendor/autoload.php');
require_once '../../../php-jwt-master/JwtHandler.php';
require_once '../../../config/db/database.php';
require_once '../../model/Merchants/merchant.php';


$header = getallheaders();
$jwt = $header["Authorization"];
$jwt_token = new JwtHandler;
$current_user = $jwt_token->_jwt_decode_data($jwt);

$data = json_decode(file_get_contents("php://input"));

\Stripe\Stripe::setApiKey("sk_test_51Jp5tPEHteAtQ3Yh4VhcDgvSgS80kdXhTtG0o9qc5oSR09B7fZZbX44z1q9GhXMfP6Wohnot9Z6JNUHTfJIrtDAV000BXpQyfY");

$amount = $data->amount * 100;
$credit_number = $data->credit_number;
$exp_year = $data->exp_year;
$exp_month = $data->exp_month;
$cvc = $data->cvc;

if(!empty($amount)&&!empty($credit_number)&&!empty($exp_year)&&!empty($exp_month)&&!empty($cvc))
{

$stripe = new \Stripe\StripeClient("sk_test_51Jp5tPEHteAtQ3Yh4VhcDgvSgS80kdXhTtG0o9qc5oSR09B7fZZbX44z1q9GhXMfP6Wohnot9Z6JNUHTfJIrtDAV000BXpQyfY");

$token = $stripe->tokens->create([
    'card' => [
      'number' => $credit_number,
      'exp_month' => $exp_month,
      'exp_year' => $exp_year,
      'cvc' => $cvc,
    ],
  ]);


$customer = $stripe->customers->create([
    'description' => "your name is $current_user->name",
    'email' => $current_user->email,
    // 'payment_method' => 'pm_card_visa',
    'source'=>$token
]);

$charge = \Stripe\Charge::create(array(
    "amount" => $amount,
    "currency"=> "usd",
    "description"=>"your money has been deducted",
    "customer"=> $customer->id
));

$db = new Database();
$db = $db->get_connection();

$mer = new Merchant();
$mer->set_merchant($current_user->id,$current_user->name,$current_user->email,$current_user->password,$current_user->credit);

$result = $mer->add_credit(($charge->amount/100),$charge->id,$db);
if($result)
{
    $response = array(
        "message"=>"Transcation successful",
        "status_code"=>"200"
    );

    echo json_encode($response);
}
else
{
    $response = array(
        "message"=>"Something went wrong",
        "status_code"=>"406"
    );
     http_response_code(406);
     echo json_encode($response);
}
}
else
{
    $response = array(
        "message"=>"Please fill all parameters",
        "status_code"=>"406"
    );
    http_response_code(406);
    echo json_encode($response);

    
}

?>