<?php

if(isset($_POST['submit_review'])) {
    echo "<br>here";
	$formID= $_GET ['formid'];
	$genotyping= mysqli_real_escape_string($bd,  $_POST ['genotyping']);
	$comment_to_clinician= mysqli_real_escape_string($bd, $_POST ['comment_to_clinician']);
	$date_reviewed= date('d/m/Y');

	$insert_expert_review_Form=" INSERT INTO expert_review_form (form_id,rev_id,genotyping,comment_to_clinician,date_reviewed)
	VALUES (
	'$formID', '$rev_id', '$genotyping', '$comment_to_clinician', '$date_reviewed')";

	mysqli_query( $bd,$insert_expert_review_Form);

	$sql_form_creation_r = "UPDATE form_creation ".
	"SET status='Reviewed'".
	"WHERE 3rdlineart_form_id='$formID'" ;

	$form_reviewed = mysqli_query( $bd , $sql_form_creation_r);    
	$sql_assigned_forms = "UPDATE assigned_forms ".
	"SET status='Reviewed'".
	"WHERE form_id='$formID' and rev_id='$rev_id' " ;

	$form_reviewed_as = mysqli_query( $bd , $sql_assigned_forms);    

	echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Success!</strong> Your review was submitted!!.
	</div>';
	echo"<meta http-equiv=\"Refresh\" content=\"1; url=review_p1.php?p\">";   
}
?>