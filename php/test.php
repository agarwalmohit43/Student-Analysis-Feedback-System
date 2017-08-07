<?php
include 'config.php';
if ($_POST['action']=='question') {
    require ("fpdf181/fpdf.php");
    $class=$_POST['class'];
    $subject=$_POST['subject'];
    $category=$_POST['category'];
    $category=json_decode("$category",true);
    $category= implode(",",$category['category']);

    $chapter=$_POST['chapter'];
    $chapter=json_decode("$chapter",true);
    $chapter= implode(",",$chapter['chapter']);

 /*   $qtype=$_POST['qtype'];
    $qtype=json_decode("$qtype",true);
    $qtype= implode("''",$qtype['qtype']);



    $qlevel=$_POST['qlevel'];
    $qlevel=json_decode("$qlevel",true);
    $qlevel= implode("''",$qlevel['qlevel']);*/

    class test extends FPDF{
        function Header()
        {
            // Logo
            // $this->Image('2.jpg',10,6,30);
            // Arial bold 15
            $this->SetFont('Arial','B',15);
            // Move to the right
            $this->Cell(80);
            // Title
            $this->Cell(30,10,'Java',1,1,'C');
            // Line break
            $this->Ln(20);
        }
        function Footer()
        {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Page number
            $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
        }

    }
   // $sql="SELECT question FROM question where qtype='".$_POST['qtype']."' and qlevel='".$_POST['qlevel']."' and cat_id in (".$category.") and ch_id in (".$chapter.");";
    $sql="SELECT question FROM question where qtype in ('Long') and qlevel='Hard' and cat_id in (1,2,3,4) and ch_id in(1,2,3,4,5);";
    //$sql2="SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='safs' AND `TABLE_NAME`='question';";
    $result=$conn->query($sql);
   // $result2=$conn->query($sql2);
    if($result->num_rows>=1){
        $pdf=new test();
        $pdf->AddPage();
        $pdf->SetFont("Arial","B",10);
        $pdf->Cell(0,10,"question",1,1);
       /* foreach($result2 as $row2) {
            $pdf->SetFont('Arial','',12);
            $pdf->Ln();
            foreach($row2 as $column)
                $pdf->Cell(15,12,$column,1,0,'C');
        }*/
        foreach ($result as $row){
            $pdf->SetFont('Arial','',12);
            $pdf->Ln();
            foreach ($row as $questions){

                $pdf->Cell(150,8,$questions,1,'','L');

            }
        }


        $rand=rand(1,10000);
        $filename="C:/xampp/htdocs/ssafs/dashboard/php/fpdf181/class_".$class."_".$subject."paper".$rand.".pdf";
        $pdf->Output($filename,'F');
        echo $filename;
    }else{
        echo "Invalid";
    }


}


?>