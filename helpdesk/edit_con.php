<?php
include_once('employee.php');

$obj = new Employee();
$uid = $_SESSION['user_id'];

if(isset($_POST['updateCon'])){
    $id = $_POST['id'];
    $new_concern = $_POST['concerns'];
    $obj->editCon($id, $new_concern);
}

if(isset($_POST['delete'])){
    @$box = $_POST['checkbox'];
    $adm_obj->adminDelete($box);
}
// When logout is clicked 
if(isset($_GET['l'])){
    $obj->Logout();
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
    <title>Update</title>
</head>
<body>
    <div class="header">
        <div class="fixed-container">
            <div class="logo">
                <a href="#">HelpDesk</a>
            </div>
            <div class="nav">
                <ul>
                    <li>Welcome: <?php $obj->getUser($uid); ?> <a href="user_index.php?l=logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="fixed-container">
        <div class="content">
            <a href="concern.php"><button class="btn btn-primary">Concern</button></a>
            <a href="request.php"><button class="btn btn-primary">Request</button></a>
            <a href="history.php"><button class="btn btn-primary">History</button></a>
        </div>
        <div class="content">
            <div class="row">
            <?php if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
            }
            ?>
                <form action="#" method="POST">
                <?php
                if(isset($_POST['edit'])){
                    @$box = $_POST['checkbox'];
                    if($box == 0){
                        echo "<script>alert('Please Select atleast one checkbox!')</script>";
                        $redirectURL = 'http://localhost/helpdesk/concern.php';
                        echo "<script>window.location.href='$redirectURL'</script>";
                    }
                    $N = count($box);
                    for($i=0; $i < $N; $i++){
                        $result = mysqli_query($obj->getConnection(),"SELECT helpdesk.id AS id,
                        helpdesk.concerns AS concerns,
                        severity.severity AS severity,
                        department.department AS department
                        FROM helpdesk INNER JOIN severity ON helpdesk.severity_id = severity.severity_id 
                        INNER JOIN department ON helpdesk.department_id = department.department_id WHERE helpdesk.id = '$box[$i]'");
                    
                        while($row = mysqli_fetch_array($result))
                        { ?>
                            <div class="row">
                                <input name="id[]" type="hidden" value="<?php echo  $row['id'] ?>" />
                                <label for="concerns" style="float: left">Message:</label>
                                <textarea name="concerns[]" id="concerns" class="form-control" placeholder="Your Concern..."><?php echo $row['concerns'];?></textarea>
                            </div>
                            <div class="row">
                                <button class="btn btn-success" name="updateCon" id="concern" style="margin-top: 20px;"><span class="fa fa-paper-plane"></span> UPDATE</button>
                            </div>
            <?php 
                        }
                    }
                }
            ?>
                </form>
            </div>
        </div>      
    </div>
    <footer></footer>
</body>
</html>
