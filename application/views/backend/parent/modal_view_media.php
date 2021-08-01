<?php
$edit_data = $this->db->get_where('media', array('id' => $param2))->result_array();
foreach ($edit_data as $row):	
?>   

    <div class="row" id="notice_print">
            <div class="col-md-12">

                <div class="panel panel-primary" data-collapsed="0">
                        
                    <div class="panel-body">
                        <b>Title</b>
                        <p><?php echo $row['title']; ?></p>
                        <b>Details</b>
                        <p><?php echo $row['details'] ?></p>                        
                        <p><a target="_blank" href="<?php echo $row['path'] ?>">Click here to view media</a></p>
                    </div>
                </div>
            </div>
    </div>
<?php endforeach; ?>


<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'notice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Notice</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        var is_chrome = Boolean(mywindow.chrome);
        if (is_chrome) {
            setTimeout(function() {
                mywindow.print();
                mywindow.close();

                return true;
            }, 250);
        }
        else {
            mywindow.print();
            mywindow.close();

            return true;
        }

        return true;
    }

</script>

