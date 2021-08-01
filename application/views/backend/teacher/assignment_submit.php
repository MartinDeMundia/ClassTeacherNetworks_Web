<hr />
<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-menu"></i>
                    <?php echo get_phrase('assignments_submit'); ?>
                </a></li>
             
        </ul>
        <!------CONTROL TABS END------>


        <div class="tab-content">
            <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <div class="row">

                    <div class="col-md-12">

                        

                        <div class="tab-content">
                             
                            <div class="tab-pane active" id="running">

                                <?php include 'assignmentsubmit_list.php'; ?>

                            </div>
                             
                        </div>


                    </div>

                </div>
            </div>
            <!----TABLE LISTING ENDS--->
 
        </div>
    </div>
</div>