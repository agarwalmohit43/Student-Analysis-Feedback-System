<?php
include_once('config.php');

if(isset($_POST['action']))
{
    if($_POST['action'] == "class")
    {
        $sql = "SELECT * FROM class";
        $result = $conn->query($sql);

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
    }elseif ($_POST['action']=='subjects')
    {

        $sql = "select * from subject where class_id='".$_POST['class']."'";

        $result = $conn->query($sql);

        if ($result->num_rows>0)
        {

            // output data of each row
            $data = [];
            while($row = $result->fetch_assoc())
            {
                array_push($data, $row);
            }
            echo json_encode($data);
        } else
        {
            echo "0 results";
        }
    }elseif ($_POST['action']=='chapters')
    {

        $sql = "select * from chapter where sub_id='".$_POST['subject']."'";

        $result = $conn->query($sql);

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

    }elseif ($_POST['action']=='categories')
    {

        $sql = "select * from category where sub_id='".$_POST['subject']."'";

        $result = $conn->query($sql);

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

    }elseif ($_POST['action']=='question')
    {

        $sql="SELECT question FROM question where qtype ='".$_POST['qtype']."' and qlevel='".$_POST['qlevel']."' and cat_id in (".$_POST['category'].") and ch_id in(".$_POST['chapter'].");";
           echo $sql;

    }
}else{
    echo "Invalid page";
}

?>