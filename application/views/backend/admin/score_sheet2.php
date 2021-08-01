<?php
     error_reporting(E_ALL);
     ini_set('display_errors', 1);
	  include_once(base_url()"support/dbconn.php");
	 ?>

			<div class="wrapper wrapper-content animated bounceIn">

                <div class="p-w-md m-t-sm">
				<div class="scroll_content">
<div class="row">
	 <div class="col-lg-12">
                <div class="ibox" id="ibox1">
                    <div class="ibox-title">
                        <h2> SCORE SHEET</h2>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                             <a href="../PDFS/score.pdf" id="prt" download="Score Sheet">
                                <i class="fa fa-2x fa-print " ></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

					 
					  <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
					 
					
					 
					 
					 
					 
					 
							</div>
								
 </div>
    </div><div class="row hidden">
	<div class="col-lg-12">
                    <div class="ibox">
					
					<div class="ibox-title">
                       
						
                        <div class="ibox-tools">
                            
                            <a href="../PDFS/score.pdf" id="p rt" download="Score Sheet">
                                <i class="fa fa-2x fa-print" ></i>
                            </a>
                        </div></div>
                        <div class="ibox-content">
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
</div></div></div></div></div>
                     
<script src="js/plugins/pdfjs/pdf.js"></script>
	<script>
		
	</script>




    <script id="script">
        $(document).ready(function() {
			
			$("#bsearch").click(function() {
				$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
				
				var l = Ladda.bind('.ladda-button-demo');
     var subjects=$("#subject").val();
					var stream=$("#Streams").val();
		var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
		var form=$("#fr").val();
				var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&subject=' + subjects + '&school_id=' + <?php echo $this->session->userdata('schoo_id'); ?>;
				$.ajax({
		type:'POST',
		url:'<?php echo base_url();?>support/sc.php',
		data:dataString,
		cache:false,
		success:function(result){
			if (result>=1){
				
			}
			else{
			
			}//location.reload();
		},
			complete: function(result){
				
				$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
				$("#prt").removeClass("hidden");
				$("#prt").attr("download","FORM " + form + "  " + stream + "  " + term + "  " + exam + "  " + "   " + subjects + "  SCORE SHEET " + year);
				//$("#prt")[0].click();
			}
		
		
	});
				return false;
				
			});
			
		});
        var url = 'PDFS/score.pdf';	


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
<script>

    $(document).ready(function (){
$('.chosen-select').chosen({width: "100%"});
        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 2000 });

        // Bind progress buttons and simulate loading progress
        Ladda.bind( '.progress-demo .ladda-button',{
            callback: function( instance ){
                var progress = 0;
                var interval = setInterval( function(){
                    progress = Math.min( progress + Math.random() * 0.1, 1 );
                    instance.setProgress( progress );

                    if( progress === 1 ){
                        instance.stop();
                        clearInterval( interval );
                    }
                }, 200 );
            }
        });


        var l = $( '.ladda-button-demo' ).ladda();

        l.click(function(){
            // Start loading
            l.ladda( 'start' );

            // Timeout example
            // Do something in backend and then stop ladda
            
                
          


        });

    });

</script>