<?php
if(isset($_POST['register_clinician'])){
    echo "<br>new or edit: $new_or_edit";
	$clin_art_clinic = mysqli_real_escape_string($bd,$_POST['art_clinic']);
// common entries
	$username = mysqli_real_escape_string($bd,$_POST['username']);
	// $fullname = mysqli_real_escape_string($bd,$_POST['fullname']);
    $firstname = mysqli_real_escape_string($bd,$_POST['firstname']);
    $lastname = mysqli_real_escape_string($bd,$_POST['lastname']);
	$email = mysqli_real_escape_string($bd,$_POST['email']);
	$phone = mysqli_real_escape_string($bd,$_POST['phone']);
	$password = mysqli_real_escape_string($bd,$_POST['password']);
	$password_confirm = mysqli_real_escape_string($bd,$_POST['confirm_pswd']);
	$date_created = date('d/m/Y');
// end common entries
    
    $fullname = "$firstname $lastname";
    $isReviewer = mysqli_real_escape_string($bd,$_POST['reviewer']) == 'on' ? 1 : 0;  // why the fuck is the value "on' and not 1?
	$role = 'Clinician';

    // echo "<br>isReviewer $isReviewer";
    // echo "<br>$fullname, $clin_art_clinic";
    
    // $user_id = insert_user($username, 'create_clin');
///////////////////////////////////////////////////////////////////////////////////////////////////////// 
	$find_users = mysqli_query($bd, "SELECT * FROM users where username='".encrypt ($username, $enckey)."'");
	$getusers = mysqli_num_rows ($find_users);
	$pswd_size = strlen($password);

	if ($password != $password_confirm){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Yoo!</strong> Passwords dont match </p>
	</div>';
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?create_clin\">";  
    } else {
        if ($pswd_size < 6){
            echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Ooops!</strong>User creation failed, Password length less than 5 characters </p>
	</div>
	';
            echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?create_clin\">";     
        } else {
            if ($getusers > 0){
                echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Yoo!</strong> Username already taken </p>
	</div>
	';
                echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?create_clin\">"; 
            } else {
                $password = hasword ($password, $salt);
                $insert_users = " INSERT INTO users
	(username,password,role,date_created)
	VALUES (
	'".encrypt ($username, $enckey)."', '$password', '".encrypt ($role, $enckey)."', '$date_created')";                
                mysqli_query($bd, $insert_users);                
                $users = mysqli_query($bd, "SELECT * FROM users where username='".encrypt ($username, $enckey)."'"); 
                $row_users = mysqli_fetch_array($users);
                $user_id = $row_users['id'];
//////////////////////////////////////////////////////////////////////////////////////////////////////////

                $insert_clinician = " INSERT INTO clinician
	(user_id,art_clinic,name,fname,lname,email,phone,isReviewer)
	VALUES (
	'$user_id', '$clin_art_clinic', '$fullname', '$firstname', '$lastname', '$email', '$phone', '$isReviewer')";
                // echo "<br>$insert_clinician";
                try {
                    mysqli_query($bd, $insert_clinician);
                } catch (Exception $e) {
                    echo 'Caught exception: ' . $e->errorMessage() ."\n";
                    exit();
                }
                if ($isReviewer) {
                    	$insert_reviewer = " INSERT INTO reviewer
	(user_id,title,fname,lname,email,phone,affiliate_institution,snapshot,isClinician,isSecretary)
	VALUES (
	'$user_id', '$title', '$firstname', '$lastname', '$email', '$phone', '$clin_art_clinic','', '1', '0')";

                        try {
                            mysqli_query($bd, $insert_reviewer);
                        } catch (Exception $e) {
                            echo 'Caught exception: ' . $e->errorMessage() . "\n";
                            exit();
                        }
                }


	echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Success!</strong> New Clinician User '.$username.' was created. Sending email to '.$email.'
	</div>
	';
    email_msg('send_user_email', $email);    
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?man_clin\">"; 
            }           
        }
    }
}

?>