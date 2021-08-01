<table class="table table-responsive" border=0>
							<tt> Exams to include in main exam <font color="red" >hold (Ctrl) to select multiple</font></tt>
							<tr><td> <label>Exams:</label>
        <select class="form-control chosen-select include" multiple="multiple" size="5">
							<?php
							foreach($exam_name as $row):
							
							?>
							
            <option><?php echo $row['exam']; ?></option>
            
       
        
							<?php
							
							endforeach;
							
							?>
							 </select></td>
							</tr>
							
							
							</table>