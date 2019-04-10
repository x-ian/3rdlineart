<?php
session_start();
include_once './includes/head.php';
global $username, $password, $role, $fullname, $enckey; 

$username = "";
$pword = "";
$secretary = 0;
$clinician = 0;
$reviewer = 0;

function quote_smart($value, $handle) {

   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }

   if (!is_numeric($value)) {
       // $value = "'" . mysqli_real_escape_string($value, $handle) . "'";
       $value = "'" . mysqli_real_escape_string($handle, $value) . "'";       
   }
   return $value;
}

$nopass = false;
$reset = isset($_POST['reset']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $username = $dusername = $_POST['username'];
   $pword = $_POST['password'];
   $username = htmlspecialchars($username);
   $pword = htmlspecialchars($pword);
   $redirect = $_GET['redirect'];
   
   // echo "<br>key is $enckey";
   // echo "<br>salt is $salt";

   // echo "<br>username is $username";   
   $username = encrypt($username, $enckey);
   // echo "<br>enc username is $username";
   $pword = hasword($pword, $salt);
   // echo "<br>pword is $pword";
   // exit();
   
   if ($reset or $nopass)
       $SQL = "SELECT * FROM users WHERE username='$username';";
   else
       $SQL = "SELECT * FROM users WHERE username='$username' AND password='$pword';";

   $result = mysqli_query($bd,$SQL);
   $num_rows = mysqli_num_rows($result);
   // echo $username;
   // echo "<br>$SQL, num_rows=$num_rows";
   // exit();
   
   //checking login attempts
   global $attempts, $row_id;

   // echo "<br>$dusername";
   $select_login_attempts = "SELECT * FROM login_attempts WHERE username='$dusername'";   
   $result_login_attempts = mysqli_query($bd, $select_login_attempts);
   $exist_attempts = mysqli_num_rows($result_login_attempts);

   $row_login_attempts = mysqli_fetch_array($result_login_attempts);
   $row_id = $row_login_attempts['id'];
   $attempts = $exist_attempts ? $row_login_attempts['attempts'] : 0;
   // end checking login attempts

   if ($num_rows != 0 && $attempts < 5) {
      while($row_user = mysqli_fetch_array($result)) {
        //reset login attempts 
        $reset_login_attempts = "DELETE FROM login_attempts WHERE username='$dusername'";
        // echo "<br>$reset_login_attempts";
        mysqli_query($bd, $reset_login_attempts);
        
        $role = $drole = decrypt($row_user['role'], $enckey);
        $user_id = $row_user['id'];
        // echo("role is a ".$role);

        $_SESSION['login'] = 'true';
        $_SESSION['role'] = $role;
        
        $username = $row_user['username'];
        $password = $row_user['password'];
        
        $_SESSION['username'] = $username;        
        $_SESSION['identification'] = $row_user['id'];
        $_SESSION['start'] = time(); // taking now logged in time (was time())
        $_SESSION['expire'] = $_SESSION['start'] + (4 * 60 * 60) ;
        // header ("Location:".$pageLocation);
        $message = 'You have logged in as a '.$role;

        // echo "<br>$message";
        if ($role == 'Clinician'){
            $SQL_clinician = "SELECT * FROM clinician WHERE user_id=$user_id";
            $clinician = mysqli_query($bd,$SQL_clinician);

            $row_clinician = mysqli_fetch_array($clinician);                
            $_SESSION['id'] = $row_clinician['id'];
            $names = explode(' ', $row_clinician['name']);
            $_SESSION['fname'] = $names[0];
            $_SESSION['lname'] = $names[1];
            $_SESSION['phone'] = $row_clinician['phone'];
            $_SESSION['email'] = $row_clinician['email'];
            $_SESSION['art_clinic'] = $row_clinician['art_clinic'];
            $_SESSION['clinician'] = 1;
            $reviewer = $row_clinician['isReviewer'];            
            $_SESSION['reviewer'] = $reviewer;
            // echo 'isReviewer: '.$reviewer;
            // echo "<script> $('[data-popup-open]').trigger('click'); </script>";
            // echo "<script> alert('$message'); </script>";
            $url = "app.php?p&reviewer=$reviewer";
            // echo "<br>".$row_clinician['name'];
       }

        if ($role == 'Reviewer'){
            $SQL_reviewer = "SELECT * FROM reviewer WHERE user_id=$user_id";
            $reviewer = mysqli_query($bd,$SQL_reviewer);
            $row_reviewer = mysqli_fetch_array($reviewer);

            $_SESSION['id'] = $row_reviewer['id'];    
            $_SESSION['fname'] = $row_reviewer['fname'];
            $_SESSION['lname'] = $row_reviewer['lname'];
            $_SESSION['phone'] = $row_reviewer['phone'];
            $_SESSION['email'] = $row_reviewer['email'];
            $_SESSION['reviewer'] = 1;
            $_SESSION['clinician'] = $clinician = $row_reviewer['isClinician'];
            $_SESSION['secretary'] = $secretary = $row_reviewer['isSecretary'];
            // echo 'login: isClinican '.$_SESSION['clinician'];
            // echo 'login: isSecretary='.$_SESSION['secretary'];
            $url = "reviewer/review_p1.php?p";
            // echo "<br>".$row_reviewer['lname'];
        }

        if ($role == 'Secretary'){
            $SQL_secretary = "SELECT * FROM secretary WHERE user_id=$user_id";
            $secretary = mysqli_query($bd,$SQL_secretary);
            $row_secretary = mysqli_fetch_array($secretary);

            $_SESSION['id'] = $row_secretary['id'];
            $_SESSION['fname'] = $row_secretary['fname'];
            $_SESSION['lname'] = $row_secretary['lname'];
            $_SESSION['phone'] = $row_secretary['phone'];
            $_SESSION['email'] = $row_secretary['email'];
            $secretary = $_SESSION['secretary'] = 1;
            // echo 'secretary: '. $_SESSION['fname'].' '.$_SESSION['lname'];
            $url = "check_point/cp_p1.php?p";
        }

        if ($role == 'Lab'){
            $SQL_pih_lab = "SELECT * FROM pih_lab WHERE user_id=$user_id";
            $pih_lab = mysqli_query($bd,$SQL_pih_lab);
            $row_pih_lab = mysqli_fetch_array($pih_lab);

            $_SESSION['id'] = $row_pih_lab['id'];
            $_SESSION['fname'] = $row_pih_lab['fname'];
            $_SESSION['lname'] = $row_pih_lab['lname'];
            $_SESSION['phone'] = $row_pih_lab['phone'];
            $_SESSION['email'] = $row_pih_lab['email'];
            $url = "pih/pih_p1.php?p";
        }
        
        if ($role == 'Admin'){
            $SQL_admin = "SELECT * FROM admin WHERE user_id=$user_id";
            $admin = mysqli_query($bd,$SQL_admin);
            $row_admin = mysqli_fetch_array($admin);

            $_SESSION['id'] = $row_admin['id'];
            $_SESSION['fname'] = $row_admin['fname'];
            $_SESSION['lname'] = $row_admin['lname'];
            $_SESSION['phone'] = $row_admin['phone'];
            $_SESSION['email'] = $row_admin['email'];
            $url = "admin/dash.php?p";
        }
        $fullname = $_SESSION['fname'].' '.$_SESSION['lname'];
        $role = $row_user['role'];

        // echo "<br>reset: $reset";
        if ($reset) {
            $url = "index.php";
            // send email
            email_msg('password_reset', $_SESSION['email']);
            echo '
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Hey!! </strong>A link to reset your password has been sent !!.
</div>';
            session_unset();
            session_destroy();
            $delay = 3;            
        } else
            $delay = 0;
        
        if ($redirect) 
            $url = $redirect;            
        echo sprintf("<meta http-equiv=\"Refresh\" content=\"%s; url=$url\">", $delay);
    }
}


if ($num_rows == 0 || $attempts >= 5) {
    echo "<br>attempts $attempts";
    $date = date ('d/m/Y');

    if ($exist_attempts) {
        $attempts = $attempts+1; 
        // echo $row_id.$attempts;

        $update_login_attempts = "UPDATE login_attempts ".
        "SET attempts='$attempts'
        WHERE id='$row_id'" ;
        mysqli_query($bd, $update_login_attempts);               
    }

    else {
        $attempts = 0;
        $insert_login_attempts = "INSERT INTO login_attempts (username, attempts, date)
        VALUES ('$dusername', '$attempts', '$date' )";
        echo "<br>$insert_login_attempts";
        // exit();
        mysqli_query( $bd,$insert_login_attempts);	
    }
    // echo $attempts;
    if ($attempts >= 5)
        $error = "been blocked";
    else
        $error = "failed";
    // echo 'error: '.$error;
                echo '
<div class="alert alert-failure">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Hey!! </strong>Your login has '.$error.'. '.($error == 'failed' ? 'Please Try Again !!' : '').'
</div>';

	//header ("Location: index.php?error=$error&use=$use");
    echo"<meta http-equiv=\"Refresh\" content=\"3; url=index.php?error=$error&sub=login\">";
}
}
?>