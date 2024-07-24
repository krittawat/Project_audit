<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require('./assets/html2text.php');
class Notification_line extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
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
        $group = 0;
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
WHERE project_status_delete = '' AND
(suggestion_duedate BETWEEN NOW() AND
DATE_ADD(NOW(), INTERVAL 7 DAY) OR suggestion_duedate) and status_name = 'progress' or tbl_status.status_name = 'no'")->result_array();
        } else {
            $follow_query = $this->db->query("SELECT * FROM tbl_project
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
WHERE project_status_delete = '' and status_name = 'progress' or tbl_status.status_name = 'no' ORDER BY project_group ASC";
            } else {
                $string = "SELECT * FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status
ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE project_status_delete = '' and project_group = '" . $group . "' and status_name = 'progress' or tbl_status.status_name = 'no' ORDER BY project_group ASC";
            }
            $follow_query = $this->db->query($string)->result_array();


            foreach ($follow_query as $value) {

                if ($value["subject_status_delete"] != 'del') {

                    $result[$value['project_name']][] = $value;
                }
                $result[$value['project_name']][] = $value;
            }
        }
//        print_r($result);
        $this->noti_line($result);
        $this->noti_line_three($result);
    }

    function noti_line($result) {
        foreach ($result as $key => $value) {
            $project_name = $key;
            foreach ($value as $key2 => $value2) {
      
                $duedate = date_create($value2["suggestion_duedate"]);
//                $datenow = date_create(date("Y-m-d", strtotime("+31 days")));
                $datenow = date_create(date("Y-m-d"));
                $interval = date_diff($datenow, $duedate);



                if ($interval->invert == 0 && $interval->days == 7) {

                    if ($value2["suggestion_status_follow"] == 0) {
                        $alert_txt = "* โทร. ครั้งที่ 1";
                        $this->send($project_name, $value2, $alert_txt);
                    }
                } else if ($interval->invert == 1 && $interval->days == 30) {
                    echo 4;
                    $alert_txt = "* ส่งเอกสารครั้งที่ 2";
                    $this->send($project_name, $value2, $alert_txt);
                } else if ($interval->invert == 1 && $interval->days >= 15) {
                    echo 3;
                    if ($value2["suggestion_status_follow"] == 1) {
                        $alert_txt = "* โทร. ครั้งที่ 2";
                        $this->send($project_name, $value2, $alert_txt);
                    } else if ($value2["suggestion_status_follow"] == 2) {
                        $alert_txt = "* ส่งเอกสารครั้งที่ 1";
                        $this->send($project_name, $value2, $alert_txt);
                    } else if ($value2["suggestion_status_follow"] != 3) {
                        if ($value2["suggestion_status_follow"] == 0) {
                            $alert_txt = "* โทร. ครั้งที่ 1";
                            $this->send($project_name, $value2, $alert_txt);
                        } else if ($value2["suggestion_status_follow"] == 1) {
                            $alert_txt = "* โทร. ครั้งที่ 2";
                            $this->send($project_name, $value2, $alert_txt);
                        }
                    }
                } else if ($interval->invert == 1 && $interval->days >= 3) {
                    echo 2;
                    if ($value2["suggestion_status_follow"] == 0) {
                        $alert_txt = "* โทร. ครั้งที่ 1";
                        $this->send($project_name, $value2, $alert_txt);
                    } 
                }
            }
        }
    }

    function noti_line_three($result) {

        foreach ($result as $key => $value) {
            $project_name = $key;
            foreach ($value as $key2 => $value2) {

                $duedate = date_create($value2["suggestion_duedate"]);

                if ($value2["suggestion_status_follow"] >= 5) {
                    if (date("d-m") == "31-12") {
                        $alert_txt = "* แจ้งเตือน ไตรมาส 1";
                        $this->send($project_name, $value2, $alert_txt);
                    } else if (date("d-m") == "31-03") {
                        $alert_txt = "* แจ้งเตือน ไตรมาส 2";
                        $this->send($project_name, $value2, $alert_txt);
                    } else if (date("d-m") == "30-06") {
                        $alert_txt = "* แจ้งเตือน ไตรมาส 3";
                        $this->send($project_name, $value2, $alert_txt);
                    } else if (date("d-m") == "30-09") {
                        $alert_txt = "* แจ้งเตือน ไตรมาส 4";
                        $this->send($project_name, $value2, $alert_txt);
                    }
                }
            }
        }
    }

    function br2nl($input) {
        return preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n", "", str_replace("\r", "", htmlspecialchars_decode($input))));
    }

    function send($project_name, $value2, $alert_txt) {

        //$token = "RX2gtqVMMfYrTPiNA3oPK1E1vJZaraGhuL2nVbSGve4"; //test

        $token = "radyQWf4ujl8Fa0DlK5y3TkkzwZ8G3OejQaFe514RZD";
        $notifyURL = "https://notify-api.line.me/api/notify";

        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token
        );

        $stickerPkg = 2; //stickerPackageId
        $stickerId = 34; //stickerId


        $code = '100035'; // emoji id
//                $bin = hex2bin(str_repeat('0', 8 - strlen($code)) . $code);
//                $emoticon = mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
        $emoticon = "";


		
		
		//$suggestion_name_text1 = new \Html2Text\Html2Text($value2["suggestion_name"]);
		//$suggestion_name_text = $suggestion_name_text1->getText();


		//$suggestion_name_text = $this->br2nl($value2["suggestion_name"]);


		
		 $suggestion_name_text = strip_tags($value2["suggestion_name"]);
		
		$suggestion_name_text = str_replace("&nbsp;", '', $suggestion_name_text);
		
		
		
		
		
		

		$text = $this->br2nl('<br>สาย ' . $value2["project_group"] . ' ปี ' . $value2["project_year"] . '<br>' . $alert_txt . '<br> &nbsp;เรื่อง : ' . $project_name . '<br> &nbsp; &nbsp;ประเด็น :');


		$text = str_ireplace('<p>', '', $text);
        $text = str_ireplace('</p>', '', $text);
        $text = str_ireplace("&nbsp;", ' ', $text);



        $message = $text.htmlspecialchars_decode($suggestion_name_text);

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


        $result = json_decode($result, TRUE);

        if (!is_null($result) && array_key_exists('status', $result)) {
            if ($result['status'] == 200) {
                echo "Pass";
            }
        }
    }

    public  function test() {
        $LINE_API = "https://notify-api.line.me/api/notify";
        $line_token = "radyQWf4ujl8Fa0DlK5y3TkkzwZ8G3OejQaFe514RZD";
        $str = "Hello"; //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร

        $message = "1111";

        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData, '', '&');
        $headerOptions = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                . "Authorization: Bearer " . $line_token . "\r\n"
                . "Content-Length: " . strlen($queryData) . "\r\n",
                'content' => $queryData
            )
        );
        $context = stream_context_create($headerOptions);
        $result = $this->file_get_contents_curl($LINE_API, FALSE, $context);
        $res = json_decode($result);
        print_r($res);
        return $res;
    }

    function file_get_contents_curl($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

	

	
	
	
}
