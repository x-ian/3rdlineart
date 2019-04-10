<?php
if(isset($_POST['update_adher'])){ 
    $patient_id= mysqli_real_escape_string($bd, $_GET['pat_id']);
    
    $sql_delete_lab = "DELETE FROM lab where pat_id =$patient_id";
    mysqli_query( $bd,$sql_delete_lab);
    $sql_delete_adherence = "DELETE FROM adherence where pat_id =$patient_id";
    mysqli_query( $bd,$sql_delete_adherence);
    $sql_delete_adherence_questions = "DELETE FROM adherence_questions where pat_id =$patient_id";
    mysqli_query( $bd,$sql_delete_adherence_questions);
	
    if (mysqli_query($bd, $sql_delete_adherence_questions)) {
        echo '<div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Client Application updated</strong>                            
          </div>';
    }
    
 	$scheduled_visit_date1= mysqli_real_escape_string($bd, $_POST['scheduled_visit_date1']);
 	$actual_visit_date1= mysqli_real_escape_string($bd, $_POST['actual_visit_date1']);
	$pill_count1=mysqli_real_escape_string($bd, $_POST['pill_count1']);
    
    $scheduled_visit_date2= mysqli_real_escape_string($bd, $_POST['scheduled_visit_date2']);
 	$actual_visit_date2= mysqli_real_escape_string($bd, $_POST['actual_visit_date2']);
	$pill_count2=mysqli_real_escape_string($bd, $_POST['pill_count2']);
    
    $scheduled_visit_date3= mysqli_real_escape_string($bd, $_POST['scheduled_visit_date3']);
 	$actual_visit_date3= mysqli_real_escape_string($bd, $_POST['actual_visit_date3']);
	$pill_count3=mysqli_real_escape_string($bd, $_POST['pill_count3']);
    
    //adherence questions 
    $ever_forget_2_take_meds= mysqli_real_escape_string($bd, $_POST['ever_forget_2_take_meds']);
 	$careless_taking_meds= mysqli_real_escape_string($bd, $_POST['careless_taking_meds']);
	$stop_taking_meds=mysqli_real_escape_string($bd, $_POST['stop_taking_meds']);
	$not_taken_meds=mysqli_real_escape_string($bd, $_POST['not_taken_meds']);
	$taken_meds_past_weekend=mysqli_real_escape_string($bd, $_POST['taken_meds_past_weekend']);
	$_3months_days_not_taken_meds=mysqli_real_escape_string($bd, $_POST['3months_days_not_taken_meds']);
    
    //lab data
	$creatinine=mysqli_real_escape_string($bd, $_POST['creatinine']);
	$hb=mysqli_real_escape_string($bd, $_POST['hb']);
	$alt=mysqli_real_escape_string($bd, $_POST['alt']);
	$bilirubin=mysqli_real_escape_string($bd, $_POST['bilirubin']);
	$hepbag=mysqli_real_escape_string($bd, $_POST['hepbag']);
       
 	
$insert_adherence=" INSERT INTO adherence (pat_id,scheduled_visit_date1,actual_visit_date1,pill_count1,scheduled_visit_date2,actual_visit_date2,pill_count2,scheduled_visit_date3,actual_visit_date3,pill_count3)
VALUES (
'$patient_id', '$scheduled_visit_date1', '$actual_visit_date1', '$pill_count1','$scheduled_visit_date2', '$actual_visit_date2', '$pill_count2', '$scheduled_visit_date3', '$actual_visit_date3', '$pill_count3')";
// echo "<br>$insert_adherence";
mysqli_query( $bd, $insert_adherence);	
    
  //insert adherence questions
$insert_adherence_questions=" INSERT INTO adherence_questions (pat_id,ever_forget_2_take_meds,careless_taking_meds,stop_taking_meds,not_taken_meds,taken_meds_past_weekend,3months_days_not_taken_meds)
VALUES (
'$patient_id', '$ever_forget_2_take_meds', '$careless_taking_meds', '$stop_taking_meds','$not_taken_meds', '$taken_meds_past_weekend', '$_3months_days_not_taken_meds')";

mysqli_query( $bd, $insert_adherence_questions);	  
 
    //insert LAB data
$insert_lab=" INSERT INTO lab (pat_id,creatinine,hb,alt,bilirubin,hepbag)
VALUES (
'$patient_id', '$creatinine', '$hb', '$alt','$bilirubin', '$hepbag')";

mysqli_query( $bd, $insert_lab);	  
}

?>