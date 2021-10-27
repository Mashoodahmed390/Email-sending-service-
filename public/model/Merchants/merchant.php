<?php
require_once "../../api/Merchants/mailjet/guzzle/vendor/autoload.php";
use GuzzleHttp\Client;
class Merchant
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $credit;
    private $token;

    public function set_merchant($id,$name,$email,$password,$credit)
    {

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->credit = $credit;
    }

    public function set_token($token)
    {
        $this->token = $token;
    }
    
    public function get_token()
    {
       return $this->token;
    }
    
    public function get_merchant()
    {
        $merchant = array(
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "password"=> $this->password,
            "credit"=> $this->credit
        );

        return $merchant;
    }

    public function sign_up($name,$email,$password,$db)
    {
        $query = "INSERT INTO merchant (name,password,email) VALUES ('$name','$password', '$email');";
        $result = $db->query($query);
        
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function sign_in($email,$password,$db)
    {
        $query = "SELECT * FROM merchant WHERE email='$email' AND password = '$password'";
        
        $result = $db->query($query);
        
        $result1 = $result->fetch_array();
        
        $id = $result1['id'];
        $name = $result1['name'];
        $email = $result1['email'];
        $password = $result1['password'];
        $credit = $result1['credit'];

        $this->set_merchant($id,$name,$email,$password,$credit);


        if($result->num_rows > 0)
        {
            $jwt = new JwtHandler();
            $token = $jwt->_jwt_encode_data('http://localhost/',$this->get_merchant());

            $this->set_token($token);

            $query = "UPDATE merchant SET token = '$token' WHERE email='$email' AND password ='$password'";
            $result = $db->query($query);
           
            return $result;
        }
        else
        {
            return false;
        }
    }
    public function send_mail($from,$send_name,$to,$to_name,$subject,$body1,$curr_email,$curr_id,$cc,$cc_name,$db)
    {

        
$body = [
    'Messages' => [
        [
        'From' => [
            'Email' => "iamkaithebest@gmail.com",
            'Name' => "Mashood ahmed"
        ],
        'To' => [
            [
                'Email' => "iamkaithebest@gmail.com",
                'Name' => "Mashood ahmed"
            ]
        ],
        'Subject' => "Greetings from Mailjet.",
        'HTMLPart' => "<h3>Dear User, welcome to Mailjet!</h3><br />May the delivery force be with you!"
        ]
    ]
];
  
$ch = curl_init();
  
curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json')
);
curl_setopt($ch, CURLOPT_USERPWD, "d5b0192304df36d3619a181998d7d071:a412278bf504580738b9d0f0492fb4e6");
$server_output = curl_exec($ch);
curl_close ($ch);
  
$response = json_decode($server_output);
if ($response->Messages[0]->Status == 'success') {
    echo "Email sent successfully.";
}

$body = [
    'Messages' => [
        [
        'From' => [
            'Email' => $from,
            'Name' => $send_name
        ],
        'To' => [
            [
                'Email' => $to,
                'Name' => $to_name
            ]
        ],
        'Cc' => [
            [
                'Email' => $cc,
                'Name' => $cc_name
            ]
        ],
        'Subject' => $subject,
        'HTMLPart' => $body1
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
    
    $query = "INSERT INTO request (from_email,to_email,subject,body,merchant_id,cc) VALUES ('$from','$to','$subject','$body1','$curr_id','$cc');";
    $db->query($query);

    $query = "SELECT * FROM merchant WHERE email = '$curr_email'";
    $result = $db->query($query);
    $result = $result->fetch_array();

    $payment = $result['credit'];
    $payment = $payment-0.0489;

    $query = "UPDATE merchant SET credit = '$payment' WHERE email = '$curr_email';";
    $db->query($query);
    
    $query = "INSERT INTO bill (Balance,merchant_id) VALUES ('$payment','$curr_id');";
    $result = $db->query($query);
    
    $body = $response->getBody();
    $response = json_decode($body);
    if ($response->Messages[0]->Status == 'success') 
    {
        return true;
    }
}
    }

    public function add_secondary_user($name,$email,$password,$checking,$billing,$db,$c_id)
    {

        $checking_listing = false;
        $billing_info = false;
        $add_user = false;

        if(isset($checking))
        {
            if($checking)
            {
                $checking_listing = true;
            }

        }
        if(isset($billing))
        {
            if($billing)
            {
                $billing_info = true;
            }
        }
        if(isset($add))
        {
            if($add)
            {
                $add_user = true;
            }
        }
        

        $query = "INSERT INTO secondary_user (name,email,password,check_listing,billing_info,merchant_id) VALUES('$name','$email','$password','$checking_listing','$billing_info','$c_id')";
        if($db->query($query))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function view_request_list($db,$c_id)
    {
      
        $query = "SELECT * FROM request WHERE merchant_id = '$c_id'";
        $result = $db->query($query);

        if($result)
        {
            return $result;
        }
        else
        {
            return false;
        }

    }
    public function view_bill_list($db,$c_id)
    {
      
        $query = "SELECT * FROM bill WHERE merchant_id = '$c_id'";
        $result = $db->query($query);

        if($result)
        {
            return $result;
        }
        else
        {
            return false;
        }

    }
    public function add_credit($credit,$charge_id,$db)
    {
        $result = $this->credit + $credit;
        $query = "INSERT INTO bill(Balance,C_D,merchant_id) VALUES($result,1,$this->id)";
        $db->query($query);
        
        $query = "UPDATE merchant SET credit = '$result', charged_id = '$charge_id' WHERE email = '$this->email'";
        $result = $db->query($query);

        return $result;
    }
}


?>