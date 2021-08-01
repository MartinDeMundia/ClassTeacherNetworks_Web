<?php
$edit_data		=	$this->db->get_where('school' , array('school_id' => $param2) )->result_array();
foreach ( $edit_data as $row):	
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_school');?>
            	</div>
            </div>
			<div class="panel-body">
                    <?php echo form_open(site_url('admin/school/do_update/'.$row['school_id']) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
                               
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="<?php echo $row['school_name'];?>" data-validate="required"/>
                                </div>
                            </div>
							
							<div class="form-group">
								<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('license_code');?></label>

								<div class="col-sm-5">
									<input type="text" class="form-control" name="license_code" data-validate="required" value="<?php echo $row['license_code'];?>">
								</div>
							</div>	
							 
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('activation_date');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="datepicker form-control" name="activation_date" value="<?php echo date('d/m/Y',strtotime($row['activation_date']));?>"/>
                                </div>
                            </div>
							
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('payment_date');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="datepicker form-control" name="payment_date" value="<?php echo date('d/m/Y',strtotime($row['payment_date']));?>"/>
                                </div>
                            </div>
							
							<div class="form-group">
								<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('amount');?></label>

								<div class="col-sm-5">
									<input type="number" class="form-control" name="amount" data-validate="required" value="<?php echo $row['amount'];?>">
								</div>
							</div>	
							
							<div class="form-group">
								<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('payment_by');?></label>

								<div class="col-sm-5">
									<input type="text" class="form-control" name="paid_by" data-validate="required" value="<?php echo $row['paid_by'];?>">
								</div>
							</div>
							
							<div class="form-group">
								<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('payment_method');?></label>

								<div class="col-sm-5">
									<input type="text" class="form-control" name="payment_method" data-validate="required" value="<?php echo $row['payment_method'];?>">
								</div>
							</div>
							
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('image');?></label>
                                <div class="col-sm-5">
                                    <input type="file" class="" name="file" id="imgInp" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <img id="blah" src="<?php echo $this->crud_model->get_image_url('school',$row['school_id']).'?'.time();?>" alt="school image" height="100" />
                                </div>
                            </div>
							
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('school_type');?></label>
                                <div class="col-sm-5">
                                    <select name="school_type" class="form-control selectboxit" onchange = "return val(this.value);">
										<option value="0">Select your school type</option>
                                    	<option value="1" <?php if($row['school_type'] == '1')echo 'selected';?>><?php echo get_phrase('Primary School');?></option>
                                    	<option value="2" <?php if($row['school_type'] == '2')echo 'selected';?>><?php echo get_phrase('Secondary School');?></option>
                                    </select>
                                </div>
                            </div>
							
							<div class="form-group" id = "extradiv" style ="display:none">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('primary_school_type');?></label>
                                <div class="col-sm-5">
                                    <select name="primary_school_type" class="uniform" style="width:100%;">
                                    	<option value="1" <?php if($row['primary_school_type'] == '1')echo 'selected';?>><?php echo get_phrase('Pre-primary / lower primary');?></option>
                                    	<option value="2" <?php if($row['primary_school_type'] == '2')echo 'selected';?>><?php echo get_phrase('Upper primary');?></option>
                                    </select>
                                </div>
							</div>
							
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('county');?></label>
                                <div class="col-sm-5">
                                    <select name="county" class="uniform" style="width:100%;">						    
                                    	<option value="0">Select County</option>
										<option value="Mombasa"><?php echo get_phrase('Mombasa');?></option>
                                    	<option value="Kwale"><?php echo get_phrase('Kwale');?></option>
                                    	<option value="Kilifi"><?php echo get_phrase('Kilifi');?></option>
                                    	<option value="Tana River"><?php echo get_phrase('Tana River');?></option>
                                    	<option value="Lamu"><?php echo get_phrase('Lamu');?></option>
                                    	<option value="Taita-Taveta"><?php echo get_phrase('Taita-Taveta');?></option>
                                    	<option value="Garissa"><?php echo get_phrase('Garissa');?></option>
                                    	<option value="Wajir"><?php echo get_phrase('Wajir');?></option>
                                    	<option value="Mandera"><?php echo get_phrase('Mandera');?></option>
                                    	<option value="Marsabit"><?php echo get_phrase('Marsabit');?></option>
                                    	<option value="Isiolo"><?php echo get_phrase('Isiolo');?></option>
                                    	<option value="Meru"><?php echo get_phrase('Meru');?></option>
                                    	<option value="Tharaka-Nithi"><?php echo get_phrase('Tharaka-Nithi');?></option>
                                    	<option value="Embu"><?php echo get_phrase('Embu');?></option>
                                    	<option value="Kitui"><?php echo get_phrase('Kitui');?></option>
                                    	<option value="Machakos"><?php echo get_phrase('Machakos');?></option>
                                    	<option value="Makueni"><?php echo get_phrase('Makueni');?></option>
                                    	<option value="Nyandarua"><?php echo get_phrase('Nyandarua');?></option>
                                    	<option value="Nyeri"><?php echo get_phrase('Nyeri');?></option>
                                    	<option value="Kirinyaga"><?php echo get_phrase('Kirinyaga');?></option>
                                    	<option value="Muranga"><?php echo get_phrase('Muranga');?></option>
                                    	<option value="Kiambu"><?php echo get_phrase('Kiambu');?></option>
                                    	<option value="Turkana"><?php echo get_phrase('Turkana');?></option>
                                    	<option value="West Pokot"><?php echo get_phrase('West Pokot');?></option>
										<option value="Samburu"><?php echo get_phrase('Samburu');?></option>
                                    	<option value="Trans Nzoia"><?php echo get_phrase('Trans Nzoia');?></option>
                                    	<option value="Uasin Gishu"><?php echo get_phrase('Uasin Gishu');?></option>
                                    	<option value="Elgeyo-Marakwet"><?php echo get_phrase('Elgeyo-Marakwet');?></option>
                                    	<option value="Nandi"><?php echo get_phrase('Nandi');?></option>
                                    	<option value="Baringo"><?php echo get_phrase('Baringo');?></option>
                                    	<option value="Laikipia"><?php echo get_phrase('Laikipia');?></option>
                                    	<option value="Nakuru"><?php echo get_phrase('Nakuru');?></option>
                                    	<option value="Narok"><?php echo get_phrase('Narok');?></option>
                                    	<option value="Kajiado"><?php echo get_phrase('Kajiado');?></option>
                                    	<option value="Kericho"><?php echo get_phrase('Kericho');?></option>
                                    	<option value="Bomet"><?php echo get_phrase('Bomet');?></option>
                                    	<option value="Kakamega"><?php echo get_phrase('Kakamega');?></option>
                                    	<option value="Vihiga"><?php echo get_phrase('Vihiga');?></option>
                                    	<option value="Bungoma"><?php echo get_phrase('Bungoma');?></option>
                                    	<option value="Busia"><?php echo get_phrase('Busia');?></option>
                                    	<option value="Siaya"><?php echo get_phrase('Siaya');?></option>
                                    	<option value="Kisumu"><?php echo get_phrase('Kisumu');?></option>
                                    	<option value="Homa Bay"><?php echo get_phrase('Homa Bay');?></option>
                                    	<option value="Migori"><?php echo get_phrase('Migori');?></option>
                                    	<option value="Kisii"><?php echo get_phrase('Kisii');?></option>
                                    	<option value="Nyamira"><?php echo get_phrase('Nyamira');?></option>    
                                    	<option value="Nairobi"><?php echo get_phrase('Nairobi');?></option>    
                                    </select>
                                </div>
							</div>
							
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
                                <div class="col-sm-5">
                                    <select name="status" class="form-control selectboxit">
                                    	<option value="1" <?php if($row['status'] == '1')echo 'selected';?>><?php echo get_phrase('active');?></option>
                                    	<option value="2" <?php if($row['status'] == '2')echo 'selected';?>><?php echo get_phrase('suspend');?></option>
                                    </select>
                                </div>
                            </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_school');?></button>
                            </div>
                        </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>
<script>
function val(x)
{
    if (x =="1" )
    {
            document.getElementById("extradiv").style.display ="block";
    }else
    {
            document.getElementById("extradiv").style.display = "none";
    }
}
</script>





