<div class="mycontainer" style="background-color:#cbe509; padding:10px; position:relative; top:0px">
        <table style="width:100%" border="0">
          <tr style="background-color:#f8f7f; text-align:center; color:#000">
            <td>
              <h4>ART Clinic</h4>
              <h4><u><?php echo $facility ?></u></h4> 
            </td>
            <td>
              <h3><?php echo $fullname ?></h3>
            </td>        
          </tr>
        </table>        

        <hr style="border: 1px solid #cbe509;" />
        <table style="width:100%" border="0" style="background-color:#0eaff7; ">        
          <tr style="background-color:#fcfgcfc; text-align:center; color:#000">
            <td>
              <h4>Tel. Number</h4>
              <h4>Email Address</h4>
            </td>
            <td>
              <h4><?php echo $clin_phone ?></h4>
              <h4><?php echo $clin_email ?></h4>
            </td>        
          </tr>
        </table>       
        </div>
            
        <form id="edit-profile" class="form-horizontal" action="app.php" method="post">
<div class='mycontainer'>
    <div class='myrow'>
         <div class="mybox">
        <a type="submit" href="app.php?part_1" class="btn btn-success" style="padding: 10px; margin: 10px; font-size:150%" name="submit_facility">New/Incomplete<br>Referral</a></div>
        <div class="mybox">
        <a type="submit"  href="app.php?rejec" class="btn btn-danger" style="padding:10px; margin: 10px; font-size:150%" name="submit_facility">Rejected forms</a></div>
   </div>
    <div class='myclear'></div>
</div>
<div class='mycontainer'>
    <div class='myrow'>
        <div class="mybox">
        <a type="submit" class="btn btn-primary" style="padding:10px; font-size:150%" name="submit_facility" href="app.php?rev">Referral<br>with Decisions</a>
            <strong><?php echo '['.$tot_number.'] ';?></strong></div>
        <div class="mybox">
        <a type="submit" class="btn btn-revert" style="padding:10px; font-size:150%" href="app.php?conso2">Genotype Results</a>
            <strong><?php echo '['.$tot_number_conso2.'] ';?></strong></div>
     </div>
    <div class='myclear'></div>
</div>

</form>

