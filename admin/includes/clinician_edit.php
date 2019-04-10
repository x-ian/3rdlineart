<script type="text/javascript">
$().ready(function() {
   $("#art_cliic").change(function() {
       document.getElementById("art_id_num_ref").value = $('#art_clinic :selected').val();
   });

   $("#art_district").change(function() {
    var selectVal = $('#art_district :selected').text();
    $.ajax({                                      
      url: 'getsubcat.php', 
      data: "dcode="+selectVal+'&facname_only=1',                                                     
      type:'post',
      success: function(data)    
      {
          // alert('selectVal is '+selectVal);
        $('#art_clinic').html(data);
      },
      complete: function() {
            // alert('hey1');
            // $("#art_clinic option:selected").prop("selected", false);
        }
    });
   });
   
   
   $("#edit-clinician").submit(function() {
       // alert('hey!');
       if ($('#art_clinic').val().startsWith('Select')) {
           alert('Please Select a Facility!');
           // $('#dialog').html('<p>Please Select a Facility within the District</p>').dialog({position: {at: "right bottom", of: $('#foo')}});
           return false;
       }
       // alert('check: '+$('#pswd').val()+' == '+$('#confirm_pswd').val());
       if ($('#pswd').val() != $('#confirm_pswd').val()) {
           alert('Passwords Don\'t Match!');
           return false;
       }
       return true;
   });

});
</script>
 
<div id="dialog" title="!!!">
</div>

<?php
global $id, $salt, $redir_page;
$id = $_GET['id'];
// echo "<br>redir_page=$redir_page";

$clinician = mysqli_query($bd, "SELECT * FROM clinician where id='$id'");
// echo "<br>clinician id=$id";
if (mysqli_num_rows($clinician)) {
    // echo "<br>here!";
    $row_clinician = mysqli_fetch_array($clinician);
    $art_clinic = $row_clinician['art_clinic'];
    $firstname = $row_clinician['fname'];
    $lastname = $row_clinician['lname'];
    if ($row_clinician['firstname'] == '')
        $clinician_name = "$firstname $lastname";
    $email = $row_clinician['email'];
    $phone = $row_clinician['phone'];
    $id = $row_clinician['id'];
    $user_id = $row_clinician['user_id'];
    $reviewer = (intval($row_clinician['isReviewer']) ? "checked" : "").' '.($readonlyroles?'disabled':'');
    // echo "<br>reviewer $reviewer";
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

    $district = mysqli_query( $bd,"SELECT dcode FROM facilitys WHERE name = '$art_clinic'"); 
    while ($row_district = mysqli_fetch_array($district)) {
        $this_district = $row_district['dcode'];
        break;
    }
}

if (isset(_POST['logoutafter']) || $logoutafter)
    $logoutafter = 1;
// else
//      $logoutafter = 0;
?>

<style type="text/css">
    input[type="text"],[type="email"],[type="password"],[type="tel"],select {
      height: 32px;
      width: 250px;
      font-size:120%;
      margin:5px 0 5px 0; 
    }
</style>

<h2 style="background-color:#fff; text-align:left; color:#000000"><?=$create_or_edit?> Clinician Registration</h2>
<hr />

<form id="edit-clinician" class="form-horizontal" action="dash.php?update_user" method="post">
<?php if ($logoutafter) echo '<input type="hidden" name="logoutafter" value="1">'; ?>
<?php if ($redir_page) echo '<input type="hidden" name="redir_page" value="'.$redir_page.'">'; ?>
	<div class="control-group id="foo"">

      District
      <select name="art_district" required type="text" id="art_district" >
          <option value="">Select ART Clinic District</option>
          <?php
          $district = mysqli_query( $bd,"SELECT distinct dcode FROM facilitys ORDER BY dcode"); 
          while ($row_district = mysqli_fetch_array($district)) {
            $district_name = $row_district['dcode'];
            $selected = ($this_district == $district_name ? 'selected="selected"' : '');
            echo "<option $selected>$district_name</option>";
          }
          ?>
      </select>

      Facility:
      <select id="art_clinic" name="art_clinic" required class="select_wide">
              <option value="<?php echo $art_clinic;?>" selected disabled><?php echo ((isset($art_clinic) and $art_clinic != '') ? $art_clinic : 'Select ART Clinic'); ?></option>
      </select>              
	</div> 
	<div class="control-group">											
		<label class="control-label" for="username">Username</label>
		<div class="controls">
			<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
			<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>" >
			<input type="text" class="text" id="username" name="username" required value="<?php echo $username; ?>" style="margin: 0px 0 0 5px;">
		</div>			
	</div>                           
	<!-- <div class="control-group">											
		<label class="control-label" for="fullname">Full Name</label>
		<div class="controls"> 
			<input type="text" class="text" id="fullname" name="fullname" required value="<?php echo $clinician_name; ?>" style="margin: 0px 0 0 5px"><br />
		</div>			
	</div> -->  
	<div class="control-group">											
		<label class="control-label" for="firstname">First Name</label>
		<div class="controls"> 
			<input type="text" class="text" id="firstname" name="firstname" required value="<?php echo $firstname; ?>" style="margin: 0px 0 0 5px"><br />
		</div>			
	</div>  
	<div class="control-group">											
		<label class="control-label" for="lastname">Surname</label>
		<div class="controls"> 
			<input type="text" class="text" id="lastname" name="lastname" required value="<?php echo $lastname; ?>" style="margin: 0px 0 0 5px"><br />
		</div>			
	</div>  
	<div class="control-group">											
		<label class="control-label" for="email">Email</label>
		<div class="controls">                               
			<input type="text" class="text" id="email" name="email" required value="<?php echo $email; ?>" style="margin: 0px 0 0 5px"><br />
		</div>			
	</div>  
	<div class="control-group">											
		<label class="control-label" for="phone">Phone Number</label>
		<div class="controls"> 
			<input type="text" class="text" id="phone" placeholder="+265 xxx xyz xyx" name="phone" required value="<?php echo $phone; ?>"  style="margin: 0px 0 0 5px"><br />
		</div>			
	</div>
	<div class="control-group">											
		<label class="control-label" for="password">Password</label>
		<div class="controls"> 
			<input type="password" class="text" id="pswd" name="password" minlength="6" value="<?=$passwd?>" required style="margin: 0px 0 0 5px"><br />
		</div>
	</div>

	<div class="control-group">											
		<label class="control-label" for="firstne">Confirm Password</label>
		<div class="controls"> 
			<input type="password" class="text" id="confirm_pswd" name="confirm_pswd" minlength="6" value="<?=$passwd?>" required style="margin: 0px 0 0 5px"><br />
		</div>			
	</div>

    <div class="control-group">											
		<label class="control-label" for="reviewer">Reviewer?</label>
		<div class="controls"> 
			<input type="checkbox" class="text" id="reviewer" name="reviewer" style="margin: 0px 0 0 5px" <?=$reviewer?> <br />
		</div>			
	</div>

	<div class="form-actions">
		<div class="span3">
			<a href="dash.php?p" class="btn btn btn-large" style="margin: 10px 0px 0px 10px; padding:10px; font-size:180%">Cancel</a>
		</div>
        <div class="span3">
<?php if ($new_or_edit == "Edit")
          echo '<button type="submit" class="btn btn-primary btn-large" style="margin: 10px 0px 0px 10px; padding:10px; font-size:180%" name="update_clinician">Update</button>';
      else
          echo '<button type="submit" class="btn btn-primary btn-large" style="padding:10px; font-size:180%" name="register_clinician">Register</button>';
?>
        </div>
	</div>
</form>