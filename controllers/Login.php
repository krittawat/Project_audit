<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {

        if (@$_SESSION['user'] != null or @ $_SESSION['user'] != "") {
            redirect("Home");
        } else {
            $data['controller'] = $this;
            return $this->load->view("login_view");
        }
    }

    public function login_process() {
        $where = [
            "PER_CODE" => $this->input->post('user'),
            "password" => $this->input->post('password'),
        ];
        $Query = $this->db->select("*")
                        ->from("tbl_user")
                        ->where($where)->get()->result_array();

        $_SESSION['user'] = $Query;

        if ($_SESSION['user'] != null) {


            $root = (isset($_SERVER['HTTPS']) ? "http://" : "http://") . $_SERVER['HTTP_HOST'];
            redirect($root . "/project");
        } else {
            return $this->load->view("login_view");
        }
    }

    public function logout() {


        $this->clear_user_use();
        $this->session->sess_destroy();
        return $this->load->view("login_view");
    }

    public function clear_user_use() {
        $data_update = [
            "project_user_process" => "0",
        ];
        $this->db->trans_begin();
        $this->db->where('project_user_process', $_SESSION["user"]["0"]["PER_CODE"]);
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
