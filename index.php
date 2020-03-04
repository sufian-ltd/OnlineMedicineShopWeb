<?php
    session_start();
    $msg = "";
    if( isset($_POST['login']) ) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($username =="adminadmin" && $password =="adminadmin") {
            $_SESSION["USER"]="admin";
            header('Location: admin-panel.php');
            exit;
        }
        else {
            $msg = "You entered wrong information...!!!";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin-Login</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color:#fff;background-color: #11698a;">
<div class="container" align="center">
    <h2></h2><br><br><br>
    <form action="index.php" method="post" style="width: 450px;padding: 15px;border-style: double;">
        <img src="images/doctor.png" style="width: 65%;height: 240px;">
        <div class="input-group">
            <h3>Health Care</h3>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input required type="text" class="form-control" name="username" id="username1" placeholder="Username : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input required type="password" class="form-control" name="password" id="password1"
                   placeholder="Password : "/>
        </div>
        <br/>
        <div class="input-group">
            <button name="login" style="width: 415px" type="submit" class="btn btn-danger glyphicon glyphicon-log-in"> Admin-Login</button>
        </div>
        <br/>
    </form>
</div>
<br/><br/>
<?php include "includes/footer.php" ?>

</body>
</html>
