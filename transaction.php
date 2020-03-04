<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php
    include "database/DBOrder.php";
    $dbOrder = new DBOrder();
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'accept') {
    $id = $_GET['id'];
    if ($dbOrder->acceptOrder($id)) {
        $msg = "Order successfully approved...!!!!!!";
    }
}
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'reject') {
    $id = $_GET['id'];
    if ($dbOrder->rejectOrder($id)) {
        $msg = "Order successfully removed...!!!!!!";
    }
}
?>
<?php
    $orderRes=$dbOrder->getOrders("Delivered");
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $orderRes=$dbOrder->searchOrder($key,'Delivered');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VIEW-Pending-Orders</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body
<body style="font-family: serif;color: black">
<?php include "includes/admin-navbar.php";?>

<div class="container" style="min-height: 500px;">
    <br/><br/>
    <div class="text-danger" style="margin-bottom: 10px;text-align: center;font-size: 18px;">The List of Customer Transaction Data</div>
    <table class="table table-hover table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Quantity</th>
            <th>Total cost</th>
            <th>Order Date</th>
            <th>Delivery Date</th>
            <th>Deivery System</th>
            <th>Payment System</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($orderRes as $values) { ?>
            <tr>
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['userId'] ?></td>
                <td><?php echo $values['qtn'] ?></td>
                <td><?php echo $values['cost'] ?></td>
                <td><?php echo $values['orderDate'] ?></td>
                <td><?php echo $values['deliveryDate'] ?></td>
                <td><?php echo $values['deliverySystem'] ?></td>
                <td><?php echo $values['payment'] ?></td>
                <td><?php echo $values['status'] ?></td>
                <td>
                    <?php echo "<a class='btn btn-danger' href='customer-transaction.php?action=customer&id=" . $values['userId'] . "'><span class='glyphicon glyphicon-user'></span> View-Customer</a>"; ?>
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