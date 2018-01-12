<?php
include 'db.php';
session_start();

$_SESSION['msg'] = '';

    class Admin {
        
        private $db;

        public function __construct(){
            $this->db = new mysqli(DB_SERVER, DB_USER, DB_PWD, DB_DATABASE);

            if(mysqli_connect_errno()){
                echo "Could not Connect";
                exit();
            }
        }

        //Get Connection 
        public function getConnection(){
            return $this->db;
        }
        
        public function Concern(){
            $con_sql = "SELECT  helpdesk.id AS id,
                                helpdesk.employee_id AS employee_id,
                                helpdesk.concerns AS concerns,
                                employee.emp_fname AS firstname,
                                employee.emp_lname AS lastname,
                                employee.emp_mname AS middlename,
                                employee.emp_email AS email
                                 FROM helpdesk INNER JOIN employee ON helpdesk.employee_id = employee.employee_id";
            $con_qry = mysqli_query($this->db, $con_sql);
            $num_rows = mysqli_num_rows($con_qry);
             
            echo "<table class='table table-striped' border='1'>";
            echo "<thead>
                    <th style='text-align: center;'>Employee ID #</th>
                    <th style='text-align: center;'><span class='fa fa-user'></span> Firstname</th>
                    <th style='text-align: center;'><span class='fa fa-user'></span> Middlename</th>
                    <th style='text-align: center;'><span class='fa fa-user'></span> Lastname</th>
                    <th style='text-align: center;'><span class='fa fa-envelope'></span> Emailaddress</th>
                    <th style='text-align: center;'><span class='fa fa-bug'></span> Concern</th>

                  </thead>";
            try{
                if($num_rows > 0){
                    echo "<tbody>";
                    while($row = mysqli_fetch_array($con_qry)){
                        echo "<tr>";
                        echo "<td class='employeeId'>".$row['employee_id']."</td>";
                        echo "<td class='name'>".$row['firstname']."</td>";
                        echo "<td class='mname'>".$row['middlename']."</td>";
                        echo "<td class='name'>".$row['lastname']."</td>";
                        echo "<td class='email'>".$row['email']."</td>";
                        echo "<td>".$row['concerns']."</td>";
                        echo "</tr>";
                        echo "</tbody>";
                    }
                }
                else{
                    throw new Exception('Theres no Concern right now :D');
                }
            }
            catch(Exception $ex){
                echo 'Message:  '.$ex->getMessage();
            }
            echo "</table>";
            //Number of Entries
            $sql_entries = "SELECT * FROM helpdesk";
            $qry_entries = $this->db->query($sql_entries);
            $num_rows =  $qry_entries->num_rows;
            echo "<p style='float: left;'>Showing of <b>$num_rows</b> entries</p>";
        }

        public function Request(){
            $req_sql = "SELECT helpdesk.id AS id,
                            helpdesk.employee_id AS emp_id,
                            helpdesk.department_id,
                            helpdesk.severity_id,
                            helpdesk.status_id,
                            helpdesk.id AS id,
                            helpdesk.concerns AS concern,
                            severity.severity AS severity,
                            department.department AS department,
                            stat.stat AS stat
                    FROM helpdesk INNER JOIN department ON helpdesk.department_id = department.department_id 
                    INNER JOIN severity ON helpdesk.severity_id = severity.severity_id INNER JOIN stat ON helpdesk.status_id = stat.status_id";
            
            $req_qry = $this->db->query($req_sql);
            $num_rows = $req_qry->num_rows;

            echo "<table class='table table-striped' border='1'>";
            echo "<thead>
                    <th style='text-align: center;'>Employee ID #</th>
                    <th style='text-align: center;'><span class='fa fa-bug'></span> Concern</th>
                    <th style='text-align: center;'><span class='fa fa-university'></span> Department</th>
                    <th style='text-align: center;'><span class='fa fa-exclamation-triangle'></span> Severity</th>
                    <th style='text-align: center;' colspan='2'><span class='fa fa-asterisk'></span> Status</th>
                  </thead>";
            try{
                if($num_rows > 0){
                    echo "<tbody>";
                    while($row = $req_qry->fetch_assoc()){
                        echo "<tr>";
                        echo "<td class='employeeId' style='padding-top: 11px;'>".$row['emp_id']."</td>";
                        echo "<td class='issues' style='padding-top: 11px;'>".$row['concern']."</td>";
                        if($row['department'] == 'CCS'){
                            echo "<td class='departmentCCS' style='padding-top: 12px;'>".$row['department']."</td>";
                        }
                        else if($row['department'] == 'CBA'){
                            echo "<td class='departmentCBA' style='padding-top: 12px;'>".$row['department']."</td>";
                        }
                        else if($row['department'] == 'CHS'){
                            echo "<td class='departmentCHS' style='padding-top: 12px;'>".$row['department']."</td>";
                        }
                        else if($row['department'] == 'CEN'){
                            echo "<td class='departmentCEN' style='padding-top: 12px;'>".$row['department']."</td>";
                        }
                        else if($row['department'] == 'CED'){
                            echo "<td class='departmentCED' style='padding-top: 12px;'>".$row['department']."</td>";
                        }
                        else if($row['department'] == 'CAS'){
                            echo "<td class='departmentCAS' style='padding-top: 12px;'>".$row['department']."</td>";
                        }
                        /** Switch Color for Severity */
                        if($row['severity'] == 'MINOR'){
                            echo "<td class='severityMinor' style='padding-top: 12px;'>".$row['severity']."</td>";
                        }
                        else if($row['severity'] == 'MAJOR'){
                            echo "<td class='severityMajor' style='padding-top: 12px;'>".$row['severity']."</td>";
                        }
                        else if($row['severity'] == 'CRITICAL'){
                            echo "<td class='severityCritical' style='padding-top: 12px;'>".$row['severity']."</td>";
                        }
                       /** Switch Color for status */
                        if($row['stat'] == 'Pending'){
                            echo "<td class='statusPending' style='padding-top: 12px;'>".$row['stat']."</td>"; 
                            echo "<td style='text-align: center; width: 5%''><a href='admin_update_stat.php?id=".$row['id']."'>
                            <button><span class='fa fa-pencil' style='font-size: 20px;'></span></button></a></td>";
                        }
                        else if($row['stat'] == 'Approved'){
                            echo "<td class='statusApproved' style='padding-top: 12px;'>".$row['stat']."</td>"; 
                            echo "<td style='text-align: center; width: 5%''><a href='admin_update_stat.php?id=".$row['id']."'>
                            <button><span class='fa fa-pencil' style='font-size: 20px;'></span></button></a></td>";
                        }
                        else if($row['stat'] == 'Ongoing'){
                            echo "<td class='statusOngoing' style='padding-top: 12px;'>".$row['stat']."</td>";
                            echo "<td style='text-align: center;  width: 5%'><a href='admin_update_stat.php?id=".$row['id']."'>
                            <button><span class='fa fa-pencil' style='font-size: 20px;'></span></button></a></td>";    
                        }
                        else if($row['stat'] == 'Solved'){
                            echo "<td class='statusSolved' style='padding-top: 12px;'>".$row['stat']."</td>";
                            echo "<td style='text-align: center; width: 5%'><button disabled><span class='fa fa-pencil' style='font-size: 20px;'></span></button></td>";
                        }
                        //**echo "<td style='text-align: center;'><a href='' class='admin_pencil'><span class='fa fa-pencil'></span></a></td>"; 
                        //**echo "<td><a href='admin_request.php?id=".$row['id']."' onclick='return adminDelete();' class='admin_trash'><span class='fa fa-trash'></span></a></td>";
                        echo "<tbody>"; 
                    }
                    echo "<table>";
                }
                else{
                    throw new Exception('Theres no Request right now :D');
                }  
            }
            catch(Exception $ex){
                echo 'Message:  '.$ex->getMessage();
            }     
        }
        
        public function History(){
            $hist_sql = "SELECT helpdesk.status_id AS id,
                                helpdesk.employee_id AS employee_id,
                                helpdesk.concerns AS concerns,
                                helpdesk.date AS date_sub,
                                stat.stat AS stat,
                                helpdesk.date2 AS date_fin
                         FROM helpdesk INNER JOIN stat ON helpdesk.status_id = stat.status_id";
            $hist_qry = $this->db->query($hist_sql);
            $num_rows = $hist_qry->num_rows;

            echo "<table class='table table-striped' border='1'>";
            echo "<thead>
                    <th style='text-align: center;'>Employee #</th>
                    <th style='text-align: center;'><span class='fa fa-bug'></span> Concern</th>
                    <th style='text-align: center;'><span class='fa fa-calendar'></span> Date Submitted</th>
                    <th style='text-align: center;'><span class='fa fa-calendar'></span> Date Finished</th>
                  </thead>";
            
            try{
                if($num_rows > 0){
                    echo "<tbody>";
                    while($row = mysqli_fetch_array($hist_qry)){
                        echo "<tr>";
                        echo "<td class='employeeId' style='padding-top: 17px;'>".$row['employee_id']."</td>";
                        echo "<td class='issues' style='padding-top: 17px;'>".$row['concerns']."</td>";
                        echo "<td class='dateSub1'>".$row['date_sub']."</td>";
                        echo "<td class='dateSub2'>".$row['date_fin']."</td>";
                       /** Switch Color for status */
                        /**if($row['stat'] == 'Pending'){
                            echo "<td class='status' style='max-width: 500px; background-color: #f9e018;'>".$row['stat']."</td>";
                        }
                        else if($row['stat'] == 'Approved'){
                            echo "<td class='status' style='max-width: 500px; background-color: #0b7bb7;'>".$row['stat']."</td>";
                        }   
                        else if($row['stat'] == 'Solved'){
                            echo "<td class='status' style='max-width: 500px; background-color: #07c14b;'>".$row['stat']."</td>";
                        }*/
                        echo "<tbody>"; 
                    }
                    echo "<table>";
                }
                else{
                    throw new Exception('Theres no History right now :D');
                }
            }
            catch(Exception $ex){
                echo 'Message:  '.$ex->getMessage();
            }
        }
        
        public function Delete($id){
            $del_sql = "DELETE FROM helpdesk WHERE id = '{$id}'";
            $del_qry = mysqli_query($this->db, $del_sql);
            $num_rows = mysqli_num_rows($del_qry);
            
            try{
                if($del_qry == true){
                    echo "<script type='text/javascript'>alert('Successfully Deleted')</script>";
                    $redirectURL = "http://localhost/helpdesk/admin_request.php";
                    echo "<script type='text/javascript'>window.location.href='$redirectURL'</script>";
                }
                else{
                    throw new Exception('Cant Deleted');
                }
            }
            catch(Exception $ex){
                echo 'Error:   '.$ex->getMessage();
            }
        }
        //Get Status
        public function getupdateStat($id){
            $stat_sql = "SELECT helpdesk.status_id, stat.stat AS status FROM helpdesk INNER JOIN stat ON helpdesk.status_id = stat.status_id 
            WHERE helpdesk.id = '{$id}'";
            $stat_qry = $this->db->query($stat_sql);
            $num_rows = $stat_qry->num_rows;
            $row = $stat_qry->fetch_assoc();
            $status = $row['status'];
            $_SESSION['stat'] = $status;
        }
        //Update Status Request
        public function updateStat($id, $stat, $dateFin){
            $status_sql = "SELECT * FROM stat WHERE stat = '{$stat}'";
            $status_qry = $this->db->query($status_sql);
            $num_rows = $status_qry->num_rows;
            $row = $status_qry->fetch_assoc();
            $stat_id = $row['status_id'];
            //Date Finished
            if($stat == 'Solved'){
                $date_sql = "UPDATE helpdesk SET date2 = '{$dateFin}' WHERE id = '{$id}'";
                $date_qry = $this->db->query($date_sql);

                $updt_sql = "UPDATE helpdesk SET status_id = '{$stat_id}' WHERE id = '{$id}'";
                $updt_qry = $this->db->query($updt_sql);

                try{
                    if($updt_qry && $date_qry == true){
                        echo "<script type='text/javascript'>alert('Successfully Updated')</script>";
                        $redirectURL = 'http://localhost/helpdesk/admin_request.php';
                        echo "<script type='text/javascript'>window.location.href='$redirectURL'</script>";
                    }   
                    else {
                        throw new Exception('No result!');
                    }
                }
                catch(Exception $ex){
                    $_SESSION['msg'] = 'Error:  '.$ex->getMessage();
                }
            }
            else{
                $updt_sql = "UPDATE helpdesk SET status_id = '{$stat_id}' WHERE id = '{$id}'";
                $updt_qry = $this->db->query($updt_sql);

                try{
                    if($updt_qry == true){
                        echo "<script type='text/javascript'>alert('Successfully Updated')</script>";
                        $redirectURL = 'http://localhost/helpdesk/admin_request.php';
                        echo "<script type='text/javascript'>window.location.href='$redirectURL'</script>";
                    }   
                    else {
                        throw new Exception('No result!');
                    }
                }
                catch(Exception $ex){
                    $_SESSION['msg'] = 'Error:  '.$ex->getMessage();
                }
            }
        }

        /*public function newConcern($concerns, $severity, $department, $uid, $date){
            //Select severity ID
            $sev_sql = "SELECT * FROM severity WHERE severity = '{$severity}'";
            $sev_qry = $this->db->query($sev_sql);
            $num_row = $sev_qry->num_rows;
            $row = $sev_qry->fetch_assoc();
            $sev_id = $row['severity_id'];
            $sev_name = $row['severity'];
            //Select department ID 
            $dep_sql = "SELECT * FROM department WHERE department = '{$department}'";
            $dep_qry = $this->db->query($dep_sql);
            $num_row = $dep_qry->num_rows;
            $row = $dep_qry->fetch_assoc();
            $dep_id = $row['department_id'];
            $sev_name = $row['department'];
            //Select employee ID
            $sql = "SELECT * FROM employee WHERE acc_id = '{$uid}'";
            $qry = $this->db->query($sql);
            $num_row = $qry->num_rows;
            $row = $qry->fetch_assoc();
            $emp_id = $row['employee_id'];
            
            $pending = "Pending/Approved/Ongoing";

            try{
                if(empty($concerns)){
                    $_SESSION['msg'] = '<p style="color: red">Please fill all the details below!</p>';
                    throw new Exception($_SESSION['msg']);
                }
                else{
                    $sql = "INSERT INTO `helpdesk`(`id`, `employee_id`, `severity_id`, `status_id`, `department_id`, `concerns`, `date`, `date2`) 
                    VALUES (NULL,'$emp_id','$sev_id','1','$dep_id','$concerns', '$date', '$pending')";
                    $qry = $this->db->query($sql);

                    if($qry == true) {  
                        $_SESSION['msg'] = '<p style="color: #1EA926">Successfully Added. This page will be refreshed in 10seconds.</p>';
                        header('Refresh:10');
                    }
                    else{
                        $_SESSION['msg'] = 'No result!';
                        throw new Exception($_SESSION['msg']);
                    }
                }
            }
            catch(Exception $ex){
                $_SESSION['msg'] =  '<b style="color:red">WARNING:</b>  ' .$ex->getMessage();
            }
        } */

        public function Actions(){
            $act_sql = "SELECT helpdesk.id AS id,
                            helpdesk.employee_id AS emp_id,
                            helpdesk.department_id,
                            helpdesk.severity_id,
                            helpdesk.status_id,
                            helpdesk.id AS id,
                            helpdesk.concerns AS concern,
                            severity.severity AS severity,
                            department.department AS department,
                            stat.stat AS stat
                    FROM helpdesk INNER JOIN department ON helpdesk.department_id = department.department_id 
                    INNER JOIN severity ON helpdesk.severity_id = severity.severity_id INNER JOIN stat ON helpdesk.status_id = stat.status_id";
            
            $act_qry = $this->db->query($act_sql);
            $num_rows = $act_qry->num_rows;
            
            echo "<form action='admin_edit.php' method='POST'>";
            echo "<button name='edit' class='btn updateConcern' onclick='return updConfirm()'><span class='fa fa-check'></span> Edit Concern</button>";
            echo "<button name='delete' class='btn deleteAllconcern' onclick='return adm_delConfirm()'><span class='fa fa-remove'></span> Delete Concern</button>";
            echo "<label style='float: right; padding-top: 13px;'><input type='checkbox' id='adm_checkAll'/> Check all</label>";
            echo "<table class='table table-striped' border='1'>";
            echo "<thead>
                    <th style='text-align: center;'>Employee ID #</th>
                    <th style='text-align: center;'><span class='fa fa-university'></span> Department</th>
                    <th style='text-align: center;'><span class='fa fa-exclamation-triangle'></span> Severity</th>
                    <th style='text-align: center;'><span class='fa fa-bug'></span> Concern</th>
                    <th style='text-align: center;' colspan='2'><span class='fa fa-superpowers'></span> Action</th>
                  </thead>";
            try{
                if($num_rows > 0){
                    echo "<tbody>";
                    while($row = $act_qry->fetch_assoc()){
                        echo "<tr>";
                        echo "<td class='employeeId' style='padding-top: 15px;'>".$row['emp_id']."</td>";
                        if($row['department'] == 'CCS'){
                            echo "<td class='departmentCCS' style='padding-top: 15px;'>".$row['department']."</td>";
                        }
                        else if($row['department'] == 'CBA'){
                            echo "<td class='departmentCBA' style='padding-top: 15px;'>".$row['department']."</td>";
                        }
                        else if($row['department'] == 'CHS'){
                            echo "<td class='departmentCHS' style='padding-top: 15px;'>".$row['department']."</td>";
                        }
                        else if($row['department'] == 'CEN'){
                            echo "<td class='departmentCEN' style='padding-top: 15px;'>".$row['department']."</td>";
                        }
                        else if($row['department'] == 'CED'){
                            echo "<td class='departmentCED' style='padding-top: 15px;'>".$row['department']."</td>";
                        }
                        else if($row['department'] == 'CAS'){
                            echo "<td class='departmentCAS' style='padding-top: 15px;'>".$row['department']."</td>";
                        }
                        /** Switch Color for Severity */
                        if($row['severity'] == 'MINOR'){
                            echo "<td class='severityMinor' style='padding-top: 15px;'>".$row['severity']."</td>";
                        }
                        else if($row['severity'] == 'MAJOR'){
                            echo "<td class='severityMajor' style='padding-top: 15px;'>".$row['severity']."</td>";
                        }
                        else if($row['severity'] == 'CRITICAL'){
                            echo "<td class='severityCritical' style='padding-top: 15px;'>".$row['severity']."</td>";
                        }
                        echo "<td class='issues' style='padding-top: 11px;'>".$row['concern']."</td>";
                        echo "<td width='10%' style='padding-top: 13px;'><input type='checkbox' name='checkbox[]' value=".$row['id']."> <i style='color:red;'></i></td>";
                        echo "</tr>"; 
                        
                    }

                }
                else{
                    throw new Exception('Theres no Request right now :D');
                }  
            }
            catch(Exception $ex){
                echo 'Message:  '.$ex->getMessage();
            }
            echo "</tbody>";
            echo "</table>";
            echo "</form>";     
        }

        public function adminDelete($box){
            if($box == 0){
                echo "<script>alert('Please Select atleast one checkbox!')</script>";
                $redirectURL = 'http://localhost/helpdesk/admin_action.php';
                echo "<script>window.location.href='$redirectURL'</script>";
            }
            else{    
                while(list($key, $val) = @each($box)){
                    $delAll_sql = "DELETE FROM helpdesk WHERE id = '{$val}'";
                    $delAll_qry = $this->db->query($delAll_sql);

                    try{
                        if($delAll_qry == true){
                            echo "<script>alert('Successfully Deleted')</script>";
                            $redirectURL = 'http://localhost/helpdesk/admin_action.php';
                            echo "<script>window.location.href='$redirectURL'</script>";
                        }
                        else{
                            throw new Exception('No result');
                        }
                    }
                    catch(Exception $ex){
                        echo "Error:  ".$ex->getMessage();
                    }
                }
            }
        }

        public function editCon($id, $new_concern){
            $N = count($id);
            for($i=0; $i < $N; $i++){
                //Get Severity ID 
                /*$sev_sql = "SELECT * FROM severity WHERE severity = '$new_severity[$i]'";
                $sev_qry = $this->db->query($sev_sql);
                $num_row = $sev_qry->num_rows;
                $row = $sev_qry->fetch_assoc();
                $sev_id = $row['severity_id'];
                //Get Department ID 
                $dep_sql = "SELECT * FROM department WHERE department = '$new_department[$i]'";
                $dep_qry = $this->db->query($dep_sql);
                $num_row = $dep_qry->num_rows;
                $row = $dep_qry->fetch_assoc();
                $dep_id = $row['department_id'];
                */
                
                $updt_sql = "UPDATE helpdesk SET concerns = '$new_concern[$i]' WHERE id = '$id[$i]'";
                $updt_qry = $this->db->query($updt_sql);
                try{
                    if($updt_qry == true){
                        $_SESSION['msg'] = '<p style="color: #1EA926;">Successfully Updated. This page will be refreshed in 10seconds.</p>';
                        header("Refresh:10");
                    }
                    else{
                        $_SESSION['msg'] = '<b style="font-size: 20px;">Cant Updated!</b>';
                        throw new Exception($_SESSION['msg']);
                    }
                }
                catch(Exception $ex){
                    $_SESSION['msg'] = '<b style="color: red; font-size: 20px;"><span class="fa fa-exclamation-triangle"></span> WARNING:</b>  '.$ex->getMessage();
                }
            }
        }
    }
?>