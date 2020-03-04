<?php
    require_once "DB.php";
    class DBMedicine
    {
        private $table = "stock";

        public function addMedicine($brand,$type,$name,$image,$unit,$qtn,$price1,$price2,$sells,$info)
        {
            $sql="INSERT into $this->table(brand,type,name,image,unit,qtn,price1,price2,sells,info)
            values (:brand,:type,:name,:image,:unit,:qtn,:price1,:price2,:sells,:info)";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':brand',$brand);
            $stmt->bindParam(':type',$type);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':image',$image);
            $stmt->bindParam(':unit',$unit);
            $stmt->bindParam(':qtn',$qtn);
            $stmt->bindParam(':price1',$price1);
            $stmt->bindParam(':price2',$price2);
            $stmt->bindParam(':sells',$sells);
            $stmt->bindParam(':info',$info);
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
        public function getAllMedicine()
        {
            $sql="SELECT * FROM $this->table";
            $stmt=DB::prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getAllBrand()
        {
            $sql="SELECT DISTINCT brand FROM $this->table";
            $stmt=DB::prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getAllType()
        {
            $sql="SELECT DISTINCT type FROM $this->table";
            $stmt=DB::prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getMedicineById($id)
        {
            $sql="SELECT * FROM $this->table where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            return $stmt->fetch();
        }
        public function updateMedicine($id,$name,$image,$unit,$qtn,$price1,$price2,$info)
        {
            $sql="UPDATE $this->table set name=:name,image=:image,unit=:unit,qtn=:qtn,price1=:price1,price2=:price2,info=:info where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':image',$image);
            $stmt->bindParam(':unit',$unit);
            $stmt->bindParam(':qtn',$qtn);
            $stmt->bindParam(':price1',$price1);
            $stmt->bindParam(':price2',$price2);
            $stmt->bindParam(':info',$info);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }
        public function deleteMedicine($id)
        {
            $sql="DELETE from $this->table where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }
        public function searchMedicine($key)
        {
            $sql="SELECT * FROM $this->table where brand like :brand or type like :type or name like :name";
//            $sql="SELECT * FROM $this->table where category like ? or subCategory like ? or productName like ?";
            $stmt=DB::prepare($sql);
            $key='%'.$key.'%';
            $stmt->bindParam(':brand',$key);
            $stmt->bindParam(':type',$key);
            $stmt->bindParam(':name',$key);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function searchMedicineByBrand($key)
        {
            $sql="SELECT * FROM $this->table where brand like :brand";
            $stmt=DB::prepare($sql);
            $key='%'.$key.'%';
            $stmt->bindParam(':brand',$key);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function searchMedicineByCategory($key)
        {
            $sql="SELECT * FROM $this->table where type like :type";
            $stmt=DB::prepare($sql);
            $key='%'.$key.'%';
            $stmt->bindParam(':type',$key);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function sellMedicine($id)
        {
            $sql="UPDATE $this->table set sells=sells+1 where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
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