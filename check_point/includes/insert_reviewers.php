<?php 
$formID= $_POST['formID']; 
$date_assigned = date ('d/m/Y');
$rev_lead = $_POST['rev_lead'];

// echo "<br>rev_lead is $rev_lead";
// exit();
$insert_reviewer_team_lead = "INSERT INTO reviewer_team_lead (rev_id,form_id,sec_id)
VALUES (
'$rev_lead', '$formID', '$sec_id')";
// echo $insert_reviewer_team_lead;

mysqli_query( $bd, "DELETE FROM reviewer_team_lead WHERE form_id = '$formID'"); //  and rev_id = '$rev_id'");
mysqli_query( $bd, $insert_reviewer_team_lead);	

$sql_form_creation4review = "UPDATE form_creation ".
"SET status='Assigned Reviewers'".
"WHERE 3rdlineart_form_id='$formID'" ;

$isreviewed = $_POST['reviewed'];
$xrev = [];
for($i=0; $i<4; $i++) {
    // echo "<br>$i: ";
    // echo $isreviewed[$i].' ';
    $revved = explode('_', $isreviewed[$i]);
    $xrev[$revved[0]] = $revved[1];
}
        
$form_submited_4review = mysqli_query( $bd , $sql_form_creation4review);   
if(!empty($_POST['checkbox'])){   
    $checkbox = $_POST['checkbox'];
    $isreviewed = $_POST['reviewed'];

    $delete_assigned_jic = "DELETE FROM assigned_forms WHERE form_id = '$formID'"; //  and sec_id = '$sec_id'";
    mysqli_query( $bd, $delete_assigned_jic);
    
    for($i=0; $i<count($_POST['checkbox']); $i++){
        if(!empty($checkbox[$i])) {  
            $rev_id = $checkbox[$i];
        }
        // echo "<br>reviewer $rev_id: ".($xrev[$rev_id] ? "Reviewed" : "Not Reviewed");
        
        $reviewed = $xrev[$rev_id] ? "Reviewed" : "Not Reviewed";

        $insert_assigned_forms = "INSERT INTO assigned_forms (form_id,sec_id,rev_id,status,date_assigned)
        VALUES ('$formID', '$sec_id', '$rev_id', '$reviewed', '$date_assigned')";
        // echo "<br>$insert_assigned_forms";

        try {
            mysqli_query( $bd, $insert_assigned_forms);
        } catch (Exception $e) {
            echo '<br>Caught exception: ' . $e->errorMessage() . "\n";
            exit();
        }

        $SQL_reviewer = "SELECT * FROM reviewer WHERE id=$rev_id";
        $reviewer = mysqli_query($bd, $SQL_reviewer);

        $row_reviewer = mysqli_fetch_array($reviewer);
        $rev_email_address = $row_reviewer['email'];
        $rev_title = $row_reviewer['title'];
        $rev_lname = $row_reviewer['lname'];

        // include_once('../includes/email_templates.php');
        email_msg('cp_p1', $rev_email_address);

    }
}
echo"<meta http-equiv=\"Refresh\" content=\"1; url=cp_p1.php?rev\">";   

?>