<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Login - 3rd Line ART Expert Committee Malawi</title>
<?php
include ('../includes/head.php');
?>
</head>
<body>
	
	<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="index.html">
				3rd Line ART Expert Committee Malawi				
			</a>	
			<div class="nav-collapse">
				<ul class="nav pull-right">
					<li class="">						
						
					</li>
					<li class="">						
						<a href="#" class="">
							<i class="icon-chevron-left"></i>
							help
						</a>
					</li>
				</ul>
			</div><!--/.nav-collapse -->	
		</div> <!-- /container -->
	</div> <!-- /navbar-inner -->
</div> <!-- /navbar -->


<div class="account-container">
	<div class="content clearfix">
		<form action="login.php" method="post" name="login">
			<h1>Administrator Login</h1>		
			
			<div class="login-fields">
				
				<p>Please provide your details</p>
                <?php
if(isset($_GET ['error'])){ 
$_error = $_GET ['error'];
if ($_error =='fail'){
    echo'
				<p style="color:#f00">You issued wrong Username or Password</p>
                    ';}
}
                ?>
				<div class="field">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
				</div> <!-- /password -->
			</div> <!-- /login-fields -->
			<div class="login-actions">
				<span class="login-checkbox">
                    <input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span>				
                <input class="button btn btn-success btn-large" type="submit" name="submit" value="Sign In"/>
			</div> <!-- .actions -->
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->



<div class="login-extra">
	<a href="reset.php">Reset Password</a>
</div>
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/signin.js"></script>

</body>

</html>
