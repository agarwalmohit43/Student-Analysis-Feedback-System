<?php
include "php/session.php";
include "php/config.php";
/*$sqlcategory = "SELECT category.category,count(question.question) as total FROM question INNER JOIN category ON question.cat_id = category.category_id INNER JOIN subject ON category.sub_id=subject.sub_id INNER JOIN class ON subject.class_id=class.class_id WHERE subject.sub_id=7 AND class.class_id=4 group by question.cat_id;";
$sqlchapter="SELECT chapter.chapter,count(question.question) as total FROM question INNER JOIN chapter ON question.ch_id = chapter.chapter_id INNER JOIN subject ON chapter.sub_id=subject.sub_id INNER JOIN class ON subject.class_id=class.class_id WHERE subject.sub_id=7 AND class.class_id=4 group by question.ch_id;";

$resultcategory = $conn->query($sqlcategory);
$resultchapter = $conn->query($sqlchapter);
if($resultcategory->num_rows>=1){

    */?><!--

    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Total'],
                <?php
/*                while( $row = $resultcategory->fetch_assoc() ){
                    extract($row);
                    echo "['{$category}', {$total}],";
                }
                */?>

            ]);

            var options = {

                title: 'Category',
                is3D: true,height: 500
                ,width: 500
            };

            var chart = new google.visualization.PieChart(document.getElementById('category_Piechart'));
            chart.draw(data, options);
        }
    </script>
    <?php
/*
}else{
    echo "<strong>"."<font size='50'>"."<center>"."No Records Found"."</center>"."</font>"."</strong>";
}
if($resultchapter->num_rows>=1){

    */?>

    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Chapter', 'Total'],
                <?php
/*                while( $row = $resultchapter->fetch_assoc() ){
                    extract($row);
                    echo "['{$chapter}', {$total}],";
                }
                */?>

            ]);

            var options = {

                title: 'Category',
                is3D: true,height: 500
                ,width: 500
            };

            var chart = new google.visualization.PieChart(document.getElementById('chapter_Piechart'));
            chart.draw(data, options);
        }
    </script>
    --><?php
/*
}else{
    echo "<strong>"."<font size='50'>"."<center>"."No Records Found"."</center>"."</font>"."</strong>";
}*/
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/materialize.min.css">
    <link href="css/icon.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/loader.js"></script>
    <style>.mohit{background: transparent center center no-repeat;
            background-size: 24px 24px;
            border: 0;
            display: block;
            height: 48px;
            overflow: hidden;
            top: 8px;
            width: 48px;
            z-index: 2;
            position: fixed;}</style>
</head>
<body>
<nav>

    <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><div class="chip">
                <img class="responsive-img" src="2.jpg" alt="User">
                <?php echo $_SESSION['uname']?>
            </div>
        </li>
        <li><a class="waves-effect waves-light btn modal-trigger" href="logout.php" >Log-out</a></li>
        <!--href="#signin"-->
    </ul>

    <button data-activates="slide-out" class="button-collapse mohit waves-effect"  ><i class="material-icons material-spec-icon">menu</i></button>
    <ul id="slide-out" class="side-nav">
        <li><img  src="2.jpg" /></li>

        <li><a class="waves-effect waves-light btn " href="addquestion.php">Add Questions</a></li>
        <li><a class="waves-effect waves-light btn " href="makequestionpaper.php" >Make Question Paper</a></li>
    </ul>

</nav>

    <div class="row">
        <div class="input-field col 3">
            <select id="classes">
                <option value=""  selected>Choose your class</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
            </select>
            <label>Select Class</label>
        </div>

        <div class="input-field col 3">
            <select id="subjects">
                <option value=""  selected>Choose your option</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
            </select>
            <label>Select Subject</label>
        </div>


    </div>

<div class="row">
    <button type="button"  id="category_wise">Category Wise</button>
    <button type="button" id="Chapter_wise">Chapter Wise</button>
    <button type="button" id="qtype_wise">Qtype Wise</button>

</div>


<script type="text/javascript">
    $(document).ready(function (e) {

        $(".button-collapse").sideNav();
        $('select').material_select();
        $("#classes").empty().html(' ');
        var data={action:"class"}
        $.ajax({
            type:"POST",
            url:"php/addquestions.php",
            data:data,
            success: function(data){

                if(data){

                    data = JSON.parse(data);
                    data.forEach(function(data,index){
                        $('#classes').append("<option value="+data.class_id+">"+data.class+"</option>")

                    });
                    $('select').material_select();
                    $('#subjects,#categories,#chapters,#qtype,#qlevel').prop('disabled', 'disabled');
                    $('select').material_select();

                }
            }
        });
    })

    $('#classes').change(function (e) {
        var data={
            action:"subjects",
            class:$('#classes').val()
        }
        $('#subjects option').remove();
        $('#subjects').prop('disabled', false);
        $('select').material_select();


        $.ajax({
            type: "POST",
            url:"php/addquestions.php",
            data:data,
            success: function(data){
                if(data){
                    $('#subjects').append("<option value='' selected>Select Subject</option>");

                    data = JSON.parse(data);
                    data.forEach(function(data,index){
                        $('#subjects').append("<option value="+data.sub_id+">"+data.subject+"</option>")

                    });
                    $('select').material_select();
                }
            }
        });

    });

   $('#category_wise').click(function(e) {
       var class_id=$('#classes').val();
       var subject=$('#subjects').val();



       window.location.href="paperanalysis/categorywise.php?classid="+class_id+"&subid="+subject;
   });






</script>
</body>
</html>
