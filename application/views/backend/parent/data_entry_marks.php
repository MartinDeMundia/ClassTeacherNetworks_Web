<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('fill_in_marks');?>
                </div>
            </div>
            <div class="panel-body">


                <form method="POST" enctype="multipart/form-data" class="form-inline" role="form" id="ef">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <select placeholder="Select Term..." class=" form-control"  id="term">
                            <option value="t">Select Term...</option>
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                        </select> </div>

                    <div id="subject1" class="form-group" style="margin-bottom: 15px;">
                        <select placeholder="Select Subject..." class="form-control"  id="subject" onchange="showUser()"><option value="0">Select Subject...</option>
                            <?php

                            $q="SELECT Description,Abbreviation,Id from subjects";
                            $r=$this->db->query($q)->result_array();;
                            foreach($r as $row) :
                                ?>

                                <option value="<?php echo $row['Abbreviation']; ?>"><?php echo $row['Description']; ?></option>
                            <?php
                            endforeach;
                            ?>

                        </select> </div>


                    <div class="form-group  " style="margin-bottom: 15px;">
                        <select placeholder="Select exam..." class="form-control"  id="examtype" onchange="showUserr(this.value)"><option value="t">Select Exam...</option>
                            <?php


                            $q="SELECT term1 from exams where school_id='".$this->session->userdata('school_id')."'";
                            $r=$this->db->query($q)->result_array();;
                            foreach ($r as $row) :
                            ?>

                            <option id="<?php echo $row['term1']; ?>" value="<?php echo $row['term1']; ?>"><?php echo $row['term1']; ?>
                                <?php
                                endforeach;

                                ?>
                            </option>

                        </select> </div>
                    <div class="form-group" style="margin-bottom: 15px;">

                        <select placeholder="Select Stream..." class="form-control"  id="fr" onchange="showUser()"><option value="t">Select class...</option>
                            <?php
                            $q="SELECT * from form where school_id='".$this->session->userdata('school_id')."' and name <> ''";
                            $r=$this->db->query($q)->result_array();;
                            foreach ($r as $row) :
                                ?>
                                <option value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select> </div>

                    <div class="form-group " style="margin-bottom: 15px;">

                        <select placeholder="Select Stream..." class="form-control"  id="st" onchange="showUser()"><option value="t">Select Stream...</option>
                            <?php
                            $q="SELECT * from streams where school_id='".$this->session->userdata('school_id')."'  and name <> ''";
                            $r=$this->db->query($q)->result_array();;
                            foreach ($r as $row) :
                                ?>
                                <option value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">

                        <select placeholder="Select Year..." class="form-control"  id="year" onchange="showUser()"><option value="t">Select Year...</option>
                            <?php
                            for ($i=0; $i<=3;$i++){
                                ?>
                                <option value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
                                <?php
                            }
                            ?>

                        </select>
                    </div> <div class="form-group" style="margin-bottom: 15px;">

                        <div id="lim">

                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">

                        <div class="col "><input placeholder="enter limit..." class="form-control" type="text" id="limit" /></div>
                    </div>

                    <div class="form-group " style="margin-bottom: 15px;">

                        <div class="col "><input placeholder="enter subject entry..." class="form-control hidden" type="text" id="entry" /></div>
                    </div>


                    <div class="form-group" style="margin-bottom: 15px;">
                        <input placeholder="enter out of..." class="form-control" type="text" id="outof"/>
                    </div>


                    <div class="form-group" style="margin-bottom: 15px;">

                    </div>

                    <a href="#"
                       class="btn btn-primary pull-right">
                        <i class="entypo-plus-circled"></i>
                        Save Students Marks</a>


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

                                <table class="table table-bordered datatable" id="table_export">
                                    <thead>
                                    <tr>

                                        <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                                        <th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                                        <th><div><?php echo get_phrase('name');?></div></th>
                                        <th><div><?php echo get_phrase('class');?></div></th>
                                        <th><div>Marks</div></th>
                                        <th><div><?php echo get_phrase('options');?></div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $students   = $this->db->query('SELECT * FROM enroll e 
                                       JOIN student s ON s.student_id = e.student_id  
                                       LEFT JOIN student_marks sm ON sm.studentid = s.student_id
                                       WHERE sm.marks > 0
                                       LIMIT 0,10')->result_array();
                                    foreach($students as $row):?>
                                        <tr>

                                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>

                                            <td><?php echo $this->db->get_where('student' , array(
                                                    'student_id' => $row['student_id']
                                                ))->row()->student_code;?></td>
                                            <td>
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
                                            <td style="text-align:center"><input style="text-align:right" type="text" name="marks" value="<?php echo $row['marks']; ?>"></td>
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






                <a href="#"
                   class="btn btn-primary pull-right">
                    <i class="entypo-plus-circled"></i>
                    Save Students Marks</a>













            </div>
        </div></div></div>

<!-- FILTER DATA -->





<script src="<?php echo base_url();?>js/plugins/dropzone/dropzone.js"></script>

<script>
    $(document).ready(function () {

 cnt = 0 ;
        $('select').on('change', function() {
            //this.value
            dataTable =  $('#table_export').DataTable();
            dataTable.fnClearTable();
            dataTable.fnDraw();
           // dataTable.fnDestroy();


            $.post("http://apps.classteacher.school/admin/marks_manage_saved",function(respData){


                $.each(respData.content, function(i, item) {
                    alert(data[i].toSource());

                });



                var data = [
                    "<td><input type='text' value="+cnt+" /></td>",
                    "<td><input type='text'/></td>",
                    "<td><input type='text'/></td>",
                    "<td><input type='text'/></td>",
                    "<td><input type='text'/></td>",
                    "<td><input type='text'/></td>"
                ];
                dataTable.fnAddData(data);


            },"json");
/*           var data = [
                "<td><input type='text' value="+cnt+" /></td>",
                "<td><input type='text'/></td>",
                "<td><input type='text'/></td>",
                "<td><input type='text'/></td>",
                "<td><input type='text'/></td>",
                "<td><input type='text'/></td>"


            ];
            dataTable.fnAddData(data);*/
            cnt ++;
        });



















        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>
<script src="<?php echo base_url('assets/dropzone/dropzone.js');?>"></script>
<script>
    Dropzone.options.dropzoneForm = {
        paramName: "userfile", // The name that will be used to transfer the file
        maxFilesize: 10, // MB
        url:'<?php echo base_url();?>support/upload.php',
        dictDefaultMessage: "<strong>Drop files here or click to upload. </strong>"
    };
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





