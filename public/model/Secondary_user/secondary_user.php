<?php 
class Secondary_user
{
    private $name;
    private $email;
    private $password;
    private $cheking_listing;
    private $billing_info;
    private $merchant_id;
    private $token;

    public function get_secondary_user()
    {
        $secondary_user = array(
            "name"=>$this->name,
            "email"=>$this->email,
            "password"=>$this->password,
            "checking_listing"=>$this->checking_listing,
            "billing_info"=>$this->billing_info,
            "merchant_id"=>$this->merchant_id
        );
        
        return $secondary_user;

    }

    public function set_secondary_user($name,$email,$password,$checking_listing,$billing_info,$merchant_id)
    {

        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->checking_listing = $checking_listing;
        $this->billing_info = $billing_info;
        $this->merchant_id = $merchant_id;

    }

    public function set_token($token)
    {
        $this->token = $token; 
    }

    public function get_token()
    {
        return $this->token;
    }

    public function sec_sign_in($email,$password,$db)
    {
        $query = "SELECT * FROM secondary_user WHERE email='$email' AND password = '$password'";
        
        $result = $db->query($query);
        
        $result1 = $result->fetch_array();
        
        $name = $result1['name'];
        $email = $result1['email'];
        $password = $result1['password'];
        $checking_listing = $result1['check_listing'];
        $billing_info = $result1['billing_info'];
        $merchant_id = $result1['merchant_id'];


        $this->set_secondary_user($name,$email,$password,$checking_listing,$billing_info,$merchant_id);


        if($result->num_rows > 0)
        {
            $jwt = new JwtHandler();
            $token = $jwt->_jwt_encode_data('http://localhost/',$this->get_secondary_user());

            $this->set_token($token);

            $query = "UPDATE secondary_user SET token = '$token' WHERE email='$email' AND password ='$password'";
            $result = $db->query($query);
           
            return $result;
        }
        else
        {
            return false;
        }
    }
}


  
?>