<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('input[type="radio"]').click(function(){
      if($(this).attr("value")=="Yes_preg"){
        $(".box").not(".yes").hide();
        $(".yes").show();
      }
      if($(this).attr("value")=="No_preg"){
        $(".box").not(".no").hide();
        $(".no").show();
      }
      
    });
  });
</script>
<?php

global $pat_id;
$pat_id= $_GET['pat_id'];
/*echo $pat_id;*/

$patient = new Patient($pat_id);
$client_name = $patient->fullname;

echo '
<form id="edit-profile" class="form-horizontal" action="app.php?pat_id='.$pat_id.'" method="post">

  ';
  ?>
  <input type="hidden" name="pat_id" value="<?php echo $pat_id; ?>" />
  <input type="hidden" name="dob" value="<?php echo $patient->dob; ?>" /> 
  <h2 style="background-color:#f8f7f7; text-align:center"> Pregnancy Section</h2>
  <h3>Client Name: <strong><i style="background-color:#f8f7f7; color:red"><?php echo $client_name; ?></i></strong></h3>
  <hr style=" border: 2px solid #1c952f;" />
  <fieldset>
    <table style="width:100%" border="0">
     <div class="box">
      <tr>
        
        <td>
          <label class="control-label">Is the patient currently pregnant?</label>
          
          <div style="width:110px; float:left" class="radio_sty">
            <input type="radio" id="yes_pregnant" name="pregnant" value="Yes_preg" required>
            <label for="yes_pregnant">Yes</label>
            
            <div class="check">
            </div>
          </div>
          <div style="width:100px; float:left" class="radio_sty">
            <input type="radio" id="no_pregnant" name="pregnant" value="No_preg" >
            <label for="no_pregnant">No</label>
            
            <div class="check">
            </div>
          </div>
          
        </td>    
        
        <td class="yes box">
         
          <p>Week of Pregnancy </p>
          
        </td>
        <td class="yes box">
         
          <select name="weeks_o_preg">
            <option>Select Week</option>
            <?php
            for ($wk=0; $wk < 60; $wk ++ ){
              echo '<option>'.$wk.'</option>';
            }
            ?>
          </select>
          
        </td> 
        
        
      </tr>
    </div>
  </table>
</fieldset>
<fieldset>
 <table style="width:100%" border="0">
   <tr>
    <td>
      <label class="control-label">Is the patient breastfeeding?</label>
      
      
      <div style="width:110px; float:left" class="radio_sty">
        <input type="radio" id="yes_breastfeeding" name="breastfeeding" value="Yes">
        <label for="yes_breastfeeding">Yes</label>
        
        <div class="check">
        </div>
      </div>
      <div style="width:100px; float:left" class="radio_sty">
        <input type="radio" id="no_breastfeeding" name="breastfeeding" value="No" >
        <label for="no_breastfeeding">No</label>
        
        <div class="check">
        </div>
      </div>
      
    </td>    
    <td>
     
    </td>
    <td>
     
    </td> 
  </tr>
</table>
</fieldset>
<div class="form-actions">
 <div class="span3">
   <button class="btn" name="submit_patD" style="padding:10px; font-size:180%">Back</button>
    </div>
    <div class="span3">
       <?php include ('includes/app_edit_menu.php'); ?>    
    </div>
    <div class="span3">
    <button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_Preg">Next</button> 
    </div>
    </div>
    </form>