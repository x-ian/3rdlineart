<script>
$().ready(function() {
    // $('#edit-profile').parsley();  // and in input elements, add  <required data-parsley-type="integer"> or whatever       
    // deal with the form +/- buttons
    $( "tr:gt(5)" ).hide();  // of course this needs to change if more than 5 rows are shown by default
    $( "input[type=number][name^=cd4][value!='']").parents("tr").show();
});

$('[id^="datepicker"]').keypress(function(e) {
    e.preventDefault();
});
        
</script>

<h2 style="background-color:#f8f7f7; text-align:center">CD4 & VL Monitoring</h2>
<?php

global $pat_id;
$pat_id = $_GET['pat_id'];

$patient = new Patient($pat_id);
$client_name = $patient->fullname;

//monitoring
$monitoring = mysqli_query( $bd,"SELECT * FROM monitoring where pat_id='$pat_id' "); 
while ( $row_monitoring = mysqli_fetch_array($monitoring)){
	$monito_date [] = $row_monitoring['monito_date'];
	$cd4 [] = $row_monitoring['cd4'];
	$vl [] = $row_monitoring['vl'];
	$reason_4_detectable_vl [] = $row_monitoring['reason_4_detectable_vl'];
	$weight [] = $row_monitoring['weight'];
}

echo '
<form id="edit-profile" class="form-horizontal" action="app.php?pat_id='.$pat_id.'" method="post">
	';
	?> 

	<h3>Client Name: <strong><i style="background-color:#f8f7f7; color:red"><?php echo $client_name; ?></i></strong></h3>
	<input type="hidden" name="pat_id" value="<?php echo $pat_id; ?>" />
	<input type="hidden" name="dob" value="<?php echo $dob; ?>"  /> 

    <script type="text/javascript">
        var today = new Date();
        var epoch = new Date(1900, 1, 1);

		$( function() {
			$( "#datepicker16" ).datepicker("option", {
				changeMonth: true,
				maxDate: today,
                minDate: epoch,
                dateFormat: 'dd/mm/yy',
                yearRange: '1900:2018',
				beforeShow : function()
				{
					jQuery( this ).datepicker('option', 'maxDate', jQuery('#datepicker17').val() == 'undefined'?today:jQuery('#datepicker17').val() );
				},
				changeYear: true
			});
		} );

		<?php
		for ($i=16; $i<24; $i++) {
			$i1=$i+1;
			echo "
			$( function() {
				$( \"#datepicker$i\" ).datepicker(\"option\", {
					changeMonth: true,
					maxDate: today, 
                    minDate: epoch,
                    dateFormat: 'dd/mm/yy',
                    yearRange: '1900:2018',
					beforeShow : function()
					{
						jQuery( this ).datepicker('option','minDate', jQuery('#datepicker$ii').val() == 'undefined'?epoch:jQuery('#datepicker$ii').val() );
					}, 
					changeYear: true
				});
			} );";
		}
        ?>
 	</script>

	<fieldset>
		<table style="width:90%" border="0">
			<thead>
				<tr>
					<th> Monitoring Date</th>
					<th style="width:120;margin:20px"> CD4 ( <i>cells/ul</i> )</th>
					<th style="width:120;margin:20px"> VL  ( <i>copies/ml</i> )</th> 
					<th style="width:360px;margin:20px"> Reason for detectable VL (Non-adherence, treatment break)</th>
					<th style="width:120;margin:10px"> Weight (kg)</th>

				</tr>
			</thead>
			<tbody>
				<?php
				$i = 0;
				$box = 1;
				for($date_i=16; $date_i<=25; $date_i++) {
					$i1 = $i+1;
					$i2 = $i+2;
                    if ($i < 1)
                        $required = 'required';
                    else
                        $required = '';
					$dateval = format_date_fromdb(!empty ($monito_date[$i]) ? $monito_date[$i] : '');
                    // $dateval = !empty ($monito_date[$i]) ? $monito_date[$i] : '');
					$cd4val = !empty ($cd4[$i]) ? $cd4[$i] : '';
					$vlval = !empty ( $vl[$i]) ? $vl[$i] : '';
					$reasonval = !empty ( $reason_4_detectable_vl[$i]) ? $reason_4_detectable_vl[$i] : '';
					$weightval = !empty  ( $weight[$i]) ? $weight[$i] : '';

					$rowclass = $i1 >= 5 ? "box$i1":"sbox";
 					echo "
					<tr class=\"$rowclass\">
						<td> <input type=\"text\" name=\"monito_date$i1\" id=\"datepicker$date_i\" style=\"width:120px\" value=\"$dateval\" $required/> </td>
						<td> <input type=\"number\" name=\"cd4$i1\" style=\"margin:10px;width:120px\" value=\"$cd4val\""."/> </td>
						<td> <input type=\"number\" name=\"vl$i1\" style=\"width:120px\" value=\"$vlval\""."/> </td>
						<td> <textarea name=\"reason_4_detectable_vl$i1\" style=\"margin:10px; width:350px\" >$reasonval</textarea> </td>
						<td> <input type=\"number\" name=\"weight$i1\" step=\".1\" style=\"width:120px\" value=\"$weightval\" $required/> </td>";

						if ($i1 >= 5) {
							echo "
							    <td><div class=\"butts$box\">".
                                (($i1>=5 and $i1<10)?"<input type=\"button\" name=\"row+$i2\" class=\"btn btn-success\" value=\"+\" />":"").
                                (($i1>5 and $i1<11)?"<input type=\"button\" name=\"row-$i1\" class=\"btn btn-danger\" value=\"-\" />":"").
                                "</div>
								</td>";
								$box += 1;
                        }
                        if ($i1 > 11)
                            echo '
							<tr class="endline box">
								<td><p style="color:#f00">Max numbr reached</p> </td>';
					echo '</tr>';
                    // echo 'endrow!! '.$i;
					$i++;
				}
?>
<script type="text/javascript">
     $('input[type="button"]').click(function(){
            // alert('click!');
<?php
            $i=1;
            for($row=6; $row<=10; $row++) {
                $i1 = $i + 1;
                echo "if($(this).attr(\"name\")==\"row+$row\") {
                        $(\".box$row\").show();
                        $(\".butts$i\").hide();
                        $(\".butts$i1\").show();
                    }
                    if($(this).attr(\"name\")==\"row-$row\") {
                        $(\".box$row\").hide();
                        $(\".butts$i\").show();
                    }";
                $i++;
            }
?>
        });
</script>

						</tbody>
					</table>
				</fieldset>

				<div class="form-actions">
					<div class="span3">
						<a class="btn" href="app.php?back_treatment2<?php echo '&pat_id='.$pat_id.'&g='.$patient->gender.'&xx='.$patient->age.'' ?>" style="padding:10px; font-size:180%">Back</a>
					</div>
					<div class="span3">
                    <?php include ('includes/app_edit_menu.php'); ?>
					</div>
					<div class="span3">
						<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="update_treatment2">Next</button> 
					</div>
				</div>
			</form>