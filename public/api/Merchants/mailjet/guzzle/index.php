<?php
require_once "vendor/autoload.php";
require_once '../../../../../config/db/database.php';
require_once '../../../../../php-jwt-master/JwtHandler.php';

header("Access-Control-Allow-Methods: POST");

$header = getallheaders();
$jwt = $header["Authorization"];
$jwt_token = new JwtHandler;
$current_user = $jwt_token->_jwt_decode_data($jwt);


use GuzzleHttp\Client;
 $data = json_decode(file_get_contents("php://input"));
 $from = $data->from;
 $send_name = $data->send_name;
 $to = $data->to;
 $to_name = $data->to_name;
 $subject = $data->subject;
 $body1 = $data->body;

$body = [
    'Messages' => [
        [
        'From' => [
            'Email' => $data->from,
            'Name' => $data->send_name
        ],
        'To' => [
            [
                'Email' => $data->to,
                'Name' => $data->to_name
            ]
        ],
        'Cc' => [
            [
                'Email' => $data->cc,
                'Name' => $data->cc_name
            ]
        ],
        'Subject' => $data->subject,
        'HTMLPart' => $data->body
        ]
    ]
];
  
$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://api.mailjet.com/v3.1/',
]);
  
$response = $client->request('POST', 'send', [
    'json' => $body,
    'auth' => ['d5b0192304df36d3619a181998d7d071', 'a412278bf504580738b9d0f0492fb4e6']
]);
  
if($response->getStatusCode() == 200) {
    $db = new Database();
    $db = $db->get_connection();

    $query = "INSERT INTO request (from_email,to_email,subject,body) VALUES ('$from','$to','$subject','$body1');";
    $db->query($query);

    $query = "SELECT * FROM merchant WHERE email = '$current_user->email'";
    $result = $db->query($query);
    $result = $result->fetch_array();

    $payment = $result['credit'];
    $payment = $payment-0.0489;

    $query = "UPDATE merchant SET credit = '$payment' WHERE email = '$current_user->email';";
    $db->query($query);
    
    $query = "INSERT INTO bill (Balance,merchant_id) VALUES ('$payment','$current_user->id');";
    $result = $db->query($query);
    
    $body = $response->getBody();
    $response = json_decode($body);
    if ($response->Messages[0]->Status == 'success') {
        echo "Email sent successfully.";
    }
}