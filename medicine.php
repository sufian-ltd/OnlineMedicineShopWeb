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
$dbMedicine = new DBMedicine();
$medicineRes=$dbMedicine->getAllMedicine();
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $medicineRes=$dbMedicine->searchMedicine($key);
}
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'searchBrand') {
    $medicineRes=$dbMedicine->searchMedicineByBrand($_GET['key']);
}
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'searchCategory') {
    $medicineRes=$dbMedicine->searchMedicineByCategory($_GET['key']);
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
    $info=$_POST['info'];
    if (empty($name)) {
        $msg = $msg . "Medicine name must be required";
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
        $msg=$msg . "<br/><br/>Medicine Information must be required";
    }
    if ($msg == "") {
        if ($dbMedicine->updateMedicine($id,$name,$image,$unit,$qtn, $price1,$price2,$info)) {
            $msg = "Medicine successfully update..!!!!";
            $medicineRes=$dbMedicine->getAllMedicine();
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
<body style="font-family: serif;color: black">

<?php include "includes/admin-navbar.php";?>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if ($dbMedicine->deleteMedicine($id)) {
        $msg = "Medicine successfully deleted...!!!!!!";
        $medicineRes=$dbMedicine->getAllMedicine();
    }
}
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = (int)$_GET['id'];
    $result = $dbMedicine->getMedicineById($id);
    ?>
    <div align="center" class="">
        <form action="medicine.php" method="post" style="width: 500px" enctype="multipart/form-data">
            <br/>
            <button style="background: black;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
                Field
            </button>
            <br/>
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
            <input type="hidden" name="sells" value="<?php echo $result['sells'] ?>">
            <div class="form-group">
                <input type="text" required="true" class="form-control" name="name" id="name"
                       value="<?php echo $result['name'] ?>" placeholder="Enter Medicine Name :"/>
            </div>
            <div class="form-group">
                <input type="number" required="true" class="form-control" name="price1" id="price11"
                       value="<?php echo $result['price1'] ?>" placeholder="Enter price before discount : "/>
            </div>
            <div class="form-group">
                <input type="number" required="true" class="form-control" name="price2" id="pri"
                       value="<?php echo $result['price2'] ?>" placeholder="Enter price after discount : "/>
            </div>
            <div class="form-group">
                <input type="file" required="true" class="form-control" name="image" id="image"/>
            </div>
            <div class="form-group">
                <input type="text" required="true" class="form-control" name="unit" id="unit"
                       value="<?php echo $result['unit'] ?>" placeholder="Enter Product Unit :"/>
            </div>
            <div class="form-group">
                <input type="number" required="true" class="form-control" name="quantity" id="quantity1"
                       value="<?php echo $result['qtn'] ?>" placeholder="Enter Quantity"/>
            </div>
            <div class="form-group">
                <textarea style="width: 500px;height: 120px;resize: none;" required="true" type="text" class="form-control" name="info" id="info1"
                          placeholder="Product Information : "><?php echo $result['info'] ?></textarea>
            </div>
            <div class="form-group">
                <input style="width: 500px" type="submit" class="btn btn-primary" name="update" value="Save Changes"/>
            </div>
        </form>
    </div>
<?php } else{ ?>
    <div align="center">
        <br/><br/>
        <form action="" method="post">
            <table style="width: 450px;">
                <tr>
                    <td><input style="width: 440px;" class="form-control" name="key" type="text"
                               placeholder="Enter Keyword..."></td>
                    <td><button class="btn btn-primary" type="submit" name="search"><span class="glyphicon glyphicon-search"></span> Search</button></td>
                </tr>
            </table>
        </form>
    </div>
<?php }?>
<div class="container-fluid">
    <br/>
    <?php
    if ($msg != "") {
        echo '<div class="alert" style="background-color:#3b6494;color:#fff;">' . $msg . '</div>';
    }
    ?>

    <button style="background: black;color: #ffffff;font-family: serif;font-size: 15px" class="form-control">The Available Medicine Added By
        Admin & Specific Authoriry
    </button>
    <div    class="row">
        <?php foreach ($medicineRes as $values) { ?>
        <div class="col-md-2">
            <div class="thumbnail" style="width: 200px;height: 420px">
                <?php echo '<img style="height:150px;width: 190px;" src="data:image/jpg;base64,' . base64_encode($values['image']) . '">' ?>
                <div align="center" class="caption">
                    <h4 style="font-weight: bold;color:red;"><?php echo $values['name'] ?></h4>
                    <p style="color: black;"><i class="glyphicon glyphicon-check"></i>  Unit : <?php echo $values['unit'] ?></p>
                    <p style="color: #68b031;"><i class="glyphicon glyphicon-user"></i> After Discount : <?php echo $values['price2'] ?> TK</p>
                    <p style="color: #0d7586;"><i class="glyphicon glyphicon-gift"></i>  Total Stock : <?php echo $values['qtn'] ?></p>
                    <p style="color: #ff9900"><i class="glyphicon glyphicon-gift"></i>  Total Sells : <?php echo $values['sells'] ?></p>
                    <?php echo "<a class='btn btn-primary form-control' href='medicine.php?action=edit&id=" . $values['id'] . "'><i class='glyphicon glyphicon-edit'></i> Update</a>"; ?>
                    <p></p>
                    <?php echo "<a class='btn btn-danger form-control' href='medicine.php?action=delete&id=" . $values['id'] . "'><i class='glyphicon glyphicon-trash'></i> Delete</a>"; ?>
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
