<?php
// echo 'send_user_email!';
email_msg('send_user_email', $email);

/*    
$to = $email;
$subject = "New Member";
$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>New User Account</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        </head>
        <body>
        <p>Welcome '.$fullname.'!</p>
        <p>You have been registered as a '.$role.' in the 3<sup>rd</sup> Line ART Expert Committee Malawi. Follow the link to complete your registration:</p>
        <a href="$rooturl/3rdline_git/3rdlineart5/admin/new_user.php?'.encrypt ($username, $enckey).'"></a>
        <p>&nbsp;</p>
        <p>Regards</p>
        <p>Admin</p>
        </body>
        </html>
';   
   
   $header = "From:j.dumisani7291@gmail.com\r\n";
   $header .= "Cc:j.dumisani7291@gmail.com\r\n";
   $header .= "MIME-Version: 1.0\r\n";
   $header .= "Content-type: text/html\r\n";
   $retval = mail ($to,$subject,$message,$header);    
*/
?>