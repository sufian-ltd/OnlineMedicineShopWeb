<?php
require_once "DB.php";

class DBUser
{
    private $table = "user";

    public function isUser($email,$password)
    {
        $sql = "SELECT * FROM $this->table where email=:email and password=:password";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        if ($stmt->rowCount()>0)
            return "exist";
        else
            return "not exist";
    }
    public function registerUser($name,$email,$password,$contact,$address){
        $sql="INSERT into $this->table(name,email,password,contact,address) values (:name,:email,:password,:contact,:address)";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':contact',$contact);
        $stmt->bindParam(':address',$address);
        return $stmt->execute();
    }
    public function getUser($id)
    {
        $sql="SELECT * FROM $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getUsers()
    {
        $sql="SELECT * FROM $this->table";
        $stmt=DB::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getUserByEmailPass($email,$password)
    {
        $sql="SELECT * FROM $this->table where email=:email and password=:password";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$password);
        $stmt->execute();
        return $stmt->fetch();
    }
}

?>