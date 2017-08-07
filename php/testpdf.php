<?php
include ('config.php');
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

     $qtype=$_POST['qtype'];
       $qtype=json_decode("$qtype",true);
      // $qtype= implode("''",$qtype['qtype']);


    $long_Qs=$_POST['qslong'];
    $short_Qs=$_POST['qsshort'];
    $small_Qs=$_POST['qssmall'];

    if($small_Qs!=0 && $short_Qs!=0 && $long_Qs!=0 ){


    }

    class testpdf extends FPDF{
        public $class;public $subject;
        public function setData($class="8",$subject="Computer"){
            $this->class =$class;
            $this->subject=$subject;
        }


        function Header()
        {
            // Logo
            // $this->Image('2.jpg',10,6,30);
            // Arial bold 15
            $this->SetFont('Arial','B',15);
            // Move to the right
            $this->Cell(80);
            // Title
            $this->MultiCell(45,10,'Class: '.$this->class."\n".'Subject: '.$this->subject,0,'C');

            // Line break
            $this->Ln(10);
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

    $sql="(select question from question where qtype='Small' LIMIT ".$small_Qs.") union (select question from question where qtype='Short' LIMIT ".$short_Qs.") union (select question from question where qtype='Long' LIMIT ".$long_Qs.") ";
    $result=$conn->query($sql);

    $sql2 ="select subject from subject  where sub_id=".$subject;
    $result2=$conn->query($sql2);
    $subject=$result2->fetch_assoc()['subject'];

    $sql3="select class from class where class_id=".$class;
    $result3=$conn->query($sql3);
    $class=$result3->fetch_assoc()['class'];

    if($result->num_rows>=1){
        $pdf=new testpdf();
        $pdf->setData($class,$subject);
        $pdf->AddPage();
        $pdf->SetFont("Arial","B",10);

        $pdf->Cell(0,5,'Time:3 Hours',0,1,'C');
        $pdf->Ln(1);
        $pdf->Cell(0,5,'Full Marks:100',0,0,'C');
        $pdf->Ln(10);
        /* foreach($result2 as $row2) {
             $pdf->SetFont('Arial','',12);
             $pdf->Ln();
             foreach($row2 as $column)
                 $pdf->Cell(15,12,$column,1,0,'C');
         }*/
        $count=1;
        foreach ($result as $row){
            $pdf->SetFont('Arial','',12);
            $pdf->Ln();

            foreach ($row as $questions){
                $item="".$count."  ".$questions;
                $pdf->MultiCell(150,4,$item ,0,'L');
                $pdf->Ln();$count++;

            }
        }


        $rand=rand(1,10000);
        $filename="../ques/class_".$class."_".$subject."_paper.pdf";
        $pdf->Output($filename,'F');
        echo $filename;
    }else{
        echo "Invalid";}
}
?>


