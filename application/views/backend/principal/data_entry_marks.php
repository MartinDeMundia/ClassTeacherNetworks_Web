<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('fill_in_marks');?>
                </div>
            </div>

             <div class="row" style="float:right;width:350px !important;margin-top: 15px;">


              <div class="col-sm-6">
                                <a href="#" style="margin:1px;" onClick="performMarkSave()"
                                   class="btn btn-primary pull-right">
                                    <i class="entypo-plus-circled"></i>
                                    Save Students Marks</a>
                                </div>
             <div class="col-sm-6">

                               <a href="#" style="margin:1px;" onClick="doUploads()"
                                   class="btn btn-primary pull-right">
                                    <i class="entypo-folder"></i>
                                    Upload Student Marks</a>

                                </div>

            </div>


            <div class="panel-body">


                <form method="POST" enctype="multipart/form-data" class="form-inline" role="form" id="ef">



                        <div class="form-group" style="margin-bottom: 15px;">
                            <select id="class_id" name="class_id" class="form-control" onchange="get_class_section(this.value)">
                                <option value="">Stream</option>
                                <?php
                                $classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                                foreach($classes as $row):
                                    ?>
                                    <option value="<?php echo $row['class_id'];?>"
                                        <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>




                        <div class="form-group" style="margin-bottom: 15px;">
                                <select name="section_id" id="section_holder" onchange="get_class_subject(this.value)" class="form-control">
                                    <?php
                                    $sections = $this->db->get_where('section' , array(
                                        'class_id' => $class_id
                                    ))->result_array();
                                    foreach($sections as $row):
                                        ?>
                                        <option value="<?php echo $row['section_id'];?>"
                                            <?php if($section_id == $row['section_id']) echo 'selected';?>>
                                            <?php echo $row['name'];?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </div>




<!--                    <div class="form-group" style="margin-bottom: 15px;">

                        <select placeholder="Select Stream..." class="form-control"  id="fr" ><option value="">Select class...</option>
                            <?php
/*                            $q="SELECT * from class where school_id='".$this->session->userdata('school_id')."' and name <> ''";
                            $r=$this->db->query($q)->result_array();;
                            foreach ($r as $row) :
                                */?>
                                <option value="<?php /*echo $row['class_id']; */?>"><?php /*echo $row['name']; */?></option>
                            <?php
/*                            endforeach;
                            */?>
                        </select>
                    </div>-->

                    <div class="form-group" style="margin-bottom: 15px;">
                        <select placeholder="Select Year..." class="form-control"  id="year" ><option value="">Select Year...</option>
                            <option selected value="2019">2019</option>
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
                            <option value="">Select Term...</option>
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                        </select> 
                    </div>



                    <div id="subject1" class="form-group" style="margin-bottom: 15px;">

                        <select name="subject_id" id="subject_holder" class="form-control">
                            <?php

                            $user_id = $this->session->userdata('login_user_id');
                            $role = $this->session->userdata('login_type');
                          /*
                            if($role =='teacher')
                                $subjects = $this->db->get_where('subject' , array('teacher_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id ))->result_array();
                            else
                                $subjects = $this->db->get_where('subject' , array(
                                    'class_id' => $class_id , 'section_id' => $section_id ,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
                                ))->result_array();
                            */

                            $query_subj = $this->db->query("                                    
                                        SELECT s.* 
                                        FROM class_subjects  cs
                                        JOIN subject s ON s.name = cs.subject  AND s.class_id = '".$class_id."' AND s.section_id = '".$section_id."'
                                        AND cs.is_elective <> 2 AND cs.school_id = '".$this->session->userdata('school_id')."' ORDER BY s.name ASC

                                    "); 

                           $subjects = $query_subj->result_array();

                            foreach($subjects as $row):
                                ?>
                                <option value="<?php echo $row['name'];?>"
                                    <?php if($subject_id == $row['subject_id']) echo 'selected';?>>
                                    <?php echo $row['name'];?>
                                </option>
                            <?php endforeach;?>
                        </select>

<!--                        <select placeholder="Select Subject..." class="form-control"  id="subject" ><option value="">Select Subject...</option>
                            <?php
/*
                            $q="SELECT id,subject FROM class_subjects WHERE school_id='".$this->session->userdata('school_id')."' ";
                            $r=$this->db->query($q)->result_array();;
                            foreach($r as $row) :
                                */?>

                                <option value="<?php /*echo $row['subject']; */?>"><?php /*echo $row['subject']; */?></option>
                            <?php
/*                            endforeach;
                            */?>
                        </select> -->
                    </div>


                    <div class="form-group  " style="margin-bottom: 15px;">
                        <select placeholder="Select exam..." class="form-control"  id="examtype" ><option value="">Select Exam...</option>
                            <?php


                            $q="SELECT term1 FROM exams WHERE school_id='".$this->session->userdata('school_id')."'";
                            $r=$this->db->query($q)->result_array();;
                            foreach ($r as $row) :
                            ?>

                            <option id="<?php echo $row['term1']; ?>" value="<?php echo $row['term1']; ?>"><?php echo $row['term1']; ?>
                                <?php
                                endforeach;

                                ?>
                            </option>

                        </select> </div>



<!--
                   <div class="form-group " style="margin-bottom: 15px;">

                        <select placeholder="Select Stream..." class="form-control"  id="st" ><option value="">Select Stream...</option>
                            <?php
/*                                                $q="SELECT * from section WHERE teacher_id ='".$this->session->userdata('login_user_id')."'";

                                                $r=$this->db->query($q)->result_array();;
                                                foreach ($r as $row) :
                                                    */?>
                                <option value="<?php /*echo $row['section_id']; */?>"><?php /*echo $row['name']; */?></option>
                            <?php
/*                                                endforeach;
                                                */?>
                        </select>
                    </div>
-->

                   <!-- <div class="form-group " style="margin-bottom: 15px;">

                        <select placeholder="Select Stream..." class="form-control"  id="st" ><option value="">Select Stream...</option>
                            <?php
/*                            $q="SELECT * from streams where school_id='".$this->session->userdata('school_id')."'  and name <> ''";
                            $r=$this->db->query($q)->result_array();;
                            foreach ($r as $row) :
                                */?>
                                <option value="<?php /*echo $row['Id']; */?>"><?php /*echo $row['Name']; */?></option>
                            <?php
/*                            endforeach;
                            */?>
                        </select>
                    </div>-->


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



                    <!--                    <div class="form-group " style="margin-bottom: 15px;">

                                            <div class="i-checks" id="sp"><label id="single"> <div style="position: relative;" class="icheckbox_square-green"><input checked="" style="position: absolute; opacity: 0;" id="s9ingle" value="" type="checkbox"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> Single subject </label></div>
                                        </div>
                                        <div class="form-group "  style="margin-bottom: 15px;">
                                            <div class="col col-sm-7 "><input placeholder="enter paper eg 1" class="form-control hidden" type="text" id="paper" style="display:;">
                                                <p id="error" style="color:red;display:none;"> Invalid Paper </p>
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-bottom: 15px;">

                                            <button type="button" class="btn btn-primary btn-lg btn-block hidden" id="activate" value="SEARCH" style="display:;">ACTIVATE</button>
                                        </div>-->
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

                                        <th width="30"><div>ID</div></th>
                                        <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                                        <th width="100"><div><?php echo get_phrase('admission_no.');?></div></th>
                                        <th><div><?php echo get_phrase('name');?></div></th>
                                        <th><div><?php echo get_phrase('class');?></div></th>
                                        <th width="" style="width:200px;"><div>Marks</div></th>
                                        <th><div><?php echo get_phrase('options');?></div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $students   = $this->db->query('SELECT * FROM enroll e 
                                       JOIN student s ON s.student_id = e.student_id  
                                       LEFT JOIN student_marks sm ON sm.studentid = s.student_id
                                       WHERE  s.school_id = "'.$this->session->userdata("school_id").'" LIMIT 0,10')->result_array();
                                    foreach($students as $row):?>
                                        <tr>
                                            <td style="" ><?php  echo $row['student_id']; ?></td>
                                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>

                                            <td><?php echo $this->db->get_where('student' , array(
                                                    'student_id' => $row['student_id']
                                                ))->row()->student_code;?></td>
                                            <td >
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
                                            <td style="text-align:center"><input class="marksinput" style="text-align:center;float:right;" type="text" id="marks_<?php echo $row['student_id']; ?>"  name="marks_<?php echo $row['student_id']; ?>" value=""></td>

                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                                        Action <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                                        <!-- STUDENT PROFILE LINK -->
                                                        <li>
                                                            <a href="<?php echo site_url('admin/student_profile/'.$row['student_id']);?>">
                                                                <i class="entypo-user"></i>
                                                                <?php echo get_phrase('profile');?>
                                                            </a>
                                                        </li>
                                                        <!-- STUDENT EDITING LINK -->
                                                        <li>
                                                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_student_edit/'.$row['student_id']);?>');">
                                                                <i class="entypo-pencil"></i>
                                                                <?php echo get_phrase('edit');?>
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="#" onclick="confirm_modal('<?php echo site_url('admin/delete_student/'.$row['student_id'].'/'.$class_id);?>');">
                                                                <i class="entypo-trash"></i>
                                                                <?php echo get_phrase('delete');?>
                                                            </a>
                                                        </li>
                                                    </ul>
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






                <a href="#" onClick="performMarkSave()"
                   class="btn btn-primary pull-right">
                    <i class="entypo-plus-circled"></i>
                    Save Students Marks</a>

            </div>
        </div></div></div>

<!-- FILTER DATA -->

<script src="<?php echo base_url();?>js/plugins/dropzone/dropzone.js"></script>
<script>
    $(document).ready(function () {

    studadditionalsubj = new Array();


    function jumptoNext(inpobj){
        inpobj.keyup(function (event) { 
            if (event.keyCode == 13) { 
                textboxes = $("input.marksinput");
                currentBoxNumber = textboxes.index(this);
                if (textboxes[currentBoxNumber + 1] != null) {
                    nextBox = textboxes[currentBoxNumber + 1];
                    nextBox.focus();
                    nextBox.select();
                }
                event.preventDefault();
                return false;
            }

            if (event.keyCode == 40) { 
                textboxes = $("input.marksinput");
                currentBoxNumber = textboxes.index(this);
                if (textboxes[currentBoxNumber + 1] != null) {
                    nextBox = textboxes[currentBoxNumber + 1];
                    nextBox.focus();
                    nextBox.select();
                }
                event.preventDefault();
                return false;
            }


           if (event.keyCode == 38) { 
                textboxes = $("input.marksinput");
                currentBoxNumber = textboxes.index(this);
                if (textboxes[currentBoxNumber - 1] != null) {
                    nextBox = textboxes[currentBoxNumber - 1];
                    nextBox.focus();
                    nextBox.select();
                }
                event.preventDefault();
                return false;
            }

        });
    }
   jumptoNext($(".marksinput"));

   function loadGrid(term,subject,examtype,fr,st,year){       

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
          //  dataTable.iDisplayLength(100);
          dataTable.paging = false;









            dataTable.fnDraw();

//var table = new $.fn.dataTable.Api( '#table_export' );
//dataTable.page.len( 150 ).draw();

    /*     
            table.page.len( 150 ).draw();*/
            postVrs = {
                "term":term,
                "subject":subject,
                "examtype":examtype,
                "fr":fr,
                "st":st,
                "year":year
            }
            $.post("marks_manage_saved",postVrs,function(respData){




                $.each(respData.content, function(i, item) {

                    btns = '<td>';
                    btns += '<div class="btn-group">';
                    btns += '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">';
                    btns += 'Action <span class="caret"></span>';
                    btns += '</button>';
                    btns += '<ul class="dropdown-menu dropdown-default pull-right" role="menu">';
                    btns += '<li>';
                    btns += '<a href="'+item.profilelink+'">';
                    btns += ' <i class="entypo-user"></i>Profile</a>';
                    btns += '</li>';
                    btns += '<li>';
                    btns += '<a href="#" onclick="showAjaxModal('+item.editlink+');">';
                    btns += '<i class="entypo-pencil"></i>Edit</a>';
                    btns += '</li>';
                    btns += '<li class="divider"></li>';
                    btns += '<li>';
                    btns += '<a href="#" onclick="confirm_modal('+item.deletelink+');">';
                    btns += '<i class="entypo-trash"></i>Delete</a>';
                    btns += '</li>';
                    btns += '</ul>';
                    btns += '</div>';
                    btns += '</td>';


                    if(item.subsubject.length > 0){

                         marksbox =  '';
                        $.each(item.subsubject, function(i, subjitem) {                          

                           marksbox += '<div class="btn-group" style="float:right;" >'+item.subsubjectname[i]+'<input onKeyPress="" class="marksinput" style="text-align:center;float:right;width:30%;" type="text" id="'+subjitem+'_marks_'+item.student_id+'" name="'+subjitem+'_marks_'+item.student_id+'" value='+item.subsubjectmark[i]+' ></div>';

                           marksbox += '<div class="btn-group" style="visibility:hidden;display:none;">Out Off<input style="text-align:center;float:right;width:30%;" type="text" id="'+subjitem+'_marks_outof_'+item.student_id+'" name="'+subjitem+'_marks_outof_'+item.student_id+'" value='+item.subsubjectmarkoutof[i]+' ></div>';
                        

                         });
                         marksbox +=  '<div class="btn-group" style="float:right;"><b>'+item.subject+' TOTAL</b><input readonly class="marksinput"  style="background:#135564;color:white;font-weight:bold;border:thick; text-align:center;float:right;width:30%;" type="text" id="marks_'+item.student_id+'" name="marks_'+item.student_id+'" value='+item.marks+'></div>';

                        var data = [
                            '<td>'+item.student_id+'</td>',
                            '<td><img src='+item.img+' class="img-circle" width="30" /></td>',
                            "<td>"+item.admno+"</td>",
                            "<td>"+item.student+"</td>",
                            "<td>"+item.section+"</td>",
                            '<td style="text-align:center;width:400px !important;">'+marksbox+'</td>',
                             btns
                        ];

                    }else{

                        var data = [
                            '<td>'+item.student_id+'</td>',
                            '<td><img src='+item.img+' class="img-circle" width="30" /></td>',
                            "<td>"+item.admno+"</td>",
                            "<td>"+item.student+"</td>",
                            "<td>"+item.section+"</td>",
                            '<td style="text-align:center"><input class="marksinput" style="text-align:center;float:right;" type="text" id="marks_'+item.student_id+'" name="marks_'+item.student_id+'" value='+item.marks+'></td>',
                             btns
                        ];

                    }

                    dataTable.fnAddData(data);
                 
                });


                $.each(respData.content, function(i, item) {

                        if(item.subsubject.length > 0){
                         $.each(item.subsubject, function(j, subjitemTot) {
                         studadditionalsubj.push(subjitemTot);  
                            $('#'+subjitemTot+'_marks_'+item.student_id).keyup(function (event) {                               
                                 entryValue = 0;
                                 entryOutOfValue = 0;
                                 $.each(item.subsubject, function(k, subjitemTotVal) { 
                                      entryValue  = entryValue +  Number($('#'+subjitemTotVal+'_marks_'+item.student_id).val());
                                      entryOutOfValue  = entryOutOfValue +  Number($('#'+subjitemTotVal+'_marks_outof_'+item.student_id).val());  
                                 }); 

                                 if( (entryValue/entryOutOfValue * 100 ).toFixed(0) > 100){
                                    alert("Marks entered are Invalid!");
                                    $('#marks_'+item.student_id).val(0);
                                 } else{
                                    $('#marks_'+item.student_id).val( (entryValue/entryOutOfValue * 100 ).toFixed(0)); 
                                 }                              

                               

                                if (event.keyCode == 13) { 
                                        textboxes = $("input.marksinput");
                                        currentBoxNumber = textboxes.index(this); 
                                        if (textboxes[currentBoxNumber + 1] != null) {
                                            nextBox = textboxes[currentBoxNumber + 1];
                                            nextBox.focus();
                                            nextBox.select();
                                        }
                                        event.preventDefault();
                                        return false;
                                    }

                                    if (event.keyCode == 40) { 
                                        textboxes = $("input.marksinput");
                                        currentBoxNumber = textboxes.index(this);
                                        if (textboxes[currentBoxNumber + 1] != null) {
                                            nextBox = textboxes[currentBoxNumber + 1];
                                            nextBox.focus();
                                            nextBox.select();
                                        }
                                        event.preventDefault();
                                        return false;
                                    }

                                   if (event.keyCode == 38) { 
                                        textboxes = $("input.marksinput");
                                        currentBoxNumber = textboxes.index(this);
                                        if (textboxes[currentBoxNumber - 1] != null) {
                                            nextBox = textboxes[currentBoxNumber - 1];
                                            nextBox.focus();
                                            nextBox.select();
                                        }
                                        event.preventDefault();
                                        return false;
                                    } 

                            }); 


                         });
                        }
                      jumptoNext($('#marks_'+item.student_id));

                });                

            },"json");



                                  

        }





        $('select').on('change', function(){
            loadGrid( $('#term').val(),$('#subject_holder').val(),$('#examtype').val(),$('#class_id').val(),$('#section_holder').val(),$('#year').val());
        });


        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });


    function performMarkSave(){
        dataTable =  $('#table_export').DataTable();
        var rows = dataTable.fnGetNodes();
        var studis = new Array();
        var studismarks = new Array();

        
        var studisubmarksmain = new Array();
        


       if(studadditionalsubj.length > 0){
           studadditionalsubj = studadditionalsubj.filter((v, i, a) => a.indexOf(v) === i);           
        }

        for(var i=0;i<rows.length;i++){
            hmlvalinput = $(rows[i]).find("td:eq(5)").html();
            studid = $(rows[i]).find("td:eq(0)").html()
            studis.push(studid);
            studismarks.push($("#marks_"+studid).val());

                var studisubmarks = new Array();
                if(studadditionalsubj.length > 0){
                   for(var l=0;l<studadditionalsubj.length;l++){
                     //studisubmarks.push(studid,$("#"+studadditionalsubj[l]+"_marks_"+studid).val(), studadditionalsubj[l] );
                     studisubmarks[l] = [studid,$("#"+studadditionalsubj[l]+"_marks_"+studid).val(),studadditionalsubj[l]];
                   }               
               }
            studisubmarksmain.push(studisubmarks);
                 
        }




        postVrs ={
            studis,
            studismarks,
            studisubmarksmain,
            "term":$('#term').val(),
            "subject":$('#subject_holder').val(),
            "examtype":$('#examtype').val(),
            "fr":$('#class_id').val(),
            "st":$('#section_holder').val(),
            "year":$('#year').val(),
            "outof":$("#outof").val(),
            "limit":$("#limit").val()
        }
        $.post("marks_manage_saving",postVrs,function(respData){
            swal({
                title: 'Saved!',
                text: '',
                type: 'success'
            });

        },"json");
    }
</script>
<script src="<?php echo base_url('assets/dropzone/dropzone.js');?>"></script>
<script>
    Dropzone.options.dropzoneForm = {
        paramName: "userfile", // The name that will be used to transfer the file
        maxFilesize: 10, // MB
        url:'<?php echo base_url();?>support/upload.php',
        dictDefaultMessage: "<strong>Drop files here or click to upload. </strong>"
    };


 function doUploads(){

            var term=$("#term").val();
            var subject=$("#subject_holder").val();
            var exam=$("#examtype").val();
            var st=$("#section_holder").val();         

            if(subject=="" || term =="" || exam=="" || st ==""){
                $("#alert").slideDown("slow");                    
            } else{
                $("#alert").slideUp("slow");
                showAjaxModal('<?php echo base_url();?>modal/popupexam/modal_upload_exam/'+st+'/'+term+'/'+subject+'/'+exam);
            }  

 }




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
        $("#examst").change(function(){
            var id2=parseInt($("#examst").val());
            var id='id=' + $("#examst").val();
            if(id2>=1){

                $.ajax({
                    type: 'POST',
                    url:'<?php echo base_url();?>support/examfetch.php',
                    data: id,
                    dataType: 'json',
                    success: function(response){
                        $("#examtype").val(response.exam);
                        $("#term").val(response.term);
                        $("#year").val(response.year);
                        $("#fr").val(response.form);
                        $("#st").val(response.stream);
                        $("#limit").val(response.limit);
                        //alert(response.form);
                        $("#entry").removeClass("hidden");
                        $("#subject1").removeClass("hidden");
                        showUser();
                    }

                });
            }else{

                swal({
                    title: 'Select a valid exam',
                    text: '',
                    type: 'warning'
                });
            }

        });
        $("#entry").focusout(function() {
            var param="activate";
            var entry=$("#entry").val();
            var subject=$("#subject").val();
            var form=$("#fr").val();
            var stream=$("#st").val();
            var year=$("#year").val();
            var term=$("#term").val();
            var exam=$("#examtype").val();
            var dataString = 'entry=' + entry  + '&subject=' + subject  + '&form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&param=' + param ;
            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>support/entry.php',
                data:dataString,
                cache:false,
                success:function(result){

                }
            });





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





