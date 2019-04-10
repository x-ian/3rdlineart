
  <h2 style="background-color:#f8f7f7; text-align:center"> TB Treatment</h2>
                        <!--   <hr style=" border: 2px solid #1c952f;" />  --> 
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

<h3>Client Name: <strong><i style="background-color:#f8f7f7; color:red"><?php echo $client_name; ?></i></strong></h3>

<input type="hidden" name="pat_id" value="<?php echo $pat_id; ?>" style="background-color:#fff; border:none; height:20px; color:#fff; position:relative; top:-300px;"/>
<input type="hidden" name="dob" value="<?php echo $patient->dob; ?>" style="background-color:#fff; border:none; height:20px; color:#fff; position:relative; top:-300px;" /> 

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="Yes"){
            $(".box").not(".yes").hide();
            $(".yes").show();
        }
        if($(this).attr("value")=="No"){
            $(".box").not(".no").hide();
            $(".no").show();
        }
        
    });
});

</script>
     
<fieldset>
    <div style="width:110px; float:left" class="radio_sty">
    <input type="radio" id="tb_treat-yes" name="tb_treat" value="Yes" required>
    <label for="tb_treat-yes">Yes</label>
    
    <div class="check">
		</div>
  </div>
    <div style="width:100px; float:left" class="radio_sty">
    <input type="radio" id="tb_treat-no" name="tb_treat" value="No">
    <label for="tb_treat-no">No</label>
    
    <div class="check">
		</div>
  </div>

<script type="text/javascript">
      jQuery(document).ready(function ($) {
    $('input[name="tb_treat"]').on('click', function () {
        if ($(this).val() === 'Yes') {
            $('#td_treatment,#td_treatment1,#td_treatment12,#td_treatment13,#td_treatment2,#td_treatment21,#td_treatment23,#datepicker21,#datepicker22,#datepicker23,#datepicker24,#reason_o_changes1,#reason_o_changes2 ').prop("disabled", false);
        } else {
            $('#td_treatment,#td_treatment1,#td_treatment12,#td_treatment13,#td_treatment2,#td_treatment21,#td_treatment23,#datepicker21,#datepicker22,#datepicker23,#datepicker24,#reason_o_changes1,#reason_o_changes2 ').prop("disabled", "disabled");
        }
    });
});
</script>
 <div class="yes box">

    <table style="width:90%" border="0">
                <thead>
                    <tr>
           <th><label><input type="checkbox" name="regimen1_checked" value="red"> Regimen 1</label></th>
           <th><label><input type="checkbox" name="regimen2_checked" value="green"> Regimen 2</label>   </th>
           <th><label><input type="checkbox" name="mdr_checked" value="blue"> MDR</label>  </th>
                   
                    
                    </tr>             
                 
                </thead>
                <tbody>
                    <tr style="background-color:#cb9112; font-size:112%; font-weight:300; color:#000">
                    <td> </td>
                    <td> Regimen Drug </td>
                    <td> Start Date</td>
                    <td> Stop Date</td>
                    <td> Reason for changes (toxicities?)</td>
                   <td> </td>
                  </tr>
             <script type="text/javascript">
$(document).ready(function(){
    $('input[type="checkbox"]').click(function(){
        if($(this).attr("value")=="red"){
            $(".red").toggle();
        }
        if($(this).attr("value")=="green"){
            $(".green").toggle();
        }
        if($(this).attr("value")=="blue"){
            $(".blue").toggle();
        }
    });
});
</script>
      <script type="text/javascript">
$(document).ready(function(){
    $('input[type="button"]').click(function(){
        
        
        if($(this).attr("name")=="row1"){
           $(".sec1").not(".row1").hide();
            $(".row1").show();
        }
        if($(this).attr("name")=="row2"){
           $(".sec2").not(".row2").hide();
           $(".r1row1").show();
           
        }
        if($(this).attr("name")=="r1row2"){
           $(".r1sec2").not(".r1row2").hide();
           $(".r1row4").not(".r1row2").hide();
           $(".r1sec3").show();
           $(".r1row2").show();
           
        } 
        if($(this).attr("name")=="r1row1"){
           $(".r1row2").not(".r1row1").hide();
           $(".r1row3").not(".r1row1").hide();
           $(".r1row4").not(".r1row1").hide();
           $(".r1sec2").show();
           $(".r1row1").show();
           
        } 
        if($(this).attr("name")=="r1row0"){
           $(".r1row1").not(".r1row0").hide();
           $(".r1row2").not(".r1row0").hide();
           $(".r1row3").not(".r1row0").hide();
           $(".r1row4").not(".r1row0").hide();
           $(".sec2").show();
           $(".row1").show();
           
        }
        if($(this).attr("name")=="row0"){
           $(".row1").not(".row0").hide();
           $(".r1row1").not(".row0").hide();
           $(".r1row2").not(".row0").hide();
           $(".r1row3").not(".row0").hide();
           $(".r1row4").not(".row0").hide();
           $(".sec1").show();
           $(".red").show();
           
        }
        if($(this).attr("name")=="r1row3"){
           $(".r1sec3").not(".r1row3").hide();
           $(".r1row5").not(".r1row3").hide();
           $(".r1row4").show();
           
        }
        if($(this).attr("name")=="r2row1"){
           $(".sec3").not(".r2row1").hide();
           $(".r2row2").not(".r2row1").hide();
           $(".r2sec1").show();
           $(".r2row1").show();
           
        }  
        if($(this).attr("name")=="green"){
           $(".sec3").not(".green").hide();
           $(".r2row1").not(".green").hide();
           $(".r2row2").not(".green").hide();
           $(".sec3").show();
           $(".green").show();
           
        }  
        
        if($(this).attr("name")=="r2row2"){
           $(".sec3").not(".r2row2").hide();
           $(".r2sec1").not(".r2row2").hide();
           $(".r2row3").not(".r2row2").hide();
           $(".r2sec2").show();
           $(".r2row2").show();
           
        } 
        
        if($(this).attr("name")=="r2row3"){
           $(".sec3").not(".r2row3").hide();
           $(".r2sec1").not(".r2row3").hide();
           $(".r2sec2").not(".r2row3").hide();
           $(".r2row4").not(".r2row3").hide();
           $(".r2sec3").show();
           $(".r2row3").show();
           
        } 
        if($(this).attr("name")=="r2row4"){
           $(".sec3").not(".r2row1").hide();
           $(".r2sec1").not(".r2row1").hide();
           $(".r2sec2").not(".r2row1").hide();
           $(".r2sec3").not(".r2row1").hide();
           $(".r2sec4").show();
           $(".r2row4").show();
           
        }
        
        if($(this).attr("name")=="row4"){
           $(".row3").not(".row4").hide();
           $(".sec3").show();
           
        }
        if($(this).attr("name")=="blue"){
           $(".mdr_row1").not(".blue").hide();
           $(".mdr_row2").not(".blue").hide();
           $(".mdr_row3").not(".blue").hide();
           $(".mdr_row4").not(".blue").hide();
           $(".sec_mdr").show();
           $(".blue").show();
           
        }
        
        if($(this).attr("name")=="mdr_row1"){
           $(".sec_mdr").not(".mdr_row1").hide();
           $(".mdr_row2").not(".mdr_row1").hide();
           $(".mdr_row3").not(".mdr_row1").hide();
           $(".mdr_row4").not(".mdr_row1").hide();
           $(".sec_mdr1").show();
           $(".mdr_row1").show();
           
        }
        
        if($(this).attr("name")=="mdr_row2"){
           $(".sec_mdr").not(".mdr_row2").hide();
           $(".sec_mdr1").not(".mdr_row2").hide();
           $(".mdr_row3").not(".mdr_row2").hide();
           $(".mdr_row4").not(".mdr_row2").hide();
           $(".sec_mdr2").show();
           $(".mdr_row2").show();
           
        }
        if($(this).attr("name")=="mdr_row3"){
           $(".sec_mdr").not(".mdr_row3").hide();
           $(".sec_mdr1").not(".mdr_row3").hide();
           $(".sec_mdr2").not(".mdr_row3").hide();
           $(".mdr_row4").not(".mdr_row3").hide();
           $(".sec_mdr3").show();
           $(".mdr_row3").show();
           
        }
        if($(this).attr("name")=="mdr_row4"){
           $(".sec_mdr").not(".mdr_row2").hide();
           $(".sec_mdr1").not(".mdr_row2").hide();
           $(".sec_mdr2").not(".mdr_row2").hide();
           $(".sec_mdr3").not(".mdr_row2").hide();
           $(".sec_mdr4").show();
           $(".mdr_row4").show();
           
        }
        if($(this).attr("name")=="row2"){
            $(".box2").not(".row7").hide();
            $(".row8").not(".row7").hide();
            $(".box3").show();
            $(".row7").show();
        }
        
         if($(this).attr("name")=="row9"){
            $(".box4").not(".row9").hide();
            $(".row9").show();
        }
        if($(this).attr("name")=="endline"){
           
            $(".box1").not(".endline").hide();
            $(".box2").not(".endline").hide();
            $(".endline").show();
        }
        
    });
});
                    </script>
                    
                    <tr class="red sec">
                       
                        
                    <td style="background-color:#d7f76d; color:#000; min-width:110px"><h4>Regimen. 1 </h4></td>
                    <td><input type="text" name="reg1" value="2RHZE/4RH"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date1" id="datepicker21" /> </td>
                    <td> <input type="text" name="tbstop_date1"  id="datepicker22"/> </td>
                    <td><textarea name="reason_o_changes1" id="reason_o_changes1">
                        
                        </textarea></td>
                      <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="sec1">
          
    <input type="button" class="btn btn-success"  name="row1"  value="+" />
        </div>
    </td>
                  </tr>  
                     <tr class="row1 box">
                      
                    <td style="background-color:#d7f76d; color:#000; min-width:110px"><h4>Regimen. 1 </h4></td>
                    <td><input type="text" name="reg12" value="2RHZE/4RH"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date12" id="datepicker21" /> </td>
                    <td> <input type="text" name="tbstop_date12"  id="datepicker22"/> </td>
                    <td><textarea name="reason_o_changes12" id="reason_o_changes1">
                        
                        </textarea></td>
                      <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="sec2">
          
    <input type="button" class="btn btn-success"  name="row2"  value="+" />
    <input type="button" class="btn btn-danger"  name="row0"  value="-" />
        </div>
    </td>
                  </tr>  
                    
                    <tr class="r1row1 box">
                      
                    <td style="background-color:#d7f76d; color:#000; min-width:110px"><h4>Regimen. 1 </h4></td>
                    <td><input type="text" name="reg13" value="2RHZE/4RH"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date13" id="datepicker21" /> </td>
                    <td> <input type="text" name="tbstop_date13"  id="datepicker22"/> </td>
                    <td><textarea name="reason_o_changes13" id="reason_o_changes1">
                        
                        </textarea></td>
                      <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="r1sec2">
          
    <input type="button" class="btn btn-success"  name="r1row2"  value="+" />
        <input type="button" class="btn btn-danger"  name="r1row0"  value="-" />
        </div>
    </td>
                  </tr>   
                    
                    <tr class="r1row2 box">
                      
                    <td style="background-color:#d7f76d; color:#000; min-width:110px"><h4>Regimen. 1 </h4></td>
                    <td><input type="text" name="reg14" value="2RHZE/4RH"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date14" id="datepicker21" /> </td>
                    <td> <input type="text" name="tbstop_date14"  id="datepicker22"/> </td>
                    <td><textarea name="reason_o_changes14" id="reason_o_changes1">
                        
                        </textarea></td>
                      <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="r1sec3">
          
    <input type="button" class="btn btn-success"  name="r1row3"  value="+" />
     <input type="button" class="btn btn-danger"  name="r1row1"  value="-" />
            
        </div>
    </td>
                  </tr>  
                    
                    <tr class="r1row4 box">
                    <td style="background-color:#d7f76d; color:#000; min-width:110px"><h4>Regimen. 1 </h4></td>
                    <td><input type="text" name="reg15" value="2RHZE/4RH"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date15" id="datepicker21" /> </td>
                    <td> <input type="text" name="tbstop_date15"  id="datepicker22"/> </td>
                    <td><textarea name="reason_o_changes15" id="reason_o_changes1">
                        
                        </textarea></td>
                      <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="r1sec4">
<!--         <input type="button" name="r1row5" class="btn btn-success" value="+" />-->
    <input type="button" class="btn btn-danger"  name="r1row2"  value="-" />
            
        </div>
    </td>
                  </tr>  
                    
                 
                    
                    <tr class="green sec">
                    <td style="background-color:#f7cc6d; color:#000; min-width:110px"><h4>Regimen. 2 </h4></td>
                    <td><input type="text" name="reg2" value="2SRHZE/1RHZE/5RH"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date2" id="datepicker23" /> </td>
                     <td> <input type="text" name="tbstop_date2" id="datepicker24" /> </td>
                   <td><textarea name="reason_o_changes2" id="reason_o_changes2">
                        
                        </textarea></td>
                        <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="sec3">
          
    <input type="button" class="btn btn-success"  name="r2row1"  value="+" />
        </div>
    </td>
                  </tr>    
                     
                    <tr class="r2row1 box">
                    <td style="background-color:#f7cc6d; color:#000; min-width:110px"><h4>Regimen. 2 </h4></td>
                    <td><input type="text" name="reg22" value="2SRHZE/1RHZE/5RH"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date22" id="datepicker23" /> </td>
                     <td> <input type="text" name="tbstop_date22" id="datepicker24" /> </td>
                   <td><textarea name="reason_o_changes22" id="reason_o_changes2">
                        
                        </textarea></td>
                        <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="r2sec1">
          
    <input type="button" class="btn btn-success"  name="r2row2"  value="+" />
    <input type="button" class="btn btn-danger" name="green"  value="-" />
        </div>
    </td>
                  </tr>    
                     
                    <tr class="r2row2 box">
                    <td style="background-color:#f7cc6d; color:#000; min-width:110px"><h4>Regimen. 2 </h4></td>
                    <td><input type="text" name="reg23" value="2SRHZE/1RHZE/5RH"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date23" id="datepicker23" /> </td>
                     <td> <input type="text" name="tbstop_date23" id="datepicker24" /> </td>
                   <td><textarea name="reason_o_changes23" id="reason_o_changes2">
                        
                        </textarea></td>
                        <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="r2sec2">
          
    <input type="button" class="btn btn-success"  name="r2row3"  value="+" />
    <input type="button" class="btn btn-danger" name="r2row1"  value="-" />
        </div>
    </td>
                  </tr>    
                     
                    <tr class="r2row3 box">
                    <td style="background-color:#f7cc6d; color:#000; min-width:110px"><h4>Regimen. 2 </h4></td>
                    <td><input type="text" name="reg24" value="2SRHZE/1RHZE/5RH"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date24" id="datepicker23" /> </td>
                     <td> <input type="text" name="tbstop_date24" id="datepicker24" /> </td>
                   <td><textarea name="reason_o_changes24" id="reason_o_changes2">
                        
                        </textarea></td>
                        <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="r2sec3">
          
    <input type="button" class="btn btn-success"  name="r2row4"  value="+" />
              
    <input type="button" class="btn btn-danger" name="r2row2"  value="-" />
        </div>
    </td>
                  </tr>    
                    
                     <tr class="r2row4 box">
                    <td style="background-color:#f7cc6d; color:#000; min-width:110px"><h4>Regimen. 2 </h4></td>
                    <td><input type="text" name="reg25" value="2SRHZE/1RHZE/5RH"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date25" id="datepicker23" /> </td>
                     <td> <input type="text" name="tbstop_date25" id="datepicker24" /> </td>
                   <td><textarea name="reason_o_changes25" id="reason_o_changes2">
                        
                        </textarea></td>
                        <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="r2sec4">
          
    <input type="button" class="btn btn-danger" name="r2row3"  value="-" />
        </div>
    </td>
                  </tr>       
      
      
                     
                     
                       <tr class="blue sec">
                    <td style="background-color:#6decf7; color:#000; min-width:110px"><h4>MDR 1</h4></td>
                    <td><input type="text" name="mdr" value="Km-Et-Z-Of-Cs"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date_mdr" id="datepicker23" /> </td>
                     <td> <input type="text" name="tbstop_date_mdr" id="datepicker24" /> </td>
                   <td><textarea name="reason_o_changes_mdr" id="reason_o_changes_mdr">
                        
                        </textarea></td>
                           
                    <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="sec_mdr">
          
    <input type="button" class="btn btn-success"  name="mdr_row1"  value="+" />
        </div>
    </td>
                  </tr>    
                       <tr class="mdr_row1 box">
                    <td style="background-color:#6decf7; color:#000; min-width:110px"><h4>MDR </h4></td>
                    <td><input type="text" name="mdr2" value="Km-Et-Z-Of-Cs"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date_mdr2" id="datepicker23" /> </td>
                     <td> <input type="text" name="tbstop_date_mdr2" id="datepicker24" /> </td>
                   <td><textarea name="reason_o_changes_mdr2" id="reason_o_changes_mdr">
                        
                        </textarea></td>
                           
                    <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="sec_mdr1">
          
    <input type="button" class="btn btn-success"  name="mdr_row2"  value="+" />
    <input type="button" class="btn btn-danger" name="blue"  value="-" />
        </div>
    </td>
                  </tr>    
                       <tr class="mdr_row2 box">
                    <td style="background-color:#6decf7; color:#000; min-width:110px"><h4>MDR </h4></td>
                    <td><input type="text" name="mdr3" value="Km-Et-Z-Of-Cs"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date_mdr3" id="datepicker23" /> </td>
                     <td> <input type="text" name="tbstop_date_mdr3" id="datepicker24" /> </td>
                   <td><textarea name="reason_o_changes_mdr3" id="reason_o_changes_mdr">
                        
                        </textarea></td>
                           
                    <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="sec_mdr2">
          
    <input type="button" class="btn btn-success"  name="mdr_row3"  value="+" />
    <input type="button" class="btn btn-danger" name="mdr_row1"  value="-" />
        </div>
    </td>
                  </tr>    
                       <tr class="mdr_row3 box">
                    <td style="background-color:#6decf7; color:#000; min-width:110px"><h4>MDR </h4></td>
                    <td><input type="text" name="mdr4" value="Km-Et-Z-Of-Cs"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date_mdr4" id="datepicker23" /> </td>
                     <td> <input type="text" name="tbstop_date_mdr4" id="datepicker24" /> </td>
                   <td><textarea name="reason_o_changes_mdr4" id="reason_o_changes_mdr">
                        
                        </textarea></td>
                           
                    <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="sec_mdr3">
          
    <input type="button" class="btn btn-success"  name="mdr_row4"  value="+" />
    <input type="button" class="btn btn-danger" name="mdr_row2"  value="-" />
        </div>
    </td>
                  </tr>  
                    
                    <tr class="mdr_row4 box">
                    <td style="background-color:#6decf7; color:#000; min-width:110px"><h4>MDR </h4></td>
                    <td><input type="text" name="mdr5" value="Km-Et-Z-Of-Cs"  style="width:150px" id="td_treatment21" /></td>
                    <td> <input type="text" name="tbstart_date_mdr5" id="datepicker23" /> </td>
                     <td> <input type="text" name="tbstop_date_mdr5" id="datepicker24" /> </td>
                   <td><textarea name="reason_o_changes_mdr5" id="reason_o_changes_mdr">
                        
                        </textarea></td>
                           
                    <td style="background-color:#f7cc6d; color:#000; min-width:110px">
        <div class="sec_mdr4">
          
    <input type="button" class="btn btn-danger" name="mdr_row3"  value="-" />
        </div>
    </td>
                  </tr>  
        </tbody>
    </table>
</div>
 </fieldset>   
    
                      <div class="form-actions">
                                                                                                                                                   <div class="span3">
               <button class="btn" style="padding:10px; font-size:180%"><a href="app.php?back&part_2<?php echo '&pat_id='.$pat_id.'' ?>">Back</a></button>                                                                                                                                    </div> 
                                                                                                                                                   <div class="span3"><!--
											<button type="submit" class="btn btn-primary" style="padding:10px; font-size:180%">Save</button> -->.
											
                                            </div>
                                            
                                            <div class="span3">
											<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_treatment3">Next</button> 
                                            </div>
                          </div>
    
</form>