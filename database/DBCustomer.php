<?php
require_once "DB.php";

class DBCustomer
{
    private $table = "users";

    public function addCustomer($name,$email,$contact,$address){
        $sql="INSERT into $this->table(name,email,contact,address) values (:name,:email,:contact,:address)";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':contact',$contact);
        $stmt->bindParam(':address',$address);
        return $stmt->execute();
    }
    public function getCustomerById($id)
    {
        $sql="SELECT * FROM $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getCustomer()
    {
        $sql="SELECT * FROM $this->table";
        $stmt=DB::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function searchCustomer($key)
    {
        $sql="SELECT * FROM $this->table where name like :name or email like :email or contact like :contact";
        $stmt=DB::prepare($sql);
        $key='%'.$key.'%';
        $stmt->bindParam(':name',$key);
        $stmt->bindParam(':email',$key);
        $stmt->bindParam(':contact',$key);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>