<?php

session_start();
if(isset($_GET['role'])) {
    $role = $_GET['role'];
    echo "<br>apd: role is $role";
}
?>

<style>
.smalltb {
   max-width: 90px;
}
.select_wide {
   width: 400px;
}
</style>

<script type="text/javascript">
$().ready(function() {
    $('body').keypress(function(e) {
        if (e.which == 13) {
            e.preventDefault();
            $('input[type="submit"]:last').click();
        }
    });
    
    $('#datepicker2').keypress(function(e) {
        e.preventDefault();
    });
    
    // date bounding...
    var date = new Date(); // Date("2017-07-15");
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();

    $("#datepicker2").datepicker("option", {
            yearRange: "1900:2018",                    
            maxDate: new Date(),
            minDate: new Date(1900, 1, 1),
            dateFormat: "dd/mm/yy",
            });

    // reversed referring clinic with treatment clinic naming - fix!!
    var notfound;
    $("#art_id_num_facility").change(function() {
        notfound = false;
        var selectVal = $("#art_id_num_facility").val();
        if (selectVal == '')
            return;
        $.ajax({                                      
          url: 'getsubcat.php',
                async: false,
                data: "bycode="+selectVal,                                                     
                type:'post',
                //dataType: 'json',                
                success: function(data)    
            {
                var selectedVal = data.substring(1);
                if (selectedVal == '') {
                    alert("no ART clinic with ID: "+selectVal);
                    $("#art_id_num_facility").focus();
                    notfound = true;
                    return;
                } else                
                    $("#art_district_refer").val(selectedVal);

               /*
                $("#art_district_refer").find("option").filter(function() {
                    // alert(selectedVal);
                    return this.innerHTML == selectedVal;
                }).attr("selected", true);
                */
                
                $.ajax({                                      
                  url: 'getsubcat.php',
                        async: false,
                        data: "dcode="+selectedVal,
                        type:'post',
                        //dataType: 'json',                
                        success: function(data)
                    {
                        $('#subcat_refer').html(data);
                    },
                        complete: function()
                        {
                            // finally, select the health center referred to by the art_id_num_facility
                            $("#subcat_refer").find("option").filter(function() {
                                return this.value == selectVal;
                            }).attr("selected", true);               
                        }
                    
                });
                
            },
                complete: function() {
                if (notfound) {                    
                    // $("#art_district_refer").val('Select ART Clinic District');   // .find('option:eq(0)').prop('selected', true);
                    // the ABOVE DO NOT WORK!!! 
                    $.ajax({                                      
                      url: 'getsubcat.php',
                            async: false,
                            data: "dcode=0",
                            type:'post',
                            //dataType: 'json',                
                            success: function(data)
                        {
                            $('#art_district_refer').empty().html(data);
                        }                        
                        });
                    $("#subcat_refer").empty().append('<option selected="selected">Select ART Clinic</option>');
                }
            }
        });
    });

    $("#art_id_num_facility").focusout(function() {
        if (notfound) {
            setTimeout(function(){
                $("#art_id_num_facility").val('');
                $("#art_id_num_facility").focus();
                notfound = false;
            }, 10);
        }
    });
    
    $("#art_id_num_ref").change(function() {
        // alert($("#art_id_num_facility").val());
        var selectVal = $("#art_id_num_ref").val();
        $.ajax({                                      
         url: 'getsubcat.php',
               async: false,
               data: "bycode="+selectVal,                                                     
               type:'post',
               //dataType: 'json',                
               success: function(data)    
           {
               var selectedVal = data.substring(1);
               $("#art_district").find("option").filter(function() {
                   return this.innerHTML == selectedVal;
               }).attr("selected", true);

               $.ajax({                                      
                 url: 'getsubcat.php',
                       async: false,
                       data: "dcode="+selectedVal,
                       type:'post',
                       //dataType: 'json',                
                       success: function(data)
                   {
                       $('#subcat').html(data);
                   },
                       complete: function()
                   {
                       // finally, select the health center referred to by the art_id_num_facility
                       $("#subcat").find("option").filter(function() {
                           return this.value == selectVal;
                       }).attr("selected", true);               
                   }
                   
               });

             }           
       });
   });
    
   $("#subcat_refer").change(function() { // hidden
       document.getElementById("art_id_num_facility").value = $('#subcat_refer :selected').val();
   });

   $("#subcat").change(function() {
       // alert($('#subcat :selected').val());       
       document.getElementById("art_id_num_ref").value = $('#subcat :selected').val();
   });

   $("#art_district").change(function() {
    var selectVal = $('#art_district :selected').text();
    $.ajax({                                      
      url: 'getsubcat.php', 
      data: "dcode="+selectVal,                                                     
      type:'post',
      success: function(data)    
      { 
        $('#subcat').html(data);
      }
    });
    });

   $("#art_district_refer").change(function() {
    var selectVal = $('#art_district_refer :selected').text();
    $.ajax({                                      
      url: 'getsubcat.php', 
      data: "dcode="+selectVal,                                                     
      type:'post',
      success: function(data)    
      { 
        $('#subcat_refer').html(data);
      }
    });
    });

// validate signup form on keyup and submit
   /* $("#edit-profile").validate({
      rules: {
          firstname: "required",
          lastname: "required",
          art_id_num: {
              required: true,
              minlength: 7
          },
          password: {
              required: true,
              minlength: 5
          },
          art_clinic: {
              required: true,    
          },
          gender: {
              required: true,                  
          },
          required: ALL
                },
  
      messages: {
          firstname: "Please enter Client's firstname",
          lastname: "Please enter Client's lastname",
          art_id_num: {
                   required: "Please enter ART Number",
                   minlength: "The ART Number must consist of at least 7 characters"
          },
          art_clinic: {
                   required: "Please Select Patient's ART Clinic"
          },
          gender: {
                   required: "Please Select Gender"
          },
          required: "required"                
       }
    }); */

	// propose username by combining first- and lastname
    $("#username").focus(function() {
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        if (firstname && lastname && !this.value) {
            this.value = firstname + "." + lastname;
        }
    });
    $("#art_id_num_facility").change();
    // alert($("#art_id_num_ref").val());
    $("#art_id_num_ref").change();    
});
/*
function format_date_fromdb($date) {
    // echo "dob is $date";
    $ds = explode('/', $date);  // stored in db iso format YYYY-MM-DD (DD/MM/YYYY)
    // echo $ds[1].'-'.$ds[2].'-'.$ds[0];
    // echo "<br> after: ".$ds[1].'/'.$ds[0].'/'.$ds[2];
    return $ds[1].'/'.$ds[0].'/'.$ds[2];
}
*/
</script>

<?php

if(isset($_GET['comment'])){ 
  $fno= $_GET['form_id'];
  $form_rejected=mysqli_query( $bd,"SELECT * FROM form_rejected where form_id = $fno "); 
  $row_form_rejected=mysqli_fetch_array($form_rejected);
  $sec_comment =$row_form_rejected['comment'];

  echo '			
  <div class="alert alert-primary" style="color:#000; background-color:rgba(253, 247, 98, 0.79); height:100px;">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <p><u>Comments from Secretary </u></p>
    '.$sec_comment.'
    
  </div>';
}
?>

<?php
if ($role != 'Admin') {
echo '
<table style="width:100%; background-color:#f8f7f7;  " >
  <tr><td>
    <form id="search_art" action="app.php" method="post" style="float:right; padding:10px; height:20px;">
     <h3>To finish incomplete Application, click here <i class="icon-arrow-down" style="font-size: 18px;"></i></h3>
    
     <select name="id" id="id">
       <option value="">--select ARV Number--</option>
';

       global $num_newforms;

       $patient_from_art = "SELECT * FROM form_creation where (status='Not Complete' or complete ='Rejected') and clinician_id='$clinicianID' ORDER BY `form_creation`.`3rdlineart_form_id` DESC ";

       $form_creation=mysqli_query( $bd, $patient_from_art); 
       $num_newforms = mysqli_num_rows ($form_creation);

       while ($row_form_creation=mysqli_fetch_array($form_creation)) {
        $_3rdlineart_form_id = $row_form_creation['3rdlineart_form_id'];
        $clinician_id = $row_form_creation['clinician_id']; 
        $patient_id = trim($row_form_creation['patient_id']);

        $patient = new Patient($patient_id);
        // echo "<br>:$patient_id: ".$patient->art_id_num;
        echo '<option value="'.$patient_id.'">'.$patient->art_id_num.'</a></option>';
      }
       
echo '
    </select>
    <button type="submit" name="search" class="btn btn-primary" style="padding:6px; font-size:110%; position:relative; top:-5px; color:#fff" >Complete Application</button>	
  </form>

</td></tr>
</table>
</form>
';
}

global $pat_id, $age, $gender;

  $pat_id = $_GET['pat_id'];
// echo "<br>new Patient $pat_id";
  $patient = new Patient($pat_id);

  $pat_art_clinic = $patient->pat_art_clinic;
  $art_id_num = $patient->art_id_num;
  $firstname = $patient->firstname;
  $lastname = $patient->lastname;
  $gender = $patient->gender;
  $dob = format_date_fromdb($patient->dob);
  $vl_sample_id = $patient->vl_sample_id;
  $age = $patient->age;

  $art_id_facility = explode("-", $art_id_num)[0];
  $art_id_num_ref = $patient->art_id_num_ref;
// echo "<br>art_id_num: $art_id_num";
// echo "<br>art_id_num_ref: $art_id_num_ref";
// echo "<br>Patient: $pat_id, gender: '$gender', dob: $dob, age: $age, clinic: $pat_art_clinic";
?>

<?php
if ($role == 'Admin')
    echo '<form id="edit-profile" class="form-horizontal" action="../app.php" method="post">';
else
    echo '<form id="edit-profile" class="form-horizontal" action="app.php" method="post">';
?>

  <input type="hidden" name="pat_id" value="<?php echo $pat_id ?>" />
  <input type="hidden" name="xx" value="<?php echo $age ?>" />      
  <input type="hidden" name="art_id_num_ref" id="art_id_num_ref" value="<?php echo $art_id_num_ref ?>" />
      
  <h2 style="background-color:#f8f7f7; text-align:center; padding:20px">Patient Details Edit</h2>
  <hr style=" border: 1.5px solid #b49308;" />
      
  <table style="width:100%" border="0">
    <tr>
      <td>
        <h3>3rd Line Referral Facility</h3>
      </td>
      </tr>
      <tr>
      <td>
      District
      <select name="art_district" type="text" required id="art_district" >
          <option value="">Select ART Clinic District</option>
          <?php
// clinic status info
          $district = mysqli_query( $bd,"SELECT distinct dcode FROM facilitys ORDER BY dcode"); 
          while ($row_district = mysqli_fetch_array($district)){
            $district_name = $row_district['dcode'];
            $selected = ""; // ($pat_art_clinic == $facility_name ? 'selected="selected"' : '');
            echo "<option $selected>".$district_name.'</option>';
          }
          ?>
      </select>

      Facility: 
      <select id="subcat" name="subcat" class="select_wide">
              <option value="" selected>Select ART Clinic</option>
      </select>              
      </td>
    </tr>
    <tr><td>&nbsp</td></tr>
    <tr>
      <td>
        <h3>Clinic where Patient receives ART</h3>
      </td>
      </tr>
      <tr>
      <td>
      District
      <select name="art_district_refer" type="text" required id="art_district_refer" >
          <option value="">Select ART Clinic District</option>
          <?php
// clinic status info
          $district = mysqli_query( $bd,"SELECT distinct dcode FROM facilitys ORDER BY dcode"); 
          while ($row_district = mysqli_fetch_array($district)){
            $district_name = $row_district['dcode'];
            $selected = ""; // ($pat_art_clinic == $facility_name ? 'selected="selected"' : '');
            echo "<option $selected>".$district_name.'</option>';
          }
          ?>
      </select>

      Facility: 
      <select id="subcat_refer" name="subcat" class="select_wide">
              <option value="" selected>Select ART Clinic</option>              
      </select>              
      </td>
    </tr>
  </table>
  <hr >
  <table style="width:100%" border="0">
    <tr>
      <td><h4>First Name</h4> 
      </td>
      <td>
        <input type="text" class="span4" id="firstname" name="firstname" value="<?php echo $firstname; ?>" required>
      </td>    
      <td><h4>Surname</h4> 									
      </td>    
      <td><span></span>												
        <input type="text" class="span4" id="lastname" name="lastname" value="<?php echo $lastname; ?>"  required >
      </td>    
    </tr> 
    <tr>
      <td>
              <h4>ART-ID Number (4 digits)</h4>
     </td>
     <td>              
      <input type="hidden" class="span4 smalltb" id="art_id_num_facility" value="<?php echo $art_id_facility; ?>" name="art_id_num_facility" required>
      <!-- - -->
      <input type="text" class="span4 smalltb" id="art_id_num" pattern=".{4,4}" value="<?php echo explode("-", $art_id_num)[1]; ?>" name="art_id_num" required>
    </td>    
    <td>
      <h4>Gender</h4>
    </td>    
    <td>
     <select name="gender" class="smalltb" required id="gender">
       <option value="">Gender</option>
              <option value="Male" <?php echo (($gender == 'Male') ? 'selected="selected"' : '')?> >Male</option>
              <option value="Female" <?php echo (($gender == 'Female') ? 'selected="selected"' : '')?> >Female</option>
     </select>
   </td>    
 </tr> 
 <tr>
  <td>
   <h4>Last VL sample-ID</h4>
 </td>
 <td>
  <input type="text" class="span4" id="firstname" value="<?php echo $vl_sample_id; ?>" name="vl_sample_id">
 </td>    
 <td>
  <h4>Date of Birth</h4>
 </td>    
<td>
  <input type="text" class="span4 date" name="dob" id="datepicker2" required value="<?php echo $dob; ?>">
 </td>    
</tr> 
</table>

<div class="form-actions">
<?php if ($role == 'Admin') echo '
  <div class="span3">
    <a class="btn" href="admin/dash.php?man_apps" style="padding:10px; font-size:180%">Cancel</a> 
  </div>';
else echo '
  <div class="span3">
    <a class="btn" href="app.php?p" style="padding:10px; font-size:180%">Back</a> 
  </div>  
';
?>
  <div class="span3">
        <?php include ('includes/app_edit_menu.php'); ?>              
  </div>

  <div class="span3">
    <?php 
    if(isset($_GET['back'])) {
        if ($role == 'Admin')
            echo '<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="admin">Next</button> ';            
        else
            echo '<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="update_patD">Next</button> ';
    }
    else {
        if ($role == 'Admin')
            echo '<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="update_patD">Update</button> ';
        else            
            echo '<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_patD">Next</button> ';
    }
    ?>    
  </div>
</div>
</form>
