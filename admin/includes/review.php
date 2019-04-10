<br /><hr /><br />
<form id="edit-profile" class="form-horizontal" action="app.php" method="post" style="background-color:#ccc; padding:20px">

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
	<tr>
		<td>
			<h4>Is Genotyping indicated?</h4>          
		</td>
		<td>
			<div class="controls">
				<label class="radio inline">
					<input type="radio"  name="art_interrup" value="Yes" id="app_radio"> Yes
				</label>

				<label class="radio inline">
					<input type="radio" name="art_interrup" value="No" id="app_radio"> No
				</label>
			</div></td>   
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<h4>Comment to Clinician?</h4>
				<textarea type="text" class="span4" rows="8" name="art_interrup_reason"  id="area1" ></textarea>
			</td>   
		</tr>
	</table>
</td>    
</tr> 

<div class="form-actions">
	<div class="span3">
		<button class="btn" style="padding:10px; font-size:180%">Cancel</button>
	</div>
	<div class="span3">
	</div>

	<div class="span3">
		<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_patD">Next</button> 
	</div>
</div>


</form>