

			<div class="wrapper wrapper-content animated fadeIn">

                <div class="p-w-md m-t-sm">
				<div class="scroll_content">
<div class="row">
	 <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h2>Print Blank Markbook</h2>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                        </div>
                    </div>
                    <div class="ibox-content">

					 
					 
					 
					 <form role="form" class="form-inline" >
                                <div class="form-group" style="margin-bottom: 35px;">
                                    <label for="exampleInputEmail2" class="col-lg-2 control-label">Form</label>
                                    <select data-placeholder="Choose a Term..." class="form-control select2" tabindex="1" id="fr" >
								<?php
                                   $q="SELECT * from form";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
                                    <option value="<?php echo $row['Id']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								  }
								  ?>
                                </select>
                                </div>
                                <div class="form-group" style="margin-bottom: 35px;">
                                    <label for="exampleInputPassword2" class="col-lg-2 control-label">Stream</label>
                                    <select data-placeholder="Choose a Term..." class="form-control select2" tabindex="1" id="Streams" >
								<?php
                                   $q="SELECT * from streams";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
                                    <option  value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								  }
								  ?><option selected value="all">ALL</option>
                                </select>
                                </div>
								 <div class="form-group" style="margin-bottom: 35px;" >
                                    <label for="exampleInputPassword2" class="col-lg-2 control-label">Term</label>
                                    <select data-placeholder="Choose a Term..." class="form-control select2" tabindex="1" id="term">
                                  
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option><option value="all">ALL</option>
                                </select>
                                </div>
								 <div class="form-group" style="margin-bottom: 35px;">
                                    <label for="exampleInputPassword2" class="col-lg-2 control-label">Year</label>
                                   <select data-placeholder="Choose a Term..." class="form-control select2" tabindex="1" id="year">
                                  <?php
								  for ($i=0; $i<=3;$i++){
									  ?>
									  <option <?php if(isset($_SESSION['en'])) if ($_SESSION['year']==((date("Y")-3)+$i))echo 'selected';?> value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
									  <?php
								  }
								  ?>
                                    
                                </select>
                                
                                    <label for="exampleInputPassword2" class="col-lg-2 control-label">Exam</label>
                                    <select data-placeholder="Choose exam..." class="form-control select2" tabindex="1" id="examtype">
                                  <?php
								  
								 
								  $q="SELECT term1 from exams";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
								 
								  
									  <option  <?php if(isset($_SESSION['en']))if ($_SESSION['en']==$row['term1'])echo 'selected';?> value="<?php echo $row['term1']; ?>"><?php echo $row['term1']; ?>
									  <?php
									  
								  }
								  
								  ?>
                                   </option>
									   <option <?php if(isset($_SESSION['en'])) if ($_SESSION['en']=="all")echo 'selected';?> value="all">ALL</option>
                                </select>
                            
                              
                                <button class="btn btn-primary" >Print</button>    </div>
                            </form>
					 
					 
					 
					 
					 
							</div>
								
 </div>
    </div>
	<div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content border-sbottom">
                            <div class="text-center pdf-toolbar">

                            <div class="btn-group">
                                <button id="prev" class="btn btn-white"><i class="fa fa-long-arrow-left"></i> <span class="hidden-xs">Previous</span></button>
                                <button id="next" class="btn btn-white"><i class="fa fa-long-arrow-right"></i> <span class="hidden-xs">Next</span></button>
                                <button id="zoomin" class="btn btn-white"><i class="fa fa-search-minus"></i> <span class="hidden-xs">Zoom In</span></button>
                                <button id="zoomout" class="btn btn-white"><i class="fa fa-search-plus"></i> <span class="hidden-xs">Zoom Out</span> </button>
                                <button id="zoomfit" class="btn btn-white"> 100%</button>
                                <span class="btn btn-white hidden-xs">Page: </span>

                            <div class="input-group">
                                <input type="text" class="form-control" id="page_num">

                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-white" id="page_count">/ 22</button>
                                </div>
                            </div>

                                </div>
                        </div>







            <div class="text-center m-t-md table-responsive">
                <canvas id="the-canvas" class="pdfcanvas border-left-right border-top-bottom b-r-md"></canvas>
            </div>

                        </div>
                    </div>
                </div>
</div></div></div></div>
                     
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>   
    <script id="script">
        
        var url = 'PDFS/BLANK BOOK S.PDF';


        var pdfDoc = null,
                pageNum = 1,
                pageRendering = false,
                pageNumPending = null,
                scale = 1,
                zoomRange = 0.25,
                canvas = document.getElementById('the-canvas'),
                ctx = canvas.getContext('2d');

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num, scale) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function(page) {
                var viewport = page.getViewport(scale);
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page_num').value = num;
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num,scale);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            var scale = pdfDoc.scale;
            queueRenderPage(pageNum, scale);
        }
        document.getElementById('prev').addEventListener('click', onPrevPage);

        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            var scale = pdfDoc.scale;
            queueRenderPage(pageNum, scale);
        }
        document.getElementById('next').addEventListener('click', onNextPage);

        /**
         * Zoom in page.
         */
        function onZoomIn() {
            if (scale >= pdfDoc.scale) {
                return;
            }
            scale += zoomRange;
            var num = pageNum;
            renderPage(num, scale)
        }
        document.getElementById('zoomin').addEventListener('click', onZoomIn);

        /**
         * Zoom out page.
         */
        function onZoomOut() {
            if (scale >= pdfDoc.scale) {
                return;
            }
            scale -= zoomRange;
            var num = pageNum;
            queueRenderPage(num, scale);
        }
        document.getElementById('zoomout').addEventListener('click', onZoomOut);

        /**
         * Zoom fit page.
         */
        function onZoomFit() {
            if (scale >= pdfDoc.scale) {
                return;
            }
            scale = 1;
            var num = pageNum;
            queueRenderPage(num, scale);
        }
        document.getElementById('zoomfit').addEventListener('click', onZoomFit);


        /**
         * Asynchronously downloads PDF.
         */
        PDFJS.getDocument(url).then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            var documentPagesNumber = pdfDoc.numPages;
            document.getElementById('page_count').textContent = '/ ' + documentPagesNumber;

            $('#page_num').on('change', function() {
                var pageNumber = Number($(this).val());

                if(pageNumber > 0 && pageNumber <= documentPagesNumber) {
                    queueRenderPage(pageNumber, scale);
                }

            });

            // Initial/first page rendering
            renderPage(pageNum, scale);
        });
    </script>
