<?php
    include_once "../connections/connection.php";
    include_once "../fpdf/fpdf.php";
    $conn = connection();
    ob_start();
    error_reporting(-1);
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    ini_set('memory_limit', '128M');
    ini_set('max_execution_time', 300);

    class myPDF extends FPDF {
        function header() {
            $conn = connection();
            $studNo = $_GET['studNo'];

            $this->Image('../images/ucc_logo.png', 15, 7, 22.5, 25);
            $this->Image('../images/csd.png', 170, 7, 30, 20);
            $this->SetFont('Arial', 'B', 20);
            $this->Cell(0, 5, 'University of Caloocan City', 0, 0, 'C');
            $this->Ln();
            $this->SetFont('Times', '', 12);
            $this->Cell(0, 5, 'Biglang Awa St., 12 Avenue East, Caloocan City', 0, 0, 'C');
            $this->Ln();
            $this->SetFont('Times', 'BI', 12);
            $this->Cell(0, 5, 'COMPUTER STUDIES DEPARTMENT', 0, 0, 'C');
            $this->Ln(9);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 5, 'STUDENT SUMMARY OF GRADES', 0, 0, 'C');

            $this->SetXY(10, 39);
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(0, 5, 'NAME:', 0, 0, '');

            $this->SetXY(10, 44);
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(0, 5, 'COURSE:', 0, 0, '');

            $this->SetXY(140, 39);
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(0, 5, 'STUDENT NUMBER:', 0, 0, '');
            
            $sql = "SELECT * FROM ems_student WHERE db_studNo = '$studNo'";
            $student = $conn->query($sql) or die($conn->error);
            $data = $student->fetch_assoc();

            $name = $data['db_Sname'].", ".$data['db_Fname']." ".$data['db_Mname'];

            $this->SetXY(25,39);
            $this->SetFont('Arial', '', 11);
            $this->Cell(0, 5, $name, 0, 0, '');

            $this->SetXY(30,44);
            $this->SetFont('Arial', '', 11);
            $this->Cell(0, 5, $data['db_course'], 0, 0, '');

            $this->SetXY(180,39);
            $this->SetFont('Arial', '', 11);
            $this->Cell(0, 5, $data['db_studNo'], 0, 0, '');
        }

        function displayGrades($conn) {
            $studNo = $_GET['studNo'];
            $years = $_GET['year'];
            $sems = $_GET['sem'];
            // $sems = '1ST';

            if ($sems=='ALL') {
                $year = $years;
                $sem = ['1ST', '2ND', 'SUMMER'];

                // $year = $years;
                // $sem = [$sems];
            } else {
                $year = $years;
                $sem = [$sems];
            }

            $xHeader = 0;
            $yHeader = 50;
            $xUnits = 130;
            $yUnits = 136;
            $xGrade = 142.5;
            $yGrade = 136;
            $x = 0;

            do {
                $sql = "SELECT * FROM ems_grades WHERE db_studNo = '$studNo' AND db_subYear = '$year' AND db_subSem = '$sem[$x]'";
                $yearSem = $conn->query($sql) or die($conn->error);
                $yearSemData = $yearSem->fetch_assoc();

                if ($yearSemData) {
                    //Header for Year
                    if ($x<1) {
                        $this->SetXY($xHeader, $yHeader - 2);
                        $this->SetFont('Arial', 'B', 12);
                        $this->Cell(0, 5, $year.' YEAR', 0, 0, 'C');
                        $this->SetXY($xHeader, $yHeader + 3);
                        $this->SetFont('Arial', 'B', 11);
                        $this->Cell(0, 5, 'S.Y. '.$yearSemData['db_subSyear'], 0, 0, 'C');
                    }

                    //Header for 1st Sem
                    $this->SetXY($xHeader, $yHeader + 10);
                    $this->SetFont('Arial', '', 12);
                    $this->Cell(0, 5, $sem[$x].' SEM', 0, 0, 'C');

                    //Header Display Grades for 1st Sem
                    $this->SetXY($xHeader + 50, $yHeader + 15);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(15, 7, 'CODE', 1, 0, 'C');
                    $this->Cell(60, 7, 'DESCRIPTION', 1, 0, 'C');
                    $this->Cell(15, 7, 'UNITS', 1, 0, 'C');
                    $this->Cell(15, 7, 'GRADE', 1, 0, 'C');
                    $this->Ln();
                }
                $line = 0;
                do {
                    if ($yearSemData) {
                        $this->SetFont('Arial', '', 8);
                        $this->SetXY($xHeader + 50, $yHeader + 22);
                        $this->Cell(15, 7, $yearSemData['db_subCode'], 1, 0, 'C');

                        $cellWidth = 57.5;
                        $fontSize = 8;
                        $tempFontSize = $fontSize;

                        while ($this->GetStringWidth($yearSemData['db_subDes']) >= $cellWidth) {
                            $this->SetFontSize($tempFontSize -= 0.1);
                        }
                        $this->Cell(60, 7, $yearSemData['db_subDes'], 1, 0, '');
                        
                        $this->SetFontSize($fontSize);
        
                        $this->Cell(15, 7, $yearSemData['db_subUnit'], 1, 0, 'C');
                        $this->Cell(15, 7, $yearSemData['db_subGrade'], 1, 0, 'C');
                        $this->Ln();
                        $yearSemData = $yearSem->fetch_assoc();
                    } else {
                        $this->SetXY($xHeader + 50, $yHeader + 22);
                        $this->Cell(15, 7, "", 1, 0, '');
                        $this->Cell(60, 7, "", 1, 0, '');
                        $this->Cell(15, 7, "", 1, 0, '');
                        $this->Cell(15, 7, "", 1, 0, '');
                        $this->Ln();
                    }
                    $yHeader += 7;
                    $line++;
                } while($yearSemData || $line < 9);

                //Display GWA for 1st SEM
                $sql = "SELECT * FROM ems_student WHERE db_studNo = '$studNo' AND db_year = '$year' AND db_sem = '$sem[$x]'";
                $grades = $conn->query($sql) or die($conn->error);
                $gradeData = $grades->fetch_assoc();

                if ($gradeData && $gradeData['db_gwa'] > 1) {
                    $this->SetXY($xUnits, $yUnits);
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(0, 5, $gradeData['db_units'], 0, 0, '');

                    $this->SetXY($xGrade, $yGrade);
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(0, 5, number_format($gradeData['db_gwa'], 2), 0, 0, '');
                }

                $yUnits += 88;
                $yGrade += 88;
                $x++;
                $yHeader += 25;
            } while ($x <= 1 && sizeof($sem)>1);
        }
    }

    $pdf = new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'Letter', 0);
    $pdf->displayGrades($conn);

    $studNo = $_GET['studNo'];
    $sql = "SELECT * FROM ems_student WHERE db_studNo = '$studNo'";
    $student = $conn->query($sql) or die($conn->error);
    $data = $student->fetch_assoc();

    $name = $data['db_Sname'].", ".$data['db_Fname']." ".$data['db_Mname'];

    $pdf->SetTitle($name);
    $pdf->Output('I', $name.'.pdf');
?>