                        
    
 <div class="span10">
   
     <form id="edit-profile" class="form-horizontal" action="#" method="post">
						 

<h2 style="background-color:#0eafff7; text-align:center; color:#000000">Application with Genotype Result Decision</h2>
                        <hr style=" border: 1px solid #cbe509;" />
                          
     <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="text-align:center"> <p><strong>FORM Id</strong></p></th> 
                    <th class="td-actions" style="text-align:center"><p><strong>Review</strong></p> </th>
                    
                   
                  </tr>
                </thead>
                <tbody>
                    <?php


    while ($row_form_creation=mysqli_fetch_array($form_creation_conso2)){
        
        $_3rdlineart_form_id =$row_form_creation['3rdlineart_form_id'];
        $switch =$row_form_creation['switch'];
        $date_reviewed =$row_form_creation['consolidate2_date'];
        
     
        
        echo '
       <tr>
                        <td> <p style="text-align:center"><strong> 3rdLForm#'.$_3rdlineart_form_id.'</strong></p> </td>
                    <td> 
                    <p style="text-align:center"><strong>'.$date_reviewed.'</strong></p>
                    </td>
                        <td class="td-actions"><a href="app.php?conso2view&formid='. $_3rdlineart_form_id.'" class="btn btn-large btn-invert"><i class="btn-icon-only icon-ok"> View Review </i></a></td>
                    </tr>
                    
        
        ';
       /*<td class="td-actions"><a href="app.php?p&sendsample&formid='. $_3rdlineart_form_id.'" class="btn btn-large btn-invert"><i class="btn-icon-only icon-ok"> View Review </i></a></td>*/
    }


?>
 
                    
                 
         </tbody>
    </table>
    
</form>
</div>
