<?php
global $id, $enckey, $salt;
$id = $_GET['id'];

$admin = mysqli_query($bd, "SELECT * FROM admin where id='$id'"); 
$row_admin = mysqli_fetch_array($admin);
$fname = $row_admin['fname'];
$lname = $row_admin['lname'];
$phone = $row_admin['phone'];
$email = $row_admin['email'];
$id = $row_admin['id'];
$user_id = $row_admin['user_id'];
$user = mysqli_query($bd, "SELECT * FROM users where id='$user_id'"); 
$row_users = mysqli_fetch_array($user);
$username = $row_users['username'];
$username = decrypt ($username, $enckey);
$passwd = $row_users['password'];
$passwd = dehasword ($passwd, $salt);

?>

<h2 style="background-color:#fff; text-align:left; color:#000000">Edit Admin Registration</h2>
<hr />

<style type="text/css">
    input[type="text"],[type="email"],[type="password"],[type="tel"],select {
      height: 32px;
      width: 250px;
      font-size:120%;
      margin:5px 0 5px 0; 
    }
</style>


<form id="edit-profile" class="form-horizontal" action="dash.php?update_user" method="post">
	<div class="control-group">											
		<label class="control-label" for="firstname">Username</label>
		<div class="controls">
			<input type="hidden" class="span3" id="id" name="id" value="<?php echo $id; ?>" style="margin:5px" >
			<input type="hidden" class="span3" id="id" name="user_id" value="<?php echo $user_id; ?>" style="margin:5px" >
			<input type="text" class="span4" id="username" name="username" value="<?php echo $username; ?>" style="margin:5px"><br />
            <input type="hidden" name="redir_page" value="<?=$redir_page?>">
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
			<input type="password" class="span4" id="password" name="password" value="<?=$passwd?>" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="firstname">Confirm Password</label>
		<div class="controls">
			<input type="password" class="span4" id="confirm_pswd" name="confirm_pswd" value="<?=$passwd?>" style="margin:5px"><br />
		</div>			
	</div>                       
	<div class="form-actions">
       <div class="span3">
          <button class="button btn" style="display: flex; justify-content: center; padding:10px; font-size:180%">Cancel</button>
       </div>
       <div class="span3">
          <button type="submit" class="button btn btn-primary btn-large" style="display: flex; justify-content: center; padding:10px; font-size:180%" name="update_admin">Update</button>
       </div>
	</div>                    
</form>
