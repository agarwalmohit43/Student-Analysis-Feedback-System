<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Question Level Wise</title>
</head>

<body style="font-family: Arial;border: 0 none;">
<!-- where the chart will be rendered -->
<div id="visualization" ></div>

<?php
include 'config.php';
$sqlqlevel= "SELECT question.qlevel ,count(question.question) as total FROM question INNER JOIN category ON question.cat_id = category.category_id INNER JOIN subject ON category.sub_id=subject.sub_id INNER JOIN class ON subject.class_id=class.class_id WHERE subject.sub_id=".$_GET['subid']." AND class.class_id=".$_GET['classid']." group by question.qlevel";
$result = $conn->query($sqlqlevel);


if( $result->num_rows > 0){

    ?>
    <!-- load api -->
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>

    <script type="text/javascript">
        //load package
        google.load('visualization', '1', {packages: ['corechart']});
    </script>

    <script type="text/javascript">
        function drawVisualization() {
            // Create and populate the data table.
            var data = google.visualization.arrayToDataTable([
                ['qlevel', 'Total'],
                <?php
                while( $row = $result->fetch_assoc() ){
                    extract($row);
                    echo "['{$qlevel}', {$total}],";
                }
                ?>
            ]);

            var options = {

                title: 'Question Level',
                is3D: true,height: 600
                ,width: 600
            };
            // Create and draw the visualization.
            new google.visualization.PieChart(document.getElementById('visualization')).
            draw(data, options);
        }

        google.setOnLoadCallback(drawVisualization);
    </script>
    <?php

}else{
    echo "No Record Found.";
}
?>

</body>
</html>