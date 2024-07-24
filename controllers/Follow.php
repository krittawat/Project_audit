<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Follow extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user'])) {
            echo '<script>window.location.href  =' . '"' . base_url('login') . '"' . '</script>';
        }
    }

    public function index() {
        $data = [];
        $data['controller'] = $this;
        return $this->load->view("follow_list", $data);
    }

    public function ajaxfile_test() {
        
    }

    public function ajaxfile() {
        $day = 7;

        if ($this->input->post("group") != NULL) {
            $group = 'project_group = ' . $this->input->post("group") . ' and ';
        } else {
            $group = "";
        }


        if ($_POST != NULL) {
            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value
        }


## Search 
        $searchQuery = " ";
        if ($searchValue != '') {
            $searchQuery = "(project_name like '%" . $searchValue . "%' or 
        project_create_date like '%" . $searchValue . "%'  or 
        suggestion_docnumber like '%" . $searchValue . "%'or 
        suggestion_name like '%" . $searchValue . "%' or 
        subject_name like '%" . $searchValue . "%') and ";
        }
        $searchDate = "";
        if ($_POST['start_date'] != '' and $_POST['end_date'] != '') {
            $searchDate = "suggestion_duedate BETWEEN '" . $this->convert_date2($_POST['start_date']) . "' AND '" . $this->convert_date2($_POST['end_date']) . "' and";
        }

## Total number of records without filtering
//        $sel = "select count(*) as allcount from tbl_project";
        $total = $this->db->query("SELECT count(*) as allcount FROM tbl_status 
left JOIN  tbl_suggestion
ON tbl_suggestion.suggestion_id  = tbl_status.FK_suggestion_id
left JOIN  tbl_subject
ON tbl_subject.subject_id  = tbl_suggestion.FK_subject_id
left JOIN  tbl_project
ON tbl_project.project_id  = tbl_subject.FK_project_id
WHERE " . $searchQuery . "$searchDate $group
subject_status_delete !=  'del' and status_name = 'progress' or tbl_status.status_name = 'no' AND suggestion_duedate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL '" . $day . "'DAY)  AND  suggestion_status_delete != 'del'", FALSE)->result_array();

        $totalRecords = $total[0]['allcount'];


## Total number of record with filtering
//        $sel = "select count(*) as allcount from tbl_project WHERE 1 " . $searchQuery . 'and project_status_delete  = ""';
//        $sel = "SELECT count(*) as allcount FROM tbl_status
//        LEFT JOIN tbl_suggestion ON tbl_suggestion.suggestion_id = tbl_status.FK_suggestion_id
//LEFT JOIN tbl_subject ON tbl_subject.subject_id = tbl_status.FK_subject_id 
//LEFT JOIN tbl_project ON tbl_project.project_id = tbl_subject.FK_project_id
//        WHERE 1 " . $searchQuery . 'and project_status_delete  = "" and project_group  ="' . $group . '"';


        $sel = "SELECT count(*) as allcount FROM tbl_status 
left JOIN  tbl_suggestion
ON tbl_suggestion.suggestion_id  = tbl_status.FK_suggestion_id
left JOIN  tbl_subject
ON tbl_subject.subject_id  = tbl_suggestion.FK_subject_id
left JOIN  tbl_project
ON tbl_project.project_id  = tbl_subject.FK_project_id
WHERE " . $searchQuery . " $searchDate $group subject_status_delete !=  'del' and (status_name = 'progress' or status_name = 'no')  AND suggestion_status_delete != 'del'";



        $records = $this->db->query($sel, FALSE)->result_array();
        $totalRecordwithFilter = $records[0]["allcount"];
//        
//## Fetch records
//        $empQuery = "select * from tbl_project WHERE 1" . $searchQuery . 'and project_status_delete  = ""' . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
//        $empQuery = "SELECT * FROM tbl_status
//LEFT JOIN tbl_suggestion ON tbl_suggestion.suggestion_id = tbl_status.FK_suggestion_id
//LEFT JOIN tbl_subject ON tbl_subject.subject_id = tbl_status.FK_subject_id 
//LEFT JOIN tbl_project ON tbl_project.project_id = tbl_subject.FK_project_id
//WHERE 1" . $searchQuery . 'and project_status_delete  = "" and project_group  ="' . $group . '"' . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;



        $empQuery = "SELECT *,ROW_NUMBER() OVER(PARTITION BY subject_id) as row FROM tbl_status 
left JOIN tbl_suggestion
ON tbl_suggestion.suggestion_id  = tbl_status.FK_suggestion_id
left JOIN tbl_subject
ON tbl_subject.subject_id  = tbl_suggestion.FK_subject_id
left JOIN tbl_project
ON tbl_project.project_id  = tbl_subject.FK_project_id
WHERE " . $searchQuery . "$searchDate $group
subject_status_delete !=  'del' and (status_name = 'progress' or tbl_status.status_name = 'no')  AND 
suggestion_status_delete != 'del ' order by suggestion_id ASC" . " limit " . $row . ", " . $rowperpage;






//suggestion_duedate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL '" . $day . "'DAY)

        $empQuery2 = $this->db->query($empQuery, FALSE)->result_array();
//        $datalist = $this->db->select("*")
//        ->from("tbl_statussd")
//                ->join("tbl_subject", "tbl_subject.subject_id = tbl_status.FK_subject_id", "left")
//                ->join("tbl_project", "tbl_project.project_id = tbl_subject.FK_project_id", "left")
//                ->get()->result_array();

        $row_number = 0;
        $row_numberSub = 0;

        $data = array();

        $proid = 95;
        $count = 0;
        $sub_id = 0;
        foreach ($empQuery2 as $value) {

            if ($value["project_status_delete"] == "") {
                $page = $value['row'] - 1;
                $text_status = "ยังไม่มีการติดตาม";
                $text_status2 = "ยังไม่มีการติดตาม";
                $text_date = "";
                $text_log = "";
                $call1_date = 0;
                $call2_date = 0;
                $doc1_date = 0;
                $doc2_date = 0;
                $text_log2 = "";

                $doc1 = 0;
                $doc2 = 0;


                $count++;
                if ($empQuery2[$count - 1]["project_id"] != $value["project_id"]) {
                    $row_number = 0;
                } else if ($empQuery2[$count - 1]["project_id"] == $value["project_id"]) {
                    if ($empQuery2[$count - 1]["subject_id"] != $value["subject_id"]) {
                        $row_number++;
                    }
                }

                $li = '<div class="row">'
                        . '<div class="col-sm">&nbsp;<a class = "btn btn-primary  btn-block" href = "' . base_url('index.php/Home/project_detail/') . $value['project_id'] . '?per_page=' . $row_number . '">รายละเอียด</a>&nbsp;</div>'
                        . '</div>';


                if ($value["suggestion_status_follow"] <= 5) {
                    if ($value["suggestion_status_follow_call1_date"] != '0000-00-00 00:00:00') {
                        $text_log = '<hr><div style="font-size: 0.8em">แจ้งทางโทรศัพท์  ครั้งที่ 1 ล่วงหน้า 7 วัน <br>วันที่ : ' . $this->convert_date($value["suggestion_status_follow_call1_date"]) . '</div><br>';
                    }
                    if ($value["suggestion_status_follow_call2_date"] != '0000-00-00 00:00:00') {
                        $text_log .= '<div style="font-size: 0.8em">แจ้งทางโทรศัพท์  ครั้งที่ 2 ล่าช้า 3 วัน <br>วันที่ : ' . $this->convert_date($value["suggestion_status_follow_call2_date"]) . '</div><br>';
                    }
                    if ($value["suggestion_status_follow_doc1_date"] != '0000-00-00 00:00:00') {
                        $text_log .= '<div style="font-size: 0.8em">แจ้งหนังสือติดตามครั้งที่ 3 ล่าช้า 15 วัน <br>วันที่ : ' . $this->convert_date($value["suggestion_status_follow_doc1_date"]) . '<br>เลขที่หนังสือติดตาม : ' . $value["suggestion_follow_doc1"] . '</div><br>';
                    }
                    if ($value["suggestion_status_follow_doc2_date"] != '0000-00-00 00:00:00') {
                        $text_log .= '<div style="font-size: 0.8em">แจ้งหนังสือติดตามครั้งที่ 4 ล่าช้า 30 วัน <br>วันที่ : ' . $this->convert_date($value["suggestion_status_follow_doc2_date"]) . '<br>เลขที่หนังสือติดตาม : ' . $value["suggestion_follow_doc2"] . '</div>';
                    }
                } else if ($value["suggestion_status_follow"] >= 5) {


                    if ($value["suggestion_follow_three_month1_date"] != '0000-00-00 00:00:00') {
                        $text_log2 = '<div style="font-size: 0.8em">ติดตาม ไตรมาส 1<br>วันที่ : ' . $this->convert_date($value["suggestion_follow_three_month1_date"]) . '<br>เลขที่หนังสือติดตาม : ' . $value["suggestion_follow_three_month1_docnumber"] . '</div>';
                    }
                    if ($value["suggestion_follow_three_month2_date"] != '0000-00-00 00:00:00') {
                        $text_log2 .= '<div style="font-size: 0.8em">ติดตาม ไตรมาส 2<br>วันที่ : ' . $this->convert_date($value["suggestion_follow_three_month2_date"]) . '<br>เลขที่หนังสือติดตาม : ' . $value["suggestion_follow_three_month2_docnumber"] . '</div>';
                    }
                    if ($value["suggestion_follow_three_month3_date"] != '0000-00-00 00:00:00') {
                        $text_log2 .= '<div style="font-size: 0.8em">ติดตาม ไตรมาส 3<br>วันที่ : ' . $this->convert_date($value["suggestion_follow_three_month3_date"]) . '<br>เลขที่หนังสือติดตาม : ' . $value["suggestion_follow_three_month3_docnumber"] . '</div>';
                    }
                    if ($value["suggestion_follow_three_month4_date"] != '0000-00-00 00:00:00') {
                        $text_log2 .= '<div style="font-size: 0.8em">ติดตาม ไตรมาส 4<br>วันที่ : ' . $this->convert_date($value["suggestion_follow_three_month4_date"]) . '<br>เลขที่หนังสือติดตาม : ' . $value["suggestion_follow_three_month4_docnumber"] . '</div>';
                    }

                    if ($value["suggestion_status_follow"] == 5) {
                        $text_status2 = 'ยังไม่มีการติดตาม';
                    } else if ($value["suggestion_status_follow"] == 6) {
                        $text_status2 = 'ไตรมาส 1';
                    } else if ($value["suggestion_status_follow"] == 7) {
                        $text_status2 = 'ไตรมาส 2';
                    } else if ($value["suggestion_status_follow"] == 8) {
                        $text_status2 = 'ไตรมาส 3';
                    } else if ($value["suggestion_status_follow"] == 9) {
                        $text_status2 = 'ไตรมาส 4';
                    }
                }


                if ($value["suggestion_status_follow"] == 0) {
                    $text_status = "ยังไม่มีการติดตาม";
                    $text_date = "";
                    $call1_date = $value["suggestion_status_follow_call1_date"];
                } elseif ($value["suggestion_status_follow"] == 1) {
                    $text_status = "แจ้งทางโทรศัพท์  ครั้งที่ 1 ล่วงหน้า 7 วัน";
                    $text_date = 'วันที่ ' . $this->convert_date($value["suggestion_status_follow_call1_date"]);
                    if ($value["suggestion_status_follow_call1_date"] == '0000-00-00 00:00:00') {
                        $text_date = "";
                    }
                    $call1_date = $value["suggestion_status_follow_call1_date"];
                } elseif ($value["suggestion_status_follow"] == 2) {
                    $text_status = "แจ้งทางโทรศัพท์  ครั้งที่ 2 ล่าช้า 3 วัน";
                    $text_date = 'วันที่ ' . $this->convert_date($value["suggestion_status_follow_call2_date"]);
                    if ($value["suggestion_status_follow_call2_date"] == '0000-00-00 00:00:00') {
                        $text_date = "";
                    }
                    $call2_date = $value["suggestion_status_follow_call2_date"];
                } elseif ($value["suggestion_status_follow"] == 3) {
                    $text_status = "แจ้งหนังสือติดตามครั้งที่ 3 ล่าช้า 15 วัน";

                    $text_date = 'วันที่ ' . $this->convert_date($value["suggestion_status_follow_doc1_date"]);
                    if ($value["suggestion_status_follow_doc1_date"] == '0000-00-00 00:00:00') {
                        $text_date = "";
                    }
                } elseif ($value["suggestion_status_follow"] == 4) {
                    $text_status = "แจ้งหนังสือติดตามครั้งที่ 4 ล่าช้า 30 วัน";

                    $text_date = 'วันที่ ' . $this->convert_date($value["suggestion_status_follow_doc2_date"]);
                    if ($value["suggestion_status_follow_doc2_date"] == '0000-00-00 00:00:00') {
                        $text_date = "";
                    }

                    $li = '<div class="row">'
                            . '<div class="col-sm">&nbsp;<a class = "btn btn-primary  btn-block" href = "' . base_url('index.php/Home/project_detail/') . $value['project_id'] . '">รายละเอียด</a>&nbsp;</div>'
                            . '<div class="col-sm">&nbsp;<a class = "btn btn-success btn-block" href = "' . base_url('Export?id=') . $value['project_id'] . '">Export</a>&nbsp;</div>'
                            . '</div>';
                }

                $doc1 = $value["suggestion_follow_doc1"];
                $doc2 = $value["suggestion_follow_doc2"];
                $doc1_date = $value["suggestion_status_follow_doc1_date"];
                $doc2_date = $value["suggestion_status_follow_doc2_date"];



                $three_month1_date = $value["suggestion_follow_doc1"];
//$three_month2_date = $three_month3_date = $three_month4_date = 
////            if ($param["suggestion_status_follow"] == "1") {
//                $text_date = $value["suggestion_status_follow_call1_date"];
//            } else if ($param["suggestion_status_follow"] == "2") {
//                $text_date = $value["suggestion_status_follow_call2_date"];
//            } else if ($param["suggestion_status_follow"] == "3") {
//                $text_date = $value["suggestion_status_follow_doc1_date"];
//            } else if ($param["suggestion_status_follow"] == "4") {
//                $text_date = $value["suggestion_status_follow_doc2_date"];
//            }



                $dropdown1 = '<div class="btn-group" id="change_status_sugges1">
                <button id="change_status_sugges2_id_' . $value["suggestion_id"] . '" class="btn btn-sm dropdown-toggle" style="color:black;" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <span id="selected">' . $text_status . '</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <button class="dropdown-item" type="button" onclick="change_status_sugges(' . $value["suggestion_id"] . ', 1,' . "'" . $call1_date . "'" . ',0,' . "'" . $value["suggestion_follow_call1_person"] . "'" . ')">แจ้งทางโทรศัพท์  ครั้งที่ 1 ล่วงหน้า 7 วัน</button>
                    <button class="dropdown-item" type="button" onclick="change_status_sugges(' . $value["suggestion_id"] . ', 2,' . "'" . $call2_date . "'" . ',0,' . "'" . $value["suggestion_follow_call2_person"] . "'" . ')">แจ้งทางโทรศัพท์  ครั้งที่ 2 ล่าช้า 3 วัน</button>
                    <button class="dropdown-item" type="button" onclick="change_status_sugges(' . $value["suggestion_id"] . ', 3,' . "'" . $doc1_date . "'" . ',' . "'" . $doc1 . "'" . ',' . "'" . $value["suggestion_follow_doc1_person"] . "'" . ')">แจ้งหนังสือติดตามครั้งที่ 3 ล่าช้า 15 วัน</button>
                    <button class="dropdown-item" type="button" onclick="change_status_sugges(' . $value["suggestion_id"] . ', 4,' . "'" . $doc2_date . "'" . ',' . "'" . $doc2 . "'" . ',' . "'" . $value["suggestion_follow_doc2_person"] . "'" . ')">แจ้งหนังสือติดตามครั้งที่ 4 ล่าช้า 30 วัน</button>
                    <button class="dropdown-item" type="button" onclick="change_status_sugges(' . $value["suggestion_id"] . ', 0,' . "'" . 0 . "'" . ',0)">ยังไม่มีการติดตาม</button>
                </div>
            </div><br>' . $text_log;




                $dropdown2 = '<div class="btn-group" id="change_status_sugges1">
                <button id="change_status_sugges2_id_' . $value["suggestion_id"] . '" class="btn btn-sm dropdown-toggle" style="color:black;" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <span id="selected">' . $text_status2 . '</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <button class="dropdown-item" type="button" onclick="change_status_sugges2(' . $value["suggestion_id"] . ', 6,' . "'" . $value["suggestion_follow_three_month1_date"] . "'" . ',' . "'" . $value["suggestion_follow_three_month1_docnumber"] . "'" . ',' . "'" . $value["suggestion_follow_three_month1_person"] . "'" . ')">ไตรมาส 1</button>
                    <button class="dropdown-item" type="button" onclick="change_status_sugges2(' . $value["suggestion_id"] . ', 7,' . "'" . $value["suggestion_follow_three_month2_date"] . "'" . ',' . "'" . $value["suggestion_follow_three_month2_docnumber"] . "'" . ',' . "'" . $value["suggestion_follow_three_month2_person"] . "'" . ')">ไตรมาส 2</button>
                    <button class="dropdown-item" type="button" onclick="change_status_sugges2(' . $value["suggestion_id"] . ', 8,' . "'" . $value["suggestion_follow_three_month3_date"] . "'" . ',' . "'" . $value["suggestion_follow_three_month3_docnumber"] . "'" . ',' . "'" . $value["suggestion_follow_three_month3_person"] . "'" . ')">ไตรมาส 3</button>
                    <button class="dropdown-item" type="button" onclick="change_status_sugges2(' . $value["suggestion_id"] . ', 9,' . "'" . $value["suggestion_follow_three_month4_date"] . "'" . ',' . "'" . $value["suggestion_follow_three_month4_docnumber"] . "'" . ',' . "'" . $value["suggestion_follow_three_month4_person"] . "'" . ')">ไตรมาส 4</button>
                <button class="dropdown-item" type="button" onclick="change_status_sugges2(' . $value["suggestion_id"] . ', 0,' . "'" . 0 . "'" . ',0)">ยังไม่มีการติดตาม</button>
</div>
            </div><br>' . $text_log2;

                if ($value["suggestion_status_follow"] < 5) {
                    $dropdown = $dropdown1;


                    $date1 = date_create($value['suggestion_duedate']);
                    $date2 = date_create(date("Y-m-d"));
                    $diff = date_diff($date1, $date2);
                    if ($diff->invert == 1) {
                        $text_ = "เร็ว";
                    } else if ($diff->d == 0) {
                        $text_ = "ปกติ";
                    } else if ($diff->invert == 0) {
                        $text_ = "ล่าช้า";
                    }
                } else if ($value["suggestion_status_follow"] >= 5) {
                    $dropdown = $dropdown2;
                    $text_ = "ติดตามตามไตรมาส";
                }



                $data[] = array(
                    "project_name" => 'เลขที่หนังสือกิจกรรมตรวจสอบ : ' . $value['project_docnumber'] . '<br>รายการผลตรวจสอบ/โครงการ :  ' . $value['project_name'] . '<br>งานตรวจสอบสาย ' . $value['project_group'] . ' ปีงบประมาณ ' . $value['project_year'],
                    "subject_name" => $value['subject_name'],
                    "suggestion_name" => $value['suggestion_name'],
//                    "suggestion_docnumber" => $value['suggestion_docnumber'],
                    "suggestion_duedate" => $this->convert_date2($value['suggestion_duedate']),
                    "suggestion_id" => $dropdown,
                    "suggestion_startdate" => $text_,
                    "project_id" => $li,
                );
            }
        }
## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        echo json_encode($response);
        
    }

    public function insert_follow() {
        $status = 0;
        $param = $this->input->post();
        $follow_date = explode("/", $param["follow_date"]);
        $follow_date_yyyy = $follow_date[2] - 543;
        $follow_date_mm = $follow_date[1];
        $follow_date_date_dd = $follow_date[0];


        $data_insert = [
            "FK_suggestion_id" => $param["follow_sugges_id"],
            "follow_date" => $follow_date_yyyy . "/" . $follow_date_mm . "/" . $follow_date_date_dd,
            "follow_create_date" => date('Y-m-d H:i:s'),
            "follow_update_date" => date('Y-m-d H:i:s'),
            "follow_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
            "follow_name" => $param["editor_follow"]
        ];
        $this->db->trans_begin();
        $this->db->insert('tbl_follow', $data_insert);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_commit();
            $status = 1;
        }
        echo $status;
    }

    public function update_follow() {
        $status = 0;
        $param = $this->input->post();
        $follow_date = explode("/", $param["edit_follow_date"]);
        $follow_date_yyyy = $follow_date[2] - 543;
        $follow_date_mm = $follow_date[1];
        $follow_date_date_dd = $follow_date[0];
        $data_update = [
            "follow_date" => $follow_date_yyyy . "/" . $follow_date_mm . "/" . $follow_date_date_dd,
            "follow_update_date" => date('Y-m-d H:i:s'),
            "follow_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
            "follow_name" => $param["editor_follow"]
        ];
        $this->db->trans_begin();
        $this->db->where('follow_id', $param["edit_follow_sugges_id"]);
        $this->db->update('tbl_follow', $data_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_commit();
            $status = 1;
        }
        echo $status;
    }

    public function check_follow($id) {
        $data = $this->db->select("*")->where("FK_suggestion_id", $id)->get("tbl_follow")->result_array();
        return $data;
    }

    public function delete_follow() {
        $status = 0;
        $param = $this->input->post();
        $data_update = [
            "follow_status_delete" => "del",
            "follow_update_date" => date('Y-m-d H:i:s'),
            "follow_user_update" => $_SESSION["user"]["0"]["PER_CODE"]
        ];

        $this->db->trans_begin();
        $this->db->where('follow_id', $param["delete_id_del"]);
        $this->db->update('tbl_follow', $data_update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_commit();
            $status = 1;
        }

        echo $status;
    }

    public function change_status_follow() {
        $status = 0;
        $param = $this->input->post();

//        $call1_date = "";
//        $call2_date = "";
//        $doc1_date = "";
//        $doc2_date = "";

        $data_update = [
            "suggestion_status_follow" => $param["status"],
            "suggestion_update_date" => date('Y-m-d H:i:s'),
            "suggestion_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
        ];

        if ($param["status"] == "1") {
            $call1_date = $this->convert_date3($param["follow_date"]) . " " . date('H:i:s');

            $data_update["suggestion_status_follow_call1_date"] = $call1_date;
            $data_update["suggestion_follow_call1_person"] = $param["person_follow"];
        } else if ($param["status"] == "2") {
            $call2_date = $this->convert_date3($param["follow_date"]) . " " . date('H:i:s');
            $data_update["suggestion_status_follow_call2_date"] = $call2_date;
            $data_update["suggestion_follow_call2_person"] = $param["person_follow"];
        } else if ($param["status"] == "3") {
            $doc1_date = $this->convert_date3($param["follow_date"]) . " " . date('H:i:s');
            $data_update["suggestion_status_follow_doc1_date"] = $doc1_date;
            $data_update["suggestion_follow_doc1"] = $param["follow_doc"];
            $data_update["suggestion_follow_doc1_person"] = $param["person_follow"];
        } else if ($param["status"] == "4") {
            $doc2_date = $this->convert_date3($param["follow_date"]) . " " . date('H:i:s');
            $data_update["suggestion_status_follow_doc2_date"] = $doc2_date;

            $data_update["suggestion_follow_doc2"] = $param["follow_doc"];


            $data_update["suggestion_follow_doc2_person"] = $param["person_follow"];
        }

        $this->db->trans_begin();
        $this->db->where('suggestion_id', $param["sugges_id"]);
        $this->db->update('tbl_suggestion', $data_update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_commit();
            $status = 1;
        }

        echo $status;
    }

    public function change_status_follow_three() {
        $status = 0;
        $param = $this->input->post();

//        $call1_date = "";
//        $call2_date = "";
//        $doc1_date = "";
//        $doc2_date = "";

        $data_update = [
            "suggestion_status_follow" => $param["status"],
            "suggestion_update_date" => date('Y-m-d H:i:s'),
            "suggestion_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
        ];



        if ($param["status"] == "5") {
            $doc2_date = $this->convert_date3($param["follow_date"]) . " " . date('H:i:s');
            $data_update["suggestion_follow_three_month1_date"] = $doc2_date;
            $data_update["suggestion_follow_three_month1_docnumber"] = $param["follow_doc"];
            $data_update["suggestion_follow_three_month1_person"] = $param["person_follow"];
        } else if ($param["status"] == "6") {
            $doc2_date = $this->convert_date3($param["follow_date"]) . " " . date('H:i:s');
            $data_update["suggestion_follow_three_month1_date"] = $doc2_date;
            $data_update["suggestion_follow_three_month1_docnumber"] = $param["follow_doc"];
            $data_update["suggestion_follow_three_month1_person"] = $param["person_follow"];
        } else if ($param["status"] == "7") {
            $doc2_date = $this->convert_date3($param["follow_date"]) . " " . date('H:i:s');
            $data_update["suggestion_follow_three_month2_date"] = $doc2_date;
            $data_update["suggestion_follow_three_month2_docnumber"] = $param["follow_doc"];
            $data_update["suggestion_follow_three_month2_person"] = $param["person_follow"];
        } else if ($param["status"] == "8") {
            $doc2_date = $this->convert_date3($param["follow_date"]) . " " . date('H:i:s');
            $data_update["suggestion_follow_three_month3_date"] = $doc2_date;
            $data_update["suggestion_follow_three_month3_docnumber"] = $param["follow_doc"];
            $data_update["suggestion_follow_three_month3_person"] = $param["person_follow"];
        } else if ($param["status"] == "9") {
            $doc2_date = $this->convert_date3($param["follow_date"]) . " " . date('H:i:s');
            $data_update["suggestion_follow_three_month4_date"] = $doc2_date;
            $data_update["suggestion_follow_three_month4_docnumber"] = $param["follow_doc"];
            $data_update["suggestion_follow_three_month4_person"] = $param["person_follow"];
        }


        $this->db->trans_begin();
        $this->db->where('suggestion_id', $param["sugges_id"]);
        $this->db->update('tbl_suggestion', $data_update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_commit();
            $status = 1;
        }

        echo $status;
    }

    function convert_date($date) {
        $textday = "";
        $date_ex = explode(" ", $date);
        $date_ex2 = explode("-", $date_ex[0]);
        $yyyy = $date_ex2[0] + 543;
        $mm = $date_ex2[1];
        $dd = $date_ex2[2];
        $textday = $dd . "/" . $mm . "/" . $yyyy;
        return $textday;
    }

    function convert_date2($date) {
        $date_ex2 = explode("-", $date);

        $yyyy = $date_ex2[0] + 543;
        $mm = $date_ex2[1];
        $dd = $date_ex2[2];
        $textday = $dd . "/" . $mm . "/" . $yyyy;
        return $textday;
    }

    function convert_date3($date) {
        $date_ex2 = explode("/", $date);

        $yyyy = $date_ex2[2] - 543;
        $mm = $date_ex2[1];
        $dd = $date_ex2[0];
        $textday = $yyyy . "-" . $mm . "-" . $dd;
        return $textday;
    }

    public function noti() {
        $empQuery = "SELECT *,ROW_NUMBER() OVER(PARTITION BY fk_project_id) as row FROM tbl_status 
left JOIN tbl_suggestion
ON tbl_suggestion.suggestion_id  = tbl_status.FK_suggestion_id
left JOIN tbl_subject
ON tbl_subject.subject_id  = tbl_suggestion.FK_subject_id
left JOIN tbl_project
ON tbl_project.project_id  = tbl_subject.FK_project_id
WHERE " . $searchQuery . "$searchDate
subject_status_delete !=  'del' and status_name = 'progress' or tbl_status.status_name = 'no' AND suggestion_duedate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL '" . $day . "'DAY)  AND 
suggestion_status_delete != 'del '";

        $empQuery2 = $this->db->query($empQuery, FALSE)->result_array();


        $data = array();
        foreach ($empQuery2 as $value) {




            $data[] = array(
                "project_name" => $value['project_name'],
                "subject_name" => $value['subject_name'],
                "suggestion_name" => $value['suggestion_name'],
                "suggestion_docnumber" => $value['suggestion_docnumber'],
                "project_create_date" => $this->convert_date($value['project_create_date']),
                "suggestion_id" => $dropdown,
                "project_id" => '<a class = "btn btn-primary btn-sm" href = "' . base_url('Notification/notification_detail/') . $value['project_id'] . '?per_page=' . $page . '">รายละเอียด</a>',
            );
            $this->notify_message($value["project_name"]);
        }
    }

    public function user_autocomplete() {
        $string = 'SELECT  CONCAT(first_name,"  ",last_name) AS name from tbl_user';
        $query = $this->db->query($string, FALSE)->result_array();
        $array = [];

        foreach ($query as $key => $value) {
            $array[] = $value["name"];
        }

        echo json_encode($array, JSON_UNESCAPED_UNICODE);
    }

}
