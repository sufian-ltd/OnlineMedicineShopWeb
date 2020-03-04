<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php
    include "database/DBCustomer.php";
    $dbCustomer = new DBCustomer();
    $customerRes=$dbCustomer->getCustomer();
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $customerRes=$dbCustomer->searchCustomer($key);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VIEW-Customers</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color: black">
<?php include "includes/admin-navbar.php";?>

<div class="container" style="min-height: 500px;">
    <br/><br/>

    <div align="center">
<!--        <a class="btn btn-success" style="width:600px" href="addSupplier.php">Add New Supplier</a><br/><br/>-->
        <form action="" method="post">
            <table style="width: 500px;">
                <tr>
                    <td><input style="width: 485px;" class="form-control" name="key" type="text"
                               placeholder="Enter Keyword..."></td>
                    <td><button class="btn btn-primary" type="submit" name="search"><span class="glyphicon glyphicon-search"></span> Search</button></td>
                </tr>
            </table>
        </form>
        <br/>
    </div>
    <table class="table table-hover table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        <?php foreach ($customerRes as $values) { ?>
            <tr>
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['name'] ?></td>
                <td><?php echo $values['email'] ?></td>
                <td><?php echo $values['contact'] ?></td>
                <td><?php echo $values['address'] ?></td>
                <td>
                    <?php echo "<a class='btn btn-danger' href='customer-transaction.php?action=customer&id=" . $values['id'] . "'><span class='glyphicon glyphicon-random'></span>  View-Transaction</a>"; ?>
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