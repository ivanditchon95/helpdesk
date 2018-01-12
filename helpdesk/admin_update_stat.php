<?php

include_once('admin.php');
$obj = new Admin();
$id = $_GET['id'];
/** If the link update was click */
if(isset($_GET['id'])){
    $obj->getupdateStat($id);
    $status = $_SESSION['stat'];
}

if(isset($_POST['update'])){
    $stat = $_POST['update_stat'];
    date_default_timezone_set('Asia/Manila');
    $dateFin = date('l jS \of F Y h:i:s A'); 
    $obj->updateStat($id, $stat, $dateFin);

}
/** End */
/** If logout was click */
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
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="assets/images/favicon.png"> 
    <script src="bootstrap/js/jquery.min.js"></script>
    <title>Update Status</title>
</head>
<body>
    <div class="header">
        <div class="fixed-container">
            <div class="logo">
                <a href="#">HelpDesk</a>
            </div>
            <div class="nav">
                <ul>
                    <li>Welcome to administration area: <a href="admin_index.php?l=logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="fixed-container">
        <div class="content">
            <a href="admin_concern.php"><button class="btn btn-primary">Concern</button></a>
            <a href="admin_request.php"><button class="btn btn-primary">Request</button></a>
            <a href="admin_history.php"><button class="btn btn-primary">History</button></a>
            <a href="admin_action.php"><button class="btn btn-primary">Actions</button></a>
        </div>
        <div class="content">
            <div class="row">
                <form action="#" method="POST">
                <label for="update_stat" style="float: left">Status:</label>
                <select name="update_stat" id="update_stat" name="update_stat" class="form-control">
                    <option><?php echo $status; ?></option>
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Solved">Solved</option>
                </select>
                <button class="btn btn-success" name="update" style="margin-top: 15px;">UPDATE</button>
                </form>
            </div>
        </div>     
    </div>
    <footer> 
        
    </footer>
</body>
</html>