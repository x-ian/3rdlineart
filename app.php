	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Application Form</title>
 
<?php
session_start();          
include ('includes/head.php'); ?>

</head>
<?php 
global $role, $now, $expire, $user_id, $fullname, $loginfullname, $clinicianID;

$redirect = isset($_GET['redirect_after']) ? urlencode($_SERVER['REQUEST_URI']) : '';
if (isset($_SESSION['identification'])) {
    $role = 'Clinician';
	$user_id = $_SESSION['identification'];
    $user = new User($user_id);
	$clinicianID = $user->clinician ? $user->clinicianID : $_SESSION['id'];
    // echo "<br>clinicianID, $clinicianID, user_id $user_id";
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
	$fullname = $loginfullname = $fname . " " . $lname;

	$clin_phone = $_SESSION['phone'];
	$clin_email = $_SESSION['email'];
	$facility = $_SESSION['art_clinic'];
    
	$now = time(); 
	$expire = $_SESSION['expire'];

    $expired = ((integer)$now) > ((integer)$expire);
    // echo "$now > $expire".":".$expired;
    if ($expired) {
        if (!$redirect)
            echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Hey!!</strong> Your session has expired. Please Login again to continue!!.
	</div>';
        // echo "<br>it has been " . (($expire - $_SESSION['start'])/60) . ' secs';
        echo "<meta http-equiv=\"Refresh\" content=\"2; url=" . "logout.php?redirect=$redirect" . "\">";
    }
} else {
        if (!$redirect)    
            echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Hey!!</strong> Your session has expired. Please Login again to continue!!.
	</div>';
        echo "<meta http-equiv=\"Refresh\" content=\"2; url=" . "logout.php?redirect=$redirect" . "\">";
}
if (!isset($_SESSION['role']))
    $_SESSION['role'] = $role; // need to set to start
?>
<body>
<?php
// echo 'role is: '.$_SESSION['role'];

include ('includes/nav_main.php');
include ('includes/nav_sub.php');

/*
echo "<br>POSTS:";
foreach($_POST as $key => $value) { echo "<br>$key: $value"; }
echo "<br>GETS:";
foreach($_GET as $key => $value) { echo "<br>$key: $value"; }
*/
// exit();


// echo "<br>REFERER: ".$_SERVER['HTTP_REFERER'];

?>
	<div class="main">

		<div class="main-inner">

			<div class="container">
				<?php
				if (isset($_SESSION['identification'])){
					// echo '<span class="glyphicon glyphicon-user">Clinician</span>';
				}
				?>  
				<div class="row">

					<div class="span12">

						<div class="widget">

							<div class="widget-content">

                                <div class="pricing-plans plans-3">

<?php

    global $tot_number;
$form_creation = mysqli_query($bd, "SELECT * FROM form_creation, expert_review_consolidate1 WHERE form_creation.3rdlineart_form_id not in (select form_id from sample) and form_creation.3rdlineart_form_id=expert_review_consolidate1.form_id and form_creation.clinician_id ='$clinicianID'"); 
$tot_number = mysqli_num_rows ($form_creation);

global $tot_number_conso2;
$form_creation_conso2 = mysqli_query($bd, "SELECT * FROM form_creation, expert_review_consolidate2 WHERE form_creation.3rdlineart_form_id=expert_review_consolidate2.form_id and form_creation.clinician_id ='$clinicianID'"); 
$tot_number_conso2 = mysqli_num_rows($form_creation_conso2);
?>

</div>
<?php
if(isset($_POST['search'])) { 
    
    $pat_id = $_POST['id'];
    if ($pat_id !='--select ARV Number--') {        
        if(isset($_POST['comment'])){ 
            $pat_id =$pat_id.'&comment&form_id='.$_POST['form_id'];
        }                                       
        echo"<meta http-equiv=\"Refresh\" content=\"0; url=app.php?back&part_1&pat_id=".$pat_id."\">";
    }
    else {
        include ('includes/app_patientdetails_edit.php');   
    }
}

global $pat_id, $gender, $age, $dob;
$patient = new Patient($pat_id);

if(isset($_GET['g'])){ 
    $gender = $_GET['g'];
    $_SESSION['gender'] = $gender;
} else
    $gender = $_SESSION['gender'];

if(isset($_POST['dob'])) {
    $dob = $_POST['dob'];
    $age = GetAge($dob);
    $_SESSION['age'] = $age;
} else if (isset($_GET['xx']))
    $age = $_GET['xx'];
else
    $age = $_SESSION['age'];

// echo "age is $age, gender is $gender";
if(isset($_GET['p'])) {
    // $_SESSION['role'] = 'Clinician'; // need to set?
    include ('includes/app_facility.php');  
}

if(isset($_GET['admin'])) {
    echo "<meta http-equiv=\"Refresh\" content=\"2; url=" . "admin/dash.php" . "\">";                                    
}
// dash stats
if(isset($_GET['dash'])){ 
    include ('includes/app_dashboard.php');  
}

if(isset($_GET['rejec'])){ 
    include ('includes/app_rejected_forms.php');  
}

if(isset($_GET['rev'])){ 
    include ('includes/app_consolidated1.php');   
}

if(isset($_GET['rev_complete'])){
    // echo '<br>'.sprintf($clinician_query['app_refer_decisions_complete'], $clinicianID);
    $form_creation = mysqli_query($bd, sprintf($clinician_query['app_refer_decisions_complete'], $clinicianID));
    include ('includes/app_consolidated1.php');   
}

if(isset($_GET['conso2'])){ 
    include ('includes/app_consolidated2.php');   
}

if(isset($_GET['conso2view'])){ 
    include ('includes/app_consolidated2_view.php');   
}

if(isset($_GET['view'])){ 
    include ('includes/app_consolidated1_view.php');   
}

if(isset($_GET['sendsample'])){ 
    include ('includes/db_operations/insert_sample.php'); 
    echo"<meta http-equiv=\"Refresh\" content=\"1; url=app.php?p\">";
}

if(isset($_POST['submit_p'])){ 
    include ('includes/app_facility.php');   
}

if(isset($_POST['submit_facility']) || isset($_GET['return_part_1'])){
    include ('includes/app_patientdetails_edit.php');   
}

if(isset($_GET['part_1'])){ 
    include ('includes/app_patientdetails_edit.php');   
}

if(isset($_GET['app_clin'])){ 
    include ('includes/app_clinic_status_edit.php');  // was app_clinic_status 
}

if(isset($_GET['completed'])){ 
    include ('includes/app_completed_forms.php');  // was app_clinic_status 
}

if(isset($_GET['del_application'])){ 
    include ('includes/delete_application.php'); 
}


if(isset($_POST['submit_patD'])) {
    include ('includes/db_operations/insert_patient.php');
    include ('includes/app_clinic_status_edit.php');
}

if (isset($_POST['submit_clinicstatus'])) {
    include ('includes/db_operations/insert_clinic_status.php');                                    
    if ($age <= 15)
        include ('includes/app_pedriatric_edit.php');
    else if ($gender == 'Female' && $age >= 10) {
        include ('includes/app_pregnancy_edit.php');
    } else
        include ('includes/app_treatment1_edit.php');                                    
}

if(isset($_POST['submit_pediatric'])){
    include ('includes/db_operations/insert_pediatric.php');
    if ($gender == 'Female' && $age >= 10)
        include ('includes/app_pregnancy_edit.php');
    else
        include ('includes/app_treatment1_edit.php');
}

if(isset($_POST['submit_Preg'])){ 
    include ('includes/db_operations/insert_pregnancy.php');
    include ('includes/app_treatment1_edit.php');
}

if(isset($_POST['submit_treatment1'])){
    // shouldn't get here
    include ('includes/db_operations/insert_treatment1.php');
    include ('includes/app_treatment2_edit.php');                                    
}

if(isset($_POST['submit_treatment2'])){ 
    include ('includes/db_operations/insert_treatment2.php');
    include ('includes/app_treatment3_edit.php');                                    
}

if(isset($_POST['submit_treatment3'])){ 
    include ('includes/db_operations/insert_treatment3.php');   
    include ('includes/app_adherence_edit.php');   								}

// update form processes
if(isset($_POST['update_patD'])) {
    include ('includes/db_operations/update_patient.php');
    include ('includes/app_clinic_status_edit.php'); 
}

if (isset($_POST['update_clinicstatus'])) { 
    include ('includes/db_operations/update_clinic_status.php');
    if ($age <= 15)
        include ('includes/app_pedriatric_edit.php');
    else if ($gender == 'Female' && $age >= 10)
        include ('includes/app_pregnancy_edit.php');
    else
        include ('includes/app_treatment1_edit.php');                                    
}

if(isset($_POST['update_pediatric'])){ 
    include ('includes/db_operations/update_pediatric.php');
    if ($gender == 'Female' && $age >= 10)
        include ('includes/app_pregnancy_edit.php');
    else
        include ('includes/app_treatment1_edit.php');                                    
}

if(isset($_POST['update_Preg'])){
    // echo "update preg?";
    include ('includes/db_operations/update_pregnancy.php');
    include ('includes/app_treatment1_edit.php');                                    
}

if(isset($_POST['update_treatment1'])){ 
    include ('includes/db_operations/update_treatment1.php'); 
    include ('includes/app_treatment2_edit.php');
}

if(isset($_POST['update_treatment2'])){ 
    include ('includes/db_operations/update_treatment2.php'); 
    include ('includes/app_treatment3_edit.php');
} 

if(isset($_POST['update_treatment3'])){
    // echo "<br>update_treatment3";
    include ('includes/db_operations/update_treatment3.php'); 
    include ('includes/app_adherence_edit.php'); 
}

// goes back to either preg, pediatric or clinic_status
if(isset($_GET['back_treatment1'])){
    if ($gender == 'Female' && $age >= 10)
        include ('includes/app_pregnancy_edit.php');                                        
    else if ($age <= 15)
        include ('includes/app_pedriatric_edit.php');                                        
    else
        include ('includes/app_clinic_status_edit.php');
}

// goes back to either pediatric or clinic_status
if(isset($_GET['back_preg'])){
    if ($age <= 15)
        include ('includes/app_pedriatric_edit.php');                                        
    else
        include ('includes/app_clinic_status_edit.php');
}

// goes back to treatment1
if(isset($_GET['back_treatment2'])){ 
    include ('includes/app_treatment1_edit.php');
}

// goes back to treatment2
if(isset($_GET['back_treatment3'])){ 
    include ('includes/app_treatment2_edit.php');
}

// goes back to treatment3 (TB Treatment)
if(isset($_GET['back_adherence'])){ 
    include ('includes/app_treatment3_edit.php'); 
}
// goes back to adherence
if(isset($_GET['back_complete'])){
    include ('includes/app_adherence_edit.php');                                     
}

?>		

							</div> <!-- /pricing-plans -->

						</div> <!-- /widget-content -->

					</div> <!-- /widget -->					

				</div> <!-- /span12 -->     	

			</div> <!-- /row -->

		</div> <!-- /container -->

	</div>

</div> <!-- /main -->

<?php include ('includes/footer.php'); ?>   
</body>

</html>
