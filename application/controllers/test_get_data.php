<?php

defined('BASEPATH') or exit('No direct script access allowed');

class test_get_data extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $row[] = array(
            "a" => 1
        );

        echo 1;
        // echo json_encode($row);
    }
}