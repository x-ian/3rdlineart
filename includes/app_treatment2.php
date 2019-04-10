<h2 style="background-color:#f8f7f7; text-align:center">CD4 & VL Monitoring</h2>
<!--   <hr style=" border: 2px solid #1c952f;" />  -->

<script>     
    $().ready(function() {  
// validate the comment form when it is submitted
		$("#commentForm").validate();
		$("#search_art").validate({
			rules: {
				id: {
					required: true,					
				},
			},
			messages: {
				id: {
					required: "need this!",
				},
			}
		});

		// validate clinic staus form on keyup and submit
		$("#edit-profile").validate({
			rules: {
				weight: {
					required: true,
                        range: [10, 250],

				},
			},
			messages: {
				weight: {
					required: "Curr Weight",
				}, 
			}
		});
	});
</script>
     
<?php
global $pat_id;
$pat_id= $_GET['pat_id'];

$patient = new Patient($pat_id);
$client_name = $patient->fullname;

echo '<form id="edit-profile" class="form-horizontal" action="app.php?pat_id='.$pat_id.'" method="post">';
?> 
	<h3>Client Name: <strong><i style="background-color:#f8f7f7; color:red"><?php echo $client_name; ?></i></strong></h3>

	<input type="hidden" name="pat_id" value="<?php echo $pat_id; ?>" />
	<input type="hidden" name="dob" value="<?php echo $patient->dob; ?>"  />
	<script>
		<?php
		for ($i=16; $i<25; $i++) {
			echo "
			$( function() {
				$( \"#datepicker$i\" ).datepicker({
					changeMonth: true,
					changeYear: true
				});
			} );";
		}
		?>
	</script>
     <!-- <hr style=" border: 1px solid #cbe509;" />
     <h3>Monitoring</h3>-->
     <fieldset>
     	<table style="width:90%" border="0">
     		<thead>
     			<tr>
     				<th> Monitoring Date</th>
     				<th> CD4 ( <i>cells/ul</i> )</th>
     				<th> VL  ( <i>copies/ml</i> )</th> 
     				<th> Reason for detectable VL (Non-adherence, treatment break)</th>
     				<th> Weight (kg)</th>
     				
     			</tr>
     		</thead>
     		<tbody>
     			<?php
     			for ($i=1; $i<25; $i++) {
     				echo "
     				$( function() {
     					$( \"#datepicker$i\" ).datepicker({
     						changeMonth: true,
     						changeYear: true
     					});
     				} );";
     			}

                $i = 0;
                $box = 1;
				for($date_i=16; $date_i<=25; $date_i++) {
					$i_1 = $i+1;
					$i_2 = $i+2;

                    $rowclass = ($i > 5) ? "row$i box" : '';
					echo "
					<tr class=\"$rowclass\">
						<td> <input type=\"text\" name=\"monito_date$i_1\" id=\"datepicker$date_i\"/></td>
						<td> <input type=\"number\" name=\"cd4$i_1\" style=\"width:120px\"/> </td>
						<td> <input type=\"number\" name=\"vl$i_1\" style=\"width:120px\"/> </td>
						<td><textarea name=\"reason_4_detectable_vl$i_1\"></textarea></td>
						<td> <input type=\"number\" name=\"weight$i_1\"/> </td>";

					if ($i == 5) 
						echo "
					<td><form action=\"#\">
						<div class=\"box$box\">
						<input type=\"button\" name=\"row$i_1\" class=\"btn btn-success\" value=\"+\" />";

                    if ($i > 5) 
                        echo
                            "<td><div class=\"box$box\">
								<input type=\"button\" name=\"row$i_2\" class=\"btn btn-success\" value=\"+\" />
								<input type=\"button\" name=\"row$i\" class=\"btn btn-danger\" value=\"-\" />";
					if ($i >= 5) {
                        echo
                            "</div>
				    </form></td>";
                        $box += 1;
                    }
					if ($i > 10)
						echo '
					<tr class="endline box">
						<td><p style="color:#f00">Max numbr reached</p> </td>';
                  
					echo '</tr>';
                    $i++;
				}
				?>                    
     		</tbody>
     	</table>
     </fieldset>
     
     <div class="form-actions">
     	<div class="span3">
     		<button class="btn" style="padding:10px; font-size:180%"><a href="app.php?part_1<?php echo '&pat_id='.$pat_id.'' ?>">Back</a></button>
      </div>
     <div class="span3"><!--
      <button type="submit" class="btn btn-primary" style="padding:10px; font-size:180%">Save</button> -->.
      
    </div>
    
    <div class="span3">
      <button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_treatment2">Next</button> 
    </div>
  </div>
  
</form>
<script type="text/javascript">
  $(document).ready(function(){
   $('input[type="button"]').click(function(){
    
    if($(this).attr("name")=="row6"){
     $(".box").not(".row6").hide();
     $(".box1").not(".row6").hide();
     $(".row7").not(".row6").hide();
     $(".row8").not(".row6").hide();
     $(".box2").show();
     $(".row6").show();
   } 
   if($(this).attr("name")=="row5"){
     $(".row6").not(".row5").hide();
     $(".box1").show();
     
   }
   if($(this).attr("name")=="row7"){
     $(".box2").not(".row7").hide();
     $(".row8").not(".row7").hide();
     $(".box3").show();
     $(".row7").show();
   } 
   
   if($(this).attr("name")=="row8"){
     $(".box3").not(".row8").hide();
     $(".row9").not(".row8").hide();
     $(".endline").not(".row8").hide();
     $(".box4").show();
     $(".row8").show();
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
