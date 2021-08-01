<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-folder"></i>
					Upload excel sheet of marks entered or ( <a class=" " href="<?php echo base_url();?>admin/defaultexamexcal/<?php echo $stream; ?>/<?php echo $term; ?>/<?php echo $subject; ?>/<?php echo $exam; ?>" download="data sample file">Click here to download an empty excel sheet</a> )
            	</div>
            </div>
			<div class="panel-body">		
           
            <div class="padded">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Drop your file</label>
                    <div class="col-sm-5">
                       <div action="" class="dropzone needsclick dz-clickable" id="exam-upload" style="background: #44686a;color: white;font-weight: bold;font-size: 12px;">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div class="dz-message needsclick">
                                <p>Upload
                                </p>
                                <span class="note needsclick">Drop your filled in Exam Excel</span>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/dropzone/dropzone.js');?>"></script>
 <script>
    $(document).ready(function () {

    $("#exam-upload").dropzone(
        {
            paramName: "userfile",
            url: "<?php echo base_url();?>admin/uploadexam",
            init : function() {
                this.on("success", function (file, response) {

                  var myObj = JSON.parse(response);

                  //myexcelfile = myObj.response;
                  //farray = myexcelfile.split('apps.classteacher.school');
                  //fullurl = "http://apps.classteacher.school/"+farray[1];  


                       var dataString = 'fpath=' + myObj.response;
                                $.ajax({
                                    type:'POST',
                                    url:'<?php echo base_url();?>admin/readuploadedexcel',
                                    data:dataString,
                                    cache:false,
                                    success:function(result){

                                       swal({
                                            title:"Info",
                                            text: "Uploaded Exam!",
                                            type: "success"
                                        });

                                       
                                    }
                                    
                                });        


/*
            var counter = 0;
            var i = setInterval(function(){
                // do your thing

                $.ajax({
                    url:fullurl,
                    type:'HEAD',
                    error: function()
                    {
                       alert("doesnot exist");
                    },
                    success: function()
                    {
                       counter = 10; 

                       var dataString = 'fpath=' + myObj.response;
                                $.ajax({
                                    type:'POST',
                                    url:'<?php echo base_url();?>admin/readuploadedexcel',
                                    data:dataString,
                                    cache:false,
                                    success:function(result){

                                       swal({
                                            title:"Info",
                                            text: "Uploaded Exam!",
                                            type: "success"
                                        });

                                       
                                    }
                                    
                                });


                        alert("exist");
                    }
                });



                counter++;
                if(counter === 10) {
                    clearInterval(i);
                }
            },30);*/





/*                  var dataString = 'fpath=' + myObj.response;
                                $.ajax({
                                    type:'POST',
                                    url:'<?php echo base_url();?>admin/readuploadedexcel',
                                    data:dataString,
                                    cache:false,
                                    success:function(result){

                                       swal({
                                            title:"Info",
                                            text: "Uploaded Exam!",
                                            type: "success"
                                        });

                                       
                                    }
                                    
                                });
               */

                });
                this.on("addedfile", function(file) {
                });
                this.on("sending", function(file, xhr, formData) {                  
                });
            }
        }
    );

    });
</script>




