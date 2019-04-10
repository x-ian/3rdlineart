<?php
global $drug_id;
$drug_id = $_GET['id'];

$drugs=mysqli_query( $bd,"SELECT * FROM drugs where id =$drug_id"); 
    $row_drugs=mysqli_fetch_array($drugs);
        $drug_name =$row_drugs['drug_name'];
        $line =$row_drugs['line'];
        $description =$row_drugs['description'];
?>

<h2 style="background-color:#fff; text-align:left; color:#000000">Edit Drug</h2>
        <hr /> 

<form id="edit-profile" class="form-horizontal" action="dash.php?update" method="post">
<input type="hidden" class="span3" id="id" name="id" value="<?php echo $drug_id; ?>" style="margin:5px" >   
<div class="control-group">											
			<label class="control-label" for="firstname">Regimen Line</label>
			<div class="controls">
                    <select class="span4" id="line"name="line" style="margin:5px; width:150px;">
                        <?php echo '<option selected="selected">'.$line.'</option>'; ?>
                              <option>Select Regimen Line</option>
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              
                    </select>
            </div>			
</div>  
<div class="control-group">											
            <label class="control-label" for="Drug Name">Drug Name</label>
            <div class="controls">											
                    <input type="text" class="span3" id="drugnmae" name="drug_name" value="<?php echo $drug_name; ?>" style="margin:5px" ><br />
            </div>			
</div> 
    
<div class="control-group">											
            <label class="control-label" for="firstname">Description</label>
            <div class="controls">
                    <textarea type="text" id="email" rows="3" cols="6" name="description"  style="width:50%; margin:5px"><?php echo $description;?></textarea>
            </div>			
</div> 

<div class="form-actions">
    <div class="span2">
               <a href="dash.php?p" class="btn" style="padding:10px; font-size:180%">Cancel</a>
    </div>
                                 
    <div class="span2">
                <button type="submit" class="button btn btn-primary btn-large" style="padding:10px; font-size:180%" name="update_drug">Register</button>
    </div>
</div>                 
</form>
 