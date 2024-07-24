<?php

defined('BASEPATH') or exit('No direct script access allowed');

class profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user'])) {
            echo '<script>window.location.href  =' . '"' . base_url('login') . '"' . '</script>';
        }
    }

    public function index()
    {
        $data = [];

        $data = $_SESSION["user"]["0"];

        if ($_SESSION["user"]["0"]["image_profile"] == null || $_SESSION["user"]["0"]["image_profile"] == 0 || $_SESSION["user"]["0"]["image_profile"] == "0" || $_SESSION["user"]["0"]["image_profile"] == "") {

            $data["image_profile"] = base_url("assets/uploads/userimg/default.png");
        } else {
            $data["image_profile"] = base_url("assets/uploads/userimg/" . $_SESSION["user"]["0"]["PER_CODE"] . "/" . $_SESSION["user"]["0"]["image_profile"]);
        }
        $data['controller'] = $this;
        return $this->load->view("profile_view", $data);
    }

    public function upload_image_user()
    {

        $image_ = "";

        $files = glob("./assets/uploads/userimg/" . $_SESSION['user']['0']['PER_CODE'] . '/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }



        if ($_POST["check_password_input"] == 1) {
            $password = $_POST["pass1"];
        } else {
            $password = $_SESSION["user"]["0"]["password"];
        }

        if ($_FILES == null) {

            $data_update = [
                "FIRST_NAME" => $_POST["name"],
                "LAST_NAME" => $_POST["lastname"],
                "password" => $password
            ];

            $this->db->trans_begin();

            $this->db->where('PER_CODE', $_SESSION["user"]["0"]["PER_CODE"]);
            $this->db->update('tbl_user', $data_update);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $status = 0;
            } else {
                $this->db->trans_commit();
                $status = 1;
            }

            // echo '<script>window.location.href  =' . '"' . base_url('profile') . '"' . '</script>';
        } else {
            if (!is_dir('./assets/uploads/userimg/' . $_SESSION["user"]["0"]["PER_CODE"])) {
                mkdir('./assets/uploads/userimg/' . $_SESSION["user"]["0"]["PER_CODE"], 0777, TRUE);
            }

            if ($_POST["check_pic"] == 1) {
                $filesCount = count($_FILES['files']['name']);
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                    $newName = date("d_m_yy") . '_' . rand(0, 999999) . '_' . $_FILES['file']['name'];
                    $config['upload_path'] = './assets/uploads/userimg/' . $_SESSION["user"]["0"]["PER_CODE"];
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
                    "FIRST_NAME" => $_POST["name"],
                    "LAST_NAME" => $_POST["lastname"],
                    "image_profile" => $data_return["file_name"],
                    "password" => $password
                ];

                $this->db->trans_begin();

                $this->db->where('PER_CODE', $_SESSION["user"]["0"]["PER_CODE"]);
                $this->db->update('tbl_user', $data_update);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $status = 0;
                } else {
                    $this->db->trans_commit();
                    $status = 1;
                    $_SESSION["user"]["0"]["image_profile"] = $data_return["file_name"];
                }
                //                echo $status;
                echo '<script>window.location.href  =' . '"' . base_url('profile') . '"' . '</script>';
            } else if ($_POST["check_pic"] == 2) {
                $data_update = [
                    "FIRST_NAME" => $_POST["name"],
                    "LAST_NAME" => $_POST["lastname"],
                    "password" => $password
                ];

                $this->db->trans_begin();

                $this->db->where('PER_CODE', $_SESSION["user"]["0"]["PER_CODE"]);
                $this->db->update('tbl_user', $data_update);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $status = 0;
                } else {
                    $this->db->trans_commit();
                    $status = 1;
                }
                // echo '<script>window.location.href  =' . '"' . base_url('profile') . '"' . '</script>';
            }
        }
    }
}
