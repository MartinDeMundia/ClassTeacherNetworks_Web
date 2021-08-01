<style>
  .exam_chart {
    width       : 100%;
    height      : 265px;
    font-size   : 11px;
  }
</style>

<?php
  $principal_info = $this->db->get_where('principal', array('principal_id' => $principal_id))->result_array();
  foreach ($principal_info as $row):   
  $subject_info = $this->db->get_where('subject', array('principal_id' => $principal_id, 'year' => $running_year))->result_array();
	 
?>
<div class="profile-env">
	<header class="row">
		<div class="col-md-3">
			<center>
        <a href="#">
  				<img src="<?php echo $this->crud_model->get_image_url('principal', $principal_id) ;?>" class="img-circle"
          style="width: 60%;" />
  			</a>
        <br>
        <h3>
          <?php echo $row['name']; ?>
        </h3>
         
      </center>
		</div>
    <div class="col-md-9">

		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab" class="btn btn-default">
					<span class="visible-xs"><i class="entypo-home"></i></span>
					<span class="hidden-xs"><?php echo get_phrase('streams'); ?></span>
				</a>
			</li>			 			
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="tab1">        
				<table class="table table-bordered" style="margin-top: 20px;">
				  <thead>
					<tr>
					  <td>Stream</td>
					  <td>Class</td>
					  <td>Subject</td>
					</tr>
				  </thead>
				  <tbody>
				  <?php 
				    foreach ($subject_info as $srow) { 
					   $class = $this->crud_model->get_type_name_by_id('class',$srow['class_id']); 
					   $section = $this->crud_model->get_type_name_by_id('section',$srow['section_id']);
					?>
					<tr>			
					  <td><?php echo $class; ?></td>
					  <td><?php echo $section; ?></td>
					  <td><?php echo $srow['name']; ?></td>
					</tr>
				  <?php } ?>
				  </tbody>
				</table>
			</div>			 
		</div>		 

	</div>
	</header>
</div>
<?php endforeach; ?>
