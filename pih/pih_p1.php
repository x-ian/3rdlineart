<?php 
session_start();
global $now,$expire,$user_id,$fullname, $pih_staff_id;
if (isset($_SESSION['identification'])) {

	/* global  $fullname;*/
	$fname= $_SESSION['fname'];
	$lname= $_SESSION['lname'];
	$loginfullname = $fullname = $fname . " " .$lname;

	$user_id=$_SESSION['identification'];
	$pih_staff_id = $_SESSION['id'];

	/*$fullname =$_SESSION['name'];*/
	$phone= $_SESSION['phone'];
	$email= $_SESSION['email'];
	$now = time(); 
	$expire= $_SESSION['expire'];
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Application Form</title>

<?php 
	include ('../includes/head.php');
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
				<?php
				if (isset($_SESSION['identification'])){
					// echo '<h4>  <span class="glyphicon glyphicon-user">Logged in: '. $fullname.'</span></h4>';
				}
				?>  
				<div class="row">

					<div class="span12">

						<div class="widget">

							<div class="widget-content">

								<div class="pricing-plans plans-3">

									<?php

									if(isset($_POST['submit_vl_done'])){ 
										include ('includes/insert_lab_vl_repeat.php');    
									}

									if(isset($_GET['p'])){ 
										include ('includes/lab_new.php');   
									}

									if(isset($_GET['sample'])){ 
										include ('includes/lab_sample.php');
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
