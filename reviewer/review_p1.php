
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Application Form</title>

<?php
    include ('../includes/head.php');
?>

</head>
<?php
session_start();
global $role,$now,$expire,$user_id,$fullname,$loginfullname,$rev_id,$comment_to_clinician;

// echo $_SERVER['REQUEST_URI'];
$redirect = isset($_GET['redirect_after']) ? urlencode($_SERVER['REQUEST_URI']) : '';
// echo "<br>redirect is $redirect";

if (isset($_SESSION['identification'])) {
    $role = 'Reviewer';
	$fname = $_SESSION['fname'];
	$lname = $_SESSION['lname'];
	$loginfullname = $fullname = $fname . " " .$lname;

    /* $fname= $_SESSION['fname']; */
	$user_id = $_SESSION['identification'];
    $user = new User($user_id);    
    $rev_id = $user->reviewer ? $user->reviewerID : $_SESSION['id'];
    // echo "<br>rev_id is $rev_id";
	$phone = $_SESSION['phone'];
	$email = $_SESSION['email'];

	$now = time(); 
	$expire = $_SESSION['expire'];
    $expired = ((integer)$now) > ((integer)$expire);
    // echo "$now > $expire".":".$expired;
    if ($expired) {
        if (!$redirect)
            echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Hey!!</strong>Your session has expired. Please Login again to continue!!.
	</div>';
        echo "<meta http-equiv=\"Refresh\" content=\"2; url=" . "logout.php?redirect=$redirect" . "\">";
    }
} else {
    if (!$redirect)
        echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Hey!!</strong>Your session has expired. Please Login again to continue!!.
	</div>';
        echo "<meta http-equiv=\"Refresh\" content=\"2; url=" . "logout.php?redirect=$redirect" . "\">";
}
if (!isset($_SESSION['role']))
    $_SESSION['role'] = $role; // need to set to start
$_SESSION['reviewer'] = 1; // set in login;

?>
<body>
<?php
include ('../includes/nav_main.php');
include ('includes/nav_sub.php');
/*
echo "<br>POSTS:";
foreach($_POST as $key => $value) { echo "<br>$key: $value"; }
echo "<br>GETS:";
foreach($_GET as $key => $value) { echo "<br>$key: $value"; }
*/
?>

<div class="main">    
    <div class="main-inner">
    <div class="container">
<?php
    if (isset($_SESSION['identification'])){        
        // echo '<h3> <span class="glyphicon glyphicon-user">Reviewer</span></h3>';
    }
?>  
<div class="row">
    <div class="span12">
        <div class="widget">
            <div class="widget-content">
                <div class="pricing-plans plans-3">		   			
<?php
							if (isset($_POST['submit_consolidate1'])) { 
								include ('includes/insert_consolidate1.php');   
							}

							if (isset($_POST['submit_consolidate2'])) { 
								include ('includes/insert_consolidate2.php');   
							}

							include ('includes/insert_review.php');  
							include ('includes/insert_reviewed_result.php');  

							if (isset($_GET['result'])) {
                                if (!isset($_GET['reviewed']))
                                    include ('includes/rev_results.php');
							}

							if (isset($_GET['p'])) {
                                // echo 'rev_new';
								include ('includes/rev_new.php');   
							}

							if (isset($_GET['lead_reviewer'])) {
                                // echo 'lead_reviewer';
								include ('includes/sec_rev.php');   
							}

							if (isset($_GET['lead_result'])) { 
								include ('includes/sec_rev_results.php');   
							}

                            if (isset($_GET['rev'])) {
								include ('includes/rev_my_reviewed.php');   
							}

                            if (isset($_GET['rev_all'])) {
                                $all_forms = true;
								include ('includes/rev_my_reviewed.php');   
							}

							if (isset($_GET['review'])) { 
								$formID= $_GET ['id'];
								$form_creation=mysqli_query($bd,"SELECT * FROM form_creation where 3rdlineart_form_id='$formID' ");
								while ($row_form_creation=mysqli_fetch_array($form_creation)) {

									$_3rdlineart_form_id = $row_form_creation['3rdlineart_form_id'];
									$clinician_id = $row_form_creation['clinician_id'];
									$pat_id = $row_form_creation['patient_id'];
									$status = $row_form_creation['status'];
									$date_created = $row_form_creation['date_created'];

									$SQL_clinician = "SELECT * FROM clinician WHERE id=$clinician_id";
									$clinician = mysqli_query($bd,$SQL_clinician);

									$row_clinician = mysqli_fetch_array($clinician);
									$facility = $row_clinician['art_clinic'];
									$clinician_name = $row_clinician['name'];
									$clinician_phone = $row_clinician['phone'];
									$clinician_email = $row_clinician['email'];
								}

                                include ('includes/my_review.php');
								// include ('includes/review_form.php');
                                include ('../form_complete.php');
                                if ($_GET ['reviewed'] != '1')
                                    include ('includes/review.php');  
							}
                            if (isset($_GET['result'])) { 
								$formID= $_GET ['id'];
								$form_creation=mysqli_query($bd,"SELECT * FROM form_creation, app_results where form_creation.3rdlineart_form_id='$formID' and  form_creation.3rdlineart_form_id=app_results.form_id");
                                if (mysqli_num_rows($form_creation) > 0) {
                                    while ($row_form_creation=mysqli_fetch_array($form_creation)) {
                                        // echo '>> $row_form_creation';        
                                        $_3rdlineart_form_id = $row_form_creation['3rdlineart_form_id'];
                                        $clinician_id = $row_form_creation['clinician_id'];
                                        $pat_id = $row_form_creation['patient_id'];
                                        $status = $row_form_creation['status'];
                                        $result_pdf = $row_form_creation['result_pdf'];
                                        $date_created = $row_form_creation['date_created'];
                                    
                                        $SQL_clinician = "SELECT * FROM clinician WHERE id=$clinician_id";
                                        $clinician = mysqli_query($bd, $SQL_clinician);
                                        
                                        $row_clinician = mysqli_fetch_array($clinician);
                                        $facility = $row_clinician['art_clinic'];
                                        $clinician_name = $row_clinician['name'];
                                        $clinician_phone = $row_clinician['phone'];
                                        $clinician_email = $row_clinician['email'];
                                    }

                                    echo '
								<div class="form-actions">
									<div class="span3"">&nbsp
									</div>
									<div class="span3"">
										<a href="../documents/results/'.$result_pdf.'" target="_blank" class="btn btn-medium btn-primary">Click here to view NHLS Genotyping Results</a>
									</div>
									<div class="span3"">&nbsp
									</div>

								</div>	
								'; 
                                    // include ('includes/review_form.php');
                                    include ('../form_complete.php');                                    
                                    include ('includes/review_result.php');
                                }
							}

							if (isset($_GET['consolidate'])) { 
								include ('includes/sec_consolidate1.php');   
							}

							if (isset($_GET['consolidate_result'])) {
								include ('includes/sec_consolidate2.php');   
							}

							if (isset($_POST['submit_facility'])) { 
								include ('includes/app_patientdetails.php');   
							}

							if (isset($_POST['submit_patD'])) { 
								include ('includes/app_clinic_status.php');   
							}

							if (isset($_POST['submit_clinicstatus'])) { 
								include ('includes/app_pregnancy.php');   
							}

							if (isset($_POST['submit_Preg'])) { 
								include ('includes/app_pedriatric.php');   
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

<?php include ('../includes/footer.php'); ?>
</body>

</html>
