<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_line_1 extends CI_Controller {

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
WHERE project_status_delete = '' and status_name = 'progress' or tbl_status.status_name = 'no'AND
(suggestion_duedate BETWEEN NOW() AND
DATE_ADD(NOW(), INTERVAL 7 DAY) OR suggestion_duedate)";
            } else {
                $string = "SELECT * FROM tbl_project
left JOIN tbl_subject
ON tbl_subject.FK_project_id = tbl_project.project_id
left JOIN tbl_suggestion
ON tbl_suggestion.FK_subject_id = tbl_subject.subject_id
left JOIN tbl_status
ON tbl_status.FK_suggestion_id = tbl_suggestion.suggestion_id
WHERE project_status_delete = '' and project_group = '" . $group . "' and status_name = 'progress' or tbl_status.status_name = 'no' AND
(suggestion_duedate BETWEEN NOW() AND
DATE_ADD(NOW(), INTERVAL 7 DAY) OR suggestion_duedate)";
            }
            $follow_query = $this->db->query($string)->result_array();


            foreach ($follow_query as $value) {

                if ($value["subject_status_delete"] != 'del') {

                    $result[$value['project_name']][] = $value;
                }
                $result[$value['project_name']][] = $value;
            }
        }
       // print_r($result);


        $this->noti_line($result);
    }

    function noti_line($result) {

        foreach ($result as $key => $value) {
            $project_name = $key;
            foreach ($value as $key2 => $value2) {
                $this->send($project_name, $value2);
            }
        }
    }

    function br2nl($input) {
        return preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n", "", str_replace("\r", "", htmlspecialchars_decode($input))));
    }

    function send($project_name, $value2) {
		
		
		
        $token = "eMLuSMFlge7MPpiD8u4qsLGwHLjrwHkaqDanZ0jO8Ga";
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

        $text = $this->br2nl('<br>' . $emoticon . 'แจ้งเตือน สาย ' . $value2["project_group"] . '<br>เรื่อง : ' . $project_name . '<br>ประเด็น :' . $value2["suggestion_name"]);

//                $text = $this->br2nl($text . '<br>');
        $text = str_ireplace('<p>', '', $text);
        $text = str_ireplace('</p>', '', $text);
        $text = str_ireplace("&nbsp;", ' ', $text);

        $message = $text;

        $queryData = array(
            'message' => $message,
//                    'stickerPackageId' => $stickerPkg,
//                    'stickerId' => $stickerId
        );


$queryData = array('message' => $message);
 $queryData = http_build_query($queryData,'','&');
 $headerOptions = array( 
         'http'=>array(
            'method'=>'POST',
            'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                      ."Authorization: Bearer ".$token."\r\n"
                      ."Content-Length: ".strlen($queryData)."\r\n",
            'content' => $queryData
         ),
 );
 

 
 $context = stream_context_create($headerOptions);
 $result = file_get_contents("https://notify-api.line.me/api/notify",FALSE,$context);
 $res = json_decode($result);
 return $res;
    }

    public function test() {
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
