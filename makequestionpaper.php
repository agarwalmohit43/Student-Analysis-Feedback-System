<?php
include "php/session.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Make Question Paper</title>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import jQuery before materialize.js-->
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
    <form id="makequestionpaper">
        <div class="container" style="margin-left: 200px;margin-top: 80px;">

            <div class="row">
                <div class="input-field col 2">
                    <select id="classes" name="class" >
                        <option value=""  selected>Choose your option</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <label>Select Class</label>
                </div>
                <div class="input-field col 2">
                    <select id="subjects" name="subject" >
                        <option value=""  selected>Choose your option</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <label>Select Subject</label>
                </div>
                <div class="input-field col 2">
                    <select id="chapters" multiple="multiple" name="chapters" >
                        <option value=""  selected>Choose your option</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <label>Select Chapter</label>
                </div>
                <div class="input-field col 2">
                    <select id="categories" multiple="multiple" name="category" >
                        <option value=""  selected>Choose your option</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <label>Select Category</label>
                </div>
                <div class="input-field col 2">
                    <select id="qlevel" name="qlevel" >
                        <option value="Hard">Hard</option>
                        <option value="Medium">Medium</option>
                        <option value="Easy">Easy</option>
                    </select>
                    <label>Select Level</label>
                </div>
            </div>


        </div>
        <div class="row" style="margin-top: 50px">
            <input type="number"  placeholder="Enter the No. of Long Qs" min="0" max="20" style="visibility: visible;width: 200px" id="qslong">
            <input type="number" placeholder="Enter the No. of Short Qs" min="0" max="20" style="visibility: visible;width: 200px" id="qsshort">
            <input type="number" placeholder="Enter the No. of Small Qs" min="0" max="20" style="visibility: visible;width: 200px" id="qssmall">

        </div>
        <div class="row" style="margin-left: 380px;margin-top:50px">
            <div class="input-field col 4">
                <input type="email" placeholder="enter email Id" style="visibility: visible;width: 250px" id="emailto">

            </div>
            <div class="input-field col 4">
                <input type="number"  placeholder="Enter the marks" min="0" max="20" style="visibility: visible;width: 200px" id="marks">
            </div>
            <div class="input-field col 4">
                <input type="number" placeholder="hr" min="0" max="3" style="visibility: visible;width: 40px" id="hours">
                <input type="number" placeholder="min" min="0" max="60" style="visibility: visible;width: 40px" id="minute">

            </div>
        </div>


        <div class="row" >
            <a href="javascript:$('#makequestionpaper').submit();" class="waves-effect waves-light btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="*Note: All details need to be filled" type="Submit">Submit</a>
        </div>
    </form>
</center>

<br/>
<div id="pp"></div>


<!--Javascript Files-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript"></script>


<script type="text/javascript">

    /* function  logout() {

     }

     function  logoutnav() {

     }
     */

    $(document).ready(function (e) {
        $(".button-collapse").sideNav();
        $('.tooltipped').tooltip({delay: 50});
        $('select').material_select();
        $('#classes option').remove();

        var data={action:"class"}
        $.ajax({
            type:"POST",
            url:"php/makequestionpapers.php",
            data:data,
            success: function(data){
                if(data){
                    data = JSON.parse(data);
                    data.forEach(function(data,index){
                        $('#classes').append("<option value="+data.class_id+">"+data.class+"</option>")

                    });
                    $('#subjects,#categories,#chapters,#qssmall,#qsshort,#qslong,#marks,#emailto,#hours,#minute,#qlevel').prop('disabled', 'disabled');
                    $('select').material_select();
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
            url:"php/makequestionpapers.php",
            data:data,
            success: function(data){
                if(data){

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
        $('#categories,#qlevel').prop('disabled', false);
        $('select').material_select();
        $.ajax({
            type: "POST",
            url:"php/makequestionpapers.php",
            data:data,
            success: function(data){
                if(data){
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
            url:"php/makequestionpapers.php",
            data:data,
            success: function(data){
                if(data){
                    data = JSON.parse(data);
                    data.forEach(function(data,index){
                        $('#chapters').append("<option value="+data.chapter_id+">"+data.chapter+"</option>")

                    });
                    $('select').material_select();
                }

            }
        });

    });
    $('#qlevel').change(function (e) {
        $('#qslong,#qsshort,#qssmall,#emailto,#marks,#hours,#minute').prop('disabled', false);
        $('select').material_select();
    })

    $(document).ready(function(e) {
        $('#makequestionpaper').on('submit',makequestionpaper);
    });


    function makequestionpaper(e) {
        e.preventDefault();
        var ob1={ chapter:$('#chapters').val()};
        var ob2={ category:$('#categories').val()};
        var ob3={ qtype:$('#qtype').val()};
        //var ob4={ qlevel:$('#qlevel').val()};

        var chapter=JSON.stringify(ob1);
        var category=JSON.stringify(ob2);
        var qtype=JSON.stringify(ob3);
        //var qlevel=JSON.stringify(ob4);
        var qslong=$('#qslong').val();
        var qsshort=$('#qsshort').val();
        var qssmall=$('#qssmall').val();

        if(qslong || qsshort|| qssmall){

            var data=
            {
                action:"question",
                qtype:qtype,
                category:category,
                chapter:chapter,
                qlevel:$('#qlevel').val(),
                subject:$('#subjects').val(),
                class:$('#classes').val(),
                qslong:qslong,
                qsshort:qsshort,
                qssmall:qssmall,
                marks:$('#marks').val(),
                hours:$('#hours').val(),
                minutes:$('#minute').val(),
                emailto:$('#emailto').val()
            }

            $.ajax({
                type: "POST",
                url:"php/mohit.php",
                data:data,
                success: function(data){
                    alert("Question paper created successfully at: "+data);            }
            });

        }else {
            alert("Please Enter the No. of question To be entered");
        }



    }
</script>
</body>
</body>
</html>
