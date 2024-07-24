<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sugges extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user'])) {
            echo '<script>window.location.href  =' . '"' . base_url('login') . '"' . '</script>';
        }
    }

    public function insert_sugges() {
        $status = 0;
        $param = $this->input->post();
        $duedate = explode("/", $param["duedate"]);
//        $startdate = explode("/", $param["startdate"]);

        $duedate_dd = $duedate[2] - 543;
        $duedate_mm = $duedate[1];
        $duedate_yyyy = $duedate[0];

//        $startdate_dd = $startdate[2] - 543;
//        $startdate_mm = $startdate[1];
//        $startdate_yyyy = $startdate[0];
        $check_box = 0;
        if ($param["check_box"] == 5) {
            $check_box = 5;
        } else {
            $check_box = 0;
        }

        $data_insert = [
            "suggestion_name" => $param["suggestext"],
            "suggestion_respon" => $param["respon"],
            "FK_subject_id" => $param["subject_id"],
            "suggestion_duedate" => $duedate_dd . "/" . $duedate_mm . "/" . $duedate_yyyy,
//            "suggestion_startdate" => $startdate_dd . "/" . $startdate_mm . "/" . $startdate_yyyy,
            "suggestion_create_date" => date('Y-m-d H:i:s'),
            "suggestion_update_date" => date('Y-m-d H:i:s'),
            "suggestion_user_insert" => $_SESSION["user"]["0"]["PER_CODE"],
            "suggestion_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
//            "suggestion_docnumber" => $param["suggestion_docnumber_insert"],
            "suggestion_status_follow" => $check_box
        ];



        $this->db->trans_begin();
        $this->db->insert('tbl_suggestion', $data_insert);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $suggestion_id = $this->db->insert_id();
            $data_insert_status = [
                "FK_suggestion_id" => $suggestion_id,
                "FK_subject_id" => $param["subject_id"],
                "status_name" => 'progress',
                "status_create_date" => date('Y-m-d H:i:s'),
                "status_update_date" => date('Y-m-d H:i:s'),
                "status_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
            ];
            $this->db->trans_begin();
            $this->db->insert('tbl_status', $data_insert_status);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $status = 0;
            } else {
                $this->db->trans_commit();
                $status = 1;
            }

            $this->db->trans_commit();
            $status = 1;
        }
        $_SESSION["insert_subject"] = 0;
        echo $status;
    }

    public function update_sugges() {
        $param = $this->input->post();
        $status = 0;

        $duedate = explode("/", $param["edit_duedate"]);
//        $startdate = explode("/", $param["edit_startdate"]);

        $duedate_dd = $duedate[2] - 543;
        $duedate_mm = $duedate[1];
        $duedate_yyyy = $duedate[0];

//        $startdate_dd = $startdate[2] - 543;
//        $startdate_mm = $startdate[1];
//        $startdate_yyyy = $startdate[0];


        $data_update = [
            "suggestion_name" => $param["suggestext"],
            "suggestion_respon" => $param["respon_edit"],
            "suggestion_update_date" => date('Y-m-d H:i:s'),
            "suggestion_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
//            "suggestion_docnumber" => $param["suggestion_docnumber_edit"],
            "suggestion_duedate" => $duedate_dd . "/" . $duedate_mm . "/" . $duedate_yyyy,
//            "suggestion_startdate" => $startdate_dd . "/" . $startdate_mm . "/" . $startdate_yyyy,
            "suggestion_status_follow" => $param["check_box"],
        ];

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

    public function delete_sugges() {
        $param = $this->input->post();
        $status = 0;
        $data_update = [
            "suggestion_id" => $param["sugges_id_del"],
            "suggestion_status_delete" => "del",
            "suggestion_update_date" => date('Y-m-d H:i:s'),
            "suggestion_user_update" => $_SESSION["user"]["0"]["PER_CODE"]
        ];

        $this->db->trans_begin();
        $this->db->where('suggestion_id', $param["sugges_id_del"]);
        $this->db->update('tbl_suggestion', $data_update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_begin();
            $this->db->delete('tbl_status', array('status_id' => $param["status_id_del"]));
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $status = 0;
            } else {
                $this->db->trans_commit();
                $status = 1;
            }

            $this->db->trans_commit();
            $status = 1;
        }
        echo $status;
    }

}
