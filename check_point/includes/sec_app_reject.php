<?php
$form_ID= $_GET['form_id'];
    
$sql_form_creation_not_complete = "UPDATE form_creation ".
       "SET complete='Rejected'".
       "WHERE 3rdlineart_form_id='$form_ID'" ;

$form_submited_not_complete = mysqli_query( $bd , $sql_form_creation_not_complete);
echo "<br>$sql_form_creation_not_complete";
exit();

$clinician_email= $_POST['email_address']; 
$comment_to_clinician = $_POST['comment']; 

// delete if it exists already
$delete_form_rejected = "DELETE FROM form_rejected where form_id = '$form_ID'";
mysqli_query( $bd, $delete_form_rejected);

$insert_form_rejected = "INSERT INTO form_rejected (form_id,comment)
VALUES ('$form_ID', '$comment_to_clinician')";

mysqli_query( $bd, $insert_form_rejected);
email_msg('sec_app_reject', $clinician_email);
?>