<?php

global $fullname, $username, $role, $enckey, $salt, $bd;
global $username, $fname, $lname, $email, $phone, $password, $password_confirm, $pswd_size;
global $logoutafter;

$logoutafter = isset($_POST['logoutafter']);

// echo '<br>'.isset($_POST['update_admin']).' - '.$_POST['update_user'].' : update_user, logoutafter: '.$logoutafter."username=".$_POST['username'].", password=".$_POST['password'];

mysqli_report(MYSQLI_REPORT_STRICT); 
function grab_common_fields() {
    global $bd, $username, $fname, $lname, $email, $phone, $password, $password_confirm, $pswd_size;    
    $username = mysqli_real_escape_string($bd,$_POST['username']);
    // $fullname = mysqli_real_escape_string($bd,$_POST['name']);
    $fname = mysqli_real_escape_string($bd,isset($_POST['fname']) ? $_POST['fname'] : $_POST['firstname']);
    $lname = mysqli_real_escape_string($bd,isset($_POST['lname']) ? $_POST['lname'] : $_POST['lastname']);
    $email = mysqli_real_escape_string($bd,$_POST['email']);
    $phone = mysqli_real_escape_string($bd,$_POST['phone']);
    $password = mysqli_real_escape_string($bd,$_POST['password']);
    $password_confirm = mysqli_real_escape_string($bd,$_POST['confirm_pswd']);
    $pswd_size = strlen($password);
}

function finish($where, $success=true) {
    global $logoutafter;
    if ($success)
        echo '<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#000">You have <strong> updated User details </strong>. </p>
	</div>';

    if (isset($_GET['source_page']) || $logoutafter) {
        // include ('includes/welcome_msg.php');
        echo"<meta http-equiv=\"Refresh\" content=\"2; url=" . "logout.php?" . "\">";
    } else {                    
        // echo "email message, username=$username, password=$password";                    
        // email_msg('send_user_email', $email);
        echo "<meta http-equiv=\"Refresh\" content=\"2; url=$main_page?$where&$source\">"; 
    }
}

function check_passwd($redir_page) {
    global $bd, $user_id, $username, $fname, $lname, $email, $phone, $password, $password_confirm, $pswd_size, $logoutafter, $update_id;        
    global $enckey, $salt;

    if ($password != $password_confirm) {
			echo '<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<p style="color:#f00"><strong>Yoo!</strong> Passwords dont match </p>
		</div>';
            echo"<meta http-equiv=\"Refresh\" content=\"2; url=".$main_page."?".$redir_page.$source."&id='.$update_id.'\">";
            return false;
    } else {
        if ($pswd_size < 6) {
            echo '<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<p style="color:#f00"><strong>Ooops!</strong>User creation failed, Password length less than 6 characters </p>
		</div>';
            finish('', false);
            return false;  // shouldn't get here
        }
    }
    $password = hasword ($password, $salt);
    // echo "<br>username is '$username', enckey is '$enckey'";
    $username = encrypt ($username, $enckey);
    // echo "<br>enc username is '$username'";
    return true;
}

function update_clinician($return=false) {
    global $bd, $user_id, $username, $fname, $lname, $email, $phone, $password, $password_confirm, $pswd_size, $logoutafter, $update_id;
    global $reviewer;
    
    grab_common_fields();
    $role = 'Clinician';
    
    $clin_art_clinic = mysqli_real_escape_string($bd,$_POST['art_clinic']);
    $reviewer = mysqli_real_escape_string($bd,$_POST['reviewer']) == '' ? '0' : '1';
    $role = 'Clinician';
	$fullname = "$fname $lname";
    // echo "<br>fname $fname, lname $lname";
    
    if (check_passwd('clin_edit')) {
        $sql_update_user = "UPDATE users ".
            "SET 
		username = '$username',
		password = '$password'
		WHERE id = '$user_id'" ;
            mysqli_query($bd, $sql_update_user);
            $sql_update_clinician = "UPDATE clinician SET 
		name = '$fullname',
		phone = '$phone',
		email = '$email',
		art_clinic = '$clin_art_clinic',
        isReviewer = '$reviewer'
		WHERE id = '$update_id'";
            if (mysqli_query($bd, $sql_update_clinician)) {
                if ($return)
                    return;
                finish('man_clin', true);
            }
    }
}

function update_lab_user() {
    global $bd, $user_id, $username, $fname, $lname, $email, $phone, $password, $password_confirm, $pswd_size, $logoutafter, $update_id;        

    grab_common_fields();
    $role = 'Lab';
    $address = mysqli_real_escape_string($bd,$_POST['address']);
    
	if (check_passwd('lab_edit')) {
            $sql_update_user =  "UPDATE users SET 
	username = '$username',
	password = '$password'
	WHERE id = '$user_id'" ;
            mysqli_query($bd, $sql_update_user);
            
            $sql_update_pih_lab =  "UPDATE pih_lab ".
                "SET 
	fname = '$fname',
	lname = '$lname',
	phone = '$phone',
	email = '$email',
    address = '$address'
	WHERE id='$update_id'" ;
            if (mysqli_query($bd, $sql_update_pih_lab)) {
                finish('man_lab', true);
            }
    }
}

function update_secretary($return=false) {
    global $bd, $user_id, $username, $fname, $lname, $email, $phone, $password, $password_confirm, $pswd_size, $logoutafter, $update_id;
    grab_common_fields();
    $role = 'Secretary';
    
	if (check_passwd('sec_edit')) {
        $sql_update_user =  "UPDATE users ".
			"SET 
            username = '$username',
			password = '$password'
			WHERE id = '$user_id'";
			mysqli_query($bd, $sql_update_user);

			$sql_update_secretary = "UPDATE secretary ".
			"SET 
			fname = '$fname',
			lname = '$lname',
			phone = '$phone',
			email = '$email'
			WHERE id = '$update_id'" ;

			if (mysqli_query($bd, $sql_update_secretary)) {
                if ($return)
                    return;
                finish('man_sec', true);
            } else { //
                echo '  <div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#000">You have failed to <strong> update User details </strong>.(2) </p>
	</div>';                
            }
    }
}

function update_reviewer($return) {
    global $bd, $user_id, $username, $fname, $lname, $email, $phone, $password, $password_confirm, $pswd_size, $logoutafter, $update_id;
    global $clinician, $secretary;
    
    // echo "<br>in update_reviewer";
    grab_common_fields();

	$title = mysqli_real_escape_string($bd,$_POST ['title']);
	$affiliate_institution = mysqli_real_escape_string($bd,$_POST ['affiliate_institution']);
	$snapshot = mysqli_real_escape_string($bd,$_POST['snapshot']);
    $clinician  = mysqli_real_escape_string($bd,$_POST['clinician']) == '' ? '0' : '1';
    $secretary = mysqli_real_escape_string($bd,$_POST['secretary']) == '' ? '0' : '1';
    $role = 'Reviewer';

    // echo 'update_user: update_rev!!';
    // echo "<br>after grab_common_fields";   
	if (check_passwd('rev_edit')) {
        $sql_update_user =  "UPDATE users ".
            "SET 
	username = '$username',
	password = '$password'
	WHERE id = '$user_id'";            
        // echo "sql update reviewer: $sql_update_user";
        mysqli_query($bd, $sql_update_user);
        $sql_update_reviewer =  "UPDATE reviewer ".
            "SET 
	title ='$title',
	fname ='$fname',
	lname ='$lname', 
	phone = '$phone',
	email = '$email',
	affiliate_institution = '$affiliate_institution',
	snapshot = '$snapshot',
    isClinician = '$clinician',
    isSecretary = '$secretary'
	WHERE id = '$update_id'";
        
        // echo "<br>updating $update_id";
        // echo "<br>$sql_update_user";
        // echo "<br>$sql_update_reviewer";
        if (mysqli_query($bd, $sql_update_reviewer)) {
            if ($return)
                return;
            finish('man_rev', true);
        }
    }
}

if(isset($_POST['update_user']) || isset($_GET['update_user'])) {
	$update_id = $_POST['id'];
	$user_id = $_POST['user_id'];
    // echo "<br>$user_id";
    
    if (isset($_POST['update_clinician'])) {
        update_clinician(true);
        if ($reviewer) {
            update_reviewer(true);
        }
        finish('man_clin', true);
    }
    
    if (isset($_POST['update_lab_user'])) {
        update_lab_user();
    }
    
    if (isset($_POST['update_sec'])) {
        update_secretary();
    }
    
    if (isset($_POST['update_admin'])) {
        update_admin();
    }
    
    if (isset($_POST['update_rev'])) {
        update_reviewer(true);
        if ($secretary) {
            update_secretary(true);
            // echo "<br>updated secretary";
        }
        if ($clinician) {
            update_clinician(true);
            // echo "<br>updated clinician";
        }
        // exit();
        finish('man_rev', true);        
    }
}
?>
