<script type="text/javascript" src="js/jquery.js"></script>
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

        $("#submit_review").click(function() {
            //Select the parent form and submit
            $("#edit_review").submit();
        });
    });

        
</script>
<br/><hr/><br/>
<form id="edit_review" class="form-horizontal" action="review_p1.php?p&formid=<?php echo $formID; ?>" method="post" style="background-color:#e6e6e6; padding:20px">
	<h2 style="background-color:#f5ec10; text-align:center">Expert Form Review</h2>
	<hr style=" border: 1.5px solid #b49308;" />

	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$('input[name="art_interrup"]').on('click', function () {
				if ($(this).val() === 'Yes') {
					$('#datepicker,#art_interupt_reason').prop("disabled", false);
				} else {
					$('#datepicker,#art_interupt_reason').prop("disabled", "disabled");
				}
			});
		});
	</script>  

	<script type="text/javascript" src="../../js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		tinymce.init({
			selector: "textarea",
			theme: "modern",
			plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern"
			],
			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			toolbar2: "print preview | forecolor backcolor emoticons",
			image_advtab: true,
			templates: [
			{title: 'Test template 1', content: 'Test 1'},
			{title: 'Test template 2', content: 'Test 2'}
			]
		});
	</script>
<?php
$other_reviewers_sql = "SELECT rev_id, title, fname, lname, email, status FROM assigned_forms,reviewer where form_id=$formID and rev_id != $rev_id and assigned_forms.rev_id = reviewer.id";
// echo "<br>$other_reviewers_sql";

$select_others = mysqli_query( $bd, $other_reviewers_sql);
$other_reviewers = '';
$email_to = '';
while ($row_others = mysqli_fetch_array($select_others)) {
    if ($other_reviewers)
        $other_reviewers .= ', ';    
    $other_reviewers .= ($row_others['title'].'. '.$row_others['fname'].' '.$row_others['lname']);
    if ($email_to)
        $email_to .= ', ';    
    $email_to .= $row_others['email'];
}
?>
	<tr>
		<td>
			<h4>Is Genotyping indicated?</h4> 
		</td>
		<td>
			<div style="width:110px;  float:left" class="radio_sty span8">
				<input type="radio" id="genotyping"  name="genotyping" value="Yes"  required>
				<label for="genotyping">Yes</label>
				<div class="check">
				</div>
			</div>
			<div style="width:100px; float:left" class="radio_sty">
				<input type="radio" id="ngenotyping" name="genotyping" value="No" >
				<label for="ngenotyping">No</label>
				<div class="check">
				</div>
			</div>
		</td>
    </tr>
    <tr>
    <td>
    <span style="font-weight:normal;font-size:16px">Other Reviewers:</span> <span style="font-weight:bold;font-size:16px"><?=$other_reviewers?></span>
<?php 
    if (0) echo '<a href="#myModal" role="button" data-toggle="modal" class="btn btn-small btn-primary">Contact Other Reviewers</a> 
		<div id="myModal" class="modal fade" tabindex="-1" style="width:800px;height:700px" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 style="te
xt-align:center">Compose Message to Other Reviewers</h3>
				</div>
				<div class="modal-body"> 
					<form id="#" action="cp_p1.php?p&notcomplete&form_id='.$form_id.'" method="post">
						<p>To:'.$email_to.'</p>
						<input type="hidden" name="email_address" Value ="'.$email_to.'" />
						<h4>Compose Message</h4>
						<textarea style="width:93%;height:100%" rows="15" name="comment" value="">
To: '.$other_reviewers.',<br>In regards to the Application #'.$form_id.', Patient '.$client_name.',<br> 
						</textarea>
						<div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;">
							<button type="submit" name="submit_message" class="btn btn-warning" style="width:80%;height=80%">Send Message</button>  
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
			</div>
		</div>';
           ?>
    </td>
	</tr>
	<tr><td><br/></td><td><br/></td></tr>
	<div class="no box">
		<tr>
			<td>
 <h4>Comment to Clinician?</h4>
            </td>
        </tr>
        <tr>
            <td>
				<textarea type="text" class="span4" rows="8" name="comment_to_clinician"  id="area1" ></textarea>
			</td>   
		</tr>
	</div>
</table>
</td>    
</tr> 

<div class="form-actions">
	<div class="span3">
		<button class="btn" style="padding:10px; float:left; font-size:180%"><a href="review_p1.php?p">Cancel</a></button>
	</div>
	<div class="span3">
    &nbsp;
	</div>
	<div class="span3">
    <button type="submit" id="submit_review" class="btn btn-success" style="padding:10px; float:right; font-size:180%" name="submit_review">Next</button> -->
	</div>
</div>

</form>