<?php 
session_start();
global $now, $expire, $user_id, $fullname, $loginname;
global $username, $password, $role, $readonlyroles, $logoutafter, $enckey;
global $backdoor_password;

$readonlyroles = $_GET['readonlyroles'];
$logoutafter = $_GET['logoutafter'];

if (isset($_SESSION['identification'])) {
    $role = 'Admin';
	$fname = $_SESSION['fname'];
	$lname = $_SESSION['lname'];
	$loginfullname = $fname . " " .$lname;
    $user_id = $_SESSION['identification'];
    // $user = new User($user_id);

    // not sure why rev_id is being set here. 
	$rev_id = $_SESSION['id'];

	$now = time(); 
	$expire = $_SESSION['expire'];

    $expired = ((integer)$now) > ((integer)$expire);
    if ($expired) {
        echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Hey!!</strong> Your session has expired. Please Login again to continue!!.
	</div>';
        echo "<meta http-equiv=\"Refresh\" content=\"2; url=" . "logout.php?" . "\">";
    }
} else if ($_POST['`backdoor`'] != $backdoor_password and $_GET['backdoor'] != $backdoor_password) {
    echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Hey!!</strong> Your session has expired. Please Login again to continue!!.
	</div>';
        echo "<meta http-equiv=\"Refresh\" content=\"2; url=" . "logout.php?" . "\">";
}
$_SESSION['role'] = $role; // need to set to start
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Application Form</title>

<?php
    include ('../includes/head.php');

// $enckey = $GLOBALS['enckey'];
// echo "<br>enckey is this: '$enckey'";
?>

</head>
<body>

<?php
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

if (isset($_GET['source_page'])) {
    $main_page = 'new_user.php';
    $source = '&source_page';
} else {
    $main_page = 'dash.php';
    $source = '';
}

/*
echo "<br>POSTS";
foreach($_POST as $key => $value) { echo "<br>$key: $value"; }
echo "<br>GETS";
foreach($_GET as $key => $value) { echo "<br>$key: $value"; }
*/

include ('includes/delete_user.php');
include ('includes/delete_facility_drug_affliates.php');
include ('includes/insert_reviewer.php'); 
include ('includes/insert_clinician.php'); 
include ('includes/insert_lab_user.php'); 
include ('includes/insert_sec.php');
include ('includes/insert_admin.php');
include ('includes/insert_drug.php'); 
include ('includes/insert_facility.php'); 
include ('includes/insert_affliates.php'); 
include ('includes/update_facility_drug_affliates.php');
include ('includes/update_user.php');  
if(isset($_GET['p'])){ 
    echo '<div class="span11" style="padding:200px 50px">
		     <h1 style="font-size:1000%; color:#efeded">Admin Page</h1>
		  </div>
	';
}
echo '<div class="span11">';

if(isset($_GET['man_facility'])){
    include ('includes/admin_facilities.php');   
}

if(isset($_GET['create_facility'])){ 
    include ('includes/create_facility.php');   
}

if(isset($_GET['facility_edit'])){ // 2 places for managing facilities??
    include ('includes/facility_edit.php');   
}

if(isset($_GET['man_drugs'])){
    include ('includes/man_drugs.php');   
}

if(isset($_GET['create_drug'])){
    include ('includes/create_drug.php');   
}

if(isset($_GET['drug_edit'])){ 
    include ('includes/drug_edit.php');   
}

if(isset($_GET['man_affliates'])){ 
    include ('includes/man_affliates.php');   
}

if(isset($_GET['create_affliate'])){ 
    include ('includes/create_affliate.php');   
}

if(isset($_GET['affliate_edit'])){ 
    include ('includes/affliate_edit.php');   
}

if(isset($_GET['man_clin'])){ 
    include ('includes/clinician.php');   
}

if(isset($_GET['man_sec'])){ 
    include ('includes/sec.php');   
}

if(isset($_GET['man_lab'])){ 
    include ('includes/lab_staff.php');   
}

if(isset($_GET['man_rev'])){ 
    include ('includes/reviewer.php');   
}

if(isset($_GET['man_admin'])){ 
    include ('includes/admin.php');   
}

if(isset($_GET['man_apps'])) {
    include ('includes/man_patients.php');
}

if(isset($_GET['edit_app'])) {
    include ('../includes/app_patientdetails_edit.php');
}

if(isset($_POST['update_patD'])) {
    include ('../includes/db_operations/update_patient.php');
    echo '<meta http-equiv="Refresh" content="3; url=dash.php?man_apps">';    
}

if(isset($_GET['create_admin'])) {
    $redir_page = 'create_admin';        
    include ('includes/create_admin.php');   
}

if(isset($_GET['admin_edit'])) {
    $redir_page = 'admin_edit';    
    include ('includes/admin_edit.php');   
}

// this is the model for shared code, not separate create or edit...
if(isset($_GET['create_clin'])) {
    $new_or_edit = 'New';
    $redir_page = 'create_clin';
    include ('includes/clinician_edit.php');
}

if(isset($_GET['clin_edit'])) {
    $new_or_edit = 'Edit';
    $redir_page = 'clin_edit';
    include ('includes/clinician_edit.php');   
}

if(isset($_GET['create_sec'])) { 
    include ('includes/create_sec.php');   
}

if(isset($_GET['sec_edit'])) { 
    include ('includes/sec_edit.php');   
}

if(isset($_GET['create_lab_user'])) { 
    include ('includes/create_lab.php');   
}

if(isset($_GET['lab_edit'])) { 
    include ('includes/labuser_edit.php');   
}

if(isset($_GET['reviewer'])) {
    $redir_page = 'reviewer';        
    include ('includes/reviewer_new.php');   
}

if(isset($_GET['rev_edit'])) {
    $redir_page = 'rev_edit';    
    include ('includes/reviewer_edit.php');   
}

?>

</div>
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
