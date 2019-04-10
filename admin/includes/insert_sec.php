<?php

if(isset($_POST['register_sec'])) { 
	$username= mysqli_real_escape_string($bd,$_POST['username']);
	$fname= mysqli_real_escape_string($bd,$_POST['fname']);
	$lname= mysqli_real_escape_string($bd,$_POST['lname']);
	$email= mysqli_real_escape_string($bd,$_POST['email']);
	$phone= mysqli_real_escape_string($bd,$_POST['phone']);
	$password= mysqli_real_escape_string($bd,$_POST['password']);
	$password_confirm= mysqli_real_escape_string($bd,$_POST['confirm_pswd']);
	$fullname = "$fname $lname";
	$role ='Secretary';
	$date_created= date('d/m/Y');

    // $user_id = insert_user($username, 'create_sec');
/////////////////////////////////////////////////////////////////////////////////////////////////////////     
	$find_users=mysqli_query($bd, "SELECT * FROM users where username='".encrypt ($username, $enckey)."'"); 
	$getusers = mysqli_num_rows ($find_users);

	$pswd_size = strlen ($password);

	if ($password!=$password_confirm) {
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Yoo!</strong> Passwords dont match </p>
	</div>
	';
        echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?create_sec\">";  
    } else {
        if ($pswd_size < 6) {
            echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Ooops!</strong>User creation failed, Password length less than 5 characters </p>
	</div>
	';            
            echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?create_sec\">";     
        } else {
            if ($getusers > 0){
                echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Yoo!</strong> Username already taken </p>
	</div>
	';
                echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?create_sec\">"; 
            } else {
                $password = hasword ($password, $salt);
                $insert_users=" INSERT  INTO  users
	(username,password,role,date_created)
	VALUES (
	'".encrypt ($username, $enckey)."', '$password', '".encrypt ($role, $enckey)."', '$date_created')";                
                mysqli_query($bd, $insert_users);

                $users=mysqli_query($bd, "SELECT * FROM users where username='".encrypt ($username, $enckey)."'"); 
                $row_users=mysqli_fetch_array($users);
                $user_id =$row_users['id'];
/////////////////////////////////////////////////////////////////////////////////////////////////////////
                
                $insert_secretary=" INSERT  INTO  secretary
	(user_id,fname,lname,email,phone)
	VALUES (
	'$user_id', '$fname', '$lname', '$email', '$phone')";

                mysqli_query($bd, $insert_secretary);
                
                echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Success!</strong> New User was created.
	</div>
	';               
                include ('includes/send_user_email.php');
                echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?sec\">"; 
            }
        }
    }
}

?>