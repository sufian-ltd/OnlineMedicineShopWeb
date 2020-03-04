<?php
    require_once "DB.php";
    class DBSell
    {
        private $table = "sells";
        public function getSells()
        {
            $sql="SELECT * FROM $this->table";
            $stmt=DB::prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getTotalProduct($userId)
        {
            $sum=0;
            $sql="SELECT quantity FROM $this->table where userId=:userId";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':userId',$userId);
            $stmt->execute();
            $res=$stmt->fetchAll();
            foreach ($res as $r){
                $sum+=(int)$r['quantity'];
            }
            return $sum;
        }
        public function getTotalCost($userId)
        {
            $sum=0;
            $sql="SELECT cost FROM $this->table where userId=:userId";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':userId',$userId);
            $stmt->execute();
            $res=$stmt->fetchAll();
            foreach ($res as $r){
                $sum+=(int)$r['cost'];
            }
            return $sum;
        }
        public function getSellById($userId)
        {
            $sql="SELECT * FROM $this->table where userId=:userId";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':userId',$userId);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function saveSells($productId,$userId,$quantity,$cost,$date)
        {
            $sql="INSERT into $this->table(productId,userId,quantity,cost,date) values (:productId,:userId,:quantity,:cost,:date)";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':productId',$productId);
            $stmt->bindParam(':userId',$userId);
            $stmt->bindParam(':quantity',$quantity);
            $stmt->bindParam(':cost',$cost);
            $stmt->bindParam(':date',$date);
            return $stmt->execute();
        }
        public function getSellByIdDate($id,$date)
        {
            $sql="SELECT * FROM $this->table where userId=:userId and date=:date";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':userId',$id);
            $stmt->bindParam(':date',$date);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
?>