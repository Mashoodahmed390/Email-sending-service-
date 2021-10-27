<?php
require_once "../../api/Merchants/mailjet/guzzle/vendor/autoload.php";
use GuzzleHttp\Client;
class Admin
{
     private $id;
     private $name;
     private $email;
     private $password;
     private $token;

     public function set_user($id, $name, $email, $password, $token)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;
    }

    public function get_user()
    {
        $user = array(
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "password" => $this->password,
            "token" => $this->token
        );
        return $user;
    }
   public function sign_up($name,$email,$password,$db)
    {
        $query = "INSERT INTO admin (name,password,email) VALUES ('$name','$password', '$email');";
        $result = $db->query($query);
        if($result)
        {
            return true;
        }
        else{
            return false;
        }
    }
   public function sign_in($email,$password,$db)
    {
        $query = "SELECT name,email FROM admin WHERE email='$email' AND password='$password'";
        $result = $db->query($query);
        if($result)
        {
            return $result;
        }else
        {
            return false;
        }
    }
    public function get_all_merchant($db)
    {
        $query = "SELECT * FROM merchant";
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

    public function send_mail($from,$send_name,$to,$to_name,$subject,$body1)
    {

        
        // $body = [
        //     'Messages' => [
        //         [
        //         'From' => [
        //             'Email' => "iamkaithebest@gmail.com",
        //             'Name' => "Mashood ahmed"
        //         ],
        //         'To' => [
        //             [
        //                 'Email' => "iamkaithebest@gmail.com",
        //                 'Name' => "Mashood ahmed"
        //             ]
        //         ],
        //         'Subject' => "Greetings from Mailjet.",
        //         'HTMLPart' => "<h3>Dear User, welcome to Mailjet!</h3><br />May the delivery force be with you!"
        //         ]
        //     ]
        // ];
        
        // $ch = curl_init();
        
        // curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        //     'Content-Type: application/json')
        // );
        // curl_setopt($ch, CURLOPT_USERPWD, "d5b0192304df36d3619a181998d7d071:a412278bf504580738b9d0f0492fb4e6");
        // $server_output = curl_exec($ch);
        // curl_close ($ch);
        
        // $response = json_decode($server_output);
        // if ($response->Messages[0]->Status == 'success') {
        //     echo "Email sent successfully.";
        // }

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
                    'Subject' => $subject,
                    'HTMLPart' => $body1
                    ]
                ]
            ];
            // var_dump($body);  
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.mailjet.com/v3.1/',
        ]);
  
        $response = $client->request('POST', 'send', [
            'json' => $body,
            'auth' => ['d5b0192304df36d3619a181998d7d071', 'a412278bf504580738b9d0f0492fb4e6']
        ]);
        
        var_dump($response);  
        if($response->getStatusCode() == 200) 
        {
            
            // if ($response->Messages[0]->Status == 'success') 
            // {
                return true;
            // }
        }
    }

    public function cron_job($db)
    {
        $query = "SELECT * FROM merchant WHERE credit < 90";
        $result = $db->query($query);

        while($row = $result->fetch_assoc())
        {
            $subject = "Balance info";
            $body1 = "Your Balance is lower then 100";
            $this->send_mail($row["email"],$row["name"],$row["email"],$row["name"],$subject,$body1);
        }
    }
}
?>