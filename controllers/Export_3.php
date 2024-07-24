<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user'])) {
            echo '<script>window.location.href  =' . '"' . base_url('login') . '"' . '</script>';
        }
		$this->load->library('curl');
        $this->load->library('Excel');
    }

    public function index() {
        $result = [];
        $result_ = [];
        $objPHPExcel = PHPExcel_IOFactory::load('./assets/excel/IAAS29.xlsm');


        $string = "SELECT * FROM tbl_project
left JOIN  tbl_subject
ON tbl_subject.FK_project_id  = tbl_project.project_id
where tbl_project.project_id = " . $_GET['id'] . "  AND subject_status_delete != 'del'";






        $query = $this->db->query($string)->result_array();

//        print_r($query);

        $i = 10;
        $no = 1;

        if (count($query) > 0) {




            foreach ($query as $key => $value) {
                $result1[$value["subject_id"]] = $value["subject_name"];
//                $result[] = array(
//                    "A$i" => $no,
//                    "B$i" => $value["subject_name"],
//                    "C$i" => $suggestion_name,
//                    "D$i" => $suggestion_respon,
//                    "E$i" => $suggestion_startdate,
//                    "F$i" => $suggestion_duedate,
//                    "G$i" => $anwser_update_date,
//                    "H$i" => $anwser_name,
//                    "I$i" => $status_success,
//                    "J$i" => $status_progress,
//                    "K$i" => $status_no,
//                    "L$i" => $follow_update_date,
//                    "M$i" => $follow_name,
//                    "N$i" => $follow_date,
//                );

                $string2 = "SELECT * from tbl_suggestion
left JOIN  tbl_status
ON tbl_status.FK_suggestion_id  = tbl_suggestion.suggestion_id
left JOIN  tbl_anwser
ON tbl_anwser.FK_suggestion_id  = tbl_suggestion.suggestion_id
left JOIN  tbl_follow
ON tbl_follow.FK_suggestion_id  = tbl_suggestion.suggestion_id
where tbl_suggestion.FK_subject_id = " . $value["subject_id"] . "";

                $query2 = $this->db->query($string2)->result_array();

                foreach ($query2 as $value2) {
                    if ($value2["suggestion_status_delete"] == "del") {
                        $suggestion_name = "-";
                        $suggestion_startdate = "-";
                        $suggestion_duedate = "-";
                        $suggestion_respon = "-";
                        $status_progress = "";
                        $status_success = "";
                        $status_no = '';
                    } else if ($value2["suggestion_status_delete"] != "del") {
                        $suggestion_name = $value2["suggestion_name"];
                        if ($value2["suggestion_respon"] == "") {
                            $suggestion_respon = "-";
                        } else {
                            $suggestion_respon = $value2["suggestion_respon"];
                        }

                        if ($value2["suggestion_startdate"] == "") {
                            $suggestion_startdate = "-";
                        } else {
                            $suggestion_startdate = $this->convert_date_b($value2["suggestion_startdate"]);
                        }

                        if ($value2["suggestion_duedate"] == "") {
                            $suggestion_duedate = "-";
                        } else {
                            $suggestion_duedate = $this->convert_date_b($value2["suggestion_duedate"]);
                        }
                    }

                    if ($value2["anwser_status_delete"] == "del") {
                        $anwser_name = "-";
                        $anwser_create_date = "-";
                        $anwser_update_date = "-";
                    } else if ($value2["anwser_status_delete"] != "del") {
                        if ($value2["anwser_name"] == "") {
                            $anwser_name = "-";
                        } else {
                            $anwser_name = $value2["anwser_name"];
                        }

                        if ($value2["anwser_update_date"] == "") {
                            $anwser_update_date = "-";
                            $anwser_create_date = "-";
                        } else {
                            $anwser_update_date = $this->convert_date_b($value2["anwser_update_date"]);
                            $anwser_create_date = $this->convert_date_b($value2["anwser_create_date"]);
                        }
                    }


                    if ($value2["follow_status_delete"] == "del") {
                        $follow_update_date = "-";
                        $follow_name = "-";
                        $follow_date = "-";
                    } else if ($value2["follow_status_delete"] != "del") {
                        if ($value2["follow_update_date"] == "") {
                            $follow_update_date = "-";
                        } else {
                            $follow_update_date = $this->convert_date_b($value2["follow_update_date"]);
                        }

                        if ($value2["follow_name"] == "") {
                            $follow_name = "-";
                        } else {
                            $follow_name = $value2["follow_name"];
                        }

                        if ($value2["follow_date"] == "") {
                            $follow_date = "-";
                        } else {
                            $follow_date = $this->convert_date_b($value2["follow_date"]);
                        }
                    }


                    if ($value2["status_name"] == 'progress') {
                        $status_progress = '✓';
                        $status_success = "";
                        $status_no = "";
                    } else if ($value2["status_name"] == 'success') {
                        $status_progress = "";
                        $status_success = '✓';
                        $status_no = "";
                    } else if ($value2["status_name"] == 'no') {
                        $status_progress = "";
                        $status_success = "";
                        $status_no = '✓';
                    }



                    $call1_date = "";
                    $call2_date = "";
                    $doc1_date = "";
                    $doc1_docnumber = "";
                    $doc2_date = "";
                    $doc2_docnumber = "";

                    $suggestion_follow_three_month1_date = "";
                    $suggestion_follow_three_month2_date = "";
                    $suggestion_follow_three_month3_date = "";
                    $suggestion_follow_three_month4_date = "";

                    if ($value2["suggestion_status_follow"] < 6) {
                        if ($value2["suggestion_status_follow_call1_date"] != '0000-00-00 00:00:00') {
                            $call1_date = $this->convert_date_time_b($value2["suggestion_status_follow_call1_date"]);
                        }
                        if ($value2["suggestion_status_follow_call2_date"] != '0000-00-00 00:00:00') {
                            $call2_date = $this->convert_date_time_b($value2["suggestion_status_follow_call2_date"]);
                        }
                        if ($value2["suggestion_status_follow_doc1_date"] != '0000-00-00 00:00:00') {
                            $doc1_date = $this->convert_date_time_b($value2["suggestion_status_follow_doc1_date"]);
                            $doc1_docnumber = $value2["suggestion_follow_doc1"];
                        }
                        if ($value2["suggestion_status_follow_doc2_date"] != '0000-00-00 00:00:00') {
                            $doc2_date = $this->convert_date_time_b($value2["suggestion_status_follow_doc2_date"]);
                            $doc2_docnumber = $value2["suggestion_follow_doc2"];
                        }
                    } else {
                        if ($value2["suggestion_follow_three_month1_date"] != '0000-00-00 00:00:00') {
                            $suggestion_follow_three_month1_date = $this->convert_date_time_b($value2["suggestion_follow_three_month1_date"]);
                        }
                        if ($value2["suggestion_follow_three_month2_date"] != '0000-00-00 00:00:00') {
                            $suggestion_follow_three_month2_date = $this->convert_date_time_b($value2["suggestion_follow_three_month2_date"]);
                        }
                        if ($value2["suggestion_follow_three_month3_date"] != '0000-00-00 00:00:00') {
                            $suggestion_follow_three_month3_date = $this->convert_date_time_b($value2["suggestion_follow_three_month3_date"]);
                        }
                        if ($value2["suggestion_follow_three_month4_date"] != '0000-00-00 00:00:00') {
                            $suggestion_follow_three_month4_date = $this->convert_date_time_b($value2["suggestion_follow_three_month4_date"]);
                        }
                    }


//                    if ($value2["suggestion_status_follow"] == 0) {
//                        $text_status = "ยังไม่มีการติดตาม";
//                        $text_date = "";
//                        $call1_date = $value2["suggestion_status_follow_call1_date"];
//                    } elseif ($value2["suggestion_status_follow"] == 1) {
//                        $text_status = "แจ้งทางโทรศัพท์  ครั้งที่ 1 ล่วงหน้า 7 วัน";
//                        $text_date = 'วันที่ ' . $this->convert_date_time_b($value2["suggestion_status_follow_call1_date"]);
//                        if ($value2["suggestion_status_follow_call1_date"] == '0000-00-00 00:00:00') {
//                            $text_date = "";
//                        }
//                        $call1_date = $this->convert_date_time_b($value2["suggestion_status_follow_call1_date"]);
//                    } elseif ($value2["suggestion_status_follow"] == 2) {
//                        $text_status = "แจ้งทางโทรศัพท์  ครั้งที่ 2 ล่าช้า 3 วัน";
//                        $text_date = 'วันที่ ' . $this->convert_date_time_b($value2["suggestion_status_follow_call2_date"]);
//                        if ($value2["suggestion_status_follow_call2_date"] == '0000-00-00 00:00:00') {
//                            $text_date = "";
//                        }
//                        $call2_date = $this->convert_date_time_b($value2["suggestion_status_follow_call2_date"]);
//                    } elseif ($value2["suggestion_status_follow"] == 3) {
//                        $text_status = "แจ้งหนังสือติดตามครั้งที่ 3 ล่าช้า 15 วัน";
//
//                        $text_date = 'วันที่ ' . $this->convert_date_time_b($value2["suggestion_status_follow_doc1_date"]);
//                        if ($value2["suggestion_status_follow_doc1_date"] == '0000-00-00 00:00:00') {
//                            $text_date = "";
//                        }
//                    } elseif ($value2["suggestion_status_follow"] == 4) {
//                        $text_status = "แจ้งหนังสือติดตามครั้งที่ 4 ล่าช้า 30 วัน";
//
//                        $text_date = 'วันที่ ' . $this->convert_date_time_b($value2["suggestion_status_follow_doc2_date"]);
//                        if ($value2["suggestion_status_follow_doc2_date"] == '0000-00-00 00:00:00') {
//                            $text_date = "";
//                        }
//                    }




                    $result_[] = array(
                        "0" => $value2["suggestion_status_delete"],
                        "1" => $no,
                        "2" => $value["subject_name"],
                        "suggestion_name" => $suggestion_name,
                        "suggestion_respon" => $suggestion_respon,
                        "suggestion_startdate" => $suggestion_startdate,
                        "suggestion_duedate" => $suggestion_duedate,
                        "anwser_update_date" => $anwser_update_date,
                        "anwser_create_date" => $anwser_create_date,
                        "anwser_name" => $anwser_name,
                        "status_success" => $status_success,
                        "status_progress" => $status_progress,
                        "status_no" => $status_no,
                        "follow_update_date" => $follow_update_date,
                        "follow_name" => $follow_name,
                        "follow_date" => $follow_date,
                        "call1_date" => $call1_date,
                        "call2_date" => $call2_date,
                        "doc1_date" => $doc1_date,
                        "doc1_docnumber" => $doc1_docnumber,
                        "doc2_date" => $doc2_date,
                        "doc2_docnumber" => $doc2_docnumber,
                        "suggestion_follow_three_month1_date" => $suggestion_follow_three_month1_date,
                        "suggestion_follow_three_month2_date" => $suggestion_follow_three_month2_date,
                        "suggestion_follow_three_month3_date" => $suggestion_follow_three_month3_date,
                        "suggestion_follow_three_month4_date" => $suggestion_follow_three_month4_date,
                        "suggestion_follow_three_month1_docnumber" => $value2["suggestion_follow_three_month1_docnumber"],
                        "suggestion_follow_three_month2_docnumber" => $value2["suggestion_follow_three_month2_docnumber"],
                        "suggestion_follow_three_month3_docnumber" => $value2["suggestion_follow_three_month3_docnumber"],
                        "suggestion_follow_three_month4_docnumber" => $value2["suggestion_follow_three_month4_docnumber"],
                    );



                    $i++;
                    $no++;
                }
            }


            $ii = 10;
            $num = 1;
            foreach ($result_ as $value) {

                if ($value["0"] != "del") {
                    $result[] = array(
                        "A$ii" => $num,
                        "B$ii" => $value["2"],
                        "C$ii" => $value["suggestion_name"],
                        "D$ii" => $value["suggestion_respon"],
                        "E$ii" => $value["suggestion_duedate"],
                        "F$ii" => $value["anwser_respone_date"],
                        "G$ii" => $value["anwser_name"],
                        "H$ii" => $value["status_no"],
                        "I$ii" => $value["status_progress"],
                        "J$ii" => $value["status_success"],
                        "K$ii" => $value["follow_date"],
                        "L$ii" => $value["call1_date"], // โทรครั้งที่ 1 วันเดือนปี
                        "M$ii" => $value["call2_date"], // โทรครั้งที่  2 วันเดือนปี
                        "N$ii" => $value["doc1_date"], // เอกสาร 1 ครั้งที่3  3 วันเดือนปี
                        "O$ii" => $value["doc1_docnumber"], // เอกสาร 1 ครั้งที่3  3 เลข
                        "P$ii" => $value["doc2_date"], // เอกสาร 2 ครั้งที่3  4 วันเดือนปี
                        "Q$ii" => $value["doc2_docnumber"], // เอกสาร 2 ครั้งที่3  4 เลข
                        "R$ii" => $value["suggestion_follow_three_month1_date"], //วันที่ไตรมาส 1
                        "S$ii" => $value["suggestion_follow_three_month1_docnumber"],
                        "T$ii" => $value["suggestion_follow_three_month2_date"], //วันที่ไตรมาส 2
                        "U$ii" => $value["suggestion_follow_three_month2_docnumber"],
                        "V$ii" => $value["suggestion_follow_three_month3_date"], //วันที่ไตรมาส 3
                        "W$ii" => $value["suggestion_follow_three_month3_docnumber"],
                        "X$ii" => $value["suggestion_follow_three_month4_date"], //วันที่ไตรมาส 4
                        "Y$ii" => $value["suggestion_follow_three_month4_docnumber"],
                    );
                    $ii++;
                    $num++;
                }
            }



            $wizard = new PHPExcel_Helper_HTML;


            $a3 = "หนังสือ " . $query[0]["project_docnumber"] . " วันที่ส่งรายงานฉบับสมบูรณ์ " . $this->convert_date_time_b($query[0]["project_create_date"]) . " เรื่อง " . $query[0]["project_name"] . " ปีงบประมาณ " . $query[0]["project_year"];

//            $a3 = "การติดตามผลการปฏิบัติตามข้อเสนอแนะ เรื่อง " . $query[0]["project_name"];
            $a4 = "งานตรวจสอบสาย " . $query[0]["project_group"] . " สำนักตรวจสอบภายใน";

//            print_r($result);
//            die();

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", $a3);
            $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(-1);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4", $a4);
            $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(-1);
            $d = 10;
            $auto_h = 10;
            foreach ($result as $key1 => $value) {
                foreach ($value as $key2 => $value2) {
                    $richText = $wizard->toRichTextObject('<?xml encoding="">' . $value2);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($key2, $richText);



//                    $objPHPExcel->getActiveSheet()
//                            ->getStyle("D" . $d)
//                            ->getNumberFormat()
//                            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
//                    $objPHPExcel->getActiveSheet()
//                            ->getStyle("F" . $d)
//                            ->getNumberFormat()
//                            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
//                    $objPHPExcel->getActiveSheet()
//                            ->getStyle("L" . $d)
//                            ->getNumberFormat()
//                            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
//                    $objPHPExcel->getActiveSheet()
//                            ->getStyle("N" . $d)
//                            ->getNumberFormat()
//                            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                }
//                $objPHPExcel->getActiveSheet()->setTitle($query[0]["project_name"]);
                $objPHPExcel->getActiveSheet()->setTitle("sheet");
                $objPHPExcel->getActiveSheet()->getRowDimension($auto_h++)->setRowHeight(-1);
                $d++;
            }
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $last = $ii - 1;
            $objPHPExcel->getActiveSheet()->getStyle('A10:Y' . $last)->applyFromArray($styleArray);

            unset($styleArray);




            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_end_clean();
            $namefile = substr($query[0]["project_name"], 0, 150);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="IA-AS-29 ' . $namefile . '.xlsm"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
            exit;
        } else {
            echo ''
            . '<div style="top: 50%; left: 50%;position: absolute;">ไม่มีข้อมูล' . ''
            . '';
        }
    }

    function convert_date_time_year_b($date) {
        $textday = "";
        $date_ex = explode(" ", $date);
        $date_ex2 = explode("-", $date_ex[0]);
        $yyyy = $date_ex2[0];
        $mm = $date_ex2[1];
        $dd = $date_ex2[2];
        $textday = $yyyy + 543;
        return $textday;
    }

    function convert_date_time_b($date) {
        $textday = "";
        $date_ex = explode(" ", $date);
        $date_ex2 = explode("-", $date_ex[0]);
        $year = $date_ex2[0] + 543;
        $textday = $date_ex2[2] . "/" . $date_ex2[1] . "/" . $year;

        return $textday;
    }

    function convert_date_b($date) {
        $textday = "";
        $date_ex2 = explode("-", $date);
        $yyyy = $date_ex2[0] + 543;
        $mm = $date_ex2[1];
        $dd = $date_ex2[2];
        $textday = $dd . "/" . $mm . "/" . $yyyy;
        return $textday;
    }

    function br2nl($input) {
        return preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n", "", str_replace("\r", "", htmlspecialchars_decode($input))));
    }

}
