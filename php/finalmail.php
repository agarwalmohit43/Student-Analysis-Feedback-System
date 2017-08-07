<?php
include ('config.php');
if ($_POST['action']=='question') {
    require ("fpdf181/fpdf.php");
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

        function SetDash($black=null, $white=null)
        {
            if($black!==null)
                $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
            else
                $s='[] 0 d';
            $this->_out($s);
        }
    }
    $sql2 ="select subject from subject  where sub_id=".$subject;
    $result2=$conn->query($sql2);
    $subject=$result2->fetch_assoc()['subject'];

    $sql3="select class from class where class_id=".$class;
    $result3=$conn->query($sql3);
    $class=$result3->fetch_assoc()['class'];
    $pdf=new testpdf();
    $pdf->setData($class,$subject);
    $pdf->AddPage();
    $pdf->SetFont("Arial","B",10);
    $pdf->Cell(0,5,'Time:3 Hours',0,1,'C');
    $pdf->Ln(1);
    $pdf->Cell(0,5,'Full Marks:100',0,0,'C');
    $pdf->Ln(10);
    // $pdf->SetDash();
    // $pdf->Line(20,55,190,55);

    $count=1;
    if($small_Qs!=0 && $short_Qs!=0 && $long_Qs!=0 )
    {
        $sqlsmall="select question from question where qtype='Small' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$small_Qs;
        $sqlshort="select question from question where qtype='Short' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$short_Qs;
        $sqllong="select question from question where qtype='Long' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$long_Qs;

        $resultsmall=$conn->query($sqlsmall);
        $resultshort=$conn->query($sqlshort);
        $resultlong=$conn->query($sqllong);

        if($resultsmall->num_rows>=1)
        {
            $pdf->Ln(5);
            $pdf->MultiCell(150,4,"Small Question" ,0,'L');
            // $pdf->SetDash();
            //$pdf->Line(20,55,190,55);
            foreach ($resultsmall as $row){
                $pdf->SetFont('Arial','',12);
                $pdf->Ln();

                foreach ($row as $questions){
                    $item="".$count."  ".$questions;
                    $pdf->MultiCell(150,4,$item ,0,'L');
                    $pdf->Ln();$count++;

                }
            }

        }
        if ($resultshort->num_rows>=1)
        {
            $pdf->Ln(5);
            $pdf->MultiCell(150,4,"Short Question" ,0,'L');
            // $pdf->SetDash();
            //$pdf->Line(20,55,190,55);
            foreach ($resultshort as $row){
                $pdf->SetFont('Arial','',12);
                $pdf->Ln();

                foreach ($row as $questions){
                    $item="".$count."  ".$questions;
                    $pdf->MultiCell(150,4,$item ,0,'L');
                    $pdf->Ln();$count++;

                }
            }
        }
        if ($resultlong->num_rows>=1)
        {
            $pdf->Ln(5);
            $pdf->MultiCell(150,4,"Long Question" ,0,'L');
            // $pdf->SetDash();
            //$pdf->Line(20,55,190,55);
            foreach ($resultlong as $row){
                $pdf->SetFont('Arial','',12);
                $pdf->Ln();

                foreach ($row as $questions){
                    $item="".$count."  ".$questions;
                    $pdf->MultiCell(150,4,$item ,0,'L');
                    $pdf->Ln();$count++;

                }
            }
        }


    }elseif ($small_Qs==0 || $short_Qs==0 || $long_Qs==0)
    {
        if ($small_Qs==0)
        {
            if($short_Qs!=0 && $long_Qs!=0)
            {
                $sqlshort="select question from question where qtype='Short' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$short_Qs;
                $sqllong="select question from question where qtype='Long' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$long_Qs;
                $resultshort=$conn->query($sqlshort);
                $resultlong=$conn->query($sqllong);
                if ($resultshort->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Short Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultshort as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }
                }
                if ($resultlong->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Long Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultlong as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }
                }
            }
            elseif ($short_Qs==0)
            {
                $sqllong="select question from question where qtype='Long' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$long_Qs;
                $resultlong=$conn->query($sqllong);
                if ($resultlong->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Long Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultlong as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }
                }
            }elseif ($long_Qs==0){
                $sqlshort="select question from question where qtype='Short' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$short_Qs;
                $resultshort=$conn->query($sqlshort);
                if ($resultshort->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Short Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultshort as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }
                }
            }

        }elseif ($short_Qs==0){
            if($small_Qs!=0 && $long_Qs!=0)
            {
                $sqlsmall="select question from question where qtype='Small' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$small_Qs;
                $sqllong="select question from question where qtype='Long' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$long_Qs;
                $resultsmall=$conn->query($sqlsmall);
                $resultlong=$conn->query($sqllong);
                if ($resultsmall->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Small Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultsmall as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }
                }
                if ($resultlong->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Long Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultlong as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }
                }
            }elseif ($small_Qs==0)
            {
                $sqllong="select question from question where qtype='Long' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$long_Qs;
                $resultlong=$conn->query($sqllong);
                if ($resultlong->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Long Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultlong as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }
                }
            }else{
                $sqlsmall="select question from question where qtype='Small' LIMIT ".$small_Qs;
                $resultsmall=$conn->query($sqlsmall);
                if ($resultsmall->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Small Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultsmall as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }
                }
            }
        }else{
            if($small_Qs!=0 && $short_Qs!=0){
                $sqlsmall="select question from question where qtype='Small' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$small_Qs;
                $sqlshort="select question from question where qtype='Short' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$short_Qs;
                $resultsmall=$conn->query($sqlsmall);
                $resultshort=$conn->query($sqlshort);
                if($resultsmall->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Small Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultsmall as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }

                }
                if ($resultshort->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Short Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultshort as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }
                }
            }elseif ($small_Qs==0){
                $sqlshort="select question from question where qtype='Short' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$short_Qs;
                $resultshort=$conn->query($sqlshort);
                if ($resultshort->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Short Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultshort as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }
                }
            }else{
                $sqlsmall="select question from question where qtype='Small' and qlevel='".$qlevel."' and cat_id in(".$category.") and ch_id in (".$chapter.") LIMIT ".$small_Qs;
                $resultsmall=$conn->query($sqlsmall);
                if ($resultsmall->num_rows>=1)
                {
                    $pdf->Ln(5);
                    $pdf->MultiCell(150,4,"Small Question" ,0,'L');
                    // $pdf->SetDash();
                    //$pdf->Line(20,55,190,55);
                    foreach ($resultsmall as $row){
                        $pdf->SetFont('Arial','',12);
                        $pdf->Ln();

                        foreach ($row as $questions){
                            $item="".$count."  ".$questions;
                            $pdf->MultiCell(150,4,$item ,0,'L');
                            $pdf->Ln();$count++;

                        }
                    }
                }
            }
        }

    }else{
        echo "Enter the no. of question";
    }
    $filename="../ques/class_".$class."_".$subject."_paper.pdf";
    $pdf->Output($filename,'F');
    $to = "007amarpandey@gmail.com";
    $from = "safsinfo@digicubesolution.com";
    $subject = "Question Paper Of class: ".$class." Subject: ".$subject;
    $message = "<p>Please see the attachment.</p>";

// a random hash will be necessary to send mixed content
    $separator = md5(time());

// carriage return type (we use a PHP end of line constant)
    $eol = PHP_EOL;

    // encode data (puts attachment in proper format)
    $pdfdoc = $pdf->Output("", "S");
    $attachment = chunk_split(base64_encode($pdfdoc));

// main header
    $headers  = "From: ".$from.$eol;
    $headers .= "MIME-Version: 1.0".$eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

// no more headers after this, we start the body! //

    $body = "--".$separator.$eol;
    $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
    $body .= "This is a MIME encoded message.".$eol;

// message
    $body .= "--".$separator.$eol;
    $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
    $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
    $body .= $message.$eol;

// attachment
    $body .= "--".$separator.$eol;
    $body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
    $body .= "Content-Transfer-Encoding: base64".$eol;
    $body .= "Content-Disposition: attachment".$eol.$eol;
    $body .= $attachment.$eol;
    $body .= "--".$separator."--";

// send message
    mail($to, $subject, $body, $headers);
    echo "File Created and mailed";


}
?>


