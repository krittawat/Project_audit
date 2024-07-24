<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
//        array_map('unlink', array_filter((array) glob("./assets/uploads/temp/" . $_SESSION['ID'] . "/*")));
//        $_SESSION['ID'] = 1;
//        if (!is_dir('./assets/uploads/temp/' . $_SESSION['ID'])) {
//            mkdir('./assets/uploads/temp/' . $_SESSION['ID'], 0777, TRUE);
//        }
//        $this->clear_session();
//        $q = $this->db->get('tbl_filebook')->result_array();
//        $data['q'] = $q;
//        return $this->load->view('upload_view', $data);
    }

    public function upload_image_user() {

        $preview = $config = $errors = [];
        
        
      
        if (!$_FILES) {
            return 0;
        } else {
            if (!is_dir('./assets/uploads/temp/' . $_SESSION['ID'])) {
                mkdir('./assets/uploads/temp/' . $_SESSION['ID'], 0777, TRUE);
            }

            $filesCount = count($_FILES['files']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                $newName = date("d_m_yy") . '_' . rand(0, 999999) . '_' . $_FILES['file']['name'];
                $config['upload_path'] = './assets/uploads/temp/' . $_SESSION['ID'];
                $config['allowed_types'] = '*';
                $config['file_name'] = $newName;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('file')) {
                    $error = array('error' => $this->upload->display_errors());
                    $data = $error;
                    return [];
                } else {
                    $type = "";
                    $preview_f = $this->upload->data();
//                    print_r($preview_f);
                    $data = $preview_f;
                }

             
            }
        }
    }

//    public function upload_multi_insert() {
//        $preview = $config = $errors = [];
//        if (!$_FILES) {
//            return 0;
//        } else {
//            if (!is_dir('./assets/uploads/temp/' . $_SESSION['ID'])) {
//                mkdir('./assets/uploads/temp/' . $_SESSION['ID'], 0777, TRUE);
//            }
//
//            $filesCount = count($_FILES['files']['name']);
//            for ($i = 0; $i < $filesCount; $i++) {
//                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
//                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
//                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
//                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
//                $_FILES['file']['size'] = $_FILES['files']['size'][$i];
//
//                $newName = date("d_m_yy") . '_' . rand(0, 999999) . '_' . $_FILES['file']['name'];
//                $config['upload_path'] = './assets/uploads/temp/' . $_SESSION['ID'];
//                $config['allowed_types'] = '*';
//                $config['file_name'] = $newName;
//                $this->load->library('upload', $config);
//
//                if (!$this->upload->do_upload('file')) {
//                    $error = array('error' => $this->upload->display_errors());
//                    return [];
//                } else {
//                    $type = "";
//                    $preview_f = $this->upload->data();
//                    if ($preview_f['file_type'] == "application/pdf") {
//                        $type = "pdf";
//                    } else if ($preview_f['file_type'] == "image/jpeg") {
//                        $type = "image";
//                    }
//                    $preview_f = $this->upload->data();
//
//                    $fileSize = $_FILES['file']['size']; // the file size
//
//                    $newFileUrl = './assets/uploads/temp/' . $_SESSION['ID'];
//                    $preview[] = base_url('assets/uploads/temp/') . $_SESSION['ID'] . '/' . $preview_f['file_name'];
//
//                    $fileName = $_FILES['file']['name']; // the file name
//
//                    $config[] = [
//                        'type' => $type,
//                        'key' => './assets/uploads/temp/' . $_SESSION['ID'] . "/" . $preview_f['file_name'],
//                        'caption' => $newFileUrl . $fileName,
//                        'size' => $fileSize,
//                        'downloadUrl' => $newFileUrl . $newName, // the url to download the file
//                        'url' => base_url('Upload/delete'), // server api to delete the file based on key
//                    ];
//
//                    array_push($_SESSION["cart2"], $preview_f['file_name']);
//                    array_push($_SESSION["cart"], './assets/uploads/temp/' . $_SESSION['ID'] . "/" . $preview_f['file_name']);
//                }
//            }
//
//            $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
//
//            if (!empty($errors)) {
//                $img = count($errors) === 1 ? 'file "' . $error[0] . '" ' : 'files: "' . implode('", "', $errors) . '" ';
//                $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
//            }
//            print_r(json_encode($out));
//        }
//    }
//    public function insert() {
//        $topic = $this->input->post("topic");
//        $last_id = 0;
//        $this->db->trans_begin();
//        $data = ["book_name" => $topic];
//        $this->db->insert('tbl_book', $data);
//        if ($this->db->trans_status() === FALSE) {
//            $this->db->trans_rollback();
//        } else {
//            $last_id = $this->db->insert_id();
//            foreach ($_SESSION["cart"] as $key => $value) {
//                $this->db->insert('tbl_filebook', [
//                    "FK_book" => $last_id,
//                    "filebook_path" => './assets/uploads/file_book/' . date("d_m_yy") . "/" . $_SESSION["cart2"][$key],
//                ]);
//            }
//            $this->db->trans_commit();
//        }
//    }
//
//    public function delete() {
//        $key = $this->input->post("key");
//        if (is_readable($key) && unlink($key)) {
//            $x = [];
//        } else {
//            $x = [];
//        }
//        echo json_encode($x);
//    }
//
//    public function session() {
////        print_r($_SESSION['cart'] = []);
//        print_r($_SESSION['cart']);
//        print_r($_SESSION['cart2']);
////        foreach ($_SESSION['cart'] as $value) {
////            print_r($value);
////        }
//
//        if (!is_dir('./assets/uploads/file_book/' . date("d_m_yy"))) {
//            mkdir('./assets/uploads/file_book/' . date("d_m_yy"), 0777, TRUE);
//        }
//
//        foreach ($_SESSION["cart"] as $key => $value) {
//            rename($value, './assets/uploads/file_book/' . date("d_m_yy") . "/" . $_SESSION["cart2"][$key]);
//        }
//    }
//
//    public function clear_session() {
//        $_SESSION['cart'] = [];
//        $_SESSION['cart2'] = [];
//    }
//    public function upload_insert() {
//        $preview = $config = $errors = [];
//
//        if (!$_FILES) {
//            return 0;
//        } else {
//            if (!is_dir('./assets/uploads/file_book/' . date("d_m_yy"))) {
//                mkdir('./assets/uploads/file_book/' . date("d_m_yy"), 0777, TRUE);
//            }
//            $newName = date("d_m_yy") . '_' . rand(0, 999999) . '_' . $_FILES['files']['name'];
//            $config['upload_path'] = './assets/uploads/file_book/' . date("d_m_yy");
//            $config['allowed_types'] = '*';
//            $config['file_name'] = $newName;
//            $this->load->library('upload', $config);
//
//            $this->load->library('upload', $config);
//            if (!$this->upload->do_upload('files')) {
//                $error = array('error' => $this->upload->display_errors());
//                return [];
//            } else {
//                $type = "";
//                $preview_f = $this->upload->data();
//                if ($preview_f['file_type'] == "application/pdf") {
//                    $type = "pdf";
//                } else if ($preview_f['file_type'] == "image/jpeg") {
//                    $type = "image";
//                }
//
//                $fileName = $_FILES['files']['name']; // the file name
//                $fileSize = $_FILES['files']['size']; // the file size
//
//                $newFileUrl = './assets/uploads/file_book/' . date("d_m_yy") . '/';
//                $preview[] = base_url('assets/uploads/file_book/' . date("d_m_yy") . '/') . $preview_f['file_name'];
//
//                $config[] = [
//                    'type' => $type,
//                    'key' => './assets/uploads/file_book/' . date("d_m_yy") . '/' . $preview_f['file_name'],
//                    'caption' => $newFileUrl . $fileName,
//                    'size' => $fileSize,
//                    'downloadUrl' => $newFileUrl . $newName, // the url to download the file
//                    'url' => base_url('Upload/delete'), // server api to delete the file based on key
//                ];
//
//                $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
//
//                if (!empty($errors)) {
//                    $img = count($errors) === 1 ? 'file "' . $error[0] . '" ' : 'files: "' . implode('", "', $errors) . '" ';
//                    $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
//                }
//
//                $insert_data = ["filebook_path" => './assets/uploads/file_book/' . date("d_m_yy") . '/' . $preview_f['file_name']];
//            }
//            print_r(json_encode($out));
//        }
//    }


    public function upload_multi_insert() {
        $_SESSION['ID'] = 1;
        $preview = $config = $errors = [];
        if (!$_FILES) {
            return 0;
        } else {
            if (!is_dir('./assets/uploads/temp/' . $_SESSION['ID'])) {
                mkdir('./assets/uploads/temp/' . $_SESSION['ID'], 0777, TRUE);
            }

            $filesCount = count($_FILES['files']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                $newName = date("d_m_yy") . '_' . rand(0, 999999) . '_' . $_FILES['file']['name'];
                $config['upload_path'] = './assets/uploads/temp/' . $_SESSION['ID'];
                $config['allowed_types'] = '*';
                $config['file_name'] = $newName;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('file')) {
                    $error = array('error' => $this->upload->display_errors());
                    return [];
                } else {
                    $type = "";
                    $preview_f = $this->upload->data();
                    if ($preview_f['file_type'] == "application/pdf") {
                        $type = "pdf";
                    } else if ($preview_f['file_type'] == "image/jpeg") {
                        $type = "image";
                    }
                    $preview_f = $this->upload->data();
                    echo $config['upload_path'] . "/" . $newName;
                }
            }
        }
    }

}
