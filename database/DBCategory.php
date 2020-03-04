<?php
require_once "DB.php";
class DBCategory
{
    private $table = "category";
    public function addCategory($name, $image)
    {
        $sql="INSERT into $this->table(name,image) values (:name,:image)";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':image',$image);
        return $stmt->execute();
    }
    public function getCategory()
    {
        $sql="SELECT * FROM $this->table";
        $stmt=DB::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getCategoryById($id)
    {
        $sql="SELECT * FROM $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function updateCategory($id,$name, $image)
    {
        $sql="UPDATE $this->table set name=:name,image=:image where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':image',$image);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }
    public function deleteCategory($id)
    {
        $sql="DELETE from $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }
    public function searchCategory($key)
    {
        $sql="SELECT * FROM $this->table where name like :name";
        $stmt=DB::prepare($sql);
        $key='%'.$key.'%';
        $stmt->bindParam(':name',$key);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function addQtnToCategory($category,$qtn)
    {
        $sql="UPDATE $this->table set totalProduct=totalProduct+$qtn where name=:name";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':name',$category);
        return $stmt->execute();
    }
}