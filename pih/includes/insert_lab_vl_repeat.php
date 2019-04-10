<?php

if(isset($_POST['submit_vl_done'])) { 
	$sampleid = mysqli_real_escape_string($bd, $_POST ['sampleid']);
	$form_id = mysqli_real_escape_string($bd, $_GET['formID']);
	$receive_date = mysqli_real_escape_string($bd, $_POST ['receive_date']);
	$vl_result = mysqli_real_escape_string($bd, $_POST ['vl_result']);
	$dispatch_date = mysqli_real_escape_string($bd, $_POST ['dispatch_date']);
	$nhls_receive_date = mysqli_real_escape_string($bd, $_POST ['nhls_receive_date']);
	$date_created = date ('d/m/Y');

    $del_lab_vl_repeat = "DELETE FROM lab_vl_repeat WHERE form_id = '$form_id'";
    mysqli_query($del_lab_vl_repeat);
	$insert_lab_vl_repeat=" INSERT INTO lab_vl_repeat (form_id,receive_date,vl_result,dispatch_date,nhls_receive_date,lab_personel_id,date_record_created)
	VALUES (
	'$form_id', '$receive_date', '$vl_result', '$dispatch_date', '$nhls_receive_date', '$pih_staff_id', '$date_created')";
	mysqli_query( $bd,$insert_lab_vl_repeat);	

	$sql_sample = "UPDATE sample ".
	"SET status='Dispatched'".
	"WHERE id='$sampleid'" ;
	$sample_recieved = mysqli_query( $bd , $sql_sample);

	echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Success!</strong> You have Dispatched the sample.
	</div>
	';    
}
// echo"<meta http-equiv=\"Refresh\" content=\"6; url=pih_p1.php?p\">";

?>