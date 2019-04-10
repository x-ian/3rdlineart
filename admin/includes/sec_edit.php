<?php
global $id, $enckey, $salt;
$id = $_GET['id'];

$secretary=mysqli_query($bd, "SELECT * FROM secretary where id='$id'"); 
$row_secretary=mysqli_fetch_array($secretary);
$fname = $row_secretary['fname'];
$lname = $row_secretary['lname'];
$phone = $row_secretary['phone'];
$email = $row_secretary['email'];
$id = $row_secretary['id'];
$user_id = $row_secretary['user_id'];
$users = mysqli_query($bd, "SELECT * FROM users where id='$user_id'"); 
$row_users = mysqli_fetch_array($users);
$username = $row_users['username'];
$passwd = $row_users['password'];
$passwd = dehasword ($passwd, $salt);

if (substr($username,-1,1) == '=') {
    $username = str_replace(' ', '+', $username);
    $username = decrypt($username, $enckey);
    // echo '<br>username is '.$username;
}
?>

<h2 style="background-color:#fff; text-align:left; color:#000000">Edit Secretary Registration</h2>
<hr />

<form id="edit-profile" class="form-horizontal" action="dash.php?update_user" method="post">
	<div class="control-group">											
		<label class="control-label" for="firstname">Username</label>
		<div class="controls">
			<input type="hidden" class="span3" id="id" name="id" value="<?php echo $id; ?>" style="margin:5px" >
			<input type="hidden" class="span3" id="id" name="user_id" value="<?php echo $user_id; ?>" style="margin:5px" >
			<input type="text" class="span4" id="username"  name="username" value="<?php echo $username; ?>" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="firstname">First Name</label>
		<div class="controls">                        
			<input type="text" class="span4" id="fname" name="fname" value="<?php echo $fname; ?>" style="margin:5px"><br />
		</div>			
	</div>              
	<div class="control-group">											
		<label class="control-label" for="firstname">Last Name</label>
		<div class="controls">  
			<input type="text" class="span4" id="lname" name="lname" value="<?php echo $lname; ?>" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="firstname">Email</label>
		<div class="controls">
			<input type="email" class="span4" id="email" name="email" value="<?php echo $email; ?>" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="firstname">Phone Number</label>
		<div class="controls">
			<input type="tel" class="span4" id="phone" name="phone" value="<?php echo $phone; ?>" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="firstname">Password</label>
		<div class="controls">
			<input type="password" class="span4" id="firstname" name="password" value="<?=$passwd?>" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="firstname">Confirm Password</label>
		<div class="controls">
			<input type="password" class="span4" id="firstname" name="confirm_pswd" value="<?=$passwd?>" style="margin:5px"><br />
		</div>			
	</div>                       
	<div class="form-actions">
		<div class="span4">
			<button class="btn" style="padding:10px; font-size:180%">Cancel</button>
		</div>
		<div class="span4">
			<button type="submit" class="button btn btn-primary btn-large" style="padding:10px; font-size:180%" name="update_sec">Register</button>
		</div>
	</div>                    
</form>
