<?php 

class Merchant
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $credit;
    private $token;

    public function set_merchant($id,$name,$email,$password,$credit,$token)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->credit = $credit;
        $this->token = $token;
    }

    public function get_merchant()
    {
        $merchant = array(
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "password"=> $this->password,
            "credit"=> $this->credit,
            "token"=> $this->token
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
        // var_dump($result);
        // exit;
        if($result->num_rows > 0)
        {
            $jwt = new JwtHandler();
            $token = $jwt->_jwt_encode_data('http://localhost/',array("email"=>$email,"password"=>$password));
            echo $token;
            $query = "UPDATE merchant SET token = '$token' WHERE email='$email' AND password ='$password'";
            $result = $db->query($query);
            return $result;
        }
        else
        {
            return false;
        }
    }

    public function request()
    {

    }
}


?>