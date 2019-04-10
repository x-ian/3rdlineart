<?php
global $formID;

if (isset($_POST['submit_reviewers'])) {
  $formID = $_POST['formID'];
  $date_assigned = date ('d/m/Y');

  if(!empty($_POST['checkbox'])) {   
   $checkbox = $_POST['checkbox'];
   for($i=0; $i<count($_POST['checkbox']); $i++) {
    if(!empty($checkbox[$i])) {
      $rev_id = $checkbox[$i];
    }
    mysqli_query($bd,"DELETE FROM assigned_forms WHERE form_id = '$formID and rev_id = '$rev_id'");
    $insert_assigned_forms="INSERT INTO assigned_forms (form_id,sec_id,rev_id,date_assigned)
    VALUES (
    '$formID', '$sec_id', '$rev_id', '$date_assigned')";
    mysqli_query( $bd,$insert_assigned_forms );	
    
    $SQL_reviewer = "SELECT * FROM reviewer WHERE id=$rev_id";
    $reviewer = mysqli_query($bd,$SQL_reviewer);
    $row_reviewer = mysqli_fetch_array($reviewer);
    $rev_email_address = $row_reviewer['email'];
    $rev_title = $row_reviewer['title'];
    $rev_lname = $row_reviewer['lname'];

    email_msg('insert_assign_reviewer', $rev_email_address);                
   }
  }
}

/*
$formID= $_POST['formID']; 
$date_assigned = date ('d/m/Y');
$rev_lead = $_POST['rev_lead'];
$insert_reviewer_team_lead = "INSERT INTO reviewer_team_lead (rev_id,form_id,sec_id)
VALUES (
'$rev_lead', '$formID', '$sec_id')";
// echo $insert_reviewer_team_lead;

mysqli_query( $bd,$insert_reviewer_team_lead);	

$sql_form_creation4review = "UPDATE form_creation ".
"SET status='Assigned Reviewers'".
"WHERE 3rdlineart_form_id='$formID'" ;

$form_submited_4review = mysqli_query( $bd , $sql_form_creation4review);   

if(!empty($_POST['checkbox'])){   
    $checkbox = $_POST['checkbox'];

    for($i=0; $i<count($_POST['checkbox']); $i++){
        if(!empty($checkbox[$i])){  
            $rev_id = $checkbox[$i];
        }

        $insert_assigned_forms = "INSERT INTO assigned_forms (form_id,sec_id,rev_id,date_assigned)
        VALUES ('$formID', '$sec_id', '$rev_id', '$date_assigned')";

        // echo $insert_assigned;

        mysqli_query( $bd,$insert_assigned_forms);                     
        $SQL_reviewer = "SELECT * FROM reviewer WHERE id=$rev_id";
        $reviewer = mysqli_query($bd,$SQL_reviewer);

        $row_reviewer = mysqli_fetch_array($reviewer);
        $rev_email_address = $row_reviewer['email'];
        $rev_title = $row_reviewer['title'];
        $rev_lname = $row_reviewer['lname'];

        // include_once('../includes/email_templates.php');
        email_msg('cp_p1', $rev_email_address);
    }
}
echo"<meta http-equiv=\"Refresh\" content=\"1; url=cp_p1.php?p\">";   
*/
?>