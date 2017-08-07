<?php
include "php/session.php";
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

    <ul id="nav-mobile" class="right hide-on-med-and-down ">
        <li><div class="chip">
                <img class="responsive-img" src="images/admin.png" alt="User">
                <?php echo $_SESSION['uname']?>
            </div>
        </li>
        <li><a class="waves-effect waves-light btn modal-trigger" href="logout.php" >Log-out</a></li>
        <!--href="#signin"-->
    </ul>

    <button data-activates="slide-out" class="button-collapse mohit waves-effect"  ><i class="material-icons material-spec-icon">menu</i></button>
    <ul id="slide-out" class="side-nav">
        <li><img  src="images/admin.png" /></li>

        <li><a class="waves-effect waves-light btn " href="addquestion.php">Add Questions</a></li>
        <li><a class="waves-effect waves-light btn " href="makequestionpaper.php" >Make Question Paper</a></li>
    </ul>

</nav>

<div class="row" style="margin-left: 430px;margin-top: 100px">
    <div class="input-field col 6">
        <select id="classes">
            <option value=""  selected>Choose your class</option>
            <option value="1">Option 1</option>
            <option value="2">Option 2</option>
            <option value="3">Option 3</option>
        </select>
        <label>Select Class</label>
    </div>

    <div class="input-field col 6">
        <select id="subjects">
            <option value=""  selected>Choose your option</option>
            <option value="1">Option 1</option>
            <option value="2">Option 2</option>
            <option value="3">Option 3</option>
        </select>
        <label>Select Subject</label>
    </div>


</div>

<div class="row" style="margin-left: 200px;margin-top: 50px">
    <button type="button"  class="waves-effect waves-light btn " id="category_wise">Category Wise</button>
    <button type="button" class="waves-effect waves-light btn " id="chapter_wise" style="margin-left: 50px">Chapter Wise</button>
    <button type="button" class="waves-effect waves-light btn " id="qtype_wise" style="margin-left: 50px">Qtype Wise</button>
    <button type="button" class="waves-effect waves-light btn " id="qlevel_wise" style="margin-left: 50px">Qlevel Wise</button>

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
                    alert(data);
                    data = JSON.parse(data);
                    data.forEach(function(data,index){

                        $('#classes').append("<option value="+data.class_id+">"+data.class+"</option>")

                    });
                    $('select').material_select();
                    $('#subjects,#category_wise,#chapter_wise,#qtype_wise,#qlevel_wise').prop('disabled', 'disabled');
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

    $('#subjects').change(function (e) {
        $('#category_wise,#chapter_wise,#qtype_wise,#qlevel_wise').prop('disabled', false);
        $('select').material_select();
    });
    $('#category_wise').click(function(e) {
        var class_id=$('#classes').val();
        var subject=$('#subjects').val();
        window.location.href="paperanalysis/categorywise.php?classid="+class_id+"&subid="+subject;
    });

    $('#chapter_wise').click(function(e) {
        var class_id=$('#classes').val();
        var subject=$('#subjects').val();
        window.location.href="paperanalysis/chapterwise.php?classid="+class_id+"&subid="+subject;
    });

    $('#qtype_wise').click(function(e) {
        var class_id=$('#classes').val();
        var subject=$('#subjects').val();
        window.location.href="paperanalysis/qtype.php?classid="+class_id+"&subid="+subject;
    });

    $('#qlevel_wise').click(function(e) {
        var class_id=$('#classes').val();
        var subject=$('#subjects').val();
        window.location.href="paperanalysis/qlevel.php?classid="+class_id+"&subid="+subject;
    });




</script>
</body>
</html>
