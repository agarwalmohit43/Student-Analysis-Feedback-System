<?php
include "php/session.php";
?>


<html>
<head>
    <meta charset="UTF-8">
    <title>Add Question</title>
    <link rel="stylesheet" href="css/materialize.min.css">
    <link href="css/icon.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/materialize.min.js"></script>
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
        <li><a class="waves-effect waves-light btn " href="logout.php" >Log-out</a></li>
    </ul>

    <button data-activates="slide-out" class="button-collapse mohit waves-effect"  ><i class="material-icons material-spec-icon">menu</i></button>
    <ul id="slide-out" class="side-nav">
        <li><img  src="2.jpg" /></li>

        <li><a class="waves-effect waves-light btn " href="addquestion.php">Add Questions</a></li>
        <li><a class="waves-effect waves-light btn " href="makequestionpaper.php" >Make Question Paper</a></li>
        <li><a class="waves-effect waves-light btn " href="index.php" >Question Paper Analysis</a></li>
    </ul>

</nav>
<center>
    <form id="addquestion">

            <div class="row" style="margin-left: 300px">
                <div class="input-field col s6">
                    <i class="material-icons prefix">mode_edit</i>
                    <textarea id="icon_prefix2" class="materialize-textarea"></textarea>
                    <label for="icon_prefix2">Write Your Question?</label>

                </div>
            </div>


        <div class="row" style="margin-left: 100px">
            <div class="input-field col 3">
                <select id="classes">
                    <option value=""  selected>Choose your option</option>
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

            <div class="input-field col 3">
                <select id="chapters">
                    <option value=""  selected>Choose your option</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                </select>
                <label>Select Chapter</label>
            </div>

            <div class="input-field col 3">
                <select id="categories">
                    <option value=""  selected>Choose your option</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                </select>
                <label>Select Category</label>
            </div>

            <div class="input-field col 3">
                <select id="qtype">
                    <option value=""  selected>Choose your option</option>
                    <option value="Long">Long</option>
                    <option value="Short">Short</option>
                    <option value="Small">Small</option>
                </select>
                <label>Select Type</label>
            </div>

            <div class="input-field col 3">
                <select id="qlevel">
                    <option value=""  selected>Choose your option</option>
                    <option value="Hard">Hard</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
                <label>Select Level</label>
            </div>
        </div>
        <div class="row" >
            <a href="javascript:$('#addquestion').submit();" class="waves-effect waves-light btn" type="Submit">Submit</a>

        </div>

    </form>
</center>

<br/>

<script type="text/javascript">


    $(document).ready(function (e) {
        $(".button-collapse").sideNav();
        $('select').material_select();
        $('.tooltipped').tooltip({delay: 50});
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


    });

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
        var data={
            action:"categories",
            subject:$('#subjects').val()
        }
        $('#categories option').remove();


        $.ajax({
            type: "POST",
            url:"php/addquestions.php",
            data:data,
            success: function(data){
                if(data){
                    $('#categories').append("<option value='' selected>Select Category</option>");

                    data = JSON.parse(data);
                    data.forEach(function(data,index){
                        $('#categories').append("<option value="+data.category_id+">"+data.category+"</option>")

                    });
                    $('select').material_select();
                }
            }
        });

    });

    $('#subjects').change(function (e) {
        var data={
            action:"chapters",
            subject:$('#subjects').val()
        }
        $('#chapters option').remove();
        $('#chapters').prop('disabled', false);
        $('select').material_select();
        $.ajax({
            type: "POST",
            url:"php/addquestions.php",
            data:data,
            success: function(data){
                if(data){
                    $('#chapters').append("<option value='' selected>Select Chapter</option>");

                    data = JSON.parse(data);
                    data.forEach(function(data,index){
                        $('#chapters').append("<option value="+data.chapter_id+">"+data.chapter+"</option>")

                    });
                    $('select').material_select();

                }
            }
        });

    });
    $('#chapters').change(function (e) {
        $('#categories').prop('disabled', false);
        $('select').material_select();
    })

    $('#categories').change(function (e) {
        $('#qtype').prop('disabled', false);
        $('select').material_select();
    })

    $('#qtype').change(function (e) {
        $('#qlevel').prop('disabled', false);
        $('select').material_select();
    })

    $(document).ready(function(e) {
        $('#addquestion').on('submit',addquestion);
    });

    function addquestion(e) {
        e.preventDefault();
        if(!$('#icon_prefix2').val() || !$('#qtype').val() || !$('#categories').val() || !$('#chapters').val() || !$('#qlevel').val())
        {
            Materialize.toast("Please Select All option", 3000, 'rounded');
        }else {
            var data=
            {
                action:"question",
                question:$('#icon_prefix2').val(),
                qtype:$('#qtype').val(),
                category:$('#categories').val(),
                chapter:$('#chapters').val(),
                qlevel:$('#qlevel').val()
            }
            $.ajax({
                type: "POST",
                url:"php/addquestions.php",
                data:data,
                success: function(data){

                    Materialize.toast(data, 3000, 'rounded');
                }
            });
        }

    }
</script>
</body>
</html>


