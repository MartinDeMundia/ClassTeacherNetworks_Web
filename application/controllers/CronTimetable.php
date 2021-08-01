<?php
//error_reporting(0); 
class CronTimetable
{  
	
    function timetable(){
        $conn = mysqli_connect("apps.classteacher.school","appsuserclass",">UKn}6=MK[w^`P5B")or die(mysqli_error());
        mysqli_select_db($conn,"appsclassteacher");
        //get todays lessons and queue them under notifications
            $qryData = "
                SELECT 
                    t.day,
                    t.tslots,
                    t.venue,
                    s.name subject,
                    te.name teacher,
                    te.teacher_id
                FROM
                    timetable t
                        JOIN
                    subject s ON s.subject_id = t.subject
                        JOIN
                    teacher te ON te.teacher_id = t.teacher
                WHERE
                    (day) = DAYNAME(CURDATE())
                        AND t.year = '2020'
                        AND t.school = 34
                        AND t.term = 'Term 1'
                GROUP BY t.teacher
    		";        
        $timetable_data = mysqli_query($conn,$qryData)or die(mysqli_error($conn));
        mysqli_query($conn,"DELETE FROM notifications WHERE type_id = 1988;");  
        while($row = mysqli_fetch_assoc($timetable_data)) {            
            $sql = "INSERT INTO notifications (
                        `title`,
                        `content`,
                        `type`,
                        `type_id`,
                        `student_id`,
                        `receiver_id`,
                        `receiver_role`,
                        `is_read`,
                        `creator_id`,
                        `creator_role`,
                        `created_on`
                        )VALUES(
                        'Lesson for Tr. ".$row['teacher']."',
                        'Class [".$row['venue']."] ,".$row['subject']." at :".$row['tslots']."',
                        '0',
                        '1988',
                        '0',
                        '".$row['teacher_id']."',
                        '2',
                        '0',
                        '0',
                        '2',
                        '".date('Y-m-d H:i:s')."'
                        )";
            mysqli_query($conn,$sql);            
        }
        
    } 	
	
}

$cls = new CronTimetable();
$cls->timetable(); 

?>