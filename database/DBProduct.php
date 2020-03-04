<?php
    require_once "DB.php";
    class DBMedicine
    {
        private $table = "stock";

        public function addMedicine($type,$name,$image,$unit,$qtn,$price1,$price2,$sells)
        {
            $sql="INSERT into $this->table(type,name,image,unit,qtn,price1,price2,sells)
            values (:type,:name,:image,:unit,:qtn,:price1,:price2,:sells)";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':type',$type);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':image',$image);
            $stmt->bindParam(':unit',$unit);
            $stmt->bindParam(':qtn',$qtn);
            $stmt->bindParam(':price1',$price1);
            $stmt->bindParam(':price2',$price2);
            $stmt->bindParam(':sells',$sells);
            return $stmt->execute();
        }
        public function getMedicine($type)
        {
            $sql="SELECT * FROM $this->table where type=:type";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':type',$type);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getMedicineById($id,$type)
        {
            $sql="SELECT * FROM $this->table where id=:id and type=:type";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':type',$type);
            $stmt->execute();
            return $stmt->fetch();
        }
        public function updateMedicine($id,$type,$name,$image,$unit,$qtn,$price1,$price2,$sells)
        {
            $sql="UPDATE $this->table set type=:type, name=:name,image=:image,unit=:unit,qtn=:qtn,price1=:price1,price2=:price2,sells=:sells where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':type',$type);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':image',$image);
            $stmt->bindParam(':unit',$unit);
            $stmt->bindParam(':qtn',$qtn);
            $stmt->bindParam(':price1',$price1);
            $stmt->bindParam(':price2',$price2);
            $stmt->bindParam(':sells',$sells);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }
        public function deleteMedicine($id,$type)
        {
            $sql="DELETE from $this->table where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }
        public function searchMedicine($key,$type)
        {
            $sql="SELECT * FROM $this->table where (name like :name) and type=:type";
//            $sql="SELECT * FROM $this->table where category like ? or subCategory like ? or productName like ?";
            $stmt=DB::prepare($sql);
            $key='%'.$key.'%';
            $stmt->bindParam(':name',$key);
            $stmt->bindParam(':type',$type);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function sellMedicine($id)
        {
            $sql="UPDATE $this->table set sells=sells+1 where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$productId);
            return $stmt->execute();
        }
        public function updateStock($medicineId,$qtn)
        {
            $sql="UPDATE $this->table set qtn=qtn-$qtn where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$medicineId);
            return $stmt->execute();
        }
        public function getTotalProductByCategory($category)
        {
            $sql="SELECT count(id) as id FROM $this->table where category=:category";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':category',$category);
            $stmt->execute();
            return $stmt->fetch();
        }
    }
?>