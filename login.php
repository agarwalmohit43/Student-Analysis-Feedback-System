<?php session_start();
$conn=new mysqli("localhost","root","loverboy43","safs");
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}
if(isset($_POST['action'])){
    if($_POST['action'] == "login"){
        $sql="select * from user where username='".$_POST['Username']."' and password='".md5($_POST['Password'])."';";
        $result=$conn->query($sql);
        $row=$result->fetch_array();
        if($result->num_rows>=1){
            if($row['username']=="agarwalmohit43"){
                $_SESSION['loggedin'] = $row['user_id'];
                $_SESSION['uname']=$row['username'];
            }else{
                $_SESSION['loggedin'] = $row['user_id'];
                $_SESSION['uname']=$row['username'];
                $_SESSION['class_Id']=$row['classid'];
                $_SESSION['Sub_Id']=$row['subid'];
            }
            echo "<script>window.location.href='index.php'</script>";
        }else{
            echo "<script>alert('Enter Correct Username And Passoword');</script>";
        }
    }

}


?>

<!--<div id="tabs-1">
    <form action="" method="post">
        <p><input id="uname" name="uname" type="text" placeholder="Username"></p>
        <p><input id="password" name="password" type="password" placeholder="Password">
            <input name="action" type="hidden" value="login" /></p>
        <p><input type="submit" value="Login" /></p>
    </form>
</div>
-->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link rel="stylesheet" href="login.css"/>

    <script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="card"></div>
    <div class="card">
        <h1 class="title">Login SAFS</h1>
        <form action="" method="post" id="signin">
            <div class="input-container">
                <input type="text" id="Username" name="Username" required="required"/>
                <label for="Username">Username</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input type="password" id="Password" name="Password" required="required"/>
                <label for="Password">Password</label>
                <div class="bar"></div>
            </div>
            <input name="action" type="hidden" value="login" /></p>
            <div class="button-container">
                <button><span>Login</span></button>
            </div>
            <!--<div class="footer"><a href="#">Forgot your password?</a></div>-->
        </form>
    </div>
    <div class="card alt">
        <div class="toggle"></div>
        <h1 class="title">Register
            <div class="close"></div>
        </h1>
        <form>
            <div class="input-container">
                <input type="text" id="Usernamesup" required="required"/>
                <label for="Username">Username</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input type="password" id="Passwordsup" required="required"/>
                <label for="Password">Password</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input type="password" id="Repeat Password" required="required"/>
                <label for="Repeat Password">Repeat Password</label>
                <div class="bar"></div>
            </div>
            <div class="button-container">
                <button><span>Next</span></button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    $('.toggle').on('click', function() {
        $('.container').stop().addClass('active');
    });

    $('.close').on('click', function() {
        $('.container').stop().removeClass('active');
    });
</script>
</body>
</html>