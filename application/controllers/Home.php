<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    protected $table = 'tbl_project';

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library("pagination");
        if (@$_SESSION['user'][0] != null or @$_SESSION['user'][0] != "") {
            
        } else {
            echo '<script>window.location.href  =' . '"' . base_url('login') . '"' . '</script>';
        }
    }

    public function leave_detail() {

        $data_update = [
            "project_user_process" => 0,
        ];

        $this->db->trans_begin();

        $this->db->where('project_id', $this->input->post('project_id'));
        $this->db->update('tbl_project', $data_update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 0;
        } else {
            $this->db->trans_commit();
            echo 1;
        }
    }

//public function update_process($project_user_process, $per_code, $project_id) {
    public function update_process() {
        $proj_id = @$this->input->post("proj_id");
        $project = $this->db->select("project_user_process")->where("project_id", $proj_id)->get("tbl_project")->result_array();


        $per_code = $_SESSION["user"]["0"]["PER_CODE"];

        if (@$project[0]["project_user_process"] == 0) {
            $data_update = [
                "project_user_process" => $per_code,
            ];

            $this->db->trans_begin();

            $this->db->where('project_id', $proj_id);
            $this->db->update('tbl_project', $data_update);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "no";
            } else {
                $this->db->trans_commit();
                $project = $this->db->select("project_user_process")->where("project_id", $proj_id)->get("tbl_project")->result_array();
                $user = $this->db->select("*")
                                ->from("tbl_user")
                                ->where("PER_CODE", $project[0]["project_user_process"])
                                ->get()->result_array();

                //echo @$project[0]["project_user_process"];
                $array_user = array(
                    "name" => 'ผู้กำลังใช้งาน : ' . $user[0]["FIRST_NAME"] . " " . $user[0]["LAST_NAME"],
                    "project_user_process" => @$project[0]["project_user_process"]
                );
                echo json_encode($array_user);
            }
        } else {
            $user = $this->db->select("*")
                            ->from("tbl_user")
                            ->where("PER_CODE", $project[0]["project_user_process"])
                            ->get()->result_array();

            $array_user = array(
                "name" => 'ผู้กำลังใช้งาน : ' . $user[0]["FIRST_NAME"] . " " . $user[0]["LAST_NAME"],
                "project_user_process" => @$project[0]["project_user_process"]
            );
            echo json_encode($array_user);
        }
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
                $project_user_process = $project[0]["project_user_process"];
            }
        } else {
            $project_user_process = $project[0]["project_user_process"];
        }
        return $project_user_process;
    }

    public function index() {


        $search = $this->input->get('search_project_name');
        $per_page = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $page = ($per_page) ? $per_page : 0;


        $config = array();
        $config["base_url"] = base_url("home?") . "search_project_name=" . $this->input->get("search_project_name");
        $config["total_rows"] = $this->get_count($search);
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

        $data['projects'] = $this->get_authors($config["per_page"], $page, $search);
        $data['controller'] = $this;
        $this->load->view("project_list", $data);
    }

    function page_boot() {
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<liclass="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<liclass="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        return $config;
    }

    public function get_count($match) {
        $group = $_SESSION["user"]["0"]["group"];

        if ($group != 0 && $group != 100) {
            $this->db->like("project_name", $match);
            $this->db->where("project_group", $group);

            $query = $this->db->get($this->table);
            $count = count($query->result_array());
        } else {
            $this->db->like("project_name", $match);
            $query = $this->db->get($this->table);
            $count = count($query->result_array());
        }


        return $count;
    }

    public function get_authors($limit, $start, $match) {
        $group = $_SESSION["user"]["0"]["group"];

        if ($group != 0 && $group != 100) {
            $this->db->limit($limit, $start);
            $this->db->where("project_group", $group);
            $this->db->like("project_name", $match);
            $this->db->order_by('project_name', 'DESC');
            $query = $this->db->get($this->table);
        } else {
            $this->db->limit($limit, $start);
            $this->db->like("project_name", $match);
            $this->db->order_by('project_name', 'DESC');
            $query = $this->db->get($this->table);
        }



        return $query->result();
    }

    public function get_count_subject_($match) {
        $group = $_SESSION["user"]["0"]["group"];
        if ($group != 0 && $group != 100) {
            $this->db->like("project_name", $match);
            $this->db->where("project_group", $group);

            $query = $this->db->get($this->table);
            $count = count($query->result_array());
        } else {
            $this->db->like("project_name", $match);

            $query = $this->db->get($this->table);
            $count = count($query->result_array());
        }

        return $count;
    }

    public function project() {
        $data = [];
        $data['controller'] = $this;
        return $this->load->view("project_list", $data);
    }

    public function ajaxfile() {

        $group = $_SESSION["user"]["0"]["group"];

        if ($group != 0 && $group != 100) {
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
                $searchQuery = " (project_name like '%" . $searchValue . "%' or
project_create_date like '%" . $searchValue . "%' or project_year = '" . $searchValue . "') and ";
            }

            $searchDate = "";


            if ($_POST['start_date'] != '' and $_POST['end_date'] != '') {
                $searchDate = "project_create_date BETWEEN '" . $this->convert_date2($_POST['start_date']) . "' AND '" . $this->convert_date2($_POST['end_date']) . "' and ";
            }


## Total number of records without filtering
            $sel = "select count(*) as allcount from tbl_project where " . $searchQuery . $searchDate . "project_group = " . $group;
            $records = $this->db->query($sel, FALSE)->result_array();
            $totalRecords = $records[0]['allcount'];

## Total number of record with filtering
            $sel = "select count(*) as allcount from tbl_project WHERE " . $searchQuery . ' ' . $searchDate . ' project_status_delete  = ""' . 'and project_group  ="' . $group . '"';
            $records = $this->db->query($sel, FALSE)->result_array();
            $totalRecordwithFilter = $records[0]["allcount"];


## Fetch records
            $empQuery = "select * from tbl_project WHERE " . $searchQuery . "$searchDate" . ' project_status_delete = "" and project_group  ="' . $group . '"' . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . ", " . $rowperpage;
            $empQuery2 = $this->db->query($empQuery, FALSE);
//        $empQuery = $this->db->select("*")
//                        ->from("tbl_project")
//                        ->order_by($columnName, $columnSortOrder)
//                        ->limit($rowperpage, $row)->get();
            $data = array();


            foreach ($empQuery2->result_array() as $value) {
                $data[] = array(
                    "project_id" => '<div class="row">'
                    . '<div class="col-sm">&nbsp;<a class = "btn btn-primary  btn-block" href = "' . base_url('index.php/Home/project_detail/') . $value['project_id'] . '">รายละเอียด</a>&nbsp;</div>'
                    . '<div class="col-sm">&nbsp;<a class = "btn btn-success btn-block" href = "' . base_url('Export?id=') . $value['project_id'] . '">Export</a>&nbsp;</div>'
                    . '</div>',
                    "project_group" => $value['project_group'],
                    "project_year" => $value['project_year'],
//                    "project_name" =>  $value['project_name'],
                    "project_name" => '<div style="word-wrap: break-word;width:30em;">' . $value['project_name'] . "<div>",
                    "project_create_date" => $this->convert_date($value['project_create_date']),
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
        } else {
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
                $searchQuery = " (project_name like '%" . $searchValue . "%' or
project_create_date like '%" . $searchValue . "%' or project_year = '" . $searchValue . "') and ";
            }

            $searchDate = "";


            if ($_POST['start_date'] != '' and $_POST['end_date'] != '') {
                $searchDate = "project_create_date BETWEEN '" . $this->convert_date2($_POST['start_date']) . "' AND '" . $this->convert_date2($_POST['end_date']) . "' and ";
            }


## Total number of records without filtering
            $sel = "select count(*) as allcount from tbl_project where " . $searchQuery . $searchDate . "project_group != " . 1000;
            $records = $this->db->query($sel, FALSE)->result_array();
            $totalRecords = $records[0]['allcount'];

## Total number of record with filtering
            $sel = "select count(*) as allcount from tbl_project WHERE " . $searchQuery . ' ' . $searchDate . ' project_status_delete  = ""';
            $records = $this->db->query($sel, FALSE)->result_array();
            $totalRecordwithFilter = $records[0]["allcount"];


## Fetch records
            $empQuery = "select * from tbl_project WHERE " . $searchQuery . "$searchDate" . ' project_status_delete = "" ' . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . ", " . $rowperpage;
            $empQuery2 = $this->db->query($empQuery, FALSE);
//        $empQuery = $this->db->select("*")
//                        ->from("tbl_project")
//                        ->order_by($columnName, $columnSortOrder)
//                        ->limit($rowperpage, $row)->get();
            $data = array();


            foreach ($empQuery2->result_array() as $value) {
                $data[] = array(
                    "project_id" => '<div class="row">'
                    . '<div class="col-sm">&nbsp;<a class = "btn btn-primary  btn-block" href = "' . base_url('index.php/Home/project_detail/') . $value['project_id'] . '">รายละเอียด</a>&nbsp;</div>'
                    . '<div class="col-sm">&nbsp;<a class = "btn btn-success btn-block" href = "' . base_url('Export?id=') . $value['project_id'] . '">Export</a>&nbsp;</div>'
                    . '</div>',
                    "project_group" => $value['project_group'],
                    "project_year" => $value['project_year'],
                    "project_name" => '<div style="word-wrap: break-word;width: 30em">' . $value['project_name'] . '<div>',
                    "project_create_date" => $this->convert_date($value['project_create_date']),
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
    }

    public function insert_view() {
        $data = [];
        $this->uri->segment(3);
        if ($this->uri->segment(3) != "") {
            $empQuery = $this->db->select("*")
                            ->from("tbl_project")
                            ->where("project_id", $this->uri->segment(3))->get()->result_array();

            $date_str = explode("-", $empQuery[0]["project_create_date"]);
            $dd = $date_str[2];
            $mm = $date_str[1];
            $yyyy = $date_str[0] + 543;
            //echo $dd."/".$mm."/".$yyyy;
            $data = [
                "project_id" => $empQuery[0]["project_id"],
                "project_name" => $empQuery[0]["project_name"],
                "project_create_date" => $dd . "/" . $mm . "/" . $yyyy . " " . date("h:m:s"),
                "project_update_date" => $dd . "/" . $mm . "/" . $yyyy . " " . date("h:m:s"),
                "project_type_edit" => $empQuery[0]["project_type"],
                "dd" => $date_str[2],
                "mm" => $date_str[1],
                "yyyy" => $date_str[0],
                "url_form" => base_url("index.php/Home/update_project"),
            ];
            $data['controller'] = $this;
            return $this->load->view("project_insert", $data);
        } else {
            $data = [
                "project_id" => null,
                "project_name" => null,
                "project_create_date" => null,
                "dd" => null,
                "mm" => null,
                "yyyy" => null,
                "url_form" => base_url("index.php/Home/insert_project"),
            ];
            $data['controller'] = $this;
            return $this->load->view("project_insert", $data);
        }
    }

    public function insert_project() {
        $param = $this->input->post();
        $explode = explode("/", $param["date"]);
        $date = $explode[2] - 543 . "-" . $explode[1] . "-" . $explode[0];

        $data_insert = [
            "project_name" => $param["project_name"],
            "project_create_date" => $date . " " . date("h:m:s"),
            "project_update_date" => date("Y-m-d h:m:s"),
            "project_user_insert" => $_SESSION["user"]["0"]["PER_CODE"],
//            "project_group" => $_SESSION["user"]["0"]["group"],
            "project_group" => $param["group"],
            "project_year" => $param["year"],
            "project_docnumber" => $param["project_docnumber"],
            "project_type" => $param["project_type"]
        ];

        $this->db->trans_begin();
        $this->db->insert('tbl_project', $data_insert);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $id_project = $this->db->insert_id();
            $this->db->trans_commit();
            redirect("home/project_detail/" . $id_project);
        }
    }

    public function update_project() {
        $param = $this->input->post();

        $explode = explode("/", $param["date"]);
        $date = $explode[2] - 543 . "-" . $explode[1] . "-" . $explode[0];

        $data_update = [
            "project_name" => $param["project_name"],
            "project_create_date" => $date . " " . date("h:m:s"),
            "project_update_date" => date("Y-m-d h:m:s"),
            "project_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
//            "project_group" => $_SESSION["user"]["0"]["group"],
            "project_group" => $param["group"],
            "project_year" => $param["year"],
            "project_docnumber" => $param["project_docnumber"]
        ];

        $this->db->trans_begin();

        $this->db->where('project_id', $param["project_id"]);
        $this->db->update('tbl_project', $data_update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            print_r($this->db->trans_commit());
        }
    }

    public function delect_project() {
        $param = $this->input->post();
//        print_r($param);
        $data_update = [
            "project_status_delete" => "del",
        ];

        $this->db->trans_begin();

        $this->db->where('project_id', $param["project_id_del"]);
        $this->db->update('tbl_project', $data_update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            redirect();
        }
    }

    public function get_subject($limit, $start, $match) {


        if ($_SESSION["user"]["0"]["group"] != 0 && $_SESSION["user"]["0"]["group"] != 100) {
            $query = $this->db->select("*")
                            ->from("tbl_project")
                            ->join('tbl_subject', 'tbl_subject.FK_project_id = tbl_project.project_id', 'left')
                            ->limit($limit, $start)
                            ->where("project_group = ", $_SESSION["user"]["0"]["group"])
                            ->where("project_id", $this->uri->segment(3))->get()->result_array();
        } else {
            $query = $this->db->select("*")
                            ->from("tbl_project")
                            ->join('tbl_subject', 'tbl_subject.FK_project_id = tbl_project.project_id', 'left')
                            ->limit($limit, $start)
                            ->where("project_id", $this->uri->segment(3))->get()->result_array();
        }


        return $query;
    }

    public function get_count_subject($match) {

        if ($_SESSION["user"]["0"]["group"] != 0 && $_SESSION["user"]["0"]["group"] != 100) {
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

    function project_detail() {

        $data = [];


        $per_page = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $page = ($per_page) ? $per_page : 0;

        $search = "";
        $config = array();
        $config["base_url"] = base_url("Home/project_detail/" . $this->uri->segment(3));
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

            if ($group != 0 || $group != 100) {
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
                        "project_create_date" => $this->convert_date_time3($empQuery[0]["project_create_date"]),
                        "project_update_date" => $this->convert_date_time3($empQuery[0]["project_update_date"]),
                        "dd" => $date_str[2],
                        "mm" => $date_str[1],
                        "yyyy" => $date_str[0],
                        "url_form" => base_url("index.php/Home/update_project"),
                        "array_subject" => $subject,
                        "project_docnumber" => $empQuery[0]["project_docnumber"],
                        "project_group" => $empQuery[0]["project_group"],
                        "project_user_process" => $project_user_process,
                        "project_type_edit" => $empQuery[0]["project_type"],
                    ];


                    $data['links'] = $this->pagination->create_links();


                    $data['sugges'] = $this;

                    $query_type_station = $this->db->select("*")->from("tbl_type_subject")->get()->result_array();


                    $data["type_station"] = $query_type_station;
                    $data['controller'] = $this;
                    return $this->load->view("project_detail", $data);
                } else {
                    redirect("Home");
                }
            } else {


//                              $data['page'] = $page;
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
                        "project_create_date" => $this->convert_date_time3($empQuery[0]["project_create_date"]),
                        "project_update_date" => $this->convert_date_time3($empQuery[0]["project_update_date"]),
                        "dd" => $date_str[2],
                        "mm" => $date_str[1],
                        "yyyy" => $date_str[0],
                        "url_form" => base_url("index.php/Home/update_project"),
                        "array_subject" => $subject,
                        "project_docnumber" => $empQuery[0]["project_docnumber"],
                        "project_group" => $empQuery[0]["project_group"],
                        "project_user_process" => $project_user_process,
                        "project_type_edit" => $empQuery[0]["project_type"],
                    ];


                    $data['links'] = $this->pagination->create_links();


                    $data['sugges'] = $this;


                    $data['controller'] = $this;


                    $query_type_station = $this->db->select("*")->from("tbl_type_subject")->get()->result_array();


                    $data["type_station"] = $query_type_station;

                    return $this->load->view("project_detail", $data);
                } else {
                    redirect("Home");
                }
            }
        }
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

    function convert_date_time($date) {
        $textday = "";
        $date_ex = explode(" ", $date);
        $date_ex2 = explode("-", $date_ex[0]);
        $yyyy = $date_ex2[0] + 543;
        $mm = $date_ex2[1];
        $dd = $date_ex2[2];
        $textday = $dd . "/" . $mm . "/" . $yyyy;
        return $textday;
    }

    function convert_date_time2($date) {
        $textday = "";
        $date_ex = explode(" ", $date);
        $date_ex2 = explode("-", $date_ex[0]);
        $yyyy = $date_ex2[0] + 543;
        $mm = $date_ex2[1];
        $dd = $date_ex2[2];
        $textday = $dd . "-" . $mm . "-" . $yyyy;
        return $textday;
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

    function convert_date2($date) {
        $textday = "";
        $date_ex = explode("/", $date);

        $yyyy = $date_ex[2] - 543;
        $mm = $date_ex[1];
        $dd = $date_ex[0];
        $textday = $yyyy . "-" . $mm . "-" . $dd;
        return $textday;
    }

}
