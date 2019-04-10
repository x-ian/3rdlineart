<form id="edit-profile" class="form-horizontal" action="pih_p1.php?p" method="post" style="background-color:#fdfdfd; padding:20px">

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


<tr>
<td>

</td>
<td>

<h4>Result</h4>

<p><span style="color:#f00">*</span> VL repeated and if  "> 5000" the sample should be shipped to NHLS. </p>
<p><span style="color:#f00">*</span> VL repeated and if  "< 5000" SEND message to 3rd line sectretary. </p>
</td>   
</tr>


</table>
</td>    

</tr> 


<div class="form-actions">
     <div class="span3">
        <div><a class="btn" style="padding:10px; font-size:180%" title="print form" alt="print form" onclick="window.print();" target="_blank">Print Form</a></div>     
        <!-- <button class="btn" style="padding:10px; font-size:180%"><a href="#">Print Form</a></button> -->
     </div>
     <div class="span3">
        <!-- <button type="submit" class="btn btn-primary" style="padding:10px; font-size:180%">Save</button> -->.     
     </div>     
     <div class="span3">
        <button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_consolidate1">Ready for Shipping</button> 
     </div>
</div>     
</form>
     