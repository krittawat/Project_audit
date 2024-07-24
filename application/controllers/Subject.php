<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user'])) {
            echo '<script>window.location.href  =' . '"' . base_url('login') . '"' . '</script>';
        }
    }

    public function insert_subject() {
        $param = $this->input->post();
        $status = array();

//        if ($param["select_center"] == 0) {
//            $allcheck = null;
//        } else if ($param["select_satation"] == 0) {
        $allcheck = explode(",", $param["allcheck"]);
//        }



        $data_insert = [
            "subject_name" => $param["subjecttext"],
            "FK_project_id" => $param["project_id"],
            "subject_create_date" => date('Y-m-d H:i:s'),
            "subject_update_date" => date('Y-m-d H:i:s'),
            "subject_user_insert" => $_SESSION["user"]["0"]["PER_CODE"],
            "subject_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
            "subject_priority" => $param["select_center"],
            "subject_priority_station" => $param["select_satation"],
            "subject_priority_type" => json_encode($allcheck)
        ];

        $this->db->trans_begin();
        $this->db->insert('tbl_subject', $data_insert);
        $insert_id = $this->db->insert_id();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $status = array(
                "projid" => $param["project_id"],
                "page" => "",
                "status" => 0,
                "last_id" => $insert_id
            );
        } else {
            $this->db->trans_commit();

            $q = $this->db->select("*")
                            ->from("tbl_subject")
                            ->where("FK_project_id", $param["project_id"])
                            ->where("subject_status_delete", "")->get()->result_array();
            if ($param["no_suggess"] == 1) {
                $data_suggess = [
                    "FK_subject_id" => $insert_id,
                    "suggestion_name" => "-",
                    "suggestion_duedate" => date('Y-m-d H:i:s'),
                    "suggestion_respon" => "-",
                    "suggestion_followday" => 0,
                    "suggestion_create_date" => date('Y-m-d'),
                    "suggestion_update_date" => date('Y-m-d'),
                    "suggestion_user_insert" => $_SESSION["user"]["0"]["PER_CODE"],
                    "suggestion_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
                ];
                $this->db->insert('tbl_suggestion', $data_suggess);
                $insert_sugges_id = $this->db->insert_id();
                $this->db->trans_begin();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();

                    $data_suggess = [
                        "FK_subject_id" => $insert_id,
                        "FK_suggestion_id" => $insert_sugges_id,
                        "FK_subsuggestion_id" => 0,
                        "status_name" => "success",
                        "status_create_date" => date('Y-m-d'),
                        "status_update_date" => date('Y-m-d'),
                        "status_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
                    ];
                    $this->db->insert('tbl_status', $data_suggess);
                    $this->db->trans_begin();
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                        $_SESSION["insert_subject"] = 0;
                    }
                }
            } else if ($param["no_suggess"] == 0) {
                $_SESSION["insert_subject"] = 1;
            }



            $status = array(
                "projid" => $param["project_id"],
                "page" => count($q) - 1,
                "status" => 1,
                "last_id" => $insert_id
            );
        }

        echo json_encode($status);
    }

    public function update_subject() {
        $param = $this->input->post();


//        if ($param["select_center"] == 0) {
//            $allcheck = null;
//        } else if ($param["select_satation"] == 0) {
        $allcheck = explode(",", $param["allcheck"]);
//        }


//        if ($param["no_suggess"] != "1") {
            $status = 0;
            $data_update = [
                "subject_name" => $param["subjecttext_edit"],
                "subject_update_date" => date('Y-m-d H:i:s'),
                "subject_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
                "subject_priority" => $param["select_center"],
                "subject_priority_station" => $param["select_satation"],
                "subject_priority_type" => json_encode($allcheck)
            ];

            $this->db->trans_begin();
            $this->db->where('subject_id', $param["subject_id"]);
            $this->db->update('tbl_subject', $data_update);
// Produces:
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $status = 0;
            } else {
                $this->db->trans_commit();

                if ($param["no_suggess"] == 1) {
                    $data_suggess = [
                        "FK_subject_id" => $param["subject_id"],
                        "suggestion_name" => "-",
                        "suggestion_duedate" => date('Y-m-d H:i:s'),
                        "suggestion_respon" => "-",
                        "suggestion_followday" => 0,
                        "suggestion_create_date" => date('Y-m-d'),
                        "suggestion_update_date" => date('Y-m-d'),
                        "suggestion_user_insert" => $_SESSION["user"]["0"]["PER_CODE"],
                        "suggestion_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
                    ];
                    $this->db->insert('tbl_suggestion', $data_suggess);
                    $insert_sugges_id = $this->db->insert_id();
                    $this->db->trans_begin();
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();

                        $data_suggess = [
                            "FK_subject_id" => $param["subject_id"],
                            "FK_suggestion_id" => $insert_sugges_id,
                            "FK_subsuggestion_id" => 0,
                            "status_name" => "success",
                            "status_create_date" => date('Y-m-d'),
                            "status_update_date" => date('Y-m-d'),
                            "status_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
                        ];
                        $this->db->insert('tbl_status', $data_suggess);
                        $this->db->trans_begin();
                        if ($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                        } else {
                            $this->db->trans_commit();
                            $_SESSION["insert_subject"] = 0;
                        }
                    }
                }


                echo $status = 1;
            }
//        } else {
//            $status = 1;
//            echo $status;
//        }
    }

    public function delete_subject() {
        $param = $this->input->post();
//        $param["subject_id_del"] = 4;
        if (isset($param["subject_id_del"])) {

            $tbl_subject = $this->db->select("*")->from("tbl_subject")
                            ->where("subject_id", $param["subject_id_del"])
                            ->get()->result_array();


            $fk_proj_id = $tbl_subject[0]["FK_project_id"];


            $tbl_suggestion = $this->db->select("suggestion_id")->from("tbl_suggestion")
                            ->where("FK_subject_id", $param["subject_id_del"])
                            ->get()->result_array();

//            $tbl_anwser = $this->db->select("*")->from("tbl_subject")
//                            ->where("tbl_anwser", $param["subject_id_del"])
//                            ->get()->result_array();
//            $tbl_status = $this->db->select("*")->from("tbl_subject")
//                            ->where("subject_id", $param["subject_id_del"])
//                            ->get()->result_array();
//
//            $tbl_follow = $this->db->select("*")->from("tbl_subject")
//                            ->where("subject_id", $param["subject_id_del"])
//                            ->get()->result_array();

            foreach ($tbl_suggestion as $value) {
                $tbl_anwser = $this->db->select("*")->from("tbl_anwser")
                                ->where("FK_suggestion_id", $value["suggestion_id"])
                                ->get()->result_array();

                foreach ($tbl_anwser as $value_tbl_anwser) {
                    $data_update_anwser = [
                        "anwser_status_delete" => "del",
                        "anwser_update_date" => date('Y-m-d H:i:s'),
                        "anwser_user_update" => $_SESSION["user"]["0"]["PER_CODE"]
                    ];
                    $this->db->trans_begin();
                    $this->db->where('anwser_id', $value["suggestion_id"]);
                    $this->db->update('tbl_anwser', $data_update_anwser);

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                    }
                }

                $tbl_follow = $this->db->select("*")->from("tbl_follow")
                                ->where("FK_suggestion_id", $value["suggestion_id"])
                                ->get()->result_array();
                foreach ($tbl_follow as $value_tbl_follow) {
                    $data_update_follow = [
                        "follow_status_delete" => "del",
                        "follow_update_date" => date('Y-m-d H:i:s'),
                        "follow_user_update" => $_SESSION["user"]["0"]["PER_CODE"]
                    ];
                    $this->db->trans_begin();
                    $this->db->where('FK_suggestion_id', $value["suggestion_id"]);
                    $this->db->update('tbl_follow', $data_update_follow);

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                    }
                }
            }
        }



        $status = 0;
        $data_update = [
            "subject_status_delete" => "del",
            "subject_update_date" => date('Y-m-d H:i:s'),
            "subject_user_update" => $_SESSION["user"]["0"]["PER_CODE"]
        ];

        if (isset($param["subject_id_del"])) {
            $this->db->trans_begin();
            $this->db->where('subject_id', $param["subject_id_del"]);
            $this->db->update('tbl_subject', $data_update);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $status = 0;
            } else {
                $this->db->trans_commit();
                $status = 1;
            }
        }

        $return = array(
            "page" => $fk_proj_id,
            "status" => $status
        );


        echo json_encode($return);
    }

}
