<div class="mail-header" style="padding-bottom: 27px ;">
    <!-- title -->
    <h3 class="mail-title">
        <?php echo get_phrase('write_new_message'); ?>
    </h3>
</div>

<div class="mail-compose">

    <?php echo form_open(site_url('parents/message/send_new/'), array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>


    <div class="form-group">
        <label for="subject"><?php echo get_phrase('recipient'); ?>:</label>
        <br><br>
        <select class="form-control select2" name="reciever" required>

            <option value=""><?php echo get_phrase('select_a_user'); ?></option>
             
			<optgroup label="<?php echo get_phrase('principal'); ?>">
                <?php
                $principals = $this->db->get('principal')->result_array();
                foreach ($principals as $row):
					$school_name = $this->db->get_where('school', array('school_id' => $row['school_id']))->row()->school_name;
                    ?>

                    <option value="principal-<?php echo $row['principal_id']; ?>">
                       School <?php echo $school_name. " - ".$row['name']; ?></option>

                <?php endforeach; ?>
            </optgroup>
			
            <optgroup label="<?php echo get_phrase('teacher'); ?>">
                <?php
                $teachers = $this->db->get('teacher')->result_array();
                foreach ($teachers as $row):
					$school_name = $this->db->get_where('school', array('school_id' => $row['school_id']))->row()->school_name;
                    ?>

                    <option value="teacher-<?php echo $row['teacher_id']; ?>">
                       School <?php echo $school_name. " - ".$row['name']; ?></option>

                <?php endforeach; ?>
            </optgroup>
            <optgroup label="<?php echo get_phrase('parent'); ?>">
                <?php
                $parents = $this->db->get('parent')->result_array();
                foreach ($parents as $row):
				   $student = $this->db->get_where('student', array('parent_id' => $row['parent_id'],'school_id' => $this->session->userdata('school_id')))->row();
				   if(count($student) == 0) continue;
				   $enroll = $this->db->get_where('enroll', array('student_id' => $student->student_id))->row();	
				   $class_name = $this->db->get_where('class', array('class_id' => $enroll->class_id))->row()->name;
				   $section_name= $this->db->get_where('section', array('section_id' => $enroll->section_id))->row()->name;	
				   $student_name = $student->name;
				   $school_id = $student->school_id;
					
                    ?>

                    <option value="parent-<?php echo $row['parent_id']; ?>">
                       <?php echo "Class: $class_name - Section: $section_name - Student: $student_name - Parent: ". $row['name']; ?></option>

                <?php endforeach; ?>
            </optgroup>
        </select>
    </div>


    <div class="compose-message-editor">
        <textarea row="5" class="form-control wysihtml5" data-stylesheet-url="assets/css/wysihtml5-color.css"
            name="message" placeholder="<?php echo get_phrase('write_your_message'); ?>"
            id="sample_wysiwyg" required></textarea>
    </div>

    <br>
    <!-- File adding module -->
    <div class="">
      <input type="file" class="form-control file2 inline btn btn-info" name="attached_file_on_messaging" accept=".pdf, .doc, .jpg, .jpeg, .png" data-label="<i class='entypo-upload'></i> Browse" />
    </div>
    <!-- end -->

    <hr>
    <button type="submit" class="btn btn-success pull-right">
        <?php echo get_phrase('send'); ?>
    </button>
</form>

</div>
