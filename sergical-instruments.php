<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBMedicine.php";
$msg = "";
$type="Sergical Instrument";
$dbMedicine = new DBMedicine();
$medicineRes=$dbMedicine->getMedicine($type);
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $medicineRes=$dbMedicine->searchMedicine($key,$type);
}
?>
<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price1 = $_POST['price1'];
    $price2 = $_POST['price2'];
    $image = $_FILES['image']['tmp_name'];
    if (!empty($image))
        $image = file_get_contents($image);
    $unit = $_POST['unit'];
    $qtn = $_POST['quantity'];
    $sells = $_POST['sells'];
    $info=$_POST['info'];
    if (empty($name)) {
        $msg = $msg . "Sergical Instrument name must be required";
    }
    if (empty($price1)) {
        $msg = $msg . "<br/>Before discount must be required";
    }
    if (empty($price2)) {
        $msg = $msg . "<br/>After discount must be required";
    }
    if (empty($qtn)) {
        $msg = $msg . "<br/>Quantity must be required";
    }
    if (empty($image)) {
        $msg = $msg . "<br/>Image must be required";
    }
    if(empty($info)){
        $msg=$msg . "<br/><br/>Sergical Instrument Information must be required";
    }
    if ($msg == "") {
        if ($dbMedicine->updateMedicine($id,$type, $name,$image,$unit,$qtn, $price1,$price2,$sells,$info)) {
            $msg = "Sergical Instrument successfully update..!!!!";
            $medicineRes=$dbMedicine->getMedicine($type);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VIEW-Foreign-Medicine</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body
<body style="font-family: serif;color: black">

<?php include "includes/admin-navbar.php";?>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if ($dbMedicine->deleteMedicine($id)) {
        $msg = "Sergical Instrument successfully deleted...!!!!!!";
        $medicineRes=$dbMedicine->getMedicine($type);
    }
}
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = (int)$_GET['id'];
    $result = $dbMedicine->getMedicineById($id,$type);
    ?>
    <div align="center" class="">
        <form action="others.php" method="post" style="width: 500px" enctype="multipart/form-data">
            <br/>
            <button style="background: black;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
                Field
            </button>
            <br/>
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
            <input type="hidden" name="sells" value="<?php echo $result['sells'] ?>">
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="name"
                       value="<?php echo $result['name'] ?>" placeholder="Enter Medicine Name :"/>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="price1" id="price11"
                       value="<?php echo $result['price1'] ?>" placeholder="Enter price before discount : "/>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="price2" id="pri"
                       value="<?php echo $result['price2'] ?>" placeholder="Enter price after discount : "/>
            </div>
            <div class="form-group">
                <input type="file" class="form-control" name="image" id="image"/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="unit" id="unit"
                       value="<?php echo $result['unit'] ?>" placeholder="Enter Product Unit :"/>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="quantity" id="quantity1"
                       value="<?php echo $result['qtn'] ?>" placeholder="Enter Quantity"/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="info" id="info1"
                       value="<?php echo $result['info'] ?>" placeholder="Enter Medicine Information : "/>
            </div>
            <div class="form-group">
                <input style="width: 500px" type="submit" class="btn btn-primary" name="update" value="Save Changes"/>
            </div>
        </form>
    </div>
<?php } else{ ?>
    <div align="center">
        <br/><br/>
        <a class="btn btn-primary" style="width:500px" href="add-medicine.php">Add New Sergical Instrument</a><br/><br/>
        <form action="" method="post" style="width: 500px">
            <div class="form-group">
                <input type="hidden" name="type" value="Sergical Instrument">
                <input type="text" class="form-control" name="key" type="text"
                               placeholder="Enter Keyword..."/>
            </div>
            <div class="form-group">
                <input style="width: 500px" type="submit" class="btn btn-primary" name="search" value="Search Sergical Instrument"/>
            </div>
            <!-- <table style="width: 500px;">
                <tr>
                    <td><input style="width: 490px;" class="form-control" name="key" type="text"
                               placeholder="Enter Keyword..."></td>
                    <td><input class="btn btn-primary" type="submit" name="search" value="Search Foreign Medicine"></td>
                </tr>
            </table> -->
        </form>
    </div>
<?php }?>
<div class="container">
    <br/>
    <?php
    if ($msg != "") {
        echo '<div class="alert alert-danger">' . $msg . '</div>';
    }
    ?>

    <button style="background: black;color: #ffffff;font-family: serif;font-size: 15px" class="form-control">The Available Sergical Instrument Added By
        Admin & Specific Authoriry
    </button>

    <br/>
    <div class="row">
        <?php foreach ($medicineRes as $values) { ?>
        <div class="col-md-3">
            <div class="thumbnail" style="width: 200px;height: 420px">
                <?php echo '<img style="height:150px;width: 190px;" src="data:image/jpg;base64,' . base64_encode($values['image']) . '">' ?>
                <div align="center" class="caption">
                    <h4 style="font-weight: bold"><?php echo $values['name'] ?></h4>
                    <p><i class="glyphicon glyphicon-check"></i>  Unit : <?php echo $values['unit'] ?></p>
                    <p><i class="glyphicon glyphicon-user"></i> After Discount : <?php echo $values['price2'] ?></p>
                    <p><i class="glyphicon glyphicon-gift"></i>  Total Stock : <?php echo $values['qtn'] ?></p>
                    <p><i class="glyphicon glyphicon-gift"></i>  Total Sells : <?php echo $values['sells'] ?></p>
                    <?php echo "<a class='btn btn-primary form-control' href='sergical-instruments.php?action=edit&id=" . $values['id'] . "'>Update</a>"; ?>
                    <p></p>
                    <?php echo "<a class='btn btn-danger form-control' href='sergical-instruments.php?action=delete&id=" . $values['id'] . "'>Delete</a>"; ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>
