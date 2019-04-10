 <?php
//  global $pat_id;
//  $pat_id= $_GET['pat_id'];
if (isset($_GET['pat_id']))
    $pat_id = $_GET['pat_id'];
if (isset($_GET['id']))
    $form_id = $_GET['id'];
if (isset($_GET['clin_id']))
    $clinician_id = $_GET['clin_id'];

// echo "<br>pat_id = $pat_id";
$patient = new Patient($pat_id);
$client_name = $patient->fullname;
$age = $patient->age;
$gender = $patient->gender;

$SQL_clinician = "SELECT * FROM clinician WHERE id=$clinician_id";
$clinician = mysqli_query($bd, $SQL_clinician);
$row_clinician = mysqli_fetch_array($clinician);
$fullname = $row_clinician['name'];
$facility = $row_clinician['art_clinic'];
$phone = $row_clinician['phone'];
$email = $row_clinician['email'];

if (!$fullname && isset($_SESSION['lname'])) {
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $fullname = $loginfullname = $fname . " " . $lname;
}
 
 //clinic status info

 $current_clinical_status=mysqli_query($bd, "SELECT * FROM current_clinical_status where patient_id='$pat_id' "); 
 while ($row_clinic_status=mysqli_fetch_array($current_clinical_status)){

   $who_stage = $row_clinic_status['who_stage'];
   $curr_who_stage = $row_clinic_status['curr_who_stage'];
   $weight = $row_clinic_status['weight'];
   $height = $row_clinic_status['height'];
   $art_interrup = $row_clinic_status['art_interrup'];
   $ol_6months = $row_clinic_status['ol_6months'];
   $sig_diarrhea_vom = $row_clinic_status['sig_diarrhea_vom'];
   $alco_drug_consump = $row_clinic_status['alco_drug_consump'];
   $trad_med = $row_clinic_status['trad_med'];
   $co_medi = $row_clinic_status['co_medi'];
   $other_curr_problem = $row_clinic_status['other_curr_problem'];

   if ($art_interrup=='Yes'){
     $art_interruption = mysqli_query($bd, "SELECT * FROM art_interruption where patient_id='$pat_id' "); 
     $row_art_interruption=mysqli_fetch_array($art_interruption);
     $interupt_reason = $row_art_interruption['reason'];
     $interup_date = $row_art_interruption['date'];
   }

   if ($ol_6months=='Yes'){
     $ol_6months_details = mysqli_query($bd,"SELECT * FROM ol_6months_details where patient_id='$pat_id' "); 
     $row_ol_6months_details=mysqli_fetch_array($ol_6months_details);
     $ol_6months_dign = $row_ol_6months_details['ol_6months_dign'];
     $ol_6months_date = $row_ol_6months_details['ol_6months_date'];  
   }
 }

 //side effects 
 $patient_side_effects=mysqli_query($bd, "SELECT * FROM patient_side_effects where patient_id='$pat_id' "); 
 $row_patient_side_effects=mysqli_fetch_array($patient_side_effects);
 $PeripheralNeuropathy = $row_patient_side_effects['PeripheralNeuropathy'];
 $Jaundice = $row_patient_side_effects['Jaundice'];
 $Lipodystrophy = $row_patient_side_effects['Lipodystrophy'];
 $KidneyFailure = $row_patient_side_effects['KidneyFailure'];
 $Psychosis = $row_patient_side_effects['Psychosis'];
 $Gynecomastia = $row_patient_side_effects['Gynecomastia'];
 $Anemia = $row_patient_side_effects['Anemia'];
 $other = $row_patient_side_effects['other'];

 //side effects details 

 $current_clinical_status_details=mysqli_query($bd,"SELECT * FROM current_clinical_status_details where pat_id='$pat_id' "); 
 $row_current_clinical_status_details=mysqli_fetch_array($current_clinical_status_details);
 $sig_diarrhea_vom_details = $row_current_clinical_status_details['sig_diarrhea_vom_details'];
 $alco_drug_consump_details = $row_current_clinical_status_details['alco_drug_consump_details'];
 $trad_med_details = $row_current_clinical_status_details['trad_med_details'];
 $co_medi_details = $row_current_clinical_status_details['co_medi_details'];
 $other_curr_problem_details = $row_current_clinical_status_details['other_curr_problem_details'];

 //tb_treatment
 $tb_treatment=mysqli_query($bd,"SELECT * FROM tb_treatment where pat_id='$pat_id' "); 
 $row_tb_treatment=mysqli_fetch_array($tb_treatment);
 $reg1 = $row_tb_treatment['reg1'];
 $reg2 = $row_tb_treatment['reg2'];
 $mdr = $row_tb_treatment['mdr'];
 $tbstart_date = $row_tb_treatment['start_date'];
 $tbstop_date = $row_tb_treatment['stop_date'];
 $reason_o_changes = $row_tb_treatment['reason_o_changes'];

 //adherence
 $adherence=mysqli_query($bd,"SELECT * FROM adherence where pat_id='$pat_id' "); 
 $row_adherence=mysqli_fetch_array($adherence);

 $scheduled_visit_date1 = $row_adherence['scheduled_visit_date1'];
 $actual_visit_date1 = $row_adherence['actual_visit_date1'];
 $pill_count1 = $row_adherence['pill_count1'];

 $scheduled_visit_date2 = $row_adherence['scheduled_visit_date2'];
 $actual_visit_date2 = $row_adherence['actual_visit_date2'];
 $pill_count2 = $row_adherence['pill_count2'];

 $scheduled_visit_date3 = $row_adherence['scheduled_visit_date3'];
 $actual_visit_date3 = $row_adherence['actual_visit_date3'];
 $pill_count3 = $row_adherence['pill_count3'];

 //adherence_questions
 $adherence_questions=mysqli_query($bd,"SELECT * FROM adherence_questions where pat_id='$pat_id' "); 
 $row_adherence_questions=mysqli_fetch_array($adherence_questions);

 $ever_forget_2_take_meds = $row_adherence_questions['ever_forget_2_take_meds'];
 $careless_taking_meds = $row_adherence_questions['careless_taking_meds'];
 $stop_taking_meds = $row_adherence_questions['stop_taking_meds'];
 $not_taken_meds = $row_adherence_questions['not_taken_meds'];
 $taken_meds_past_weekend = $row_adherence_questions['taken_meds_past_weekend'];
 $_3months_days_not_taken_meds = $row_adherence_questions['3months_days_not_taken_meds'];

 //lab
 $lab=mysqli_query($bd,"SELECT * FROM lab where pat_id='$pat_id' "); 
 $row_lab=mysqli_fetch_array($lab);

 $creatinine = $row_lab['creatinine'];
 $hb = $row_lab['hb'];
 $alt = $row_lab['alt'];
 $bilirubin = $row_lab['bilirubin'];
 $hepbag = $row_lab['hepbag'];

 //treatement history
 $treatment_history=mysqli_query($bd,"SELECT * FROM treatment_history where pat_id='$pat_id' "); 
 $row_treatment_history=mysqli_fetch_array($treatment_history);

 $art_drug = $row_treatment_history['art_drug'];
 $treat_start_date = $row_treatment_history['start_date'];
 $treat_stop_date = $row_treatment_history['stop_date'];
 $treat_reason_for_change = $row_treatment_history['reason_for_change'];

 if ($patient->gender=='Female' && $patient->age >= '10'){
 //pregnacy for females age greater than 10
   $pregnancy=mysqli_query($bd, "SELECT * FROM pregnancy where pat_id='$pat_id' "); 
   $row_pregnancy=mysqli_fetch_array($pregnancy);
   $pregnant = $row_pregnancy['pregnant'];
   $weeks_o_preg = $row_pregnancy['weeks_o_preg'];
   $breastfeeding = $row_pregnancy['breastfeeding'];  
 }

 if ( $age <= '15' ) {                
 //pediatric age < 3
   $pediatric=mysqli_query($bd, "SELECT * FROM pediatric where pat_id='$pat_id' "); 
   $row_pediatric=mysqli_fetch_array($pediatric);
   $mother_had_single_dose_NVP = $row_pediatric['mother_had_single_dose_NVP'];
   $given_NVP = $row_pediatric['given_NVP'];
   $mother_had_PMTCT = $row_pediatric['mother_had_PMTCT'];
   $swallow_tablets = $row_pediatric['swallow_tablets'];
 }
 // include ('includes/app_edit_menu.php');  
 ?>

<?php
if (!isset($_GET['subnav']) and !isset($_GET['review']) and !isset($_POST['update_adher']) and !isset($POST['submit_adher']) and !isset($_GET['reviewed']))
echo '
<div class="form-actions">
	<div class="span3">             
		<a href="#myModalNC" role="button" data-toggle="modal" class="btn btn-danger"><i class="btn-icon-only icon-remove">Form Not Complete </i></a> 
		<div id="myModalNC" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 style="te
xt-align:center">Compose Message</h3>
				</div>
				<div class="modal-body"> 
					<form id="#" action="cp_p1.php?p&notcomplete&form_id='.$form_id.'" method="post">
						<p>To:'.$email.'</p>
						<input type="hidden" name="email_address" Value ="'.$email.'" />
						<h4>Compose Message</h4>
						<textarea style="width:93%" rows="8" name="comment" value="">
						</textarea>
						<div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;">
							<button type="submit" name="submit_reject" class="btn btn-warning" style="width:90%;height=80%">Not Complete</button>  
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
			</div>
		</div>
		<div class="span3" style="float:right">
			<a href="cp_p1.php?p&complete&form_id='.$form_id.'" class="btn btn-success"><i class="btn-icon-only icon-ok">Form Complete</i></a>
		</div>
	</div>';
	?>

 <h1 style="background-color:#f8f7f7; text-align:center; color:#000">3rd Line ART Expert Committee Malawi</h1>
 <hr style=" border: 2px solid #000;" />
 <fieldset style="background-color:#f8f7f7;">
   <table style="width:100%; border-color:#f5f0f0" border="0.5" cellpadding="4px">
     <tr>
       <td>
         <h4 style="font-weight:normal; text-align:left">ART Clinic :</h4> 
       </td>
       <td>
         <span style="font-weight:bold; text-align:left"><?php echo $facility ?></span>
       </td>    <td>

       <?php 
       $date = date ('d/m/Y');
       $time = date ('h:m:s');

       echo "Date <i>".$date. "</i>  Time <i>". $time. "</i>";
       ?>
     </td>
   </tr> 

   <tr>
     <td>
       <h4 style="font-weight:normal; text-align:left">Clinician's Name : </h4> 
    </td>
    <td>
      <span style="font-weight:bold; text-align:left"><?php echo $fullname ?></span>
    </td>    
  </tr> 

  <tr>
    <td>
     <h4 style="font-weight:normal; text-align:left">Clinician's Tel. Number :</h4>
    </td>
    <td>
     <span style="font-weight:bold; text-align:left"><?php echo $phone ?></span>
   </td>    

 </tr> 
 <tr>
  <td>
    <h4 style="font-weight:normal; text-align:left">Clinician's Email Address :</h4>
 </td>
 <td>
  <span style="font-weight:bold; text-align:left"><?php echo $email ?></span>
</td>    

</tr> 
</table>
</fieldset> 

<h3 style="background-color:#111; text-align:left; color:#ffffff">Patient Details</h3>

<fieldset>                     
  <table style="width:100%;border-color:#f5f0f0" border="0" cellpadding="4px">
    <tr>
      <td><h4 style="font-weight:normal; text-align:left">First Name : </h4> 
      </td>
      <td>
       <span style="font-weight:bold; text-align:left"><?php echo  $patient->firstname; ?></span>
     </td>    
     <td><h4 style="font-weight:normal; text-align:left">Surname :</h4> 									
     </td>    
     <td>       
      <span style="font-weight:bold; text-align:left"><?php echo  $patient->lastname; ?></span>
    </td>    
  </tr> 
  <tr>
    <td>
     <h4 style="font-weight:normal; text-align:left">Referring ART Clinic :</h4>
   </td>
   <td>
    <span style="font-weight:bold; text-align:left"><?php echo $healthcenters->facility($patient->art_id_num_ref); ?></span>     
  </td>    
    <td>
     <h4 style="font-weight:normal; text-align:left">ART Treatment Clinic :</h4>
   </td>
   <td>
    <span style="font-weight:bold; text-align:left"><?php echo $healthcenters->facility($patient->pat_art_clinic); ?></span>     
  </td>    
</tr>
  <tr>
    <td>
     <h4 style="font-weight:normal; text-align:left">ART-ID Number :</h4>
   </td>
   <td>
    <span style="font-weight:bold; text-align:left"><?php echo  $patient->art_id_num; ?></span>     
  </td>    
  <td>
    <h4 style="font-weight:normal; text-align:left">Gender :</h4>
  </td>    
  <td>
    <p><?php echo '<span style="font-weight:bold; text-align:left">'. $patient->gender. '</span>'; ?></p>
  </td>    
</tr> 
<tr>
  <td>
   <h4 style="font-weight:normal; text-align:left">VL sample-ID :</h4>
 </td>
 <td>
   <span style="font-weight:bold; text-align:left"><?php echo $patient->vl_sample_id; ?></span>     
 </td>    
 <td>
  <h4 style="font-weight:normal; text-align:left">Date of Birth :</h4>
</td>    
<td>												
  <p><?php echo '<span style="font-weight:bold; text-align:left">'. $patient->dob. '</span>'; ?></p>
</td>    
</tr> 
</table>
</fieldset> 
<h3 style="background-color:#111; text-align:center; color:#ffffff">Current Clinic Status and history</h3>
<fieldset>
  <table style="width:100%; border-color:#f5f0f0; border:0px;" border="1">
    <tr>
      <td>
        <h4 style="font-weight:normal; text-align:left">WHO stage at start of Treatment :</h4> 
      </td>
      <td width="50%">
        <span style="font-weight:bold; text-align:center"><?php echo  $who_stage ?></span>
      </td>    
    </tr> 

    <tr>
      <td>
        <h4 style="font-weight:normal; text-align:left">Current WHO stage (+defining condition) : </h4> 
      </td>
      <td>
       <span style="font-weight:bold; text-align:center"><?php echo  $curr_who_stage ?></span>
     </td>    
   </tr> 

   <tr>
    <td>
     <h4 style="font-weight:normal; text-align:left">Weight :</h4>
   </td>
   <td>
    <span style="font-weight:bold; text-align:left"><?php echo  $weight ?>Kgs</span>
  </td>    
</tr> 

<tr>
  <td>
   <h4 style="font-weight:normal; text-align:left">Height:</h4>
 </td>
 <td>
   <span style="font-weight:bold; text-align:left"><?php echo  $height ?>Cm</span>
 </td>    
</tr> 

<tr>
 <td>
  <h4 style="font-weight:normal; text-align:left">ART Interruptions? : </h4>          
</td>
<td>
  <span style="font-weight:normal; text-align:left"><i>ART Interruptions*</i> : <?php 
   if ($art_interrup=='Yes'){
    echo '<span style="font-style:bold;text-decoration-line: underline;">'. $art_interrup. '</span>'; 
  }

  else {
    echo '<i style="color:#f00">No ART Interruptions</i>';
  }
  ?></span> 
</tr>
<tr>
  <td>  </td>
  <td>
    <?php 

    if ($art_interrup=='Yes'){

      $art_interruption = mysqli_query($bd, "SELECT * FROM art_interruption where patient_id='$pat_id' "); 
      $row_art_interruption = mysqli_fetch_array($art_interruption);
      $interupt_reason = $row_art_interruption['reason'];
      $interup_date = $row_art_interruption['date'];

      echo ' <table>
       <tr>
        <td>if Yes, Date:</td>
        <td>    <span style="font-weight:bold; text-align:center">'.$interup_date.'</span></td>
      </tr>
      <tr>
        <td>Reason:</td>
        <td>
          <span style="font-weight:bold; text-align:center">'. $interupt_reason .'</span>
        </td>
      </tr>
    </table>';

 }
 else { echo '
    <table>
      <tr>
        <td></td>
      </tr>
    </table>';
 }
 ?>

</td>    

</tr> 

<tr>
  <td>
    <h4 style="font-weight:normal;text-align:left" >History of serious side effects :</h4>
  </td>
  <td>
    <table>
      <tr>
        <td> 
        </td>
      </tr>
    </table>
  </td>    
</tr> 
<tr>

  <td> </td>
  <td> 
   <span style="font-weight:normal;text-align:left"> Peripheral Neuropathy : <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $PeripheralNeuropathy. '</span>'; ?></span>
 </td>
</tr>
<tr>

  <td> </td>
  <td> 
    <span style="font-weight:normal;text-align:left">Jaundice : <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $Jaundice. '</span>'; ?></span>
  </td>
</tr>
<tr>

  <td> </td>
  <td> 
    <span style="font-weight:normal;text-align:left">Lipodystrophy : <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $Lipodystrophy. '</span>'; ?></span>
  </td>
</tr>
<tr>

  <td> </td>
  <td> 
    <span style="font-weight:normal;text-align:left">Kidney Failure : <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $KidneyFailure. '</span>'; ?></span>
  </td>
</tr>

<tr>
 <td> </td>
 <td> 
  <span style="font-weight:normal;text-align:left">Psychosis : <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $Psychosis. '</span>'; ?></span>
</td>
</tr>

<tr>
 <td> </td>
 <td> 
  <span style="font-weight:normal;text-align:left">Gynecomastia : <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $Gynecomastia. '</span>'; ?></span>
</td>
</tr>
<tr>

 <td> </td>
 <td> 
  <span style="font-weight:normal;text-align:left">Anemia : <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $Anemia. '</span>'; ?></span>
</td>
</tr> 
<tr>

 <td> </td>

 <td> <span style="font-weight:normal;text-align:left">Other  : <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $other. '</span>'; ?></span> </td>
</tr>


</table>
</fieldset>
<fieldset>
 <table style="width:100%; border-color:#f5f0f0; border:0px;" border="1">

  <tr>
    <td>
     <span style="font-weight:normal;text-align:left">Ol in the last 6 month? </span> <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $ol_6months. '</span>'; ?>

   </td>    
   <?php

   if ($ol_6months=='Yes'){
    $ol_6months_details = mysqli_query($bd, "SELECT * FROM ol_6months_details where patient_id='$pat_id' "); 
    $row_ol_6months_details=mysqli_fetch_array($ol_6months_details);

    $ol_6months_dign = $row_ol_6months_details['ol_6months_dign'];
    $ol_6months_date = $row_ol_6months_details['ol_6months_date'];
  }

  ?>
  <td width="40%">
    If yes, Date
  </td>
  <td width="10%">
    <span style="font-weight:bold;text-align:left"><?php if ($ol_6months=='Yes'){ echo $ol_6months_date; } echo ' N/A</span>';  ?>
  </td> 
</tr>
<tr>
  <td></td>
  <td>
    Diagnosis
  </td>
  <td>
    <?php
    if ($ol_6months=='Yes'){
      echo '<span style="font-weight:bold;">'. $ol_6months_dign. '</span>'; 
    }
    else {
      echo '<span style="font-weight:bold;"> N/A</span>';
    }     
    ?> 

  </td> 

</tr>


</table>
</fieldset>
<fieldset>

 <table style="width:100%; border-color:#f5f0f0; border:0px;" border="1">

  <tr>
   <td>
       <span style="font-weight:normal;">Significant diarrhea or vomiting? <?php echo '<span style="font-weight:bold; text-decoration-line:underline;">'. $sig_diarrhea_vom. '</span></span>'; ?>
   </td>
   <td width="50%">
    <?php
    if ($sig_diarrhea_vom=='Yes'){
      echo 'Details: <span style="font-weight:bold;">'. $sig_diarrhea_vom_details. '</span>'; 
    }
    else {
      echo '<span style="font-weight:bold;"> N/A</span>';
    }     
    ?>

  </td>

</tr> 

<tr>
  <td> 
    <span style="font-weight:normal;text-align:left">Alcohol or drug consumption?</span> <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $alco_drug_consump. '</span>'; ?>
  </td>
  <td>
    <?php 
    if ($alco_drug_consump=='Yes'){
      echo 'Details: <span style="font-weight:bold;">'. $alco_drug_consump_details. '</span>'; 
    }
    else {
      echo '<span style="font-weight:bold;"> N/A</span>';
    }     
    ?>                                  </td>
  </tr> 

  <tr>
   <td> 
     <span style="font-weight:normal;text-align:left">Traditional medicine?</span> <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $trad_med. '</span>'; ?>
   </td>
   <td>
    <?php 
    if ($trad_med=='Yes'){
      echo 'Details: <span style="font-weight:bold;">'. $trad_med_details. '</span>'; 
    }
    else {
      echo '<span style="font-weight:bold;"> N/A</span>';
    }
    ?>                          
  </td>
</tr> 
<tr>
  <td> 
    <span style="font-weight:normal;text-align:left">Current co-medications (Antiepileptic, Steroids, Warfarin, Statins)? <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $co_medi. '</span>'; ?></span>
  </td>
  <td>
   <?php 
   if ($co_medi=='Yes'){
    echo 'Details: <span style="font-weight:bold;">'. $co_medi_details. '</span>'; 
  }
  else {
    echo '<span style="font-weight:bold;"> N/A</span>';
  }
  ?>                 
</td>
</tr> 

<tr>
  <td> 
    <span style="font-weight:normal;text-align:left">Other current clinical problems? <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $other_curr_problem. '</span>'; ?></span>
  </td>
  <td>
    <?php 
    if ($other_curr_problem=='Yes'){
      echo 'Details: <span style="font-weight:bold;">'. $other_curr_problem_details. '</span>'; 
    }
    else {
      echo '<span style="font-weight:bold;"> N/A</span>';
    }
    ?>                 
  </td>

</tr> 
</table>
</fieldset>

<h3 style="background-color:#111; text-align:center; color:#ffffff"> Pregnancy Section</h3>

<fieldset> 
  <?php 

  if ($gender=='Male' || $age < 10){
    echo '<h3 style="font-weight:bold;color:#f00">N/A</h3>';
  }
  else {
    ?>
    <table style="width:100%" border-color:#f5f0f0" border="0.5" border="1" cellpadding="2px">
      <tr>
        <td>
         <span style="font-weight:normal;text-align:left">Is the patient currently pregnant? <?php if  ($gender=='Female' && $age >= 10){ echo  "<span style\"font-weight:bold;text-decoration-line: underline;\">$pregnant</span>"; }?></span></td>
       </td>    
     </tr>
     <tr>
      <td> <span style="font-weight:normal;text-align:left">If Yes, week of pregnancy? <?php if  ($gender=='Female' && $age >= 10){   echo "<span style\"font-weight:bold;text-decoration-line: underline;\">$weeks_o_preg</span>"; }?></span></td>
    </tr>
    <tr>
      <td>
       <span style="font-weight:normal;text-align:left">Is the patient breastfeeding?  <?php if  ($gender=='Female' && $age >= 10 ){  echo "<span style=\"font-weight:bold;text-decoration-line: underline;\">$breastfeeding</span>"; }?></span>
      </td>    
    </tr>
  </table>
  <?php } ?>
</fieldset> 

<h3 style="background-color:#111; text-align:center; color:#ffffff">Pediatric Section</h3>
<fieldset>
 <?php 
 if ($age >'3'){
  echo '<h3 style="color:#f00">N/A</h3>';
}
else {
  ?>                     
  <table style="width:100%; border:0px;" border="0" cellpadding="2px">
    <tr> 
      <td>
       <span style="font-weight:normal;text-align:left">Has mother had single dose NVP? <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $mother_had_single_dose_NVP. '</span>'; ?></span>
     </td>    
   </tr>  
   <tr> 
    <td>
     <span style="font-weight:normal;text-align:left">Has Mother had PMTCT? <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $mother_had_PMTCT. '</span>'; ?></span>

   </td>    
 </tr>  
 <tr> 
  <td>
   <span style="font-weight:normal;text-align:left">Was baby given NVP? <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $given_NVP. '</span>'; ?></span>
 </td>    
</tr>  
<tr> 
  <td>
   <span style="font-weight:normal;text-align:left">Is the child able to swallow tablets? <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $swallow_tablets. '</span>'; ?></span>
 </td>    
</tr>  

</table>
<?php } ?>
</fieldset>   
<h3 style="background-color:#111; text-align:center; color:#ffffff"> Treatment History</h2>
 <fieldset>                      
  <table style="width:100%; border:0px;" border="1" cellpadding="2px">
    <thead>
      <tr style="background-color:#eee">
        <th> ART Drugs</th>
        <th> Start Date</th>
        <th> Stop Date</th>
        <th> Reason for changes (toxicities?)</th>

      </tr>
    </thead>
    <tbody>
      <?php

//treatement history
      $treatment_history=mysqli_query($bd, "SELECT * FROM treatment_history where pat_id='$pat_id' "); 
      while ($row_treatment_history=mysqli_fetch_array($treatment_history)){

        $art_drug = $row_treatment_history['art_drug'];
        $treat_start_date = $row_treatment_history['start_date'];
        $treat_stop_date = $row_treatment_history['stop_date'];
        $treat_reason_for_change = $row_treatment_history['reason_for_change'];

        echo ' <tr>
         <td>  
          <span style="font-weight:normal;text-align:left">'.$art_drug.'</span>';
         echo '        
        </td>
        <td>   
          <span style="font-weight:normal;text-align:left">'.$treat_start_date.'</span>
        </td>
        <td>   
          <span style="font-weight:normal;text-align:left">'.$treat_stop_date.'</span>
        </td> 
        <td>   
          <span style="font-weight:normal;text-align:left">'.$treat_reason_for_change.'</span>
        </td>

      </tr> 
      ';       
   } ?>
 </tbody>
</table>
<br />
</fieldset>
<h3 style="background-color:#111; text-align:center; color:#ffffff">Monitoring</h3>
<fieldset>
  <table style="width:100%; border:0px;" border="1" cellpadding="2px">
    <thead>
      <tr style="background-color:#eee">
        <th> Monitoring Date</th>
        <th> CD4</th>
        <th> VL</th> 
        <th> Reason for detectable VL (Non-adherence, treatment break)</th>
        <th> Weight (kg)</th>

      </tr>
    </thead>
    <tbody>
      <?php
    //monitoring
      $monitoring=mysqli_query($bd, "SELECT * FROM monitoring where pat_id='$pat_id' "); 
      while ( $row_monitoring=mysqli_fetch_array($monitoring)){

        $monito_date = $row_monitoring['monito_date'];
        $cd4 = $row_monitoring['cd4'];
        $vl = $row_monitoring['vl'];
        $reason_4_detectable_vl = $row_monitoring['reason_4_detectable_vl'];
        $weight = $row_monitoring['weight'];
        
        echo '
         <tr> 
          <td>   <span style="font-weight:normal;text-align:left">'.$monito_date.'</span>  </td>
          <td>   <span style="font-weight:normal;text-align:left">'.$cd4.'</span>  </td>
          <td>   <span style="font-weight:normal;text-align:left">'.$vl.'</span>  </td>
          <td>   <span style="font-weight:normal;text-align:left">'.$reason_4_detectable_vl.'</span>  </td>
          <td>   <span style="font-weight:normal;text-align:left">'.$weight.'</span>  </td>
        </tr>  
        '; 
     }
     ?>
   </tbody>
 </table>
 <br />
</fieldset>
<h3 style="background-color:#111; text-align:center; color:#ffffff">TB Treatment</h3>
<fieldset>
  <table style="width:100%" border="0" cellpadding="2px">

    <tbody>
     <?php
//tb_treatment
     $tb_treat =mysqli_query($bd, "SELECT * FROM tb_treat where pat_id='$pat_id' "); 
     $row_tb_treat=mysqli_fetch_array($tb_treat);

     $tb_tb_treatment = $row_tb_treat['tb_treatment'];
     if ($tb_tb_treatment=='Yes') {
    //tb_treat_regimen1
      $tb_treat_regimen1=mysqli_query($bd, "SELECT * FROM tb_treat_regimen1 where pat_id = '$pat_id' and start_date != ''"); 
      while ( $row_tb_treat_regimen1=mysqli_fetch_array($tb_treat_regimen1)){
        $reg_name = $row_tb_treat_regimen1['reg_name'];
        $start_date = $row_tb_treat_regimen1['start_date'];
        $stop_date = $row_tb_treat_regimen1['stop_date'];
        $reason_for_change = $row_tb_treat_regimen1['reason_for_change'];
        echo '
        <thead><tr style="background-color:#eee"><th colspan="2">Regimen</th><th>Start Date</th><th>End Date</th></tr></thead>
         <tr>
          <td> <span style="font-weight:norma;text-align:left"> Reg. 1 </span></td>
          <td> 
            <span style="font-weight:bold;text-align:left">'.$reg_name.'</span>
          </td>
          <td> 
            <span style="font-weight:bold;text-align:left">'.$start_date.'</span>
          </td>
          <td> 
            <span style="font-weight:bold;text-align:left">'.$stop_date.'</span>
          </td>
          <td> 
            <span style="font-weight:bold;text-align:left">'.$reason_for_change.'</span>
          </td>
        </tr>
        ';
     }

// tb_treat_regimen2
     $tb_treat_regimen2=mysqli_query($bd, "SELECT * FROM tb_treat_regimen2 where pat_id='$pat_id' and start_date != ''"); 
     while ( $row_tb_treat_regimen2=mysqli_fetch_array($tb_treat_regimen2)){

      $reg_name = $row_tb_treat_regimen2['reg_name'];
      $start_date = $row_tb_treat_regimen2['start_date'];
      $stop_date = $row_tb_treat_regimen2['stop_date'];
      $reason_for_change = $row_tb_treat_regimen2['reason_for_change'];

      echo '
       <tr>
        <td> <span style="font-weight:normal;text-align:left"> Reg. 2 </span></td>
        <td> <span style="font-weight:bold;text-align:left">'. $reg_name .'</span></td>
        <td> <span style="font-weight:bold;text-align:left">'. $start_date .'</span></td>
        <td> <span style="font-weight:bold;text-align:left">'. $start_date .'</span></td>
        <td> <span style="font-weight:bold;text-align:left">'. $reason_for_change .'</span></td>
      </tr>

      ';
   }

// tb_treat_MDR
   $tb_treat_mdr=mysqli_query($bd, "SELECT * FROM tb_treat_mdr where pat_id='$pat_id' and start_date != ''"); 
   while ( $row_tb_treat_mdr=mysqli_fetch_array($tb_treat_mdr)){

    $reg_name = $row_tb_treat_mdr['reg_name'];
    $start_date = $row_tb_treat_mdr['start_date'];
    $stop_date = $row_tb_treat_mdr['stop_date'];
    $reason_for_change = $row_tb_treat_mdr['reason_for_change'];

    echo '
     <tr>
      <td> <span style="font-weight:normal;text-align:center"> MDR </span></td>
      <td> <span style="font-weight:bold;text-align:center">'. $reg_name .'</span></td>
      <td> <span style="font-weight:bold;text-align:center">'. $start_date .'</span></td>
      <td> <span style="font-weight:bold;text-align:center">'. $stop_date .'</span></td>
      <td> <span style="font-weight:bold;text-align:center">'. $reason_for_change .'</span></td>
    </tr>
    ';
 }
}
else {
  echo '<h3 style="color:#f00">No TB treatment</h3>';
}
?>

</tbody>
</table>
</fieldset>

<h3 style="background-color:#111; text-align:center; color:#ffffff"> Adherence</h2>

  <fieldset>                         
    <h3>Adherence Section <i>(Patient adherence in the last 3 visits)</i></h3>
    <table style="width:100%" border="0">
      <tbody>

        <tr>
          <td> Schedule visit date: </td>
          <td>    
            <span style="font-weight:bold;text-align:center"><?php echo  $scheduled_visit_date1; ?></span> 
          </td>
          <td> Actual visit date </td>
          <td>    
            <span style="font-weight:bold;text-align:center"><?php echo  $actual_visit_date1; ?></span> 
            <?php /*echo '<span style="font-weight:bold;text-align:center">'. $actual_visit_date1. '</span>';*/ ?> </td>
            <td> Pill Count </td>
            <td>    
              <span style="font-weight:bold;text-align:center"><?php echo  $pill_count1; ?> %</span> 
              <?php /*echo '<span style="font-weight:bold;text-align:center">'. $pill_count1. '%</span>';*/ ?> </td>

            </tr> 
            <tr>
              <td> Schedule visit date: </td>
              <td>    
                <span style="font-weight:bold;text-align:center"><?php echo  $scheduled_visit_date2; ?></span> 
                <?php /*echo '<span style="font-weight:bold;text-align:center">'. $scheduled_visit_date2. '</span>';*/ ?> </td>
                <td> Actual visit date </td>
                <td>    
                  <span style="font-weight:bold;text-align:center"><?php echo  $actual_visit_date2; ?></span> 
                  <?php /*echo '<span style="font-weight:bold;text-align:center">'. $actual_visit_date2. '</span>';*/ ?> </td>
                  <td> Pill Count </td>
                  <td>    
                    <span style="font-weight:bold;text-align:center"><?php echo  $pill_count2; ?> %</span> 
                    <?php /*echo '<span style="font-weight:bold;text-align:center">'. $pill_count2. '%</span>'; */?> </td>

                  </tr> 
                  <tr>
                    <td> Schedule visit date: </td>
                    <td>    
                      <span style="font-weight:bold;text-align:center"><?php echo  $scheduled_visit_date3; ?></span> 
                      <?php /*echo '<span style="font-weight:bold;text-align:center">'. $scheduled_visit_date3. '</span>';*/ ?> </td>
                      <td> Actual visit date </td>
                      <td>    
                        <span style="font-weight:bold;text-align:center"><?php echo  $actual_visit_date3; ?></span> 
                        <?php /*echo '<span style="font-weight:bold;text-align:center">'. $actual_visit_date3. '</span>';*/ ?> </td>
                        <td> Pill Count </td>
                        <td>    
                          <span style="font-weight:bold;text-align:center"><?php echo  $pill_count3; ?> %</span> 
                          <?php /*echo '<span style="font-weight:bold;text-align:center">'. $pill_count3. '%</span>';*/ ?> </td>
                        </tr> 

                      </tbody>
                    </table>
                  </fieldset>
                  <fieldset>
                    <h3>Adherence questions <i>(circle answer)</i></h3>

                    <table style="width:100%" border="0" cellpadding="5px">
                      <tr>     <td>Do you ever forget to take your medicine?</td>    
                       <td width="45%"> 
                         <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $ever_forget_2_take_meds. '</span>'; ?>
                       </td>
                     </tr>
                     <tr>     <td>Are you careless at times about taking your medicine?</td>     
                       <td> 
                         <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $careless_taking_meds. '</span>'; ?>
                       </td>
                     </tr>
                     <tr>     <td>Sometimes if you feel worse, do you stop taking your medicine?</td>    
                       <td> 
                        <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $stop_taking_meds. '</span>'; ?>
                      </td>
                    </tr>
                    <tr>     <td>Thinking about the last week. How often have you not taken your medicine</td>    
                     <td> 
                       <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $not_taken_meds. '</span>'; ?>
                     </td>
                   </tr>
                   <tr>     <td>Did you not take any of your medicine over the past weekend?</td>    
                     <td> 
                       <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $taken_meds_past_weekend. '</span>'; ?>
                     </td>
                   </tr>
                   <tr>     <td>Over the past 3 months, how many days have you not taken any medicine at all?</td>    
                     <td> 
                       <?php echo '<span style="font-weight:bold;text-decoration-line: underline;">'. $_3months_days_not_taken_meds. '</span>'; ?>
                     </td>
                   </tr>



                 </table>
               </fieldset>
               <fieldset>
                <h3>Laboratory Section <i>(compulsory)</i></h3>
                <table style="width:100%" border="0" cellpadding="5px">
                  <tbody>
                    <tr>
                      <td> Hb: </td>
                      <td>  <?php echo '<span style="font-weight:bold;text-align:left">'. $hb. '</span><i>*g/dl</i>'; ?></td>
                    </tr>
                    <tr>
                      <td> ALT: </td>
                      <td>  <?php echo '<span style="font-weight:bold;text-align:left">'. $alt. '</span><i>*U/l</i>'; ?></td>
       </tr>
       <tr>
        <td> Bilirubin </td>
        <td>  <?php echo '<span style="font-weight:bold;text-align:left">'. $bilirubin. '</span><i>*mg/dl</i>'; ?> </td>
       </tr>   
       <tr>
        <td> Creatinine: </td>
        <td>  <?php echo '<span style="font-weight:bold;text-align:left">'. $creatinine. '</span><i>*mg/dl</i>'; ?> </td>
       </tr>
       <tr>
        <td>HepB Ag</td>
        <td> 
         <?php echo '<span style="font-weight:bold;text-align:left">'. $hepbag. '</span>'; ?>
       </td>

     </tr> 
   </tbody>
 </table> </fieldset>