<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library("pagination");
        if (!isset($_SESSION['user'])) {
            echo '<script>window.location.href  =' . '"' . base_url('login') . '"' . '</script>';
        }
    }

    public function index() {
        $data = [];

        $search = $this->input->get('');
        $per_page = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $page = ($per_page) ? $per_page : 0;


        $config = array();
        $config["base_url"] = base_url("Notification?") . $this->input->get("search_project_name");
        $config["total_rows"] = $this->get_count();
        $config["per_page"] = 5;


        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination justify-content-end">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['page_query_string'] = TRUE;
        $data['search'] = $search;



        $this->pagination->initialize($config);


        $data['page'] = $page;
        $data["links"] = $this->pagination->create_links();

        $data['notis'] = $this->get_noti($config["per_page"], $page);


        $data['controller'] = $this;

        return $this->load->view("notification_list_backup", $data);
    }

    public function get_count() {


        $group = $_SESSION["user"]["0"]["group"];

        if ($group != 0) {
            $sel = $this->db->select("count(*) as allcount")
                            ->from("tbl_status")
                            ->join("tbl_suggestion", "tbl_suggestion.suggestion_id = tbl_status.FK_suggestion_id", "left")
                            ->join("tbl_subject", "tbl_subject.subject_id = tbl_status.FK_subject_id", "left")
                            ->join("tbl_project", "tbl_project.project_id = tbl_subject.FK_project_id", "left")
                            ->where("project_status_delete =", "")
                            ->where("project_group", $group)
                            ->get()->result_array();
            $totalRecords = $sel[0]['allcount'];
        } else {
            $sel = $this->db->select("count(*) as allcount")
                            ->from("tbl_status")
                            ->join("tbl_suggestion", "tbl_suggestion.suggestion_id = tbl_status.FK_suggestion_id", "left")
                            ->join("tbl_subject", "tbl_subject.subject_id = tbl_status.FK_subject_id", "left")
                            ->join("tbl_project", "tbl_project.project_id = tbl_subject.FK_project_id", "left")
                            ->where("project_status_delete =", "")
                            ->get()->result_array();
            $totalRecords = $sel[0]['allcount'];
        }


        return $totalRecords;
    }

    public function get_noti($limit, $start) {
//        $this->db->where('order_date >=', $first_date);
//        $this->db->where('order_date <=', $second_date);
        $group = $_SESSION["user"]["0"]["group"];

        if ($group != 0) {
            $this->db->limit($limit, $start);
            $empQuery = $this->db->select("*")
                            ->from("tbl_status")
                            ->join("tbl_suggestion", "tbl_suggestion.suggestion_id = tbl_status.FK_suggestion_id", "left")
                            ->join("tbl_subject", "tbl_subject.subject_id = tbl_status.FK_subject_id", "left")
                            ->join("tbl_project", "tbl_project.project_id = tbl_subject.FK_project_id", "left")
                            ->where("project_status_delete =", "")
                            ->where("project_group", $group)
                            ->get()->result_array();
        } else {
            $this->db->limit($limit, $start);
            $empQuery = $this->db->select("*")
                            ->from("tbl_status")
                            ->join("tbl_suggestion", "tbl_suggestion.suggestion_id = tbl_status.FK_suggestion_id", "left")
                            ->join("tbl_subject", "tbl_subject.subject_id = tbl_status.FK_subject_id", "left")
                            ->join("tbl_project", "tbl_project.project_id = tbl_subject.FK_project_id", "left")
                            ->where("project_status_delete =", "")
                            ->get()->result_array();
        }

        return $empQuery;
    }
	
	
	
	public function update_process2($project_id) {
		 $project = $this->db->select("project_user_process")->where("project_id", $project_id)->get("tbl_project")->result_array();
	$project_user_process = "";
	
	 $per_code = $_SESSION["user"]["0"]["PER_CODE"];
	if ($project[0]["project_user_process"] == 0) {
            $data_update = [
                "project_user_process" => $per_code,
            ];

            $this->db->trans_begin();

            $this->db->where('project_id', $project_id);
            $this->db->update('tbl_project', $data_update);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                "no";
            } else {
                $this->db->trans_commit();
                $project = $this->db->select("project_user_process")->where("project_id", $project_id)->get("tbl_project")->result_array();
               $project_user_process =  $project[0]["project_user_process"];
            }
        } else {
            $project_user_process = $project[0]["project_user_process"];
        }
		return $project_user_process;
	
	}
	

    public function ajaxfile() {
        $day = 7;


        if ($_SESSION["user"]["0"]["group"] != 0) {

            $group = 'project_group = ' . $_SESSION["user"]["0"]["group"] . ' and ';
        } else {
            $group = '';
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
WHERE " . $searchQuery . "$searchDate  $group
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
WHERE " . $searchQuery . " $searchDate $group subject_status_delete !=  'del'  
and project_status_delete !=  'del'
and status_name = 'progress' or tbl_status.status_name = 'no' AND suggestion_duedate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL '" . $day . "'DAY) AND suggestion_status_delete != 'del'";



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



        $empQuery = "SELECT *,ROW_NUMBER() OVER(PARTITION BY fk_project_id) as row FROM tbl_status 
left JOIN tbl_suggestion
ON tbl_suggestion.suggestion_id  = tbl_status.FK_suggestion_id
left JOIN tbl_subject
ON tbl_subject.subject_id  = tbl_suggestion.FK_subject_id
left JOIN tbl_project
ON tbl_project.project_id  = tbl_subject.FK_project_id
WHERE " . $searchQuery . "$searchDate $group
subject_status_delete !=  'del' and project_status_delete !=  'del'
and status_name = 'progress' or tbl_status.status_name = 'no' AND suggestion_duedate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL '" . $day . "'DAY)  AND 
suggestion_status_delete != 'del ' order by suggestion_id ASC" . " limit " . $row . ", " . $rowperpage;;


        $empQuery2 = $this->db->query($empQuery, FALSE)->result_array();
//        $datalist = $this->db->select("*")
//        ->from("tbl_statussd")
//                ->join("tbl_subject", "tbl_subject.subject_id = tbl_status.FK_subject_id", "left")
//                ->join("tbl_project", "tbl_project.project_id = tbl_subject.FK_project_id", "left")
//                ->get()->result_array();

        $data = array();
		
		
		$row_number = 0;
        $row_numberSub = 0;
		     $count = 0;
        foreach ($empQuery2 as $value) {
            if ($value["project_status_delete"] == "") {

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


				$count++;
                if ($empQuery2[$count - 1]["project_id"] != $value["project_id"]) {
                    $row_number = 0;
                } else if ($empQuery2[$count - 1]["project_id"] == $value["project_id"]) {
                    if ($empQuery2[$count - 1]["subject_id"] != $value["subject_id"]) {
                        $row_number++;
                    }
                }

             

                $data[] = array(
                    "project_name" => '<div style="word-wrap: break-word;width:50em;">' . $value['project_name'] . '<br>งานตรวจสอบสาย ' . $value['project_group'] . ' ปีงบประมาณ ' . $value['project_year'] . "</div>",
                    "subject_name" => $value['subject_name'],
                    "suggestion_name" => $value['suggestion_name'],
                    "suggestion_docnumber" => $value['project_docnumber'],
                    "project_create_date" => $this->convert_date($value['project_create_date']),
                    "suggestion_id" => $text_,
                    "project_id" => '<a class="btn btn-primary btn-sm" href="' . base_url('Notification/notification_detail/') . $value['project_id'] . '?per_page=' . $row_number . '">รายละเอียด</a>',
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

    public function notification_detail() {
        $data = [];


        $per_page = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $page = ($per_page) ? $per_page : 0;

        $search = "";
        $config = array();
        $config["base_url"] = base_url("notification/notification_detail/" . $this->uri->segment(3));
        $config["total_rows"] = $this->get_count_subject($search);
        $config["per_page"] = 1;
//        $config['per_page'] = 20;

        $config['next_link'] = 'ถัดไป';
        $config['prev_link'] = 'ก่อนหน้า';
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination justify-content-end">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['page_query_string'] = TRUE;
        $data['search'] = $search;



        $this->pagination->initialize($config);


        if ($this->uri->segment(3) != "") {

            $group = $_SESSION["user"]["0"]["group"];

            if ($group != 0) {
                $data['page'] = $page;
                $data["links"] = $this->pagination->create_links();
//                $empQuery = $this->db->select("*")
//                                ->from("tbl_project")
//                                ->join('tbl_subject', 'tbl_subject.FK_project_id = tbl_project.project_id', 'left')
//                                ->where("project_group = ", $_SESSION["user"]["0"]["group"])
//                                ->where("project_id", $this->uri->segment(3))->get()->result_array();
                $empQuery = $this->get_subject($config["per_page"], $page, $search);
//limit,start,ค้นหา

                if (count($empQuery) > 0) {
					$project_user_process = $this->update_process2($empQuery[0]["project_id"]);
                    $date_str = explode("-", $empQuery[0]["project_create_date"]);
                    $dd = $date_str[2];
                    $mm = $date_str[1];
                    $yyyy = $date_str[0] + 543;
//echo $dd."/".$mm."/".$yyyy;



                    $subject = $this->db->select("*")
                                    ->from("tbl_subject")
                                    ->where("FK_project_id", $this->uri->segment(3))
                                    ->where("subject_status_delete != ", "del")
                                    ->limit($config["per_page"], $page)
                                    ->get()->result_array();

                    $data = [
                        "project_id" => $empQuery[0]["project_id"],
                        "project_name" => $empQuery[0]["project_name"],
                        "project_year" => $empQuery[0]["project_year"],
                        "project_create_date" => $this->convert_date($empQuery[0]["project_create_date"]),
                        "project_update_date" => $this->convert_date_time3($empQuery[0]["project_update_date"]),
						  "project_create_date2" => $this->convert_date_time3($empQuery[0]["project_create_date"]),
                        "dd" => $date_str[2],
                        "mm" => $date_str[1],
                        "yyyy" => $date_str[0],
                        "url_form" => base_url("index.php/Home/update_project"),
                        "array_subject" => $subject,
                        "project_docnumber" => $empQuery[0]["project_docnumber"],
                        "project_group" => $empQuery[0]['project_group'],
						"project_user_process" => $project_user_process,
                    ];

                    $data['links'] = $this->pagination->create_links();


                    $data['sugges'] = $this;
                    $data['controller'] = $this;
                    $this->load->view("notification_detail", $data);
                } else {
                    redirect("Home");
                }
            } else {
//             $data['page'] = $page;
                $data["links"] = $this->pagination->create_links();
//                $empQuery = $this->db->select("*")
//                                ->from("tbl_project")
//                                ->join('tbl_subject', 'tbl_subject.FK_project_id = tbl_project.project_id', 'left')
//                                ->where("project_group = ", $_SESSION["user"]["0"]["group"])
//                                ->where("project_id", $this->uri->segment(3))->get()->result_array();
                $empQuery = $this->get_subject($config["per_page"], $page, $search);
//limit,start,ค้นหา

                if (count($empQuery) > 0) {
					$project_user_process = $this->update_process2($empQuery[0]["project_id"]);
                    $date_str = explode("-", $empQuery[0]["project_create_date"]);
                    $dd = $date_str[2];
                    $mm = $date_str[1];
                    $yyyy = $date_str[0] + 543;
//echo $dd."/".$mm."/".$yyyy;



                    $subject = $this->db->select("*")
                                    ->from("tbl_subject")
                                    ->where("FK_project_id", $this->uri->segment(3))
                                    ->where("subject_status_delete != ", "del")
                                    ->limit($config["per_page"], $page)
                                    ->get()->result_array();

                    $data = [
                        "project_id" => $empQuery[0]["project_id"],
                        "project_name" => $empQuery[0]["project_name"],
                        "project_year" => $empQuery[0]["project_year"],
                        "project_create_date" => $this->convert_date($empQuery[0]["project_create_date"]),
                        "project_update_date" => $this->convert_date_time3($empQuery[0]["project_update_date"]),
                          "project_create_date2" => $this->convert_date_time3($empQuery[0]["project_create_date"]),
						"dd" => $date_str[2],
                        "mm" => $date_str[1],
                        "yyyy" => $date_str[0],
                        "url_form" => base_url("index.php/Home/update_project"),
                        "array_subject" => $subject,
                        "project_docnumber" => $empQuery[0]["project_docnumber"],
                        "project_group" => $empQuery[0]["project_group"],
						 "project_user_process" => $project_user_process,
                    ];


                    $data['links'] = $this->pagination->create_links();


                    $data['sugges'] = $this;
                    $data['controller'] = $this;
                    $this->load->view("notification_detail", $data);
                } else {
                    redirect("Home");
                }
            }
        }
    }

    public function get_count_subject($match) {
//        $group = $_SESSION["user"]["0"]["group"];
//        $this->db->like("project_name", $match);
//        $this->db->where("project_group", $group);
        if ($_SESSION["user"]["0"]["group"] != 0) {
            $query = $this->db->select("*")
                            ->from("tbl_project")
                            ->join('tbl_subject', 'tbl_subject.FK_project_id = tbl_project.project_id', 'left')
                            ->where("project_group = ", $_SESSION["user"]["0"]["group"])
                            ->where("subject_status_delete != ", "del")
                            ->where("project_id", $this->uri->segment(3))->get()->result_array();

            $count = count($query);
        } else {
            $query = $this->db->select("*")
                            ->from("tbl_project")
                            ->join('tbl_subject', 'tbl_subject.FK_project_id = tbl_project.project_id', 'left')
                            ->where("subject_status_delete != ", "del")
                            ->where("project_id", $this->uri->segment(3))->get()->result_array();

            $count = count($query);
        }

        return $count;
    }

    public function get_subject($limit, $start, $match) {
        if ($_SESSION["user"]["0"]["group"] != 0) {
            $query = $this->db->select("*")
                            ->from("tbl_project")
                            ->join('tbl_subject', 'tbl_subject.FK_project_id = tbl_project.project_id', 'left')
                            ->limit($limit, $start)
                            ->where("project_group = ", $_SESSION["user"]["0"]["group"])
                            ->where("subject_status_delete != ", "del")
                            ->where("project_id", $this->uri->segment(3))->get()->result_array();
        } else {
            $query = $this->db->select("*")
                            ->from("tbl_project")
                            ->join('tbl_subject', 'tbl_subject.FK_project_id = tbl_project.project_id', 'left')
                            ->limit($limit, $start)
                            ->where("subject_status_delete != ", "del")
                            ->where("project_id", $this->uri->segment(3))->get()->result_array();
        }


        return $query;
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

    public function alert() {
        $day = 7;

        $data = [];

        $follow_query = $this->db->query("SELECT * FROM tbl_follow WHERE follow_Date
BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL '" . $day . "' DAY) AND follow_status_delete != 'del'")->result_array();


        if (count($follow_query) > 0) {
            foreach ($follow_query as $value) {
                $sugges_query = $this->db->query("SELECT * FROM tbl_status
left JOIN tbl_suggestion
ON tbl_suggestion.suggestion_id = tbl_status.FK_suggestion_id
left JOIN tbl_subject
ON tbl_subject.subject_id = tbl_suggestion.FK_subject_id
left JOIN tbl_project
ON tbl_project.project_id = tbl_subject.FK_project_id
WHERE status_name = 'progress' or tbl_status.status_name = 'no' AND
suggestion_duedate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL '" . $day . "' DAY)
AND suggestion_status_delete != 'del' and suggestion_id = '" . $value["FK_suggestion_id"] . "'")->result_array();
                $data[] = $sugges_query;
//                echo 1;
//                echo "<br>";
            }
        } else if (count($follow_query) <= 0) {
            $sugges_query2 = $this->db->query("SELECT * FROM tbl_status
left JOIN tbl_suggestion
ON tbl_suggestion.suggestion_id = tbl_status.FK_suggestion_id
left JOIN tbl_subject
ON tbl_subject.subject_id = tbl_suggestion.FK_subject_id
left JOIN tbl_project
ON tbl_project.project_id = tbl_subject.FK_project_id
WHERE suggestion_duedate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL '" . $day . "'DAY) AND
status_name = 'progress' or tbl_status.status_name = 'no' AND
suggestion_status_delete != 'del'")->result_array();
            $data[] = $sugges_query2;
//            echo 2;
//            echo "<br>";
        }
        print_r($data[0]);
//        echo json_encode($data[0]);
//เตือน 
    }

    public function alert2() {
        $group = 0;
        $day = 7;
        $result = [];
        $data = [];


        if ($group == 0) {
            $follow_query = $this->db->query("SELECT *,ROW_NUMBER() OVER(PARTITION BY fk_project_id) as row  FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status
ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE project_status_delete = '' AND
(suggestion_duedate BETWEEN NOW() AND
DATE_ADD(NOW(), INTERVAL 7 DAY) OR suggestion_duedate) and status_name = 'progress' or tbl_status.status_name = 'no'")->result_array();
        } else {
            $follow_query = $this->db->query("SELECT *,ROW_NUMBER() OVER(PARTITION BY fk_project_id) as row  FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status
ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE project_status_delete = '' and project_group = '" . $group . "' AND
(suggestion_duedate BETWEEN NOW() AND
DATE_ADD(NOW(), INTERVAL 7 DAY) OR suggestion_duedate) and status_name = 'progress' or tbl_status.status_name = 'no'")->result_array();
        }
        if (count($follow_query) > 0) {
            $data[] = $follow_query;
            foreach ($follow_query as $value) {
                if ($value["subject_status_delete"] != 'del') {
                    $result[$value['project_name']][] = $value;
                }
            }
        } else if (count($follow_query) <= 0) {
            if ($group == 0) {
                $string = "SELECT * FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status
ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE project_status_delete = '' and status_name = 'progress' or tbl_status.status_name = 'no'";
            } else {
                $string = "SELECT * FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status
ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE project_status_delete = '' and project_group = '" . $group . "' and status_name = 'progress' or tbl_status.status_name = 'no'";
            }
            $follow_query = $this->db->query($string)->result_array();


            foreach ($follow_query as $value) {

                if ($value["subject_status_delete"] != 'del') {

                    $result[$value['project_name']][] = $value;
                }
                $result[$value['project_name']][] = $value;
            }
        }

        $this->noti_box($result);
    }

    function noti_box($result) {
        $respon = [];
        $i = 0;
        foreach ($result as $key => $value) {
            $project_name = $key;
            foreach ($value as $key2 => $value2) {

                $duedate = date_create($value2["suggestion_duedate"]);
                $datenow = date_create(date("Y-m-d", strtotime("-7 days")));
//                $datenow = date_create(date("Y-m-d"));
                $interval = date_diff($datenow, $duedate);



                if ($interval->invert == 0 && $interval->days == 7) {
                    if ($value2["suggestion_status_follow"] == 0) {
                        $alert_txt = "";
                        $respon[$i] = array(
                            "project_name" => array("project_name" => $project_name),
                            "value2" => $value2,
                            "alert_txt" => array("alert_txt" => $alert_txt)
                        );
                    }
                } else if ($interval->invert == 1 && $interval->days == 30) {
                    $alert_txt = "* แจ้งหนังสือติดตามครั้งที่ 4 ล่าช้า 30 วัน";
                    $respon[$i] = array(
                        "project_name" => array("project_name" => $project_name),
                        "value2" => $value2,
                        "alert_txt" => array("alert_txt" => $alert_txt)
                    );
                } else if ($interval->invert == 1 && $interval->days >= 15) {
                    if ($value2["suggestion_status_follow"] == 1) {
                        $alert_txt = "* แจ้งทางโทรศัพท์  ครั้งที่ 2 ล่าช้า 3 วัน";
                        $respon[$i] = array(
                            "project_name" => array("project_name" => $project_name),
                            "value2" => $value2,
                            "alert_txt" => array("alert_txt" => $alert_txt)
                        );
                    } else if ($value2["suggestion_status_follow"] == 2) {
                        $alert_txt = "* แจ้งหนังสือติดตามครั้งที่ 3 ล่าช้า 15 วัน";
                        $respon[$i] = array(
                            "project_name" => array("project_name" => $project_name),
                            "value2" => $value2,
                            "alert_txt" => array("alert_txt" => $alert_txt)
                        );
                    } else if ($value2["suggestion_status_follow"] != 3) {
                        if ($value2["suggestion_status_follow"] == 0) {
                            $alert_txt = "* แจ้งทางโทรศัพท์  ครั้งที่ 1 ล่วงหน้า 7 วัน";
                            $respon[$i] = array(
                                "project_name" => array("project_name" => $project_name),
                                "value2" => $value2,
                                "alert_txt" => array("alert_txt" => $alert_txt)
                            );
                        } else if ($value2["suggestion_status_follow"] == 1) {
                            $alert_txt = "* แจ้งทางโทรศัพท์  ครั้งที่ 2 ล่าช้า 3 วัน";
                            $respon[$i] = array(
                                "project_name" => array("project_name" => $project_name),
                                "value2" => $value2,
                                "alert_txt" => array("alert_txt" => $alert_txt)
                            );
                        }
                    }
                } else if ($interval->invert == 1 && $interval->days >= 3) {
                    if ($value2["suggestion_status_follow"] == 0) {
                        $alert_txt = "* แจ้งทางโทรศัพท์  ครั้งที่ 1 ล่วงหน้า 7 วัน";
                        $respon[$i] = array(
                            "project_name" => array("project_name" => $project_name),
                            "value2" => $value2,
                            "alert_txt" => array("alert_txt" => $alert_txt)
                        );
                    } else if ($value2["suggestion_status_follow"] == 1) {
                        $alert_txt = "* แจ้งทางโทรศัพท์  ครั้งที่ 2 ล่าช้า 3 วัน";
                        $respon[$i] = array(
                            "project_name" => array("project_name" => $project_name),
                            "value2" => $value2,
                            "alert_txt" => array("alert_txt" => $alert_txt)
                        );
                    } else if ($value2["suggestion_status_follow"] == 2) {
                        $alert_txt = "* แจ้งหนังสือติดตามครั้งที่ 3 ล่าช้า 15 วัน";
                        $respon[$i] = array(
                            "project_name" => array("project_name" => $project_name),
                            "value2" => $value2,
                            "alert_txt" => array("alert_txt" => $alert_txt)
                        );
                    }
                }
                $i++;
            }
        }
//        print_r($respon);
        echo json_encode($respon);
    }

    public function detail1() {
        $group = $_SESSION["user"]["0"]["group"];
        $result = [];

        $data = [];
        $result = [];
        $follow_query = $this->db->query("SELECT * FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
WHERE project_group = '" . $group . "'")->result_array();


        if (count($follow_query) > 0) {
            $data[] = $follow_query;
            foreach ($follow_query as $value) {
//                print_r($value);
                array_push($result, array(
                    'ลำดับ',
                    $value['subject_name'],
                    $value['suggestion_name'],
                    $value['suggestion_respon'],
                    $value['suggestion_duedate'],
                    $value['suggestion_startdate'],
                    'วันที่รับรายงานตอบกลับ',
                    'ผลการปฏิบัติตามข้อเสนอแนะ',
                    'ดำเนินการแล้ว',
                    'อยู่ระหว่างดำเนินการ',
                    'ยังไม่ได้ดำเนินการ',
                    'วัน เดือน ปีที่ติดตาม',
                    'การติดตาม'
                ));
            }
        }

//        print_r($result);

        echo json_encode($result);
    }

    public function detail() {
        $group = $_SESSION["user"]["0"]["group"];

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
            $searchQuery = " and (suggestion_name like '%" . $searchValue . "%'";
        }

## Total number of records without filtering
//        $sel = "select count(*) as allcount from tbl_project";
        $sel = $this->db->select("count(*) as allcount")
                        ->from("tbl_project")
                        ->join("tbl_subject", "tbl_subject.FK_project_id = tbl_project.project_id", "left")
                        ->join("tbl_suggestion", "tbl_suggestion.FK_subject_id = tbl_subject.subject_id", "left")
                        ->join("tbl_anwser", "tbl_anwser.FK_suggestion_id = tbl_suggestion.suggestion_id", "left")
                        ->join("tbl_status", "tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id", "left")
                        ->where("project_group", $group)->get()->result_array();

        $totalRecords = $sel[0]['allcount'];



## Total number of record with filtering
//        $sel = "select count(*) as allcount from tbl_project WHERE 1 " . $searchQuery . 'and project_status_delete  = ""';
        $sel = "SELECT count(*) as allcount FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_anwser
ON tbl_anwser.FK_suggestion_id = tbl_suggestion.suggestion_id
left JOIN tbl_status ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE 1 " . $searchQuery . 'and project_status_delete  = "" and project_group  ="' . $group . '"' . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . ", " . $rowperpage;

        $records = $this->db->query($sel, FALSE)->result_array();
        $totalRecordwithFilter = $records[0]["allcount"];
//        
//## Fetch records
//        $empQuery = "select * from tbl_project WHERE 1" . $searchQuery . 'and project_status_delete  = ""' . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . ", " . $rowperpage;


        $empQuery = "SELECT * FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_anwser
ON tbl_anwser.FK_suggestion_id = tbl_suggestion.suggestion_id
left JOIN tbl_status ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE project_group = " . $group;
        $empQuery2 = $this->db->query($empQuery, FALSE)->result_array();


        $data = array();
        foreach ($empQuery2 as $value) {
            $data[] = array(
                "subject_name" => 1,
                "subject_name" => $value['subject_name'],
                "suggestion_name" => $value['suggestion_name'],
                "suggestion_startdate" => $value['suggestion_startdate'],
                "suggestion_duedate" => $value['suggestion_duedate'],
                "anwser_respone_date" => $value['anwser_respone_date'],
                "anwser_name" => $value['anwser_name'],
                "anwser_name" => $value['project_create_date'],
                "anwser_name" => $value['project_create_date'],
                "anwser_name" => $value['project_create_date'],
                "anwser_name" => $value['project_create_date'],
                "anwser_name" => '',
                "anwser_name" => $value['project_create_date'],
            );
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

    function convert_date2($date) {
        $textday = "";
        $date_ex = explode("/", $date);

        $yyyy = $date_ex[2] - 543;
        $mm = $date_ex[1];
        $dd = $date_ex[0];
        $textday = $yyyy . "-" . $mm . "-" . $dd;
        return $textday;
    }

    public function notify_message() {
        $group = $_SESSION["user"]["0"]["group"];
        $day = 7;
        $result = [];
        $data = [];


        if ($group == 0) {
            $follow_query = $this->db->query("SELECT * FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status
ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE project_status_delete = '' and status_name = 'progress' or tbl_status.status_name = 'no'AND
(suggestion_duedate BETWEEN NOW() AND
DATE_ADD(NOW(), INTERVAL 7 DAY) OR suggestion_duedate)")->result_array();
        } else {
            $follow_query = $this->db->query("SELECT * FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status
ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE project_status_delete = '' and project_group = '" . $group . "' and status_name = 'progress' or tbl_status.status_name = 'no'AND
(suggestion_duedate BETWEEN NOW() AND
DATE_ADD(NOW(), INTERVAL 7 DAY) OR suggestion_duedate)")->result_array();
        }
        if (count($follow_query) > 0) {
            $data[] = $follow_query;
            foreach ($follow_query as $value) {
                $result[$value['project_name']][] = $value;
            }
        } else if (count($follow_query) <= 0) {
            if ($group == 0) {
                $string = "SELECT * FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status
ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE project_status_delete = '' and status_name = 'progress' or tbl_status.status_name = 'no'AND
(suggestion_duedate BETWEEN NOW() AND
DATE_ADD(NOW(), INTERVAL 7 DAY) OR suggestion_duedate)";
            } else {
                $string = "SELECT * FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status
ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE project_status_delete = '' and project_group = '" . $group . "' and status_name = 'progress' or tbl_status.status_name = 'no' AND
(suggestion_duedate BETWEEN NOW() AND
DATE_ADD(NOW(), INTERVAL 7 DAY) OR suggestion_duedate)";
            }
            $follow_query = $this->db->query($string)->result_array();


            foreach ($follow_query as $value) {
                $result[$value['project_name']][] = $value;
            }
        }
        $this->noti_line($result);
    }

    function noti_line($result) {
        print_r($result);
        foreach ($result as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $subject_name = $value2["subject_name"];
                $suggestion_name = $value2["suggestion_name"];
            }
        }

        foreach ($result as $key => $value) {
            $project_name = $key;

            foreach ($value as $key2 => $value2) {
                print_r($value2["subject_name"]);
                print_r($value2["suggestion_name"]);



                $token = "vBESmBZRFWGSb64IQnbt63sltEglv4cXMgGOX0OtDUn";
                $notifyURL = "https://notify-api.line.me/api/notify";

                $headers = array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Bearer ' . $token
                );

                $stickerPkg = 2; //stickerPackageId
                $stickerId = 34; //stickerId


                $code = '100035'; // emoji id

                $bin = hex2bin(str_repeat('0', 8 - strlen($code)) . $code);
                $emoticon = mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
//                $emoticon = "";

                $text = $this->br2nl('<br>' . $emoticon . 'แจ้งเตือน สาย ' . $value2["project_group"] . '<br>เรื่อง ' . $project_name . '<br>&nbsp;&nbsp;ประเด็น : ' . $value2["subject_name"] . '<br>&nbsp;&nbsp;&nbsp;มิติที่ประชุม : ' . $value2["suggestion_name"]);

//                $text = $this->br2nl($text . '<br>');
                $text = str_ireplace('<p>', '', $text);
                $text = str_ireplace('</p>', '', $text);
                $text = str_ireplace("&nbsp;", ' ', $text);

                $message = $text;

                $queryData = array(
                    'message' => $message,
//                    'stickerPackageId' => $stickerPkg,
//                    'stickerId' => $stickerId
                );


// ส่วนของการส่งการแจ้งเตือนผ่านฟังก์ชั่น cURL
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $notifyURL);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($queryData));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // ถ้าเว็บเรามี ssl สามารถเปลี่ยนเป้น 2
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // ถ้าเว็บเรามี ssl สามารถเปลี่ยนเป้น 1
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                curl_close($ch);

// ตรวจสอบค่าข้อมูล ว่าเป็นตัวแปร ปรเภทไหน ข้อมูลอะไร
                var_dump($result);

// การเช็คสถานะการทำงาน 
                $result = json_decode($result, TRUE);
// ดูโครงสร้าง กรณีแปลงเป็น array แล้ว
//echo "<pre>";
//print_r($result);
// ตรวจสอบข้อมูล ใช้เป็นเงื่อนไขในการทำงาน
                if (!is_null($result) && array_key_exists('status', $result)) {
                    if ($result['status'] == 200) {
                        echo "Pass";
                    }
                }
            }
        }
    }

    function br2nl($input) {
        return preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n", "", str_replace("\r", "", htmlspecialchars_decode($input))));
    }

    function convert_date_time3($date) {
        $textday = "";
        $date_ex = explode(" ", $date);
        $date_ex2 = explode("-", $date_ex[0]);
        $yyyy = $date_ex2[0];
        $mm = $date_ex2[1];
        $dd = $date_ex2[2];
        $textday = $yyyy . "-" . $mm . "-" . $dd;
        return $textday;
    }

}
