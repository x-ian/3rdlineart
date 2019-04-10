<h2 style="background-color:#fff; text-align:left; color:#000000">New Clinician Registration</h2>
<hr/>

<form id="edit-profile" class="form-horizontal" action="dash.php" method="post">
	<div class="control-group">											
		<label class="control-label" for="firstname">ART Clinic</label>
		<div class="controls">                          
			<select name="art_clinic" required id="art_clinic" style="margin:5px">
				<option selected="selected" value="">select ART Clinic</option>
				<?php
                // facility
				$facility=mysqli_query( $bd,"SELECT * FROM facility"); 
				while ($row_facility=mysqli_fetch_array($facility)) {
					$facility_name =$row_facility['facilityName'];			
					echo '<option>'.$facility_name.'</option>';
				}
				?>
			</select><br />
		</div>			
	</div> 
	<div class="control-group">											
		<label class="control-label" for="firstname">Username</label>
		<div class="controls">   
			<input type="text" class="span4" id="firstname" name="username" style="margin:5px"><br />
		</div>			
	</div>                           
	<div class="control-group">											
		<label class="control-label" for="fullname">Full Name</label>
		<div class="controls"> 
			<input type="text" class="span4" id="fullname" name="name" style="margin:5px"><br />
		</div>			
	</div>  
	<div class="control-group">											
		<label class="control-label" for="email">Email</label>
		<div class="controls">                               
			<input type="text" class="span4" id="email"  name="email" style="margin:5px"><br />
		</div>			
	</div>  
	<div class="control-group">											
		<label class="control-label" for="phone">Phone Number</label>
		<div class="controls"> 
			<input type="text" class="span4" id="phone" placeholder="+265 xxx xyz xyx"  name="phone" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="pswd">Password</label>
		<div class="controls"> 
			<input type="password" class="span4" id="pswd"  name="password" style="margin:5px"><br />
		</div>			
	</div>

	<div class="control-group">											
		<label class="control-label" for="pswd">Confirm Password</label>
		<div class="controls"> 
			<input type="password" class="span4" id="pswd"  name="confirm_pswd" style="margin:5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="reviewer">Reviewer?</label>
		<div class="controls"> 
			<input type="checkbox" class="span4" id="reviewer"  name="reviewer" style="margin:5px"><br />
		</div>			
	</div>

	<div class="form-actions">
		<div class="span3">
			<a href="dash.php?p" class="btn" style="padding:10px; font-size:180%">Cancel</a>
		</div>
		<div class="span3">
			<button type="submit" class="btn btn-primary btn-large" style="padding:10px; font-size:180%" name="register_clinician">Register</button>
		</div>
	</div>
	
	
</form>
