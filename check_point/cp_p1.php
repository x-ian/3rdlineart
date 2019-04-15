<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Application Form</title>

<?php
      include ('../includes/head.php');
?>

<link rel="stylesheet" href="../css/app.css">

</head>
<body>

<?php

session_start();
global $role, $now, $expire, $user_id, $fullname, $loginfullname, $sec_id;

$redirect = isset($_GET['redirect_after']) ? urlencode($_SERVER['REQUEST_URI']) : '';
if (isset($_SESSION['identification'])) {

    $role = 'Secretary';
	$user_id = $_SESSION['identification'];

    $user = new User($user_id);
    // echo '<br>clin is '.$user->clinician.', secretary is '.$user->secretaryID;
    $clinicianID = $user->clinician ? $user->clinicianID : 0;
    $sec_id = $user->secretary ? $user->secretaryID : _SESSION['identification'];

    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
	$fullname = $loginfullname = $fname . " " .$lname;
    
	$sec_phone = $_SESSION['phone'];
	$sec_email = $_SESSION['email'];
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

/*
echo "<br>POSTS:";
foreach($_POST as $key => $value) { echo "<br>$key: $value"; }
echo "<br>GETS:";
foreach($_GET as $key => $value) { echo "<br>$key: $value"; }
// exit();
*/
    
if (isset($_GET['form_id']))
    $formID = $_GET['form_id'];
else
    $formID = $_GET['id'];
?>

<?php
    global $rev_title, $rev_lname, $comment_to_clinician;
	include ('../includes/nav_main.php');
    include ('includes/nav_sub.php');
 	?>

	<div class="main">

		<div class="main-inner">

			<div class="container">

				<div class="row">

					<div class="span12">

						<div class="widget">

							<div class="widget-content">

								<div class="pricing-plans plans-3">

									<?php

                                    // if(isset($_POST['submit_assign_result'])){
                                    //    include ('includes/insert_attach_result.php');
                                    // }

									if(isset($_POST['submit_reviewers'])){
                                        include ('includes/insert_reviewers.php');
									}

									if(isset($_POST['submit_consolidate1'])){ 
										include ('includes/insert_consolidate1.php');   
									}

									if(isset($_POST['submit_consolidate2'])){ 
										include ('includes/insert_consolidate2.php');   
									}

									if(isset($_GET['complete'])){ 
										$sql_form_creation_complete = "UPDATE form_creation ".
										"SET complete='Yes'".
										"WHERE 3rdlineart_form_id='$formID'" ;
										$form_submited_complete = mysqli_query( $bd , $sql_form_creation_complete);   
									}
                                   
                                    if(isset($_GET['notcomplete'])){ 
                                        include ('includes/sec_app_reject.php');
                                    }

									if(isset($_GET['p'])){
                                        // echo '<br>sec_new';
										include ('includes/sec_new.php');
									}

									if(isset($_GET['del_application'])){
										include ('includes/delete_application.php');
									}

									if(isset($_GET['view'])) {
                                        // if (isset($_GET['subnav']))
                                            // include ('includes/sub_nav.php');
										// include ('includes/app_form.php');
                                        
                                        include ('../reviewer/includes/my_review.php');
										include ('../form_complete.php');
									}

									if(isset($_GET['received'])){ 
										include ('includes/sec_attach_resultpdf.php');  
									}

									if(isset($_GET['pending'])){ 
										include ('includes/sec_results_under_rev.php');   
									}

 									if(isset($_GET['pending_result'])){
										include ('includes/sec_pending_result.php');   
									}

									if(isset($_GET['pending_sample'])){ 
										include ('includes/sec_pending_sample.php');   
									}

									if(isset($_GET['reviewed_app'])){ 
										include ('includes/sec_reviewed_app.php');   
									}

									if(isset($_GET['reviewed_result'])){ 
										include ('includes/sec_reviewed_result.php');   
									}

									if(isset($_GET['reminder'])){ 
										include ('includes/sec_reminder.php');   
									}

									if(isset($_GET['rev'])){
                                        // echo '<br>sec_rev';
										include ('includes/sec_rev.php');   
									}

									if(isset($_GET['assign'])){
										include ('includes/sec_assign_reviewer.php');   
									}

									if(isset($_GET['consolidate'])){ 
										include ('includes/sec_consolidate1.php');   
									}

									if(isset($_GET['consolidate_result'])){ 
										include ('includes/sec_consolidate2.php');   
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
