<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Application Form</title>
	
	<?php
	require_once ('../includes/head.php');
    # require_once ('../includes/crypt_function.php');
	?>

	<style>
		input[type="text"] {
			height: 35px; 
		}

	</style>
</head>
<body>

<?php
include('../includes/nav_main.php');
if (file_exists('../includes/crypt_function.php')) {
    require_once '../includes/crypt_function.php';
} else 
    require 'includes/crypt_function.php';
$logoutafter = 0;
	?>
	
	<div class="main">
		
		<div class="main-inner">

			<div class="container">
				
				<div class="row">
					
					<div class="span12">
						
						<div class="widget">
							<div class="widget-content">
								
								<div class="pricing-plans plans-3">
									<p><br /></p>
									<?php
									
									if(isset($_GET['u'])) { 
										$username = $_GET['u'];
                                        $username = decrypt($username, $enckey);
									}
									if(isset($_GET['r'])) { 
										$role = $_GET['r'];
                                        $role = decrypt($role, $enckey);
									}

									if(isset($_GET['source_page'])) { 
										$main_page ="new_user.php";   
										$source ="&source_page";
									}
									else {
										$main_page ="dash.php";
										$source ="";
									}
									if(isset($_GET['logoutafter'])) {
										$logoutafter=1;   
									}
                                    if(isset($_GET['readonlyroles'])) {
										$readonlyroles=1;   
									}
// echo "<br>role $role, logoutafter $logoutafter, readonlyroles $readonlyroles";
// exit();
                                    $new_or_edit = 'Edit';
									if (($role == 'Reviewer') || isset($_GET['rev_edit']) ) {
										include ('../admin/includes/reviewer_edit.php');
									}    
									if (($role == 'Secretary') || isset($_GET['sec_edit']) ) {
										include ('../admin/includes/sec_edit.php');      
									}    
									if (($role == 'Clinician') || isset($_GET['clin_edit']) ) {
										include ('../admin/includes/clinician_edit.php');
									}
									if (($role == 'Lab') || isset($_GET['lab_edit']) ) {
										include ('../admin/includes/labuser_edit.php');     
									}																		
									include ('includes/update_user.php');  									
									?>
									
									
								</div>
							</div> 
							
						</div>>
						
					</div>				
					
				</div>    	
				
				
			</div>
			
		</div>
		
	</div>
<?php include ('../includes/footer.php'); ?>
</body>

</html>
