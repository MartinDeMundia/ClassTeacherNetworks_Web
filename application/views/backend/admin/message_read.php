<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<?php
$messages = $this->db->get_where('message', array('message_thread_code' => $current_message_thread_code))->result_array();
foreach ($messages as $row):

    $sender = explode('-', $row['sender']);
    $sender_account_type = $sender[0];
    $sender_id = $sender[1];
    ?>
    <div class="mail-info">

        <div class="mail-sender " style="padding:7px;">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo $this->crud_model->get_image_url($sender_account_type, $sender_id); ?>" class="img-circle" width="30">
                <span><?php echo $this->db->get_where($sender_account_type, array($sender_account_type . '_id' => $sender_id))->row()->name; ?></span>
            </a>
        </div>

        <div class="mail-date" style="padding:7px;">
            <?php echo date("d M, Y", $row['timestamp']); ?>
        </div>

    </div>

    <div class="mail-text">
        <p> <?php echo $row['message']; ?></p>
        <?php if ($row['attached_file_name'] != ''):?>
          <p style="text-align: right;">
            <a href="<?php echo base_url('uploads/private_messaging_attached_file/'.$row['attached_file_name']);?>" target="_blank" style="color: #2196F3;">
            <i class="entypo-download" style="color: #757575"></i> <?php echo $row['attached_file_name']; ?>
          </a>
          </p>
        <?php endif; ?>
    </div>

<?php endforeach; ?>

<?php echo form_open(site_url('admin/message/send_reply/'.$current_message_thread_code)  , array('enctype' => 'multipart/form-data')); ?>
<div class="mail-reply">
    <div class="compose-message-editor">
        <!--<textarea row="5" class="form-control wysihtml5" data-stylesheet-url="assets/css/wysihtml5-color.css" name="message"
                  placeholder="<?php echo get_phrase('reply_message'); ?>" id="sample_wysiwyg" required></textarea>-->
				  <textarea></textarea>
    </div>
    <br>
    <!-- File adding module -->
    <div class="">
      <input type="file" class="form-control file2 inline btn btn-info" name="attached_file_on_messaging" accept=".pdf, .doc, .jpg, .jpeg, .png" data-label="<i class='entypo-upload'></i> Browse" />
    </div>
  <!-- end -->
    <button type="submit" class="btn btn-success pull-right">
        <?php echo get_phrase('send'); ?>
    </button>
    <br><br>
</div>
</form>
<style>
#mceu_34,#mceu_30-body { display:none !important;}
</style>
 <script>
 
 tinymce.init({
  selector: 'textarea',
  height: 200,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor textcolor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code help wordcount'
  ],
  toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css']
});
 
 </script>