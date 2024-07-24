<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {

    public function update_status() {
        $param = $this->input->post();

        if ($param["status_id"] == 0) {
            $data_insert_status = [
                "FK_suggestion_id" => $param["sugges_id"],
                "FK_subject_id" => $param["subject_id"],
                "status_name" => $param["status_name"],
                "status_create_date" => date('Y-m-d H:i:s'),
                "status_update_date" => date('Y-m-d H:i:s'),
                "status_user_update" => $_SESSION["user"]["0"]["PER_CODE"]
            ];
            $this->db->trans_begin();
            $this->db->insert('tbl_status', $data_insert_status);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
            $this->db->trans_commit();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } else {
            $data_update = [
                "status_name" => $param["status_name"],
                "status_update_date" => date('Y-m-d H:i:s'),
                "status_user_update" => $_SESSION["user"]["0"]["PER_CODE"]
            ];
            $this->db->trans_begin();
            $this->db->where('status_id', $param["status_id"]);
            $this->db->update('tbl_status', $data_update);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();

                $this->update_id($param["subject_id"]);
                $this->update1($param["subject_id"]);
            }
        }
    }

    public function condition() {
        $param = $this->input->post();
        if ($param["status_id_codition"] == 0) {
            $data_insert_status = [
                "FK_suggestion_id" => $param["sugges_id_condition"],
                "FK_subject_id" => $param["subject_id_condition"],
                "status_name" => $param["status_condition"],
                "status_create_date" => date('Y-m-d H:i:s'),
                "status_update_date" => date('Y-m-d H:i:s'),
                "status_user_update" => $_SESSION["user"]["0"]["PER_CODE"]
            ];
            $this->db->trans_begin();
            $this->db->insert('tbl_status', $data_insert_status);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } else {
            $data_update = [
                "FK_suggestion_id" => $param["sugges_id_condition"],
                "FK_subject_id" => $param["subject_id_condition"],
                "status_name" => $param["status_condition"],
                "status_create_date" => date('Y-m-d H:i:s'),
                "status_update_date" => date('Y-m-d H:i:s'),
                "status_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
            ];
            $this->db->trans_begin();
            $this->db->where('status_id', $param["status_id_codition"]);
            $this->db->update('tbl_status', $data_update);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $condition_respone_date = explode("/", $param["condition_respone_date"]);
                $condition_respone_date_yyyy = $condition_respone_date[2] - 543;
                $condition_respone_date_mm = $condition_respone_date[1];
                $condition_respone_date_dd = $condition_respone_date[0];
                $condition_respone_date = $condition_respone_date_yyyy . "/" . $condition_respone_date_mm . "/" . $condition_respone_date_dd;
                $data_insert_condition = [
                    "condition_text" => $param["condition_text"],
                    "FK_suggestion_id" => $param["sugges_id_condition"],
                    "FK_subject_id" => $param["subject_id_condition"],
                    "condition_create_date" => date('Y-m-d H:i:s'),
                    "condition_update_date" => date('Y-m-d H:i:s'),
                    "condition_user_create" => $_SESSION["user"]["0"]["PER_CODE"],
                    "condition_user_update" => $_SESSION["user"]["0"]["PER_CODE"],
                    "condition_docnumber" => $param['condition_docnumber'],
                    "condition_respone_date" => $condition_respone_date
                ];
                $this->db->trans_begin();
                $this->db->insert('tbl_condition', $data_insert_condition);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    echo 2;
                    $this->db->trans_commit();
                }
            }
        }
    }

    public function update_condition() {
        $param = $this->input->post();
        $condition_respone_date = explode("/", $param["condition_respone_date"]);
        $condition_respone_date_yyyy = $condition_respone_date[2] - 543;
        $condition_respone_date_mm = $condition_respone_date[1];
        $condition_respone_date_dd = $condition_respone_date[0];
        $condition_respone_date = $condition_respone_date_yyyy . "/" . $condition_respone_date_mm . "/" . $condition_respone_date_dd;
        $data_update = [
            "condition_docnumber" => $param["condition_docnumber"],
            "condition_respone_date" => $condition_respone_date,
            "condition_text" => $param["condition_text"],
            "condition_update_date" => date('Y-m-d H:i:s'),
            "condition_user_update" => $_SESSION["user"]["0"]["PER_CODE"]
        ];
        $this->db->trans_begin();
        $this->db->where('condition_id', $param["condition_id"]);
        $this->db->update('tbl_condition', $data_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function delete_condition() {
        $param = $this->input->post();

        $data_update = [
            "condition_status_del" => 'del',
            "condition_update_date" => date('Y-m-d H:i:s'),
            "condition_user_update" => $_SESSION["user"]["0"]["PER_CODE"]
        ];
        $this->db->trans_begin();
        $this->db->where('condition_id', $param["condition_id"]);
        $this->db->update('tbl_condition', $data_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function checksuedate_sugges() {
        $sugges_query = $this->db->select("*")
                        ->from("tbl_suggestion")
                        ->where("suggestion_status_delete != ", "del")
                        ->get()->result_array();

        foreach ($sugges_query as $value) {
            $this->checkdayoff($value["suggestion_duedate"]);
        }
    }

    public function checkdayoff($duedate) {
        $strStartDate = date("Y-m-d");
        $strEndDate = $duedate;
        $intWorkDay = 0;
        $intHoliday = 0;
        $intPublicHoliday = 0;
        $intTotalDay = ((strtotime($strEndDate) - strtotime($strStartDate)) / ( 60 * 60 * 24 )) + 1;
        $alert_day = array();
        while (strtotime($strStartDate) <= strtotime($strEndDate)) {

            $DayOfWeek = date("w", strtotime($strStartDate));
            if ($DayOfWeek == 0 or $DayOfWeek == 6) {  // 0 = Sunday, 6 = Saturday;
                $intHoliday++;
                echo "$strStartDate = <font color=red>Holiday</font><br>";
            } elseif ($this->CheckPublicHoliday($strStartDate)) {
                $intPublicHoliday++;
                echo "$strStartDate = <font color=orange>Public Holiday</font><br>";
            } else {
                $intWorkDay++;
                echo "$strStartDate = <b>Work Day</b><br>";
                $alert_day[] = $strStartDate;
            }

            $strStartDate = date("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
        }

        echo "<hr>";
        echo "<br>Total Day = $intTotalDay";
        echo "<br>Work Day = $intWorkDay";
        echo "<br>Holiday = $intHoliday";
        echo "<br>Public Holiday = $intPublicHoliday";
        echo "<br>All Holiday = " . ($intHoliday + $intPublicHoliday);

        if ($intWorkDay <= 7) {
            echo "<br>เตือน";
        } else {
            echo "<br>ไม่เตือน";
        }

        echo "<hr>";
        print_r(end($alert_day));
    }

    function CheckPublicHoliday($param) {
        if (!in_array($param, ['2020-04-27', '2020-04-28', '2020-04-30'])) {
            return false;
        } else {
            return true;
        }
    }

    public function update_id($subject_id) {
        echo $subject_id;
        $join_type = " left JOIN tbl_follow ON tbl_follow.FK_suggestion_id = tbl_suggestion.suggestion_id ";
        $d = ",UNIX_TIMESTAMP(follow_date) AS DATE ";

        $empQuery = "SELECT * " . $d . " FROM tbl_project
left JOIN tbl_subject ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id" . $join_type . "
WHERE subject_id = '" . $subject_id . "' And project_status_delete!= 'del' AND subject_status_delete != 'del' AND status_name = 'progress'";

        $empQuery2 = $this->db->query($empQuery, FALSE)->result_array();

        if (count($empQuery2) > 0) {
            foreach ($empQuery2 as $value) {

                $today = new DateTime('');
                $expireDate = new DateTime($value["suggestion_duedate"]); //from database
                $expireDate2 = new DateTime($value["follow_date"]);

                if ($today->format("Y-m-d") >= $expireDate->format("Y-m-d")) {  //
//                    print_r($value);
                    if (($value["follow_date"] != "" || $value["follow_date"] != null) && $value["follow_status_delete"] != 'del') {
                        if ($expireDate2->format("Y-m-d") <= $today->format("Y-m-d")) {
//                            $all[$value["project_id"]][] = $value;
                            $this->update($value["project_id"], 'expired');
//                            print_r($value);
                        }
                    } else if (($value["follow_date"] == "" || $value["follow_date"] == null) && $value["follow_status_delete"] != 'del') {
//                        $all[$value["project_id"]][] = $value;
                        //เกินแบบไม่ได้ขอขยายเวลา
//                        print_r($value);
                        $this->update($value["project_id"], 'expired');
//                        echo '<br>';
                    }
                } else {
                    $this->update($value["project_id"], 'progress');
                }
            }
        } else {
            $all = [];
        }
    }

    function update($projec_id, $status) {
        if ($projec_id != null) {
//            $this->db->transStart();
            $data = array(
                'project_status' => $status,
            );
            $this->db->where('project_id', $projec_id);

            $this->db->update('tbl_project', $data);
//            $this->db->transComplete();
        }
    }

    public function update1($subject_id) {
        $d = ",UNIX_TIMESTAMP(follow_date) AS DATE ";
        $empQuery = "SELECT * " . $d . " FROM tbl_project
left JOIN tbl_subject ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
left JOIN tbl_follow ON tbl_follow.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE subject_id = '" . $subject_id . "' And project_status_delete!= 'del' AND subject_status_delete != 'del' and subject_status_delete != 'del' ";

        $empQuery2 = $this->db->query($empQuery, FALSE)->result_array();

        foreach ($empQuery2 as $key => $value) {
            $data_check[$value["project_id"]]["status"][] = $value["status_name"];
            $data_check[$value["project_id"]]['name'] = $value["project_name"];
            $data_check[$value["project_id"]]['project_id'] = $value["project_id"];
            $data_check[$value["project_id"]]['project_id'] = $value["project_id"];
        }

        foreach ($data_check as $key => $value) {
            if (in_array("success", $value["status"])) {
                $data_check2[$key]["success"][] = $value['project_id'];
                $this->update($value["project_id"], 'success');
            } else if (in_array("progress", $value["status"]) || in_array("", $value["status"])) {
                $data_check2[$key]["progress"][] = $value['project_id'];
                $this->update($value["project_id"], 'progress');
            }
        }
    }

}
