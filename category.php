<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBCategory.php";
$msg = "";
$dbCategory = new DBCategory();
$categoryRes=$dbCategory->getCategory();
?>
<?php
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $image = $_FILES['image']['tmp_name'];
    if(!empty($image))
        $image = file_get_contents($image);
    if (empty($name)) {
        $msg = $msg . "Category Image must be required";
    }
    if ($msg == "") {
        if ($dbCategory->addCategory($name, $image)) {
            $msg = "Category successfully added..!!!!";
            $categoryRes=$dbCategory->getCategory();
        }
    }
}
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $categoryRes=$dbCategory->searchCategory($key);
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
        $msg = $msg . "Category Image must be required";
    }
    if ($msg == "") {
        if ($dbCategory->updateCategory($id, $name, $image)) {
            $msg = "Category successfully update..!!!!";
            $categoryRes=$dbCategory->getCategory();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VIEW-Category</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color: black">

<?php include "includes/admin-navbar.php";?>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if ($dbCategory->deleteCategory($id)) {
        $msg = "Category successfully deleted...!!!!!!";
        $categoryRes=$dbCategory->getCategory();
    }
}
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = (int)$_GET['id'];
    $result = $dbCategory->getCategoryById($id);
    ?>
    <div align="center" class="">
        <form action="category.php" method="post" style="width: 400px" enctype="multipart/form-data">
            <br/>
            <!-- <button style="background: black;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
                Field
            </button>
            <br/> -->
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
            <div class="form-group">
                <input required="true" type="text" class="form-control" name="name" id="name"
                       value="<?php echo $result['name'] ?>" placeholder="Enter Category Name :"/>
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
    
        <form action="category.php" method="post" style="width: 400px" enctype="multipart/form-data">
        <br/><!-- <br/>
        <button style="background: black;color: #ffffff;font-family: serif;width: 400px;" class="btn btn-success">Add New Brand</button> -->
            <div class="form-group">
                <input type="text"  required="true" class="form-control" name="name" id="name" placeholder="Enter Category Name :"/>
            </div>
            <div class="form-group">
                <input required="true" type="file" class="form-control" name="image" id="image"/>
            </div>
            <div class="form-group">
                <button style="width: 400px" type="submit" class="btn btn-primary" name="add"><i class="glyphicon glyphicon-book"></i> Add New Category</button>
            </div>
        </form>
        <!-- <form action="" method="post">
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

    <button style="background: black;color: #ffffff;font-family: serif;font-size: 15px" class="form-control">The Available Category Added By
        Admin & Specific Authoriry
    </button>

    <div class="row">
        <?php foreach ($categoryRes as $values) { ?>
        <div class="col-md-2">
            <div class="thumbnail" style="width: 200px;height: 325px">
                <?php echo '<img style="height:150px;width: 190px;" src="data:image/jpg;base64,' . base64_encode($values['image']) . '">' ?>
                <div align="center" class="caption">
                    <p style="color: orangered;font-weight: 600;font-size: 16px;text-decoration: underline;">Category:<?php echo $values['name'] ?></p>
                    <?php echo "<a class='btn btn-primary form-control' href='category.php?action=edit&id=" . $values['id'] . "'><i class='glyphicon glyphicon-edit'></i> Update</a>"; ?>
                    <p></p>
                    <?php echo "<a class='btn btn-danger form-control' href='category.php?action=delete&id=" . $values['id'] . "'><i class='glyphicon glyphicon-trash'></i> Delete</a>"; ?>
                    <p></p>
                    <?php echo "<a class='btn btn-success form-control' href='medicine.php?action=searchCategory&key=" . $values['name'] . "'><i class='glyphicon glyphicon-search'></i> View Product</a>"; ?>
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
