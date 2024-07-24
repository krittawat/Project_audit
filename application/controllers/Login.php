<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

 public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
    }

    public function index() {



        if (@$_SESSION['user'] != null or @$_SESSION['user'] != "") {
            redirect("Home");
        } else {
            $data['controller'] = $this;
            return $this->load->view("login_view");
        }
    }

    public function login_process() {
                $where = [
            "PER_CODE" => $this->input->post('username'),
            // "password" => $this->input->post('password'),
        ];

        $password = $this->input->post('password');

        $Query =  $this->db->select("*")
            ->from("tbl_user")
            ->where($where)->get()->result_array();

        // echo password_verify($password, $Query[0]["password"]);

        if (count($Query) > 0 && password_verify($password, $Query[0]["password"])) {
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

            $actual_link2 = $actual_link . '/userpermission/assets/uploads/userimg/' . $Query[0]["PER_CODE"] . '/' . $Query[0]['image_profile'];
            $newdata = array(
                'user' => $Query,
                'img' => $actual_link2,
                'logged_in' => TRUE
            );

            $this->session->set_userdata($newdata);
            //if ($this->session->has_userdata('user') == 1) {
                echo "success";
            //}
        } else {

            $data = [];
            echo "false";
        }
    }

    public function logout() {


        $this->clear_user_use();
        $this->session->sess_destroy();
        return $this->load->view("login_view");
    }

    public function clear_user_use() {
		
		//print_r(@$_SESSION["user"]);
        $data_update = [
            "project_user_process" => "0",
        ];
        $this->db->trans_begin();
        $this->db->where('project_user_process', @$_SESSION["user"]["0"]["PER_CODE"]);
        $this->db->update('tbl_project', $data_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_commit();
            $status = 1;
            $_SESSION['user'] = null;
        }
        $status;
    }

    public function clear_user_use_day() {
        $data_update = [
            "project_user_process" => "0",
        ];
        $this->db->trans_begin();
        $this->db->update('tbl_project', $data_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_commit();
            $status = 1;
        }
    }

}
