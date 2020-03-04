<?php
require_once "DB.php";
class DBHealthTips
{
    private $table = "tips";
    public function addTip($title, $image,$description)
    {
        $sql="INSERT into $this->table(title,image,description) values (:title,:image,:description)";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':title',$title);
        $stmt->bindParam(':image',$image);
        $stmt->bindParam(':description',$description);
        return $stmt->execute();
    }
    public function getTip()
    {
        $sql="SELECT * FROM $this->table";
        $stmt=DB::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getTipById($id)
    {
        $sql="SELECT * FROM $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function updateTip($id,$title, $image,$description)
    {
        $sql="UPDATE $this->table set title=:title,image=:image,description=:description where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':title',$title);
        $stmt->bindParam(':image',$image);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }
    public function deleteTip($id)
    {
        $sql="DELETE from $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }
    public function searchTip($key)
    {
        $sql="SELECT * FROM $this->table where title like :title";
        $stmt=DB::prepare($sql);
        $key='%'.$key.'%';
        $stmt->bindParam(':title',$key);
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