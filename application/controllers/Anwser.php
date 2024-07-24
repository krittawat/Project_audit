<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Anwser extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user'])) {
            echo '<script>window.location.href  =' . '"' . base_url('login') . '"' . '</script>';
        }
    }

    public function insert_anwser() {
        $status = 0;
        $param = $this->input->post();
        $anwser_respone_date = explode("/", $param["anwser_respone_date"]);
        $anwser_respone_date_yyyy = $anwser_respone_date[2] - 543;
        $anwser_respone_date_mm = $anwser_respone_date[1];
        $anwser_respone_date_dd = $anwser_respone_date[0];

        $data_insert = [
            "FK_suggestion_id" => $param["sugges_id_add_anwser"],
            "anwser_name" => $param["editor_add_anwser"],
            "anwser_number_docnumber" => $param["anwser_number_docnumber"],
            "anwser_docnumber" => $param["anwser_docnumber"],
            "anwser_create_date" => date('Y-m-d H:i:s'),
            "anwser_update_date" => date('Y-m-d H:i:s'),
            "anwser_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
            "anwser_respone_date" => $anwser_respone_date_yyyy . "/" . $anwser_respone_date_mm . "/" . $anwser_respone_date_dd,
        ];
        $this->db->trans_begin();
        $this->db->insert('tbl_anwser', $data_insert);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_commit();
            $status = 1;
        }
        echo $status;
    }

    public function update_anwser() {
        $param = $this->input->post();
        $status = 0;
        $anwser_respone_date = explode("/", $param["anwser_respone_date_edit"]);
        $anwser_respone_date_yyyy = $anwser_respone_date[2] - 543;
        $anwser_respone_date_mm = $anwser_respone_date[1];
        $anwser_respone_date_dd = $anwser_respone_date[0];
 
        $data_update = [
            "anwser_name" => $param["editor_edit_anwser"],
            "anwser_docnumber" => $param["anwser_docnumber"],
            "anwser_number_docnumber" => $param["anwser_number_docnumber_edit"],
            "anwser_update_date" => date('Y-m-d H:i:s'),
            "anwser_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
            "anwser_respone_date" => $anwser_respone_date_yyyy . "-" . $anwser_respone_date_mm . "-" . $anwser_respone_date_dd,
        ];



        $this->db->trans_begin();
        $this->db->where('anwser_id', $param["id_edit_anwser"]);
        $this->db->update('tbl_anwser', $data_update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_commit();
            $status = 1;
        }

        echo $status;
    }

    public function delete_anwser() {
        $status = 0;
        $param = $this->input->post();
        $data_update = [
            "anwser_id" => $param["anwser_id_del"],
            "anwser_status_delete" => "del",
            "anwser_update_date" => date('Y-m-d H:i:s'),
            "anwser_user_update" => $_SESSION["user"]["0"]["PER_CODE"]
        ];

        $this->db->trans_begin();
        $this->db->where('anwser_id', $param["anwser_id_del"]);
        $this->db->update('tbl_anwser', $data_update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 0;
        } else {
            $this->db->trans_commit();
            $status = 1;
        }

        echo $status;
    }

}
