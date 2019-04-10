<?php

if(isset($_GET['sendsample'])){ 
	
    $form_id= mysqli_real_escape_string($bd, $_GET['formid']);
    $date_created= date('d/m/Y');
 	
$insert_sample=" INSERT  INTO  sample (form_id,clinician_id,date_created)
VALUES (
'$form_id', '$clinicianID', '$date_created')";

mysqli_query( $bd,$insert_sample);	

email_msg('insert_sample', $email);
// moved to email_templates
/*
 $to = $email;
   $subject = "New Patient Sample 3RD Line";
   $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>New form to review</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<p>Dear </p>
<p>Kindly note/receive sample for patient form #'.$form_id.'</p>
<p>Thank you very much,</p>
<p>Regards</p>
<p>&nbsp;</p>
<p>'.$fullname.'</p>
<p>Clinician at: '.$facility.'</p>

</body>
</html>
';   
 $header = "From:dumi_ndhlovu@lighthouse.org.mw\r\n";
   $header .= "Cc:j.dumisani7291@gmail.com\r\n";
   $header .= "MIME-Version: 1.0\r\n";
   $header .= "Content-type: text/html\r\n";
   $retval = mail ($to,$subject,$message,$header);    
*/  
}



?>