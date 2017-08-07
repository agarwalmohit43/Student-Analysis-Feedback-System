<?php
?>

<html lang="en">
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
        <li><a class="waves-effect waves-light btn modal-trigger" onclick="logout();logoutnav();" >Log-out</a></li>
        <!--href="#signin"-->
    </ul>

    <button data-activates="slide-out" class="button-collapse mohit waves-effect"  ><i class="material-icons material-spec-icon">menu</i></button>
    <ul id="slide-out" class="side-nav">
        <li><img  src="2.jpg" /></li>

        <li><a href="#">Add Questions</a></li>
        <li><a href="#">Make Question Paper</a></li>
    </ul>

</nav>

<script type="text/javascript">
    $(document).ready(function (e) {

            $(".button-collapse").sideNav();
    })

</script>
</body>
</html>
