<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<?php
include "database/DBBrand.php";
$msg = "";
$dbBrand = new DBBrand();
$brandRes=$dbBrand->getBrand();
?>
<?php
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $image = $_FILES['image']['tmp_name'];
    if(!empty($image))
        $image = file_get_contents($image);
    if (empty($name)) {
        $msg = $msg . "Brand Image must be required";
    }
    if ($msg == "") {
        if ($dbBrand->addBrand($name, $image)) {
            $msg = "Brand successfully added..!!!!";
            $brandRes=$dbBrand->getBrand();
        }
    }
}
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $brandRes=$dbBrand->searchBrand($key);
}
?>
<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $image = $_FILES['image']['tmp_name'];
    if(!empty($image))
        $image = file_get_contents($image);
    if (empty($name)) {
        $msg = $msg . "Brand Image must be required";
    }
    if ($msg == "") {
        if ($dbBrand->updateBrand($id, $name, $image)) {
            $msg = "Brand successfully update..!!!!";
            $brandRes=$dbBrand->getBrand();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VIEW-PRODUCT-Category</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color: black">

<?php include "includes/admin-navbar.php";?>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if ($dbBrand->deleteBrand($id)) {
        $msg = "Brand successfully deleted...!!!!!!";
        $brandRes=$dbBrand->getBrand();
    }
}
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = (int)$_GET['id'];
    $result = $dbBrand->getBrandById($id);
    ?>
    <div align="center" class="">
        <form action="brand.php" method="post" style="width: 400px" enctype="multipart/form-data">
            <br/>
            <!-- <button style="background: black;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
                Field
            </button>
            <br/> -->
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
            <div class="form-group">
                <input required="true" type="text" class="form-control" name="name" id="name"
                       value="<?php echo $result['name'] ?>" placeholder="Enter Brand Name :"/>
            </div>
            <div class="form-group">
                   <input required="true" type="file" class="form-control" name="image" id="image"/>
            </div>
            <div class="form-group">
                <input style="width: 400px" type="submit" class="btn btn-primary" name="update" value="Click here to Save Changes"/>
            </div>
        </form>
    </div>
<?php } else{ ?>
    <div align="center">
    
        <form action="brand.php" method="post" style="width: 400px" enctype="multipart/form-data">
        <br/><!-- <br/>
        <button style="background: black;color: #ffffff;font-family: serif;width: 400px;" class="btn btn-success">Add New Brand</button> -->
            <div class="form-group">
                <input type="text"  required="true" class="form-control" name="name" id="name" placeholder="Enter Brand Name :"/>
            </div>
            <div class="form-group">
                <input required="true" type="file" class="form-control" name="image" id="image"/>
            </div>
            <div class="form-group">
                <button style="width: 400px" type="submit" class="btn btn-primary" name="add"><i class="glyphicon glyphicon-book"></i> Add New Brand</button>
            </div>
        </form>
      <!--   <form action="" method="post">
            <table style="width: 400px;">
                <tr>
                    <td><input style="width: 320px;" class="form-control" name="key" type="text"
                               placeholder="Enter Keyword..."></td>
                    <td><button class="btn btn-primary" type="submit" name="search"><span class="glyphicon glyphicon-search"></span> Search</button></td>
                </tr>
            </table>
        </form> -->
    </div>
<?php }?>
<div class="container-fluid">
    <br/>
    <?php
    if ($msg != "") {
        echo '<div class="alert" style="background-color:#3b6494;color:#fff;">' . $msg . '</div>';
    }
    ?>

    <button style="background: black;color: #ffffff;font-family: serif;font-size: 15px" class="form-control">The Available Brands Added By
        Admin & Specific Authoriry
    </button>

    <div class="row">
        <?php foreach ($brandRes as $values) { ?>
        <div class="col-md-2">
            <div class="thumbnail" style="width: 200px;height: 325px">
                <?php echo '<img style="height:150px;width: 190px;" src="data:image/jpg;base64,' . base64_encode($values['image']) . '">' ?>
                <div align="center" class="caption">
                    <p style="color: orangered;font-weight: 600;font-size: 16px;text-decoration: underline;">Brand:<?php echo $values['name'] ?></p>
                    <?php echo "<a class='btn btn-primary form-control' href='brand.php?action=edit&id=" . $values['id'] . "'><i class='glyphicon glyphicon-edit'></i> Update</a>"; ?>
                    <p></p>
                    <?php echo "<a class='btn btn-danger form-control' href='brand.php?action=delete&id=" . $values['id'] . "'><i class='glyphicon glyphicon-trash'></i> Delete</a>"; ?>
                    <p></p>
                    <?php echo "<a class='btn btn-success form-control' href='medicine.php?action=searchBrand&key=" . $values['name'] . "'><i class='glyphicon glyphicon-search'></i> View Product</a>"; ?>
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
