<?php
global $rev_title;
global $rev_lname;
error_reporting(E_ALL);

if(isset($_POST['submit_assign_result'])){

	$formID= $_POST['formID']; 
	$date_assigned = date ('d/m/Y');
	$rev_lead = $_POST['rev_lead'];

    // just in case
    mysqli_query($bd, "DELETE FROM reviewer_team_lead2 WHERE form_id = '$form_id'");
    mysqli_query($bd, "DELETE FROM assigned_app_results WHERE form_id = '$form_id'");
    
	$insert_reviewer_team_lead =" INSERT INTO reviewer_team_lead2 (rev_id,form_id,sec_id)
	VALUES (
	'$rev_lead', '$formID', '$sec_id')";
	mysqli_query( $bd,$insert_reviewer_team_lead);	

	if(!empty($_POST['checkbox'])) {
		$checkbox = $_POST['checkbox'];
		for($i=0;$i<count($_POST['checkbox']);$i++) {
			if(!empty($checkbox[$i])){  
				$rev_id = $checkbox[$i];
			}
			$insert_assigned_app_results=" INSERT INTO assigned_app_results (form_id,sec_id,rev_id,date_assigned)
			VALUES (
			'$formID', '$sec_id', '$rev_id', '$date_assigned')";

			mysqli_query( $bd,$insert_assigned_app_results);	

			$SQL_reviewer = "SELECT * FROM reviewer WHERE id=$rev_id";
			$reviewer = mysqli_query($bd, $SQL_reviewer);
			$row_reviewer = mysqli_fetch_array($reviewer);
			$rev_email_address = $row_reviewer['email'];
			$rev_title = $row_reviewer['title'];
			$rev_lname = $row_reviewer['lname'];

			email_msg('insert_consolidate1', $rev_email_address);
        }
    }

$date_created = date('d/m/Y');
$file=$_FILES['file'];  
// file properties  
$file_name=$file['name'];  
$file_temp=$file['tmp_name'];  
$file_size=$file['size'];  
$file_error=$file['error'];  

// echo $file['name'].', '. $file['tmp_name'].', '. $file['size'].', '. $file['error'];

// file extension  
$file_ext = explode('.',$file_name);  
$file_ext = strtolower(end($file_ext));  
$allow = array('txt','jpg','docx','pdf');

if (in_array($file_ext, $allow)) {
    if ($file_error === 0){
        echo "file is is $file_size";
		if ($file_size <= 2097152) { 
            // $file_name_new = uniqid('',true) . '.' .$file_ext;  
			$file_name_new = time().'-3rdartline-result.'.$file_ext;  
			$file_dest = __DIR__.'/../../documents/results/'.$file_name_new;  
			move_uploaded_file($file_temp, $file_dest);
            // echo "moved $file_dest";
			echo "move form $formID from $file_temp to $file_dest";	
			$insert_app_results = "INSERT INTO app_results (form_id,result_pdf,date_created)
			VALUES (
			'$formID','$file_name_new','$date_created')";
            // echo $insert_app_results;
			$retval = mysqli_query( $bd, $insert_app_results);
		}
	}
}
echo"<meta http-equiv=\"Refresh\" content=\"30; url=cp_p1.php?pending_result\">";  
}
?>