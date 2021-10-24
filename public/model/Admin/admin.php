<?php 
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
}
?>