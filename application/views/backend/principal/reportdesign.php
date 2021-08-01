<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>CBC Report</title>	
		<script src="<?php echo base_url('assets/treegrid/jquery-1.10.2.min.js');?>"></script>
		<script src="<?php echo base_url('assets/treegrid/jquery.easing.1.3.min.js');?>"></script>
		<script src="<?php echo base_url('assets/treegrid/jsrender.min.js');?>"></script>
		<script src="<?php echo base_url('assets/treegrid/ej.web.all.min.js');?>"></script>
		<link rel="stylesheet" href="<?php echo base_url('assets/treegrid/ej.widgets.core.min.css');?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/treegrid/ej.theme.min.css');?>">
  <style>     
		.e-expandIcon:before {
			content: "\e703";
		}
		.e-collapseIcon:before {
			content: "\e707";
		}
      .e-aboveIcon:before {
          content: "\e7e5";
      }

      .e-belowIcon:before {
          content: "";
      }

      .e-topIcon:before {
          content: "\e7e2";
      }

      .e-bottomIcon:before {
          content: "";
      }

      .e-childIcon:before {
          content: "";
      }
    #Above {
    display: none !important;
	}
	#Below {
		display: none !important;
	}
    </style>
</head>
<body>
    <div class="content-container-fluid">




      <div class="row">
            <div class="panel-body" style="margin-left:-12px !important;padding-left:0px !important;">
                         <div class="col-sm-6">
                                                
                            <select id="class_id" name="class_id" class="form-control" onchange="">
                                <option value="">Select Classes/Grade</option>
                                <option value="1">PP1</option>
                                <option value="2">PP2</option>
                                <option value="3">GRADE 1</option>
                                <option value="4">GRADE 2</option>
                                <option value="5">GRADE 3</option>
                                <option value="6">ASSESSMENT RUBRIC 4</option>
                                <?php
                                  /* $q="
                                    SELECT  section_id ,CAST(name as SIGNED) as class  
                                    FROM  section 
                                    WHERE class_id IN (SELECT class_id  
                                    FROM class WHERE school_id = '".$this->session->userdata('school_id')."')  
                                    GROUP BY CAST(name as SIGNED)  ORDER BY name ASC
                                    ";
                                    $classes =$this->db->query($q)->result_array();                              
                                foreach($classes as $row):*/
                                    ?>                           
                            </select>
                    

                        </div>
                        <div class="col-sm-6">

                             <div class="row" style="float:right;width:350px !important;margin-top: 0px;">

                                 <div class="col-sm-6">                                                    
                                 </div>
                                 <div class="col-sm-6">


                                     <a href="#" style="margin:1px;" onClick="generateReport()"
                                                       class="btn btn-primary pull-right">
                                                        <i class="entypo-book"></i>
                                                        Preview CBC Report</a>


                                   </div>
                             </div>                                            
                        </div>

                 </div>
          <div id="alert" class="alert alert-danger" style="display:none;" >Please class to create the cbc design!</div> 

      </div>


        <div class="row">
            <div class="cols-sample-area">
                <div id="TreeGridContainer" style="height:800px;width:100%"></div>                
            </div>

        
            
             <div class="cols-sample-area">
              <h5>Preview</h5>
                  <textarea id="txtarea" name="txtarea" style="width:100%;height:200px;" readonly>
                  </textarea> 
            </div>
                        
     

        </div>

    </div>

    <script type="text/javascript">
        $(function () {
      		 var dataManager = ej.DataManager({
      				url: "cbcdesign",
      				crossDomain: true,
      			});

            $("#TreeGridContainer").ejTreeGrid({
                dataSource: dataManager,
                childMapping: "subtasks",
                expandStateMapping : "isCollapsed",
                treeColumnIndex: 1,
                allowDragAndDrop:false,
                isResponsive: true,
                contextMenuSettings: {
                    showContextMenu: true,
                    contextMenuItems: ["add", "edit", "delete"]
                },
				        contextMenuOpen: contextMenuOpen,
                editSettings: { allowEditing: true, editMode: "rowEditing" },
                columns: [
                    { field: "id", headerText: "#", editType: "numericedit", width: "60" , visible:false },
                    { field: "topic_number", headerText: "Topic Number",width: "100" ,editType: "stringedit" },
                    { field: "topic_title", headerText: "Title", editType: "stringedit" },
                    { field: "topic_description", headerText: "Description", editType: "stringedit" },
                    { field: "date_created", headerText: "Date of Creation", editType: "datepicker"}
                ],

            endEdit: function (args) {          
              var modifiedData = args.data ? args.data : args.currentValue;
        			  $.post("editnode",modifiedData,function(responsedata){				   
        				},"json");
            },

            rowSelected: function (args) {
            // alert(args.data.topic_title);
             $("#txtarea").val(args.data.topic_title);
             console.log(args);
             },

        actionComplete: function (args) {

        if (args.requestType == "addNewRow") {
            var NewRow = args.addedRow;
            //console.log(args);
            //code to add new row to table
        }
        /*if (args.requestType == "delete") {
            var data = args.data;
            //console.log(args);
            // code to delete the selected row from table

        }*/
        if (args.requestType == "save") {
            //var data = args.data;
            //console.log(args);
            // code to delete the selected row from table

        }

        if (args.requestType == "delete") {
            var data = args.data;           
      			postdata = {"id":data.id}
      			  $.post("deletenode",postdata,function(responsedata){				   
      			  },"json");           
        }



    }



            })
        });

        function contextMenuOpen(args) {
            //To add the custom context menu in Treegrid
            var isExpandable = true, isCollapsable = true, data;
            data = args.item;
            if (data && data.hasChildRecords) {
                if (data.expanded)
                    isExpandable = false;
                else
                    isCollapsable = false;
            } else {
                isExpandable = false;
                isCollapsable = false;
            }
            var aboveMenu = args.contextMenuItems.filter(function (val) { return val.menuId == "Above" }),
            belowMenu = args.contextMenuItems.filter(function (val) { return val.menuId == "Below" });
            aboveMenu[0].iconClass = "e-aboveIcon";
            belowMenu[0].iconClass = "e-belowIcon";
            //To add the customized menu items in context menu
            var contextMenuItems = [
           /*{
                headerText: "Top",
                eventHandler: customMenuAddHandler,
                menuId: "Top",
                parentMenuId: "Add",
                iconClass: "e-topIcon"

            },*/
           {
                headerText: "Add Main Course (Below)",
                menuId: "Bottom",
                parentMenuId: "Add",
                eventHandler: customMenuAddHandler,
                iconClass: "e-bottomIcon"
            },
            {
                headerText: "Add Child Course (On selected)",
                menuId: "Child",
                parentMenuId: "Add",
                eventHandler: customMenuAddHandler,
                iconClass: "e-childIcon"
            },
             {
                 headerText: "Expand",
                 menuId: "Expand",
                 eventHandler: customMenuExpandCollapseHandler,
                 iconClass: "e-expandIcon",
                 disable: !isExpandable
             },
			 {
                 headerText: "Collapse",
                 menuId: "Collapse",
                 eventHandler: customMenuExpandCollapseHandler,
                 iconClass: "e-collapseIcon",
                 disable: !isCollapsable
             }
            ];
           args.contextMenuItems.push.apply(args.contextMenuItems, contextMenuItems);
        }

        function customMenuAddHandler(args) {         
            var class_id =$("#class_id").val(); 
            if(class_id ==""){
                $("#alert").slideDown("slow");                    
            } else{          
            $("#alert").slideUp("slow"); 
            var currentMenuId = args.menuId,
                tempData = args.data && $.extend({}, args.data.item), rowPosition;

            if (currentMenuId == "Top") {
                rowPosition = ej.TreeGrid.RowPosition.Top;				
            }
            else if (currentMenuId == "Bottom") {
                rowPosition = ej.TreeGrid.RowPosition.Bottom;
            }
            else if (currentMenuId == "Child") {
                rowPosition = ej.TreeGrid.RowPosition.Child;
            }
      			postdata = {
      			"pid":args.data.id,
            "class_id":class_id,
      			"rowposition":rowPosition
      			}
      			grdObj = this;
      		    $.post("addnode",postdata,function(responsedata){             
                     grdObj.addRow(responsedata,rowPosition);
                     console.log(responsedata);
              },"json");
                                
         } 
	
           
           
        }
        function customMenuExpandCollapseHandler(args) {
            var currentMenuId = args.menuId, expandCollapseArgs = {};
            expandCollapseArgs.data = args.data;
            if (currentMenuId === "Expand")
                expandCollapseArgs.expanded = true;
            else
                expandCollapseArgs.expanded = false;
            ej.TreeGrid.sendExpandCollapseRequest(this, expandCollapseArgs);
        }

        $('select').on('change', function(){ 
          $("#alert").slideUp("slow");         
             postData = {"id":$('#class_id').val()};
             $.post("cbcdesign",postData,function(dbdata){
                  var treeObj = $("#TreeGridContainer").data("ejTreeGrid");                  
                  treeObj.refresh(dbdata);
             },"json"); 
        

        });

      function generateReport(){
         var term=$("#term").val();
            var class_id = $("#class_id").val();
            if(class_id ==""){
                $("#alert").slideDown("slow");                    
            } else{
                $("#alert").slideUp("slow");
                //showAjaxModal('<?php echo base_url();?>modal/popup/modalcbcpreview/'+class_id);
                url = '<?php echo base_url();?>modal/popup/modalcbcpreview/'+class_id;
                window.open(url,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width="900",height=700');

            }  
      }
    </script>
</body>

</html>
