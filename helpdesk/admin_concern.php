<?php
include_once('admin.php');
$adm_obj = new Admin();

if(isset($_GET['l'])){
    include_once('employee.php');
    $obj = new Employee();
    header("location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/mystyle.css"/>
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css"/>
    <link rel="icon" type="image/png" href="assets/images/favicon.png"> 
    <script src="bootstrap/js/jquery.min.js"></script>
    <title>Concern</title>
</head>
<body>
    <div class="header">
        <div class="fixed-container">
            <div class="logo">
                <a href="#">HelpDesk</a>
            </div>
            <div class="nav">
                <ul>
                    <li>Welcome to administration area: <a href="admin_concern.php?l=logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="fixed-container">
        <div class="content">
            <a href="#"><button class="btn btn-primary" id="active">Concern</button></a>
            <a href="admin_request.php"><button class="btn btn-primary">Request</button></a>
            <a href="admin_history.php"><button class="btn btn-primary">Reports</button></a>
            <a href="admin_action.php"><button class="btn btn-primary">Actions</button></a>
        </div>
        <div class="content">
            <?php echo $adm_obj->Concern(); ?>
        </div>     
    </div>
    <footer> 
        
    </footer>
</body>
</html>