<?php 

  if(isset($_POST['submit_consolidate2'])){
	
$formID = $_POST['formid']; 
$clinician_email = $_POST['clinician_email']; 
$clinician_name = $_POST['clinician_name'];
$pi_mutation = $_POST['pi_mutation'];
$switch = $_POST['switch'];
$decision = $_POST['decision'];
/*$attachements = $_POST['attachements'];*/
$attachements = "no attachements";
      
      $attach1 =" ";
      $attach2 =" ";
      $attach3 =" ";
      $url = $rooturl.'documents/attachments/';
      if(isset($_POST['checkbox_drv'])){
          $attach1 =$_POST['checkbox_drv'];
          $attach1 ='<a href="'.$rooturl.'documents/attachments/'.$attach1.'.docx" target="_blank">'.$attach1.'</a><br />';
      }
      if(isset($_POST['checkbox_ral'])){
          $attach2 =$_POST['checkbox_ral'];
          $attach2 ='<a href="'.$rooturl.'documents/attachments/'.$attach2.'.docx" target="_blank">'.$attach2.'</a><br />';
      }
      if(isset($_POST['checkbox_etv'])){
          $attach3 =$_POST['checkbox_etv'];
          $attach3 ='<a href="'.$rooturl.'documents/attachments/'.$attach3.'.docx" target="_blank">'.$attach3.'</a><br />';
      }
      
      $attachements = $attach1.$attach2.$attach3;
      
      if ($pi_mutation=='Yes_pi'){
      $pi_mutation = $pi_mutation['0'].$pi_mutation['1'].$pi_mutation['2'];
      }
      
      if ($pi_mutation=='No_pi'){
      $pi_mutation = $pi_mutation['0'].$pi_mutation['1'];
      }
      
$date_reviewed = date('d/m/Y');
      
//	echo  $pi_mutation;
$insert_expert_review_consolidate2=" INSERT  INTO  expert_review_consolidate2 (form_id,sec_id,pi_mutation,switch,decision,attachements,consolidate2_date)
VALUES (
'$formID', '$rev_id', '$pi_mutation', '$switch', '$decision', '$attachements','$date_reviewed')";

mysqli_query( $bd,$insert_expert_review_consolidate2);	
email_msg('insert_consolidate2', $clinician_email); 
    
 echo"<meta http-equiv=\"Refresh\" content=\"1; url=review_p1.php?p\">";      
}
    
?>