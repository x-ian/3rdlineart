
<h2 style="background-color:#f8f7f7; text-align:center"> TB Treatment</h2>
<?php

global $pat_id;
$pat_id= $_GET['pat_id'];

$patient = new Patient($pat_id);
$client_name = $patient->fullname;

$tb_treatment ="";
//tb_treat
$tb_treat = mysqli_query( $bd,"SELECT * FROM tb_treat where pat_id='$pat_id' "); 
while ( $row_tb_treat=mysqli_fetch_array($tb_treat)) {
	$tb_treatment =$row_tb_treat['tb_treatment'];
}

//tb_treat_regimen1
$tb_treat_regimen1=mysqli_query( $bd,"SELECT * FROM tb_treat_regimen1 where pat_id='$pat_id' "); 
while ( $row_tb_treat_regimen1=mysqli_fetch_array($tb_treat_regimen1)) {
	$reg1_name [] =$row_tb_treat_regimen1['reg_name'];
	$start_date1 [] =$row_tb_treat_regimen1['start_date'];
	$stop_date1 [] =$row_tb_treat_regimen1['stop_date'];
	$reason_for_change1 [] =$row_tb_treat_regimen1['reason_for_change'];
}

//tb_treat_regimen2
$tb_treat_regimen2=mysqli_query( $bd,"SELECT * FROM tb_treat_regimen2 where pat_id='$pat_id' "); 
while ( $row_tb_treat_regimen2=mysqli_fetch_array($tb_treat_regimen2)) {
	$reg2_name []=$row_tb_treat_regimen2['reg_name'];
	$start_date2 [] =$row_tb_treat_regimen2['start_date'];
	$stop_date2 [] =$row_tb_treat_regimen2['stop_date'];
	$reason_for_change2 [] =$row_tb_treat_regimen2['reason_for_change'];
}

//tb_treat_MDR
$tb_treat_mdr=mysqli_query( $bd,"SELECT * FROM tb_treat_mdr where pat_id='$pat_id' "); 
while ( $row_tb_treat_mdr=mysqli_fetch_array($tb_treat_mdr)){
	$reg3_name []=$row_tb_treat_mdr['reg_name'];
	$start_date3 [] =$row_tb_treat_mdr['start_date'];
	$stop_date3 [] =$row_tb_treat_mdr['stop_date'];
	$reason_for_change3 [] =$row_tb_treat_mdr['reason_for_change'];
}

echo '<form id="edit-profile" class="form-horizontal" action="app.php?pat_id='.$pat_id.'" method="post">';
?> 

<h3>Client Name: <strong><i style="background-color:#f8f7f7; color:red"><?php echo $client_name; ?></i></strong></h3>

<input type="hidden" name="pat_id" value="<?php echo $pat_id; ?>" style="background-color:#fff; border:none; height:20px; color:#fff; position:relative; top:-300px;"/>
<input type="hidden" name="dob" value="<?php echo $dob; ?>" style="background-color:#fff; border:none; height:20px; color:#fff; position:relative; top:-300px;" /> 

<script type="text/javascript"> 
	$(document).ready(function(){
        // $("#edit-profile").parsley();
		if ($('input[id="tb_treat-yes"]').attr("checked") == 'checked') {
			$(".box").not(".yes").hide();
			$(".yes").show();
		} else
		$(".yes").hide();
        $( "input[type=text][name^=tbstart_date][value!='']").parents("tr" ).show();
        <?php
        echo "$( \"input[type=checkbox][name=regimen1_checked]\" ).prop('checked',".(count($start_date1) > 0 ? 'true':'false').");";
        echo "$( \"input[type=checkbox][name=regimen2_checked]\" ).prop('checked',".(count($start_date2) > 0 ? 'true':'false').");"; 
        echo "$( \"input[type=checkbox][name=mdr_checked]\" ).prop('checked',".(count($start_date_mdr) > 0 ? 'true':'false').");";
        ?>
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
        // prevents typing into date input box
        $('[id^="datepicker"]').keypress(function(e) {
            e.preventDefault();
        });
    });
</script>

<fieldset>
	<div style="width:110px; float:left" class="radio-btn">
		<input type="radio" id="tb_treat-yes" name="tb_treat" value="Yes"  <?php if ($tb_treatment =='Yes'){echo 'checked="checked"'; } ?> >
		<label for="tb_treat-yes">Yes</label>
		<div class="check">
		</div>
	</div>
	<div style="width:100px; float:left" class="radio-btn">
		<input type="radio" id="tb_treat-no" name="tb_treat" value="No"  <?php if ($tb_treatment =='No'){echo 'checked="checked"'; } ?> >
		<label for="tb_treat-no">No</label>
		<div class="check">
		</div>
	</div>

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
				<tr style="background-color:#cb9112; font-size:112%; font-weight:300; color:#fff">
					<td> </td>
					<td> Regimen Drug </td>
					<td> Start Date</td>
					<td> End Date</td>
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
							<?php
							for($regimen=1; $regimen<=3; $regimen++) {
								$regnamecl = $regimen<3 ? "r$regimen" : 'mdr_';
								$regrow = 0;

								for ($col=0; $col<5; $col++) {
									$cols = $col ? $col : '';
									$regrowp1 = $regrow+1;
									$cols_1 = $col-1 ? $col-1 : '';

									if ($regrow < 4) {
										echo "\nif($(this).attr(\"name\")==\"$regnamecl+row$regrowp1\"){
											$(\".$regnamecl"."row$regrowp1\").show();
											$(\".$regnamecl"."butts$cols\").hide();
											$(\".$regnamecl"."butts$regrowp1\").show();
										}";
									}
									if ($regrow > 0) {
										echo "\nif($(this).attr(\"name\")==\"$regnamecl-row$regrow\"){
											$(\".$regnamecl"."row$regrow\").hide();
											$(\".$regnamecl"."butts$cols_1\").show();".
											($regrow < 4 ? "\n\t$(\".$regnamecl"."butts$regrowp1\").hide();":"").
											"\n}";
										}
										$regrow++;
									}
								}
								?>
							});
					});
				</script>

				<script>
var today = new Date();
var epoch = new Date(1900, 1, 1);
					<?php
					for($i=21; $i<=29; $i+=2) {
						$i1 = $i+1;
						echo "
						$( function() {
							$( \"#datepicker$i1\" ).datepicker('option', {
								changeMonth: true,
				                maxDate: today,
                                minDate: epoch,
                                dateFormat: 'dd/mm/yy',
                                yearRange: '1900:20202020',
								beforeShow : function()
								{
                                        jQuery( this ).datepicker('option','minDate', jQuery('#datepicker$i').val() == 'undefined'?epoch:jQuery('#datepicker$i').val() );
								},
								changeYear: true
							});
						} );

						$( function() {
							$( \"#datepicker$i\" ).datepicker('option', {
								changeMonth: true,
				                maxDate: today,
                                minDate: epoch,
                                dateFormat: 'dd/mm/yy',
                                yearRange: '1900:20202020',
								changeYear: true
							});
						} );";
					}
					for ($i=31; $i<=50; $i++) {
						echo "
						$( function() {
							$( \"#datepicker$i\" ).datepicker('option', {
								changeMonth: true,
				                maxDate: today,
                                minDate: epoch,
                                dateFormat: 'dd/mm/yy',
                                yearRange: '1900:20202020',
								changeYear: true
							});
						} );";
					}
					?>
				</script>

<?php
$colors = ["red", "green", "blue"];
$colorcodes = ["#d7f76d", "#f7cc6d", "#6decf7"];
$regimens = ['2RHZE/4RH', '2SRHZE/1RHZE/5RH', 'Km-Et-Z-Of-Cs'];
$startdate = 1;
$datepicker = 21;
$row = 1;
$row_1 = 0;
$regimen = 1;
$js = '';

for($regimen=1; $regimen<=3; $regimen++) {
    $regnamecl = $regimen<3 ? "r$regimen" : 'mdr_';
    $regname = $regimen<3 ? "$regimen" : 'mdr_';
	$regrow = 0;
    
    for ($col=1; $col<=5; $col++) { // col means row within a regimen
        $cols = $col; // $col>1 ? $col : '';
        $datepicker2 = $datepicker + 1;
        $color = $colors[$regimen-1];

        $regrowp1 = $regrow+1;
        $cols1 = $col-1 ? $col-1 : '';

        $regrow1 = $regnamecl.'+row'.($regrow+1);
        $regrow2 = $regnamecl.'-row'.($regrow);

        eval("\$reg_name = !empty (\$reg$regimen"."_name [$regrow]) ? \$reg$regimen"."_name [$regrow] : '".$regimens[$regimen-1]."';");
        eval("\$start_date = !empty(\$start_date$regimen [$regrow]) ? format_date_fromdb(\$start_date$regimen [$regrow]) : '';");
        eval("\$stop_date = !empty (\$stop_date$regimen [$regrow]) ? format_date_fromdb(\$stop_date$regimen [$regrow]) : '';");
        eval("\$reason = !empty (\$reason_for_change$regimen [$regrow]) ? \$reason_for_change$regimen [$regrow] : '';");

        $class = $col==1 ? "$color sec": $regnamecl."row$regrow box";
        $class_sec = $regrow==0 ? "$regnamecl"."butts" : $regnamecl."butts$regrow"; // sec$cols
        // $required = $col == 1 ? "required" : "";
        $required = "";
        echo "\n<tr class=\"$class\">
        <td style=\"background-color:$color; color:#000; min-width:110px\"><h4>Regimen. $regimen </h4></td>
        <td><input type=\"text\" name=\"reg$regname$cols\" value=\"$reg_name\" style=\"width:170px;margin: 5px\" id=\"tb_treatment$regname$cols\" /></td>
        <td> <input type=\"text\" name=\"tbstart_date$regname$cols\" style=\"width:110px;margin: 5px\" value=\"$start_date\" id=\"datepicker$datepicker\" $required/> </td>
        <td> <input type=\"text\" name=\"tbstop_date$regname$cols\" style=\"width:110px;margin: 5px\"  value=\"$stop_date\" id=\"datepicker$datepicker2\" $required/> </td>
        <!-- <td><input type=\"radio\" name=\"radio1[]\" value\"Stop\"></td><td><input type=\"radio\" name=\"radio1[]\" value\"Finish\"></td> -->
        <td><textarea name=\"reason_o_changes$regname$cols\" style=\"width:270px;margin: 5px\" id=\"reason_o_changes$regname$cols\">$reason</textarea></td>

        <td style=\"background-color:#f7cc6d; color:#000; min-width:80px\">
        	<div class=\"$class_sec\">".
        		($regrow<4?"<input type=\"button\" class=\"btn btn-success\" name=\"$regrow1\" value=\"+\" />\n\t":"").
        		($regrow>0?"<input type=\"button\" class=\"btn btn-danger\" name=\"$regrow2\"  value=\"-\" />":"").
        		"</div>
        	</td>
        </tr>";
        
        $regrow++;
        $datepicker += 2;
    }
}
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('input[type="button"]').click(function(){
			<?php echo $js; ?>
		}); 
	});
</script>
</form>

</tbody>
</table>
</div>
</fieldset>   

<div class="form-actions">
	<div class="span3">
		<a class="btn" href="app.php?back&back_treatment3<?php echo '&pat_id='.$pat_id.'&g='.$patient->gender.'&xx='.$patient->age.'' ?>" style="padding:10px; font-size:180%">Back</a>
	</div> 
	<div class="span3">

	</div>
	<div class="span3">
		<?php include ('includes/app_edit_menu.php'); ?>
	</div>

	<div class="span3">
		<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="update_treatment3">Next</button> 
	</div>
</div>
</form>