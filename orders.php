<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php
    include "database/DBOrder.php";
    include "database/DBMedicine.php";
    include "database/DBCustomer.php";
    $dbOrder = new DBOrder();
    $dbMedicine=new DBMedicine();
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'accept') {
    $id = $_GET['id'];
    if ($dbOrder->acceptOrder($id)) {
        $msg = "Order successfully delivered...!!!!!!";
        header('Location: transaction.php');
        exit();
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
if (isset($_GET['action']) && $_GET['action'] == 'print') {
    $id = $_GET['id'];
    require_once('tcpdf/tcpdf.php');
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle("Customer Order Memo");
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $obj_pdf->setPrintHeader(false);
    $obj_pdf->setPrintFooter(false);
    $obj_pdf->SetAutoPageBreak(TRUE, 10);
    $obj_pdf->SetFont('helvetica', '', 11);
    $obj_pdf->AddPage();
    $content = '';
    $content .= '  
        <h4 align="center">Customer Order Report Memo</h4><hr/><br>
        <table cellspacing="2" cellpadding="3">  
           <tr>  
                <th>Order Details</th>  
                <th>Order Values</th>  
           </tr>  
        ';
    $content .= fetch_data($id);
    $content .= '</table>';
    $obj_pdf->writeHTML($content);
    $obj_pdf->Output('file.pdf', 'I');
}
?>
<?php
function fetch_data($id)
{
    $output = '';
    $dbOrder = new DBOrder();
    $dbUser=new DBCustomer();
    $orderRes=$dbOrder->getOrderByOrderId($id);
    $userRes=$dbUser->getCustomerById($orderRes['userId']);
    $output .= '
        <tr>  
            <td>'.'Order ID : '.'</td>  
            <td>'.$orderRes['id'].'</td>
        </tr>
        <tr>
            <td>'.'Customer ID : '.'</td>  
            <td>'.$orderRes['userId'].'</td>
        </tr>
        <tr>
            <td>'.'Customer Name : '.'</td>  
            <td>'.$userRes['name'].'</td>
        </tr>
        <tr>
            <td>'.'Customer Address : '.'</td>  
            <td>'.$userRes['address'].'</td>
        </tr>
        <tr>
            <td>'.'Product Quantity : '.'</td>  
            <td>'.$orderRes['qtn'].'</td>
        </tr>
        <tr>
            <td>'.'Total Cost : '.'</td>  
            <td>'.$orderRes['cost'].'</td>
        </tr>
        <tr>
            <td>'.'Order Date : '.'</td>  
            <td>'.$orderRes['orderDate'].'</td>
        </tr>
        <tr>
            <td>'.'Payment Method : '.'</td>  
            <td>'.$orderRes['payment'].'</td>
        </tr>
        <tr>
            <td>'.'Delivery System : '.'</td>  
            <td>'.$orderRes['deliverySystem'].'</td>
        </tr> 
        <tr>
            <td>'.'Delivery Date : '.'</td>  
            <td>'.$orderRes['deliveryDate'].'</td>
        </tr>  
                          ';
    return $output;
}
?>
<?php
    $orderRes=$dbOrder->getOrders("Pending");
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $orderRes=$dbOrder->searchOrder($key,'Pending');
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
    <div class="text-danger" style="margin-bottom: 10px;text-align: center;font-size: 18px;">All Pending Customer Orders List</div>
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
            <th>Action</th>
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
                    <?php echo "<a class='btn btn-primary' href='orders.php?action=print&id=" . $values['id']."'><i class='glyphicon glyphicon-print'></i> Print-Order</a>"; ?>
                </td>
                <td>
                    <?php echo "<a class='btn btn-primary' href='orders.php?action=accept&id=" . $values['id']."'><i class='glyphicon glyphicon-refresh'></i> Confirm-Delivery</a>"; ?>
                </td>
                <td>
                    <?php echo "<a class='btn btn-danger' href='orders.php?action=reject&id=" . $values['id'] . "'><i class='glyphicon glyphicon-trash'></i> Reject</a>"; ?>
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