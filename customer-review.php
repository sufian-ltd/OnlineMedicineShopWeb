<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBOrder.php";
include "database/DBCustomer.php";
include "database/DBReview.php";
$dbOrder = new DBOrder();
$dbCustomer = new DBCustomer;
$dbReview=new DBReview();
$reviewRes=$dbReview->getReview();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer-Review</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color: #000">
<?php include "includes/admin-navbar.php";?>
<div class="container-fluid" style="text-align: center;">
    <img src="images/mid1.jpg" style="height: 190px;margin-bottom: 10px;">
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Customer Address</th>
            <th>Quantity</th>
            <th>Total Cost</th>
            <th>Order Date</th>
            <th>Delivery Date</th>
            <th>Delivery System</th>
            <th>Payment System</th>
            <th style="color: red;">Customer Message</th>
        </tr>
        <?php foreach ($reviewRes as $values) { ?>
            <?php
                $orderRes=$dbOrder->getOrderByOrderId($values['orderid']);
                $userRes=$dbCustomer->getCustomerById($orderRes['userId']);
            ?>
            <tr>
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $userRes['name'] ?></td>
                <td><?php echo $userRes['address'] ?></td>
                <td><?php echo $orderRes['qtn'] ?></td>
                <td><?php echo $orderRes['cost'] ?></td>
                <td><?php echo $orderRes['orderDate'] ?></td>
                <td><?php echo $orderRes['deliveryDate'] ?></td>
                <td><?php echo $orderRes['deliverySystem'] ?></td>
                <td><?php echo $orderRes['payment'] ?></td>
                <td style="color: red;"><?php echo $values['msg'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>