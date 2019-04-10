<?php
/*
  $file = '../documents/results/1483558591-3rdartline-result.pdf';
  $filename = '1483558591-3rdartline-result.pdf';
  header('Content-type: application/pdf');
  header('Content-Disposition: inline; filename="' . $filename . '"');
  header('Content-Transfer-Encoding: binary');
  header('Accept-Ranges: bytes');
  @readfile($file);*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>jQuery Show Hide Elements Using Radio Buttons</title>
<style type="text/css">
    .box{
        padding: 20px;
        display: none;
        margin-top: 20px;
        border: 1px solid #000;
    }
    .red{ background: #ff0000; }
    .green{ background: #00ff00; }
    .blue{ background: #0000ff; }
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="red"){
            $(".box").not(".yes").hide();
            $(".yes").show();
        }
        if($(this).attr("value")=="green"){
            $(".box").not(".no").hide();
            $(".no").show();
        }
        
    });
});
</script>
</head>
<body>
    <div>
        <label> <input type="radio" name="colorRadio" value="red"> Yes</label>
        <label> <input type="radio" name="colorRadio" value="green"> No</label>
        
    </div>
    <div class="yes box">
    
     <table style="width:100%; font-size:120%" >
        <hr />
        <tr>
        <td>
            <p><i>*If switch is indicated, suggest ART regimen</i></p>
         <P>ART Regimen</P>  
           <p><strong>Drug 1:</strong> <input type="text" name="drug1" /></p> 
           <p><strong>Drug 2:</strong><input type="text" name="drug2" /></p> 
           <p><strong>Drug 3:</strong><input type="text" name="drug3" /></p> 
           <h4>Comment: </h4>
           <textarea type="text" class="span4" rows="4" name="comment_to_clinician"  id="area1" ></textarea>    
        </td>
       
        </tr>
     
    </table>
    
    </div>
    <div class="no box">
        <table style="width:100%; font-size:120%" >
        <hr />
        <tr>
     <td>
         <p><i>*If switch is NOT indicated, suggest ART regimen</i></p>
            <h4>Feedback to Clinician</h4>
              <textarea type="text" class="span4" rows="8" name="feedback_to_clinician"  id="area1" ></textarea> 
        </td>
            </tr>
        </table>
    
    
    </div>
   
</body>
</html>