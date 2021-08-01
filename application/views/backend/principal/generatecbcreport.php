<style>
.dcolumn{
	float:left;
	margin-left:1%;
	border: 0.3px solid black;
	text-align: center;
}
.dcolumnh{
	float:left;
	margin-left:1%;
	margin-right:1px;	
}
.dbox{
	width:30px;
	height:30px;
	text-align: center;
	padding:0px;
	margin:0px;
}
.drow{
	float:left;
	margin-left:1%;
}
.hinputs{
	width:310px !important;
	margin-left:-150px !important;
	margin-bottom:140px !important;
}
th.rotate {
  /* Something you can count on */
  height: 20px;
  white-space: nowrap;
}

th.rotate > div {
  transform: 
    /* Magic Numbers */
    translate(0px,0px)
    /* 45 is really 360 - 45 */
    rotate(270deg);
  width: 20px;
}
th.rotate > div > span {
  border-bottom: 1px solid #ccc;
 /* padding: 5px 10px;*/
}

</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">          


            <div class="panel-body">
                <form method="POST" enctype="multipart/form-data" class="form-inline" role="form" id="ef">

                        <div class="form-group" style="margin-bottom: 15px;">
                            <select id="class_id" name="class_id" class="form-control" onchange="get_class_section(this.value)">
                                <option value="">Stream</option>
                                <?php
                                $classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                                 echo '<option selected value="'.$db_section_id.'">'.$section_name.'</option>';
                                foreach($classes as $row):
                                    ?>
                                    <option value="<?php echo $row['class_id'];?>"
                                        <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

						<?php
						$cls = ($db_section_id) ? $db_section_id : $class_id;
              function getcbcentry($studid,$term,$year,$cbcid,$conn){
                  return  $conn->get_where('cbc_student' , array('studid'=>$studid,'year' => $year ,'term'=>urldecode($term),'cbcdataid'=>$cbcid))->row()->val;
              }					
						?>


                        <div class="form-group" style="margin-bottom: 15px;">
                                <select name="section_id" id="section_holder" onchange="get_class_subject(this.value)" class="form-control">
                                    <?php                                    
                                    $sections = $this->db->get_where('section' , array(
                                        'class_id' => $cls
                                    ))->result_array();                                   
                                    echo '<option value="'.$db_class_id.'">'.$class_name.'</option>';
									 foreach($sections as $row){
                                      echo '<option value="'.$row['section_id'].'">'.$row['name'].'</option>';
									 }
                                   ?>                               
                                </select>
                        </div>



                        <div class="form-group" style="margin-bottom: 15px;">
                                <select name="topic_id" id="topic_id" class="form-control">
                                    <?php   

                                       $sqldata = "
                                             SELECT * FROM cbc_report_design WHERE (parent is NULL || parent = 0 ) AND class = ".$class_id." ORDER BY sort ASC 
                                            ";
                                       $queryData = $this->db->query($sqldata)->result_array();
                                           if($topic_id > 0){
                                             echo '<option value="'.$topic_id.'" selected>'.$topic_number." ".$topic_name.'</option>';                                             
                                           }else{
                                             echo '<option value="0" selected>Select to filter main topic</option>';                                           
                                           } 
                                             echo '<option value="0">All</option>';                                      
                                        foreach($queryData as $row){
                                        echo '<option value="'.$row['id'].'">'.$row['topic_number']." ".$row['topic_title'].'</option>';
                                     }
                                   ?>                               
                                </select>
                        </div>






					<?php  
					    $yr = date('Y');
					?>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <select placeholder="Select Year..." class="form-control"  id="year" ><option value="">Select Year...</option>
                            <option selected value="<?=$yr?>"><?=$yr?></option>
                            <?php
                            for ($i=0; $i<=3;$i++){
                                ?>
                                <option value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <select placeholder="Select Term..." class=" form-control"  id="term">
                                        <?php
                                        if($term){
                                             echo '<option value="'.urldecode($term).'" selected>'.urldecode($term).'</option>';                                             
                                           }else{
                                             echo '<option value="0">Select Term...</option>';                                           
                                           } 
                                        ?>                            
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                        </select> 
                    </div>





                    <div class="form-group" style="margin-bottom: 15px;display:none;">

                        <div id="lim">

                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;display:none;">

                        <div class="col "><input placeholder="enter limit..." class="form-control" type="text" id="limit" /></div>
                    </div>

                    <div class="form-group " style="margin-bottom: 15px;display:none;">

                        <div class="col "><input placeholder="enter subject entry..." class="form-control hidden" type="text" id="entry" /></div>
                    </div>


                    <div class="form-group" style="margin-bottom: 15px;display:none;">
                        <input placeholder="enter out of..." class="form-control" type="text" id="outof"/>
                    </div>


                    <div class="form-group" style="margin-bottom: 15px;">

                    </div>


                </form>


			  <div id="alert" class="alert alert-danger" style="display:none;" >Please select  Stream , term , subject and exam</div> 


                <div class="row">
                    <div class="col-md-12">

                        <ul class="nav nav-tabs bordered">
                            <li class="active">
                                <a href="#home" data-toggle="tab">
                                    <span class="visible-xs"><i class="entypo-users"></i></span>
                                    <span class="hidden-xs"><?php echo get_phrase('all_students');?></span>
                                </a>
                            </li>


                            <li class="">
                                <a href="#test" data-toggle="tab">
                                    <span class="visible-xs"><i class="entypo-users"></i></span>
                                    <span class="hidden-xs"></span>
                                </a>
                            </li>
                        </ul>


                        <div class="tab-content">
                            <div class="tab-pane active" id="home">

                                <table class="table table-bordered datatable" id="table_export" data-page-length='150'>
                                    <thead>
                                    <tr>

                                        <th width="30" style=""><div>ID</div></th>
                                        <th width="120"><div style="width:70px !important">Adm. No</div></th>
                                        <th style="width:150px !important"><div style="width:150px !important"><?php echo get_phrase('name');?></div></th>
                                        <th><div><?php echo get_phrase('class');?></div></th>


                  											<?php
                  											//$class_id = 2;
                                            if($topic_id>0){
                                                 $sqldata = "
                                                     SELECT * FROM cbc_report_design WHERE (parent is NULL || parent = 0 ) AND class = ".$class_id." AND id = '".$topic_id."' ORDER BY sort ASC 
                                                    ";
                                                }else{
                                                      $sqldata = "
                                                         SELECT * FROM cbc_report_design WHERE (parent is NULL || parent = 0 ) AND class = ".$class_id." ORDER BY sort ASC 
                                                        ";   
                                                }
		
											   $queryData = $this->db->query($sqldata)->result_array();
											   foreach ($queryData as $key => $dbvalue){

														$number = ($dbvalue["topic_number"])?$dbvalue["topic_number"]:"&nbsp;";
														echo '<th class="rotate"><div>
                            <span><i class="entypo-book-open"></i>'.$number." ".$dbvalue["topic_title"].'</span></div>
                            </th>';
																			
														   $sqlcbchild1 = "
																 SELECT * FROM cbc_report_design WHERE parent = '".$dbvalue["id"]."' ORDER BY sort ASC
																";
											               $queryData1 = $this->db->query($sqlcbchild1)->result_array();
														   foreach ($queryData1 as $key => $dbvalue1){
															   $number1 = ($dbvalue1["topic_number"])?$dbvalue1["topic_number"]:"&nbsp;";
											                   echo '<th class="rotate" style="font-size:12px;background:#7e9bd0;color:white;"><div><span><i class="entypo-cog"></i>'.$number1." ".$dbvalue1["topic_title"].'</span></div>
                                         <input onchange="savemenudata(this.value,'.$dbvalue1["id"].')" style="margin-top:2px;text-align:center;color:black;font-size:12px !important;width:20px;height:20px;" type="text" value=""></input>
                                         </th>';

															   $sqlcbchild2 = "
																	 SELECT * FROM cbc_report_design WHERE parent = '".$dbvalue1["id"]."' ORDER BY sort ASC
																	";
																   $queryData2 = $this->db->query($sqlcbchild2)->result_array();
											                        $subtasks3 = array();
																	foreach ($queryData2 as $key => $dbvalue2){
																			$number2 = ($dbvalue2["topic_number"])?$dbvalue2["topic_number"]:"&nbsp;";
											                     echo '<th class="rotate" style="height:350px;font-size:10px;background:#8cb1f5;color:white;"><div><span><i class="entypo-dot"></i>'.$number2." ".$dbvalue2["topic_title"].'</span></div>
                                           <input onchange="savemenudata(this.value,'.$dbvalue2["id"].')" style="margin-top:2px;text-align:center;color:black;font-size:12px !important;width:20px;height:20px;" type="text" value=""></input>
                                           </th>';
																	}


														   }
											   }
											?>

                                        <th><div><?php echo get_phrase('options');?></div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php


                                      $dbQry = "SELECT * FROM enroll e 
                                       JOIN student s ON s.student_id = e.student_id 
                                       WHERE  s.school_id = '".$this->session->userdata("school_id")."'  ";

                                    if($db_class_id > 0 ) $dbQry .= ' AND e.section_id =  "'.$db_class_id .'" ';
                  									if($db_section_id > 0 ) $dbQry .= ' AND e.class_id =  "'.$db_section_id .'" ';

                  									if( $db_class_id <= 0 && $db_section_id <= 0){
                  										$dbQry .= ' LIMIT 0,10';
                  									}									

                                    $students   = $this->db->query($dbQry)->result_array();
                                       foreach($students as $row):?>
                                        <tr>
                                            <td style="" ><?php  echo $row['student_id']; ?></td>                                           

                                            <td style="width:100px !important"><?php echo $this->db->get_where('student' , array(
                                                    'student_id' => $row['student_id']
                                                ))->row()->student_code;?></td>
                                            <td style="width:150px !important" >
                                                <?php
                                                echo $this->db->get_where('student' , array(
                                                    'student_id' => $row['student_id']
                                                ))->row()->name;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $this->db->get_where('section' , array(
                                                    'section_id' => $row['section_id']
                                                ))->row()->name;
                                                ?>
                                            </td>
                                  


										<?php
                                            if($topic_id>0){
                                               $sqldata = "
                                                 SELECT * FROM cbc_report_design WHERE (parent is NULL || parent = 0 ) AND class = ".$class_id." AND id = '".$topic_id."' ORDER BY sort ASC 
                                                ";
                                            }else{

                                               $sqldata = "
                                                 SELECT * FROM cbc_report_design WHERE (parent is NULL || parent = 0 ) AND class = ".$class_id." ORDER BY sort ASC 
                                                ";
                                            }
										   $queryData = $this->db->query($sqldata)->result_array();
										   foreach ($queryData as $key => $dbvalue){		
										            echo '<td style="text-align:center"> </td>';
													   $sqlcbchild1 = "
															 SELECT * FROM cbc_report_design WHERE parent = '".$dbvalue["id"]."' ORDER BY sort ASC
															";
										               $queryData1 = $this->db->query($sqlcbchild1)->result_array();
													   foreach ($queryData1 as $key => $dbvalue1){
													   	echo '<td style="text-align:center"><input onchange="savestudata(this.value,'.$row['student_id'].','.$dbvalue1["id"].')" class="dbox" type="number" value="'.getcbcentry($row['student_id'],$term,$year,$dbvalue1["id"],$this->db).'"></input> </td>';			   
														   $sqlcbchild2 = "
																 SELECT * FROM cbc_report_design WHERE parent = '".$dbvalue1["id"]."' ORDER BY sort ASC
																";
															   $queryData2 = $this->db->query($sqlcbchild2)->result_array();
										                        $subtasks3 = array();
																foreach ($queryData2 as $key => $dbvalue2){
											                        echo '<td style="text-align:center"><input onchange="savestudata(this.value,'.$row['student_id'].','.$dbvalue2["id"].')" class="dbox" type="number" value="'.getcbcentry($row['student_id'],$term,$year,$dbvalue2["id"],$this->db).'"></input> </td>';
															}


													   }
										     }
										  ?>



                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" onclick="getCbcReport('<?=$row['student_id']?>')">
                                                        <span class="entypo-book"></span> Get CBC Report 
                                                    </button>                                                  
                                                </div>

                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>

                            </div>


                            <div class="tab-pane" id="test">

                            </div>

                        </div>
                    </div>
                </div>

                <!--<a href="#" onClick="performMarkSave()"
                   class="btn btn-primary pull-right">
                    <i class="entypo-plus-circled"></i>
                    Save Students Marks</a>-->

            </div>
        </div></div></div>

<!-- FILTER DATA -->

<script src="<?php echo base_url();?>js/plugins/dropzone/dropzone.js"></script>
<script>
 $(document).ready(function () {   });

   function loadGrid(term,fr,st,year,topic_id){       

         $("#table_export").dataTable().fnDestroy();
          dataTable=$('#table_export').DataTable( {
                bRetrieve:true,
                bDestroy: true,
                destroy: true,
                processing: true,
                serverSide: true,
                fixedColumns    : true,
                stateSave: false
                 
                ,autoWidth  : false
                ,responsive : true
                ,deferRender    : true
                ,processing : true
                ,paging     : false
                ,pageLength : parseInt(150)
                ,searching  : false
                ,info       : false
                ,ordering       : false
                ,dom            : "<ipf>"
                ,bPaginate  : false
                ,sDom       :"fptip"
            });               

            dataTable.fnClearTable();       
            dataTable.paging = false;
            dataTable.fnDraw();

            postVrs = {
                "term":term,
                "fr":fr,
                "st":st,
                "year":year,
                "topic_id":topic_id
            }
            $.post("/admin/cbc_manage_saved",postVrs,function(respData){

                $.each(respData.content, function(i, item) {

                    btns = '<td>';
                    btns += '<div class="btn-group">';
                    btns += '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" onclick="getCbcReport('+item.student_id+')" >';
                    btns += '<span class="entypo-book"></span> Get CBC Report ';
                    btns += '</button>';
                    btns += '</div>';
                    btns += '</td>';


                    cbcdata = item.cbcdetails; 
                    
                    

                   var data = [
                            '<td style="">'+item.student_id+'</td>',                           
                            "<td width='100'>"+item.admno+"</td>",
                            "<td>"+item.student+"</td>",
                            "<td>"+item.section+"</td>"                          
                             
                        ];
                    if(cbcdata.length >0){                    	
                    	$.each(cbcdata, function(i, cbcrecord) { 
                           data.push(cbcrecord);
                    	
                    	});

                    }
                    data.push(btns);
                    dataTable.fnAddData(data);                 
                }); 
            },"json");

                   

        }





    
        $('#class_id').on('change', function(){
            loadGrid( $('#term').val(),$('#class_id').val(),$('#section_holder').val(),$('#year').val(),$('#topic_id').val());
        });
        $('#year').on('change', function(){
            loadGrid( $('#term').val(),$('#class_id').val(),$('#section_holder').val(),$('#year').val(),$('#topic_id').val());
        });
        $('#term').on('change', function(){
            loadGrid( $('#term').val(),$('#class_id').val(),$('#section_holder').val(),$('#year').val(),$('#topic_id').val());
        });

        $('#section_holder').on('change', function(){ 
        	window.location.href = "/admin/generatecbcreport/"+ Number($('#section_holder').val()) +"/"+$('#class_id').val()+"/"+$('#year').val() +"/"+$('#term').val() +"/"+$('#topic_id').val();
        });

        $('#topic_id').on('change', function(){ 
            window.location.href = "/admin/generatecbcreport/"+ Number($('#section_holder').val()) +"/"+$('#class_id').val()+"/"+$('#year').val() +"/"+$('#term').val() +"/"+$('#topic_id').val();
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
 


    function get_class_section(class_id) {
        jQuery('#subject_holder').html("<option value=''>select section first</option>");
        if (class_id !== '') {
            $.ajax({
                url: '<?php echo site_url('admin/get_class_section/');?>' + class_id,
                success: function(response)
                {
                    jQuery('#section_holder').html(response);
                }
            });
        }
        else{
            $('#submit').attr('disabled', 'disabled');
        }
    }

    function get_class_subject(section_id) {

        var class_id =  jQuery('#class_id').val();
        if (class_id !== '' && section_id !='') {
            $.ajax({
                url: '<?php echo site_url('admin/get_class_subject/');?>' + class_id + '/'+ section_id ,
                success: function(response)
                {
                    jQuery('#subject_holder').html(response);
                }
            });
            $('#submit').removeAttr('disabled');
        }
        else{
            $('#submit').attr('disabled', 'disabled');
        }
    }

    function savestudata(val,studid,cbcdataid){
      postvars = {
        "val":val,
        "studid":studid,
        "cbcdataid":cbcdataid,
        "term":$('#term').val(),
        "year":$('#year').val()
      }
      $.post("/admin/cbcsave",postvars,function(data){

      },"json");
    }
    function savemenudata(val,cbcdataid){
       postvars = {
        "val":val,       
        "cbcdataid":cbcdataid,
        "term":$('#term').val(),
        "year":$('#year').val(),
        "db_class_id":"<?=$db_class_id?>",
        "db_section_id":"<?=$db_section_id?>"
      }
      $.post("/admin/cbcsavemain",postvars,function(data){        
         loadGrid($('#term').val(),$('#class_id').val(),$('#section_holder').val(),$('#year').val(),$('#topic_id').val());
      },"json");

    }

    function getCbcReport(studid){
      url = '<?php echo base_url();?>modal/popup/cbcreport/'+studid+'/'+$('#term').val()+'/'+$('#year').val()+'/<?=$class_id?>';
                window.open(url,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width="900",height=700');        
    }

    $(document).ready(function() {



        $("#single").click(function() {

            if ($("#s9ingle").prop('checked')==true){
                //alert($("#s9ingle").prop('checked'));
                $("#paper").addClass('hidden');
            }else{
                $("#paper").removeClass('hidden');
                //alert($("#s9ingle").prop('checked'));


            }


        });

        $("#upload").click(function() {

            if ($("#up").prop('checked')==true){
                //alert($("#s9ingle").prop('checked'));
                $("#updiv").removeClass('hidden');
                $("#return").addClass('hidden');
            }else{
                $("#updiv").addClass('hidden');
                $("#return").removeClass('hidden');
                //alert($("#s9ingle").prop('checked'));


            }


        });


        $(".i-checks").iCheck(function(){
            //alert("");


        });
 


        $('body').on('keypress', '.marks',function(e){

            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {



                var no_error=true;

                var marks=parseInt($(this).val());
                var outof=$("#outof").val();
                var limit=$("#limit").val();
                var subject=$("#subject").val();
                var single=$("#s9ingle").prop('checked');
                var paper=$("#paper").val();
                var admno=$(this).attr('id');
                var form=$("#fr").val();
                var stream=$("#st").val();
                var year=$("#year").val();
                var term=$("#term").val();
                var exam=$("#examtype").val();
                var dataString = 'marks=' + marks + '&outof=' + outof + '&limit=' + limit + '&single=' + single + '&subject=' + subject + '&paper=' + paper + '&admno=' + admno + '&form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam;

                if (subject ==0 ){


                    swal({
                        title:"ERROR!",
                        text: "Invalid subject",
                        type: "warning"
                    });
                    no_error=false;
                }
                //alert ((single==="true"));
                if ($("#s9ingle").prop('checked')==true){





                }else{

                    if(paper=="" || paper<1 || paper>4){
                        swal({
                            title:"ERROR!",
                            text: "Invalid paper",
                            type: "warning"
                        });
                        no_error=false;
                    }else{


                        no_error=true;
                    }

                }

                if (marks > outof){
                    swal({
                        title:"ERROR!",
                        text: marks + "  Score can't be greater than out of  " + outof,
                        type: "warning"
                    });

                    no_error=false;
                }
                if (outof <=0 ){


                    swal({
                        title:"ERROR!",
                        text: "Invalid outof",
                        type: "warning"
                    });
                    no_error=false;
                }
                if (limit <=0 ){

                    swal({
                        title:"ERROR!",
                        text: "Invalid Limit",
                        type: "warning"
                    });
                    no_error=false;
                }
                if (marks <=0 ){

                    swal({
                        title:"ERROR!",
                        text: "Invalid Score",
                        type: "warning"
                    });
                    no_error=false;
                }

                if (outof>100){

                    swal({
                        title:"ERROR!",
                        text: "Invalid Out of",
                        type: "warning"
                    });
                    no_error=false;
                }
                if (no_error){

                    $.ajax({
                        type:'POST',
                        url:'<?php echo base_url();?>support/save.php',
                        data:dataString,
                        cache:false,
                        success:function(result){
                            //$("#paper").val('');
                            if (result>=1){
                                $("#errorv").html("");
                                /////$("#save" + admno).addRemove('fa fa-close');
                                $("#save" + admno).addClass('fa fa-check');
                                $("#save" + admno).attr("style","color:green;");
                            }else{
                                //$("#save" + admno).addRemove('fa fa-check');
                                $("#save" + admno).addClass('fa fa-close');
                                $("#save" + admno).attr("style","color:red;");
                            }
                            //$("#error_div").slideDown('slow');
                            //$("#errorv").html(result);
                        }

                    });

                    $("input")[ $("input").index(this)+1].focus();

                }else{

                }


            }else{
            }
        });

        $('#updata').click(function(){
            var no_error=true;

            var id2=parseInt($("#examst").val());
            //var marks=parseInt($(this).val());
            var outof=$("#outof").val();
            var limit=$("#limit").val();
            //var subject=$("#subject").val();
            var single=$("#s9ingle").prop('checked');
            var paper=$("#paper").val();
            //var admno=$(this).attr('id');
            var form=$("#fr").val();
            var stream=$("#st").val();
            var year=$("#year").val();
            var term=$("#term").val();
            var exam=$("#examtype").val();
            var dataString = 'outof=' + outof + '&limit=' + limit + '&single=' + single  + '&paper=' + paper  + '&form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam;
            //alert ((single==="true"));
            if ($("#s9ingle").prop('checked')==true){





            }else{

                if(paper=="" || paper<1 || paper>4){
                    swal({
                        title:"ERROR!",
                        text: "Invalid paper",
                        type: "warning"
                    });
                    no_error=false;
                }else{


                    no_error=true;
                }

            }


            if (outof <=0 ){


                swal({
                    title:"ERROR!",
                    text: "Invalid outof",
                    type: "warning"
                });
                no_error=false;
            }
            if (limit <=0 ){

                swal({
                    title:"ERROR!",
                    text: "Invalid Limit",
                    type: "warning"
                });
                no_error=false;
            }


            if (outof>100){

                swal({
                    title:"ERROR!",
                    text: "Invalid Out of",
                    type: "warning"
                });
                no_error=false;
            }
            if (no_error){

                if(id2>=0 && parseInt($("#entry").val())>0){
                    $("#gif").removeClass('hidden');

                    alert($("#drop").val());


                    $.ajax({
                        type:'POST',
                        url:'<?php echo base_url();?>support/excel.php',
                        data:dataString,
                        cache:false,
                        success:function(result){
                            $("#gif").addClass('hidden');
                            if (result>=1){
                                swal({
                                    title:"SUCCESS!",
                                    text: "",
                                    type: "success"
                                });
                                $("#errorv").html("");
                                $("#save" + admno).addClass('ti-check');
                                $("#save" + admno).attr("style","color:green;");
                            }else{

                                $("#save" + admno).addClass('ti-close');
                                $("#save" + admno).attr("style","color:red;");
                            }
                            //$("#error_div").slideDown('slow');
                            //$("#errorv").html(result);
                        }

                    });
                }else{
                    $("#subject1").addClass("hidden");
                    swal({
                        title: 'Select a valid exam and entry level',
                        text: '',
                        type: 'warning'
                    });
                }


            }else{

            }


        });
    });

</script>





