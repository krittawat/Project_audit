<?php

defined('BASEPATH') or exit('No direct script access allowed');

class setpermission extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
     //   if (!isset($_SESSION['user'])) {
            echo '<script>window.location.href  =' . '"' . base_url('Home') . '"' . '</script>';
      //  }
    }

    public function index()
    {
        $data = [];

        $data = $_SESSION["user"]["0"];

        $data['permission'] = array(
            99 => "ผู้บริหาร",
            98 => "Admin",
            97 => "ง.บท.สตส.",
            0 => "ผู้ตรวจสอบ",
        );

        if ($_SESSION["user"]["0"]["image_profile"] == null || $_SESSION["user"]["0"]["image_profile"] == 0 || $_SESSION["user"]["0"]["image_profile"] == "0" || $_SESSION["user"]["0"]["image_profile"] == "") {

            $data["image_profile"] = base_url("assets/uploads/userimg/default.png");
        } else {
            $data["image_profile"] = base_url("assets/uploads/userimg/" . $_SESSION["user"]["0"]["PER_CODE"] . "/" . $_SESSION["user"]["0"]["image_profile"]);
        }
        $data['controller'] = $this;
        return $this->load->view("setpermission_view", $data);
    }

    public function ajaxfile()
    {

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
            $searchQuery = " where FIRST_NAME like '%" . $searchValue . "%' or  LAST_NAME like '%" . $searchValue . "%' ";
        }



        ## Total number of records without filtering
        //        $sel = "select count(*) as allcount from tbl_project";
        $total = $this->db->query("SELECT count(*) as allcount FROM tbl_user 
         " . $searchQuery . " ", FALSE)->result_array();

        $totalRecords = $total[0]['allcount'];


        $sel = "SELECT count(*) as allcount FROM tbl_user 
 " . $searchQuery . "   ";



        $records = $this->db->query($sel, FALSE)->result_array();
        $totalRecordwithFilter = $records[0]["allcount"];
        //        
        //## Fetch records


        $empQuery = "SELECT * FROM tbl_user 
 " . $searchQuery . "  limit " . $row . ", " . $rowperpage;

        //suggestion_duedate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL '" . $day . "'DAY)

        $empQuery2 = $this->db->query($empQuery, FALSE)->result_array();
        //        $datalist = $this->db->select("*")
        //        ->from("tbl_statussd")
        //                ->join("tbl_subject", "tbl_subject.subject_id = tbl_status.FK_subject_id", "left")
        //                ->join("tbl_project", "tbl_project.project_id = tbl_subject.FK_project_id", "left")
        //                ->get()->result_array();

        // print_r($empQuery2);
        $no = 1;


        if (count($empQuery2) > 0) {
            foreach ($empQuery2 as $value) {

                $li = '<div class="row">'
                    . '<div class="col-sm">&nbsp;<a class = "btn btn-primary  btn-block" href = "' . base_url('setpermission/profile_permission/') . $value['PER_CODE'] . '">รายละเอียด</a>&nbsp;</div>'
                    . '</div>';

                if ($value["STATUS"] == 1) {
                    $status = '<div class="form-check text-center">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" value="" checked onclick="update_status(`' . $value["PER_CODE"] . '`,`' . $value["STATUS"] . '`)"> ใช้งาน
                    </label>
                  </div>';
                } else {
                    $status = '<div class="form-check text-center">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" value="" onclick="update_status(`' . $value["PER_CODE"] . '`,`' . $value["STATUS"] . '`)"> ไม่ใช้งาน
                    </label>
                  </div>';
                }



                $data[] = array(
                    "no" => '<div class="text-center">' . $no . '</div>',
                    "name" => $value['FIRST_NAME'] . " " . $value['LAST_NAME'],
                    "POSITION" => $value['POSITION'] . ' ระดับ ' . $value['level_sal'],
                    "status" => $status,
                    "tools" => $li,
                );
                $no++;
            }
        } else {
            $data[] = array(
                "no" => "",
                "name" => "",
                "POSITION" => "",
                "status" => "",
                "tools" => "",
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

    public function profile_permission()
    {
        $data = [];
        $percode = $this->uri->segment(3);
        $q = $this->db->query("SELECT * FROM tbl_user 
        WHERE  PER_CODE = " . "'$percode'", FALSE)->result_array();
        $data['controller'] = $this;
        $data['user'] = $q;



        $data['permission'] = array(
            99 => "ผู้บริหาร",
            98 => "Admin",
            97 => "ง.บท.สตส.",
            0 => "ผู้ตรวจสอบ",
        );



        if ($q[0]["STATUS"] == 0) {
            $data['STATUS'] = "";
        } else {
            $data['STATUS'] = "checked";
        }

        if ($q[0]["image_profile"] == null || $q[0]["image_profile"] == 0 || $q[0]["image_profile"] == "0" || $q[0]["image_profile"] == "" || $q[0]["image_profile"] == null) {

            $data["image_profile"] = base_url("assets/uploads/userimg/default.png");
        } else {
            $data["image_profile"] = base_url("assets/uploads/userimg/" . $q[0]["PER_CODE"] . "/" . $q[0]["image_profile"]);
        }



        return $this->load->view("profile_permission_view", $data);
    }


    public function upload_image_user()
    {

        $image_ = "";
        $data_update = array();

        if (isset($_POST["status"])) {
            $status = 1;
        } else {
            $status = 0;
        }

        // print_r($_POST);


        $data_update = [
            "per_code" => $_POST["per_code"],
            "TITLE_DESC" => $_POST["TITLE_DESC"],
            "FIRST_NAME" => $_POST["name"],
            "LAST_NAME" => $_POST["lastname"],
            "POSITION" => $_POST["POSITION"],
            "level_sal" => $_POST["level_sal"],
            "group" => $_POST["group"],
            "level" => $_POST["optradio"][0],
            "STATUS" => $status,
        ];

        if ($_POST["pass2"] != "" || $_POST["pass2"] != null) {
            // $password = $_POST["pass1"];
            $data_update['password'] = $_POST["pass2"];
        } else {
            # code...
        }

        // print_r($_FILES);
        if ($_FILES['files']['error'][0] > 0) {
            // echo 1;
            // print_r($data_update);
            $this->db->trans_begin();
            $this->db->where('PER_CODE', $_POST["per_code"]);
            $this->db->update('tbl_user', $data_update);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $statuss = 0;
            } else {
                $this->db->trans_commit();
                $statuss = 1;
            }

            echo '<script>window.location.href  =' . '"' . base_url('setpermission/profile_permission/') . $_POST["per_code"] . '"' . '</script>';

        } else {
            // echo 2;
            // print_r($data_update);

            if (!is_dir('./assets/uploads/userimg/' . $_POST["per_code"])) {
                mkdir('./assets/uploads/userimg/' . $_POST["per_code"], 0777, TRUE);
            }

            if ($_POST["check_pic"] == 1) {
                $files = glob("./assets/uploads/userimg/" . $_POST["per_code"] . '/*'); // get all file names
                foreach ($files as $file) { // iterate files
                    if (is_file($file))
                        unlink($file); // delete file
                }


                $filesCount = count($_FILES['files']['name']);
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                    $newName = date("d_m_yy") . '_' . rand(0, 999999) . '_' . $_FILES['file']['name'];
                    $config['upload_path'] = './assets/uploads/userimg/' . $_POST["per_code"];
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $newName;
                    $this->load->library('image_lib');

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('file')) {
                        $data_return = array('error' => $this->upload->display_errors());
                    } else {
                        $data_return = $this->upload->data();


                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $data_return["full_path"];

                        $config['maintain_ratio'] = TRUE;
                        $config['width'] = 200;
                        $config['height'] = 200;

                        $this->image_lib->initialize($config);

                        if (!$this->image_lib->resize()) {
                            $this->image_lib->display_errors();
                        } else {
                        }
                    }


                    //                    print_r($data_return["file_name"]);
                }

                $data_update = [
                    "per_code" => $_POST["per_code"],
                    "TITLE_DESC" => $_POST["TITLE_DESC"],
                    "FIRST_NAME" => $_POST["name"],
                    "LAST_NAME" => $_POST["lastname"],
                    "POSITION" => $_POST["POSITION"],
                    "level_sal" => $_POST["level_sal"],
                    "group" => $_POST["group"],
                    "level" => $_POST["optradio"][0],
                    "image_profile" => $data_return["file_name"],
                    "STATUS" => $status,

                ];


                // print_r($data_update);

                $this->db->trans_begin();

                $this->db->where('PER_CODE', $_POST["per_code"]);
                $this->db->update('tbl_user', $data_update);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $status = 0;
                } else {
                    $this->db->trans_commit();
                    $status = 1;
                    // $_SESSION["user"]["0"]["image_profile"] = $data_return["file_name"];
                }
                //                echo $status;
                echo '<script>window.location.href  =' . '"' . base_url('setpermission/profile_permission/') . $_POST["per_code"] . '"' . '</script>';
            } else if ($_POST["check_pic"] == 2) {
                // $data_update["password"] = "x";
                $data_update = [
                    "per_code" => $_POST["per_code"],
                    "TITLE_DESC" => $_POST["TITLE_DESC"],
                    "FIRST_NAME" => $_POST["name"],
                    "LAST_NAME" => $_POST["lastname"],
                    "POSITION" => $_POST["POSITION"],
                    "level_sal" => $_POST["level_sal"],
                    "group" => $_POST["group"],
                    "level" => $_POST["optradio"][0],
                    "STATUS" => $status,
                ];
                // echo 3;
                $this->db->trans_begin();

                $this->db->where('PER_CODE', $_POST["per_code"]);
                $this->db->update('tbl_user', $data_update);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $statuss = 0;
                } else {
                    $this->db->trans_commit();
                    $statuss = 1;
                }
                echo '<script>window.location.href  =' . '"' . base_url('setpermission/profile_permission/') . $_POST["per_code"] . '"' . '</script>';
            }
        }
    }

    public function insert_user()
    {
        $data['permission'] = array(
            99 => "ผู้บริหาร",
            98 => "Admin",
            97 => "ง.บท.สตส.",
            0 => "ผู้ตรวจสอบ",
        );

        $data["image_profile"] = base_url("assets/uploads/userimg/default.png");

        $data['controller'] = $this;
        return $this->load->view("profile_permission_insert_view", $data);
    }

    public function insert()
    {
        $data['permission'] = array(
            99 => "ผู้บริหาร",
            98 => "Admin",
            97 => "ง.บท.สตส.",
            0 => "ผู้ตรวจสอบ",
        );

        $image_ = "";


        $q = "SELECT MAX(PER_ID) as maxid FROM tbl_user";

        $empQuery2 = $this->db->query($q, FALSE)->result_array();




        if (isset($_POST["status"])) {
            $status = 1;
        } else {
            $status = 0;
        }

        $password = $_POST["pass1"];


        if ($_FILES == null) {
            $data_update = [
                "PER_ID" => $empQuery2[0]["maxid"] + 1,
                "TITLE_DESC" => $_POST["TITLE_DESC"],
                "per_code" => $_POST["per_code"],
                "FIRST_NAME" => $_POST["name"],
                "LAST_NAME" => $_POST["lastname"],
                "POSITION" => $_POST["POSITION"],
                "level_sal" => $_POST["level_sal"],
                "group" => $_POST["group"],
                "level" => $_POST["optradio"][0],
                "STATUS" => $status,
                "password" => $password
            ];

            $this->db->trans_begin();
            // $this->db->where('PER_CODE', $_POST["per_code"]);
            $this->db->insert('tbl_user', $data_update);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $status = 0;
            } else {
                $this->db->trans_commit();
                $status = 1;
            }
            // echo '<script>window.location.href  =' . '"' . base_url('profile') . '"' . '</script>';
        } else {
            if (!is_dir('./assets/uploads/userimg/' . $_POST["per_code"])) {
                mkdir('./assets/uploads/userimg/' . $_POST["per_code"], 0777, TRUE);
            }

            if ($_POST["check_pic"] == 1) {
                $files = glob("./assets/uploads/userimg/" . $_POST["per_code"] . '/*'); // get all file names
                foreach ($files as $file) { // iterate files
                    if (is_file($file))
                        unlink($file); // delete file
                }
                $filesCount = count($_FILES['files']['name']);
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                    $newName = date("d_m_yy") . '_' . rand(0, 999999) . '_' . $_FILES['file']['name'];
                    $config['upload_path'] = './assets/uploads/userimg/' . $_POST["per_code"];
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $newName;
                    $this->load->library('image_lib');

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('file')) {
                        $data_return = array('error' => $this->upload->display_errors());
                    } else {
                        $data_return = $this->upload->data();


                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $data_return["full_path"];

                        $config['maintain_ratio'] = TRUE;
                        $config['width'] = 200;
                        $config['height'] = 200;

                        $this->image_lib->initialize($config);

                        if (!$this->image_lib->resize()) {
                            $this->image_lib->display_errors();
                        } else {
                        }
                    }


                    //                    print_r($data_return["file_name"]);
                }

                $data_update = [
                    "PER_ID" => $empQuery2[0]["maxid"] + 1,
                    "TITLE_DESC" => $_POST["TITLE_DESC"],
                    "per_code" => $_POST["per_code"],
                    "FIRST_NAME" => $_POST["name"],
                    "LAST_NAME" => $_POST["lastname"],
                    "POSITION" => $_POST["POSITION"],
                    "level_sal" => $_POST["level_sal"],
                    "group" => $_POST["group"],
                    "level" => $_POST["optradio"][0],
                    "image_profile" => $data_return["file_name"],
                    "STATUS" => $status,
                    "password" => $password
                ];

                $this->db->trans_begin();
                // $this->db->where('PER_CODE', $_POST["per_code"]);
                $this->db->insert('tbl_user', $data_update);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $status = 0;
                } else {
                    $this->db->trans_commit();
                    $status = 1;
                    // $_SESSION["user"]["0"]["image_profile"] = $data_return["file_name"];
                }
                //                echo $status;
                // echo '<script>window.location.href  =' . '"' . base_url('setpermission/profile_permission/') . $_POST["per_code"] . '"' . '</script>';
            } else if ($_POST["check_pic"] == 2) {
                $data_update = [
                    "PER_ID" => $empQuery2[0]["maxid"] + 1,
                    "TITLE_DESC" => $_POST["TITLE_DESC"],
                    "per_code" => $_POST["per_code"],
                    "FIRST_NAME" => $_POST["name"],
                    "LAST_NAME" => $_POST["lastname"],
                    "POSITION" => $_POST["POSITION"],
                    "level_sal" => $_POST["level_sal"],
                    "group" => $_POST["group"],
                    "level" => $_POST["optradio"][0],
                    "STATUS" => $status,
                    "password" => $password
                ];

                $this->db->trans_begin();


                $this->db->insert('tbl_user', $data_update);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $status = 0;
                } else {
                    $this->db->trans_commit();
                    $status = 1;
                }
                // echo '<script>window.location.href  =' . '"' . base_url('setpermission/profile_permission/') . $_POST["per_code"] . '"' . '</script>';
            }
        }
    }
    public function checkpercode()
    {
        $q = $this->db->query("SELECT * FROM tbl_user 
        WHERE  PER_CODE = '" . $_POST["per_code"] . "'", FALSE)->result_array();

        if (count($q)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function update_status()
    {
        $data_update = [
            "STATUS" => $_POST["status"],
        ];

        $this->db->trans_begin();

        $this->db->where('PER_CODE', $_POST["per_code"]);
        $this->db->update('tbl_user', $data_update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_commit();
            $status = 1;
        }
    }
}
