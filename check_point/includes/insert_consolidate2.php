<?php 

  if(isset($_POST['submit_consolidate2'])){
	
$formID= $_POST['formid']; 
$clinician_email= $_POST['clinician_email']; 
$clinician_name= $_POST['clinician_name'];
$pi_mutation= $_POST['pi_mutation'];
$switch= $_POST['switch'];
$decision= $_POST['decision'];
/*$attachements= $_POST['attachements'];*/
$attachements= "no attachements";
      
      $attach1 =" ";
      $attach2 =" ";
      $attach3 =" ";
      
      if(isset($_POST['checkbox_drv'])){
          $attach1 =$_POST['checkbox_drv'];
          $attach1 ='<a href="documents/attachments/'.$attach1.'.docx" target="_blank">'.$attach1.'</a><br />';
      }
      if(isset($_POST['checkbox_ral'])){
          $attach2 =$_POST['checkbox_ral'];
          $attach2 ='<a href="documents/attachments/'.$attach2.'.docx" target="_blank">'.$attach2.'</a><br />';
      }
      if(isset($_POST['checkbox_etv'])){
          $attach3 =$_POST['checkbox_etv'];
          $attach3 ='<a href="documents/attachments/'.$attach3.'.docx" target="_blank">'.$attach3.'</a><br />';
      }
      
      $attachements= $attach1.$attach2.$attach3;
      
      if ($pi_mutation=='Yes_pi'){
      $pi_mutation = $pi_mutation['0'].$pi_mutation['1'].$pi_mutation['2'];
      }
      
      if ($pi_mutation=='No_pi'){
      $pi_mutation = $pi_mutation['0'].$pi_mutation['1'];
      }
      
$date_reviewed = date('d/m/Y');
      
echo  $pi_mutation;
$insert_expert_review_consolidate2=" INSERT  INTO  expert_review_consolidate2 (form_id,sec_id,pi_mutation,switch,decision,attachements,consolidate2_date)
VALUES (
'$formID', '$sec_id', '$pi_mutation', '$switch', '$decision', '$attachements','$date_reviewed')";

mysqli_query( $bd,$insert_expert_review_consolidate2);	

email_msg('insert_consolidate2', $clinician_email);

/*   
 $to = $clinician_email;
   $subject = "3RD Line Expert Committee Genotype Result review";
   $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>New form to review</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
'.$decision.'
<p>Find attachments:</p>
'.$attachements.'
</body>
</html>
';   
 $header = "From:dumi_ndhlovu@lighthouse.org.mw\r\n";
   $header .= "Cc:j.dumisani7291@gmail.com\r\n";
   $header .= "MIME-Version: 1.0\r\n";
   $header .= "Content-type: text/html\r\n";
   $retval = mail ($to,$subject,$message,$header);   
*/      
      echo '							
<div class="alert alert-success">
                                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                  <strong>Success!</strong> Consolidated review sent to '.$clinician_name.'.
                           
                           </div>';
    
 echo"<meta http-equiv=\"Refresh\" content=\"1; url=cp_p1.php?pending\">";      
}
    
?>