<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php

    include "database/DBMedicine.php";
    include "database/DBBrand.php";
    include "database/DBCategory.php";
    $msg = "";
    $dbMedicine=new DBMedicine();
    $dbBrand=new DBBrand();
    $dbCategory=new DBCategory();

    if (isset($_POST['add'])) {
        $brand = $_POST['brand'];
        $type = $_POST['type'];
        $name = $_POST['name'];
        $price1 = $_POST['price1'];
        $price2 = $_POST['price2'];
        $unit=$_POST['unit'];
        $info=$_POST['info'];
        $image = $_FILES['image']['tmp_name'];
        if(!empty($image))
            $image = file_get_contents($image);
        $qtn = $_POST['qtn'];
        $sells=0;
        if (empty($brand)) {
            $msg = $msg . "<br/>Brand name must be required";
        }
        if (empty($type)) {
            $msg = $msg . "<br/>Medicine Type name must be required";
        }
        if (empty($name)) {
            $msg = $msg . "<br/>Product name must be required";
        }
        if (empty($price1)) {
            $msg = $msg . "<br/>Before discount must be required";
        }
        if (empty($price2)) {
            $msg = $msg . "<br/>After discount must be required";
        }
        if (empty($unit)) {
            $msg = $msg . "<br/>Unit must be required";
        }
        if (empty($qtn)) {
            $msg = $msg . "<br/>Quantity must be required";
        }
        if (empty($image)) {
            $msg = $msg . "<br/>Image must be required";
        }
        if (empty($info)) {
            $msg = $msg . "<br/>Medicine Information must be required";
        }
        if ($msg == "") {
            if($dbMedicine->addMedicine($brand,$type, $name,$image, $unit, $qtn,$price1,$price2,$sells,$info)){
                $msg="This Product is successfully added";
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>ADD-Medicine</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color: black">
<?php include "includes/admin-navbar.php";?>

<div align="center">
    <br/><br/>
    <form action="add-medicine.php" method="post"
      style="width: 500px" enctype="multipart/form-data">
        <div class="input-group">
            <?php
            if ($msg != "") {
                echo '<div class="alert alert-danger">' . $msg . '</div>';
            }
            ?>
        </div>
        <button style="background: black;color: #ffffff;font-family: serif" class="form-control btn-primary">Please Fill The Specific Field</button>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input required="true" class="form-control" list="brands" name="brand" placeholder="Brand : "/>
        </div>
        <datalist id="brands">
            <?php $brandRes= $dbBrand->getBrand(); ?>
            <?php foreach ($brandRes as $values) { ?>
                <option value="<?php echo $values['name']; ?>">
            <?php } ?>
        </datalist>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input required="true" class="form-control" list="types" name="type" placeholder="Category : "/>
        </div>
        <datalist id="types">
            <?php $typeRes= $dbCategory->getCategory(); ?>
            <?php foreach ($typeRes as $values) { ?>
                <option value="<?php echo $values['name']; ?>">
            <?php } ?>
        </datalist>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input required="true" type="text" class="form-control" name="name" id="name1"
                   placeholder="Name : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <select name="unit" class="form-control">
                <option value="Kilogram(KG)">Kilogram(KG)</option>
                <option value="Litre(L)">Litre(L)</option>
                <option value="Box(L)">Box(L)</option>
                <option value="Packet(P)">Packet(P)</option>
            </select>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input required="true" type="number" class="form-control" name="price1" id="price11"
                   placeholder="Price before discount : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input required="true" type="number" class="form-control" name="price2" id="price2"
                   placeholder="Price after discount : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input required="true" type="file" class="form-control" name="image" id="image"/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input required="true" type="number" class="form-control" name="qtn" id="qtn1"
                   placeholder="Product Quantity : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <textarea style="width: 460px;height: 120px;resize: none;" required="true" type="text" class="form-control" name="info" id="info1"
                      placeholder="Product Information : "></textarea>
        </div>
        <br/>
        <div class="form-group">
            <button name="add" style="width: 500px" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Click Here To Save
            </button>
        </div>
    </form>
</div>
<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>