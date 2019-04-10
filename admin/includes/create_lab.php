<h2 style="background-color:#fff; text-align:left; color:#000000">New Lab User Registration</h2>
<hr />


<form id="edit-profile" class="form-horizontal" action="dash.php" method="post">
	<div class="control-group">											
		<label class="control-label" for="firstname">Username</label>
		<div class="controls">
			<input type="text" class="span4" id="username"  name="username" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="firstname">first Name</label>
		<div class="controls">
			<input type="text" class="span4" id="fname"   name="fname" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="firstname">Last name</label>
		<div class="controls">
			<input type="text" class="span4" id="lname"   name="lname" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="firstname">Email</label>
		<div class="controls">
			<input type="text" class="span4" id="email"  name="email" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="firstname">Phone</label>
		<div class="controls">
			<input type="tel" class="span4" id="phone"   name="phone" style="margin:5px"><br />
		</div>			
	</div>                   
	<div class="control-group">											
		<label class="control-label" for="firstname">Password</label>
		<div class="controls">
			<input type="password" class="span4" id="firstname"   name="password" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="firstname">Confirm Password</label>
		<div class="controls">
			<input type="password" class="span4" id="firstname"  name="confirm_pswd" style="margin:5px"><br />
		</div>			
	</div>
	
	<div class="form-actions">
		<div class="span2">
			<a href="dash.php?p" class="btn" style="padding:10px; font-size:180%">Cancel</a>
		</div>
		
		<div class="span3">
			<button type="submit" class="button btn btn-primary btn-large" style="padding:10px; font-size:180%" name="register_lab_user">Register</button>
		</div>
	</div>
	
	
</form>
