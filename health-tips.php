<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<?php
include "database/DBHealthTips.php";
$msg = "";
$dbTip = new DBHealthTips();
$tipRes=$dbTip->getTip();
?>
<?php
if(isset($_POST['add'])){
    $title = $_POST['title'];
    $image = $_FILES['image']['tmp_name'];
    if(!empty($image))
        $image = file_get_contents($image);
    $description = $_POST['description'];
    if (empty($title)) {
        $msg = $msg . "Health Tip Image must be required";
    }
    if ($msg == "") {
        if ($dbTip->addTip($title, $image,$description)) {
            $msg = "Tip successfully added..!!!!";
            $tipRes=$dbTip->getTip();
        }
    }
}
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $tipRes=$dbTip->searchTip($key);
}
?>
<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image']['tmp_name'];
    if(!empty($image))
        $image = file_get_contents($image);
    if (empty($title)) {
        $msg = $msg . "Health Tip mage must be required";
    }
    if ($msg == "") {
        if ($dbTip->updateTip($id, $title, $image,$description)) {
            $msg = "Tip successfully update..!!!!";
            $tipRes=$dbTip->getTip();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VIEW-HEALTH-TIPS</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color: black">

<?php include "includes/admin-navbar.php";?>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if ($dbTip->deleteTip($id)) {
        $msg = "Health Tip successfully deleted...!!!!!!";
        $tipRes=$dbTip->getTip();
    }
}
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = (int)$_GET['id'];
    $result = $dbTip->getTipById($id);
    ?>
    <div align="center" class="">
        <form action="health-tips.php" method="post" style="width: 550px" enctype="multipart/form-data">
            <br/>
            <!-- <button style="background: black;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
                Field
            </button>
            <br/> -->
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
            <div class="form-group">
                <input required="true" type="text" class="form-control" name="title" id="title"
                       value="<?php echo $result['title'] ?>" placeholder="Enter Title :"/>
            </div>
            <div class="form-group">
                   <input required="true" type="file" class="form-control" name="image" id="image"/>
            </div>
            <div class="form-group">
                <textarea style="width: 550px;height: 135px;resize: none;" required="true" type="text" class="form-control" name="description" id="description"
                       placeholder="Enter Description :"><?php echo $result['description']; ?></textarea>
            </div>
            <div class="form-group">
                <input style="width: 550px" type="submit" class="btn btn-primary" name="update" value="Save Changes"/>
            </div>
        </form>
    </div>
<?php } else{ ?>
    <div align="center">
    
        <form action="health-tips.php" method="post" style="width: 550px" enctype="multipart/form-data">
        <br/><!-- <br/>
        <button style="background: black;color: #ffffff;font-family: serif;width: 400px;" class="btn btn-success">Add New Brand</button> -->
            <div class="form-group">
                <input type="text"  required="true" class="form-control" name="title" id="title" placeholder="Enter Title :"/>
            </div>
            <div class="form-group">
                <input required="true" type="file" class="form-control" name="image" id="image"/>
            </div>
            <div class="form-group">
                <textarea style="width: 550px;height: 135px;resize: none;" type="text"  required="true" class="form-control" name="description" id="description" placeholder="Enter Description :"></textarea>
            </div>
            <div class="form-group">
                <button style="width: 550px" type="submit" class="btn btn-primary" name="add"><i class="glyphicon glyphicon-book"></i> Save New Tip</button>
            </div>
        </form>
    </div>
<?php }?>
<div class="container">
    <br/>
    <?php
    if ($msg != "") {
        echo '<div class="alert" style="background-color:#3b6494;color:#fff;">' . $msg . '</div>';
    }
    ?>

    <button style="background: black;color: #ffffff;font-family: serif;font-size: 15px" class="form-control">The Available Health Tips Added By
        Admin & Specific Authoriry
    </button>
    <table class="table table-hover table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Image</th>
            <th>Description</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
        <?php foreach ($tipRes as $values) { ?>
            <tr>
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['title'] ?></td>
                <td>
                    <?php echo '<img width="150" height="150" src="data:image/jpg;base64,' . base64_encode($values['image']) . '">' ?>
                </td>
                <td><?php echo $values['description'] ?></td>
                <td>
                    <?php echo "<a class='btn btn-primary' href='health-tips.php?action=edit&id=" . $values['id'] . "'><i class='glyphicon glyphicon-pencil'></i> Update</a>"; ?>
                </td>
                <td>
                    <?php echo "<a class='btn btn-danger' href='health-tips.php?action=delete&id=" . $values['id'] . "'><i class='glyphicon glyphicon-trash'></i> Delete</a>"; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>
