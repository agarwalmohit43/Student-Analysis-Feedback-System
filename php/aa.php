<?php
$class=$_POST['class'];
$subject=$_POST['subject'];
$qlevel=$_POST['qlevel'];


$category=$_POST['category'];
$category=json_decode("$category",true);
$category= implode(",",$category['category']);

$chapter=$_POST['chapter'];
$chapter=json_decode("$chapter",true);
$chapter= implode(",",$chapter['chapter']);

$qtype=$_POST['qtype'];
$qtype=json_decode("$qtype",true);
// $qtype= implode("''",$qtype['qtype']);


$long_Qs=$_POST['qslong'];
$short_Qs=$_POST['qsshort'];
$small_Qs=$_POST['qssmall'];

$sqlsmall="select question from question where qtype='Small' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$small_Qs;
echo $sqlsmall;
?>