<?php

if(isset($_POST['register_lab_user'])){ 
		
	$username= mysqli_real_escape_string($bd,$_POST['username']);
	$fname= mysqli_real_escape_string($bd,$_POST['fname']);
	$lname= mysqli_real_escape_string($bd,$_POST['lname']);
	$email= mysqli_real_escape_string($bd,$_POST['email']);
	$phone= mysqli_real_escape_string($bd,$_POST['phone']);
	$password= mysqli_real_escape_string($bd,$_POST['password']);
	$password_confirm= mysqli_real_escape_string($bd,$_POST['confirm_pswd']);
	
	$role ='Lab';
	
	$date_created= date('d/m/Y');
	
	$find_users=mysqli_query($bd, "SELECT * FROM users where username='".encrypt ($username, $enckey)."'");
	$getusers = mysqli_num_rows ($find_users);
	
	$pswd_size = strlen ($password);
	
	if ($password!=$password_confirm){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Yoo!</strong> Passwords dont match </p>
		
	</div>
	';
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?create_lab_user\">";  
}

else {
	
	if ($pswd_size < 6){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Ooops!</strong>User creation failed, Password length less than 5 characters </p>
		
	</div>
	';
	
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?create_lab_user\">";     
}
else {
	
	if ($getusers > 0){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Yoo!</strong> Username already taken </p>
		
	</div>
	';
	
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?create_lab_user\">"; 
}
else {
	
	$password= hasword ($password, $salt);
	
	$insert_users=" INSERT  INTO  users
	(username,password,role,date_created)
	VALUES (
	'".encrypt ($username, $enckey)."', '$password', '".encrypt ($role, $enckey)."', '$date_created')";

	mysqli_query($bd, $insert_users);
	
	$users=mysqli_query($bd, "SELECT * FROM users where username='".encrypt ($username, $enckey)."'"); 
	$row_users=mysqli_fetch_array($users);
	$user_id =$row_users['id'];
	
	$insert_pih_lab=" INSERT  INTO  pih_lab
	(user_id,fname,lname,email,phone)
	VALUES (
	'$user_id', '$fname', '$lname', '$email', '$phone')";

	mysqli_query($bd, $insert_pih_lab);
	
	echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Success!</strong> New User was created.
	</div>
	';
	
    email_msg('send_user_email', $email);
    
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?man_lab\">"; 
	
}
}
}
}

?>