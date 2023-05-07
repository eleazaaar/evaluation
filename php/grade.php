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
            $this->Cell(0, 5, utf8_decode($name), 0, 0, '');

            $this->SetXY(30,44);
            $this->SetFont('Arial', '', 11);
            $this->Cell(0, 5, $data['db_course'], 0, 0, '');

            $this->SetXY(180,39);
            $this->SetFont('Arial', '', 11);
            $this->Cell(0, 5, $data['db_studNo'], 0, 0, '');
        }

        function displayGrades($conn) {
            $studNo = $_GET['studNo'];
            $year = ['1ST', '2ND', '3RD', '4TH'];
            $sem = ['1ST', '2ND'];

            $year1sem1 = null;
            $year1sem2 = null;
            $year2sem1 = null;
            $year2sem2 = null;
            $year3sem1 = null;
            $year3sem2 = null;
            $year4sem1 = null;
            $year4sem2 = null;
            $arrayYearSem = [$year1sem1, $year1sem2, $year2sem1, $year2sem2, $year3sem1, $year3sem2, $year4sem1, $year4sem2];

            $xHeader = 0;
            $yHeader = 55;
            $xUnits = 80;
            $yUnits = 135;
            $xGrade = 93;
            $yGrade = 135;

            $i = 0; //incrementation for all
            $a = 0; //incrementation for index of year
            $b = 0; //incrementation for index of sem

            do {
                // if ($yHeader >= 240) {
                //     $this->AddPage('P', 'Letter', 0);
                //     $yHeader = 55;
                //     $yUnits = 135;
                //     $yGrade = 135;
                // }
                
                $sql = "SELECT * FROM ems_grades WHERE db_studNo = '$studNo' AND db_subYear = '3RD' AND db_subSem = '1ST'";
                $grades = $conn->query($sql) or die($conn->error);
                $nextData = $grades->fetch_assoc();

                if($year[$a] == '3RD' && $sem[$b] == '1ST' && $nextData != null) {
                    $this->AddPage('P', 'Letter', 0);
                    $yHeader = 55;
                    $yUnits = 135;
                    $yGrade = 135;
                }

                $sql = "SELECT * FROM ems_grades WHERE db_studNo = '$studNo' AND db_subYear = '$year[$a]' AND db_subSem = '$sem[$b]'";
                $arrayYearSem[$i] = $conn->query($sql) or die($conn->error);
                $allYearSemData = $arrayYearSem[$i]->fetch_assoc();

                if($allYearSemData) {
                    //Select all Grades for 1st Sem
                    $sql = "SELECT * FROM ems_grades WHERE db_studNo = '$studNo' AND db_subYear = '$year[$a]' AND db_subSem = '$sem[$b]'";
                    $arrayYearSem[$i] = $conn->query($sql) or die($conn->error);
                    $yearSemData = $arrayYearSem[$i]->fetch_assoc();

                    if ($yearSemData) {
                        //Header for Year
                        $this->SetXY($xHeader, $yHeader - 2);
                        $this->SetFont('Arial', 'B', 12);
                        $this->Cell(0, 5, $year[$a].' YEAR', 0, 0, 'C');
                        $this->SetXY($xHeader, $yHeader + 3);
                        $this->SetFont('Arial', 'B', 11);
                        $this->Cell(0, 5, 'S.Y. '.$yearSemData['db_subSyear'], 0, 0, 'C');

                        //Header for 1st Sem
                        $this->SetXY($xHeader + 35, $yHeader);
                        $this->SetFont('Arial', '', 12);
                        $this->Cell(20, 5, $sem[$b].' SEM', 0, 0, 'C');

                        //Header Display Grades for 1st Sem
                        $this->SetXY($xHeader + 10, $yHeader + 10);
                        $this->SetFont('Arial', 'B', 10);
                        $this->Cell(15, 7, 'CODE', 1, 0, 'C');
                        $this->Cell(50, 7, 'DESCRIPTION', 1, 0, 'C');
                        $this->Cell(15, 7, 'UNITS', 1, 0, 'C');
                        $this->Cell(15, 7, 'GRADE', 1, 0, 'C');
                        $this->Ln();
                        
                        //Display Table for Grades of 1st Sem
                        $line = 0;
                        do {
                            if ($yearSemData) {
                                $this->SetFont('Arial', '', 8);
                                $this->Cell(15, 7, $yearSemData['db_subCode'], 1, 0, 'C');
    
                                $cellWidth = 47.5;
                                $fontSize = 8;
                                $tempFontSize = $fontSize;
    
                                while ($this->GetStringWidth($yearSemData['db_subDes']) >= $cellWidth) {
                                    $this->SetFontSize($tempFontSize -= 0.1);
                                }
                                $this->Cell(50, 7, $yearSemData['db_subDes'], 1, 0, '');
                                
                                $this->SetFontSize($fontSize);
                
                                $this->Cell(15, 7, $yearSemData['db_subUnit'], 1, 0, 'C');
                                $this->Cell(15, 7, $yearSemData['db_subGrade'], 1, 0, 'C');
                                $this->Ln();
                                $yearSemData = $arrayYearSem[$i]->fetch_assoc();
                            } else {
                                $this->Cell(15, 7, "", 1, 0, '');
                                $this->Cell(50, 7, "", 1, 0, '');
                                $this->Cell(15, 7, "", 1, 0, '');
                                $this->Cell(15, 7, "", 1, 0, '');
                                $this->Ln();
                            }
                            $line++;
                        } while($yearSemData || $line < 9);

                        //Display GWA for 1st SEM
                        $sql = "SELECT * FROM ems_student WHERE db_studNo = '$studNo' AND db_year = '$year[$a]' AND db_sem = '$sem[$b]'";
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
                    }

                    $i++;
                    $b++;

// =====================================END OF 1ST SEM==============================================
// =================================================================================================
// ====================================START OF 2ND SEM=============================================

                    //Select all Grades for 2nd Sem
                    $sql = "SELECT * FROM ems_grades WHERE db_studNo = '$studNo' AND db_subYear = '$year[$a]' AND db_subSem = '$sem[$b]'";
                    $arrayYearSem[$i] = $conn->query($sql) or die($conn->error);
                    $yearSemData = $arrayYearSem[$i]->fetch_assoc();

                    if ($yearSemData) {
                        //Header for 2nd Sem
                        $this->SetXY($xHeader + 155, $yHeader);
                        $this->SetFont('Arial', '', 12);
                        $this->Cell(20, 5, $sem[$b].' SEM', 0, 0, 'C');
    
                        //Header Display Grades for 2nd Sem
                        $this->SetXY($xHeader + 110, $yHeader + 10);
                        $this->SetFont('Arial', 'B', 10);
                        $this->Cell(15, 7, 'CODE', 1, 0, 'C');
                        $this->Cell(50, 7, 'DESCRIPTION', 1, 0, 'C');
                        $this->Cell(15, 7, 'UNITS', 1, 0, 'C');
                        $this->Cell(15, 7, 'GRADE', 1, 0, 'C');
                        $this->Ln();

                        //Display Table for Grades of 1st Sem
                        $y = $yHeader + 17;
                        $line = 0;
                        do {
                            if ($yearSemData) {
                                $this->SetXY($xHeader + 110, $y);
                                $this->SetFont('Arial', '', 8);
                                $this->Cell(15, 7, $yearSemData['db_subCode'], 1, 0, 'C');
                                
                                $cellWidth = 47.5;
                                $fontSize = 8;
                                $tempFontSize = $fontSize;
                                while ($this->GetStringWidth($yearSemData['db_subDes']) >= $cellWidth) {
                                    $this->SetFontSize($tempFontSize -= 0.1);
                                }
                                $this->Cell(50, 7, $yearSemData['db_subDes'], 1, 0, '');
                                
                                $tempFontSize = $fontSize;
                                $this->SetFontSize($fontSize);
                                
                                $this->Cell(15, 7, $yearSemData['db_subUnit'], 1, 0, 'C');
                                $this->Cell(15, 7, $yearSemData['db_subGrade'], 1, 0, 'C');
                                $this->Ln();
                                $yearSemData = $arrayYearSem[$i]->fetch_assoc();
                            } else {
                                $this->SetXY($xHeader + 110, $y);
                                $this->Cell(15, 7, "", 1, 0, '');
                                $this->Cell(50, 7, "", 1, 0, '');
                                $this->Cell(15, 7, "", 1, 0, '');
                                $this->Cell(15, 7, "", 1, 0, '');
                                $this->Ln();
                            }
                            $line++;
                            $y+=7;
                        } while($yearSemData || $line < 9);

                        //Display GWA for 2nd SEM
                        $sql = "SELECT * FROM ems_student WHERE db_studNo = '$studNo' AND db_year = '$year[$a]' AND db_sem = '$sem[$b]'";
                        $grades = $conn->query($sql) or die($conn->error);
                        $gradeData = $grades->fetch_assoc();

                        if ($gradeData && $gradeData['db_gwa'] > 1) {
                            $this->SetXY($xUnits + 100, $yUnits);
                            $this->SetFont('Arial', '', 10);
                            $this->Cell(0, 5, $gradeData['db_units'], 0, 0, '');
            
                            $this->SetXY($xGrade + 100, $yGrade);
                            $this->SetFont('Arial', '', 10);
                            $this->Cell(0, 5, number_format($gradeData['db_gwa'], 2), 0, 0, '');
                        }
                    }

                    $yHeader += 90;
                    $yUnits += 90;
                    $yGrade += 90;
                    $i++;
                    $a++;
                    $b=0;
                }
            } while($i<sizeof($arrayYearSem) && $allYearSemData);

// =================================================================================================
// ====================================START SUMMER=================================================
// =================================================================================================

            $studNo = $_GET['studNo'];
            $sem = 'SUMMER';

            $sql = "SELECT * FROM ems_grades WHERE db_studNo = '$studNo' AND db_subSem = '$sem'";
            $summerGrade = $conn->query($sql) or die($conn->error);
            $gradeData = $summerGrade->fetch_assoc();

            // $this->Cell(0, 5, $yHeader, 0, 0, 'C');

            // if ($yHeader >= 240) {
            //     $this->AddPage('P', 'Letter', 0);
            //     $yHeader = 55;
            // }

            if ($gradeData) {
                //Header for Year
                $this->SetXY($xHeader, $yHeader - 2);
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 5, $gradeData['db_subYear'].' YEAR', 0, 0, 'C');
                $this->SetXY($xHeader, $yHeader + 3);
                $this->SetFont('Arial', 'B', 11);
                $this->Cell(0, 5, 'S.Y. '.$gradeData['db_subSyear'], 0, 0, 'C');

                //Header for Summer Sem
                $this->SetXY($xHeader + 35, $yHeader);
                $this->SetFont('Arial', '', 12);
                $this->Cell(20, 5, $sem.' SEM', 0, 0, 'C');                
    
                //Header Display Grades for SUMMER
                $this->SetXY($xHeader + 10, $yHeader + 10);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(15, 7, 'CODE', 1, 0, 'C');
                $this->Cell(50, 7, 'DESCRIPTION', 1, 0, 'C');
                $this->Cell(15, 7, 'UNITS', 1, 0, 'C');
                $this->Cell(15, 7, 'GRADE', 1, 0, 'C');
                $this->Ln();

                do {
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(15, 7, $gradeData['db_subCode'], 1, 0, 'C');

                    $cellWidth = 47.5;
                    $fontSize = 8;
                    $tempFontSize = $fontSize;

                    while ($this->GetStringWidth($gradeData['db_subDes']) >= $cellWidth) {
                        $this->SetFontSize($tempFontSize -= 0.1);
                    }
                    $this->Cell(50, 7, $gradeData['db_subDes'], 1, 0, '');
                    
                    $tempFontSize = $fontSize;
                    $this->SetFontSize($fontSize);
    
                    $this->Cell(15, 7, $gradeData['db_subUnit'], 1, 0, 'C');
                    $this->Cell(15, 7, $gradeData['db_subGrade'], 1, 0, 'C');
                    $this->Ln();
                } while($gradeData = $summerGrade->fetch_assoc());
            }
        }

        function displaySignature($conn) {
            $x = 150;
            $y = 250;

            $this->SetXY($x-10, $y-10);
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(0, 5, 'Evaluated By:', 0, 0, '');
            $this->SetXY($x, $y);
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(0, 5, 'Prof. Ryan B. Mateo', 0, 0, '');
            $this->SetXY($x - 10, $y);
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(0, 5, '__________________________', 0, 0, '');
        }
    }

    $pdf = new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'Letter', 0);
    $pdf->displayGrades($conn);
    $pdf->displaySignature($conn);

    $studNo = $_GET['studNo'];
    $sql = "SELECT * FROM ems_student WHERE db_studNo = '$studNo'";
    $student = $conn->query($sql) or die($conn->error);
    $data = $student->fetch_assoc();

    $name = $data['db_Sname'].", ".$data['db_Fname']." ".$data['db_Mname'];

    $pdf->SetTitle(utf8_decode($name));
    $pdf->Output('I', $name.'.pdf');
?>