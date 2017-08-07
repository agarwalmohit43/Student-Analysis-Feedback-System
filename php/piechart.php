<?php
include "config.php";
if(isset($_POST['action'])){
    $class_id=$_POST['class'];
    $subject_Id=$_POST['subject'];
    $sqlcategory = "SELECT category.category,count(question.question) as total FROM question INNER JOIN category ON question.cat_id = category.category_id INNER JOIN subject ON category.sub_id=subject.sub_id INNER JOIN class ON subject.class_id=class.class_id WHERE subject.sub_id=7 AND class.class_id=4 group by question.cat_id;";
    $result=$conn->query($sqlcategory);
    if ($result->num_rows>0) {

        // output data of each row
        $data = [];
        while($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        echo json_encode($data);
    } else {
        echo "0 results";
    }
}
 ?>