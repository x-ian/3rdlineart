<?php

if(isset($_POST['submit_review_result'])){ 
    
    $formID= $_GET ['formid'];
    
    $pi_mutation = mysqli_real_escape_string($bd, $_POST ['pi_mutation']);
    $switch = mysqli_real_escape_string($bd, $_POST ['switch']);
    $drug1 = mysqli_real_escape_string($bd, $_POST ['drug1']);
    $drug2 = mysqli_real_escape_string($bd, $_POST ['drug2']);
    $drug3 = mysqli_real_escape_string($bd, $_POST ['drug3']);
    $drug4 = mysqli_real_escape_string($bd, $_POST ['drug4']);
    $drug5 = mysqli_real_escape_string($bd, $_POST ['drug5']);
    $comment = mysqli_real_escape_string($bd,  $_POST ['comment_to_clinician']);
    $feedback_to_clinician = mysqli_real_escape_string($bd, $_POST ['feedback_to_clinician']);
    
    if ($switch == 'SwitchYes') {
    $switch ='Yes';
    } else {
    $switch ='No';
    }
    
    $date_reviewed = date('d/m/Y'); 
 	echo $drug3;
     
$insert_expert_review_result=" INSERT  INTO  expert_review_result (form_id,rev_id,pi_mutation,switch,drug1,drug2,drug3,drug4,drug5,comment,feedback_to_clinician)
VALUES (
'$formID', '$rev_id', '$pi_mutation', '$switch', '$drug1', '$drug2', '$drug3', '$drug4', '$drug5', '$comment', '$feedback_to_clinician')";

mysqli_query( $bd,$insert_expert_review_result);
    
    
$sql_form_creation_r = "UPDATE form_creation ".
       "SET status='Reviewed'".
       "WHERE 3rdlineart_form_id='$formID'" ;

// mysqli_select_db('3rdlineart_db');
$form_reviewed = mysqli_query( $bd , $sql_form_creation_r);    
    
    $sql_assigned_app_results = "UPDATE assigned_app_results ".
       "SET status='Reviewed'".
       "WHERE form_id='$formID' and rev_id='$rev_id' " ;

$form_reviewed_result = mysqli_query( $bd , $sql_assigned_app_results);    
    
    
    echo '							
<div class="alert alert-success">
                                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                  <strong>Success!</strong> Your review was submitted!!.
                           
                           </div>
                           
                            ';

      echo"<meta http-equiv=\"Refresh\" content=\"1; url=review_p1.php?result\">";       
}

?>