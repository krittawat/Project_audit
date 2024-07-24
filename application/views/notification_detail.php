<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ระบบแจ้งเตือนการติดตามผลการปฏิบัติตามข้อเสนอแนะ</title>
        <?php
        $this->load->view('Template/css');
        ?>
        <?php
        $this->load->view('Template/js');
        ?>
        <style>
            textarea {
                color: black !important;
            }

        </style>
    </head>
    <body id="page-top" onload="startTime()">

        <div id="loader" style="display: none">
            <div class="spinner-border text-primary" role="status" style="margin-top: 20%;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar -->
            <?php
            $this->load->view('Template/menu_sidebar');
            ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <?php
                    $this->load->view('Template/topbar');
                    ?>
                    <!-- End of Topbar -->
                    <!-- Begin Page Content -->



                    <div class="container-fluid">

                        <!-- Content Row -->
                        <!-- The Modal -->
                        <div class="col">

                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->


                                <div class="d-flex flex-row-reverse" >
                                    <div class="p-2"><?php
                                        if ($project_user_process == $_SESSION["user"]["0"]["PER_CODE"]) {
                                            ?>   
                                            <a class = "btn btn-danger btn-sm leave" href="#" style="width:18rem;display:none" onclick="leave_detail('<?= $_SESSION["user"]["0"]["PER_CODE"] ?>', '<?= $project_id ?>')"><i class="fas fa-file-download"></i>&nbsp;ออกจากการแก้ไข</a>
                                            <?php
                                        } else if ($project_user_process != $_SESSION["user"]["0"]["PER_CODE"]) {
                                            $user = $controller->db->select("*")
                                                            ->from("tbl_user")
                                                            ->where("PER_CODE",  $project_user_process)
                                                            ->get()->result_array();
                                            echo @$person = '<div class="d-flex flex-row-reverse" style="    font-size: 0.8em;">ผู้กำลังใช้งาน : ' . $user[0]["FIRST_NAME"] . " " . $user[0]["LAST_NAME"] . '</div>';
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                                    <h6 class="m-0 font-weight-bold text-primary">รายละเอียด</h6>
                                    <div class="d-flex justify-content-end">
                                        <a class = "btn btn-success" href = "<?= base_url('Export?id=') . $project_id ?>"><i class="fas fa-file-download"></i>&nbsp;Export</a>&nbsp;
                                        <button class="open-modal btn btn-danger btn-small float-right trash-alt" data-toggle="modal" data-target="#exampleModal" data-id="<?= $project_id ?>" data-name="<?= $project_name ?>"><i class="far fa-trash-alt"></i>  ลบโครงการ</button>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <form action="<?= $url_form ?>" method="POST">
                                    <div class="card-body">
                                        <label for="demo">เลขที่หนังสือกิจกรรมตรวจสอบ</label>
                                        <div class="input-group mb-3" >
                                            <input  type="text" class="form-control" placeholder="เลขที่หนังสือ"  name="project_docnumber" id="project_docnumber" value="<?= $project_docnumber ?>">
                                        </div>

                                        <label for="demo">วันที่ส่งรายงานฉบับสมบูรณ์</label>
                                        <div class="input-group mb-3" >
                                            <input  type="text"  class="datepicker form-control" placeholder="วันที่ส่งรายงานฉบับสมบูรณ์" data-date-format="mm/dd/yyyy" name="datepicker_project" id="datepicker_project"  required="" onkeypress="return false" autocomplete="off">
                                        </div>

                                        <!--<label>เลือกวันที่</label>-->
                                        <!--  สร้าง textbox สำหรับสร้างตัวเลือก ปฎิทิน โดยมี id มีค่าเป็น my_date  -->

                                        <!--                                        <label for="demo">วันที่ส่งรายงานฉบับสมบูรณ์</label>
                                                                                <div class="input-group mb-3">
                                                                                    <input  type="text"  class="datepicker form-control" placeholder="วันที่ส่งรายงานฉบับสมบูรณ์" data-date-format="mm/dd/yyyy" name="datepicker_project" id="datepicker_project"  required="" onkeypress="return false" autocomplete="off">
                                                                                    <input id="my_date"   type="text" class="form-control" placeholder="วันที่ส่งรายงานฉบับสมบูรณ์" value="01/01/2563"/>
                                                                                </div>-->


                                        <div class="form-group" style="color:black">
                                            <label for="comment">ชื่อกิจกรรมตรวจสอบ/โครงการ</label>
                                            <textarea  class="form-control" rows="1" id="project_name"  spellcheck="false" placeholder="ชื่อโครงการ"  name="project_name" onkeyup="onkeyupdateproject()"><?= $project_name ?></textarea>
                                        </div>


                                        <label for="demo">ปีงบประมาณ</label>
                                        <div class="input-group mb-3" >
                                            <input  type="text"  class="datepicker form-control" placeholder="ปีงบประมาณ" data-date-format="yyyy" name="yearpicker_project" id="yearpicker_project"  required="" onkeypress="return false" autocomplete="off">
                                        </div>

                                        <label for="demo">งานตรวจสอบสาย</label>
                                        <div class="input-group mb-3" >
                                            <input  type="number" min="1" max="6" class="form-control" placeholder="กลุ่มงานตรวจสอบสาย"  name="group" id="group" required="" value="<?= $project_group ?>">
                                        </div>




                                        <button type="button" class="open-modal_addsubject btn btn-primary" data-toggle="modal" data-target="#addsubject" data-id="<?= $project_id ?>">
                                            <i class="fas fa-plus"></i> เพิ่มประเด็น
                                        </button>
                                        <br><br><br>
                                        <div class="container">
                                            <p><?php echo $links; ?></p>
                                            <?php foreach ($array_subject as $key => $value) { ?>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <h5><u><?php echo count($array_subject) > 0 ? "ประเด็นที่ " : ""; ?>
                                                                <?php
                                                                if (!isset($_GET["per_page"])) {
                                                                    echo 1;
                                                                } else {
                                                                    echo $_GET["per_page"] + 1;
                                                                }
                                                                ?></u></h5>
                                                        <div id="subject_name_<?php echo $value["subject_id"]; ?>"><?php echo $value["subject_name"]; ?></div>
                                                    </div>
                                                    <div class="col">
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="float-right">
                                                            <div id="text_data_subject1_name_<?= $value["subject_id"] ?>" style="display: none"><?= $value["subject_name"] ?></div>
                                                            <div id="text_data_subject2_name_<?= $value["subject_id"] ?>" style="display: none"><?= $value["subject_name"] ?></div>
                                                            <div id="text_data_subject3_name_<?= $value["subject_id"] ?>" style="display: none"><?= $value["subject_name"] ?></div>
                                                            <button style="margin:5px" type="button" class="open-modal_editsubject btn btn-warning btn-sm" data-toggle="modal" data-target="#editsubject" data-id="<?= $value["subject_id"] ?>">
                                                                <i class="fas fa-edit"></i> แก้ไขประเด็น
                                                            </button>
                                                            <button style="margin:5px" type="button" class="open-modal_deletesubject btn btn-danger btn-sm" data-toggle="modal" data-target="#deletesubject" data-id="<?= $value["subject_id"] ?>">
                                                                <i class="far fa-trash-alt"></i> ลบประเด็น
                                                            </button>
                                                            <button style="margin:5px" type="button" class="open-modal_addsugges btn btn-primary btn-sm" data-toggle="modal" data-target="#addsugges" data-id="<?= $value["subject_id"] ?>">
                                                                <i class="fas fa-edit" ></i> เพิ่มมติที่ประชุมจากการปิดตรวจ
                                                            </button><br>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-12">
                                                        <?php
                                                        $i = 1;

                                                        if (isset($_GET["Search"])) {
                                                            $sugges->db->like("suggestion_docnumber", $_GET["Search"]);
                                                        }

                                                        $sugges->db->select("*");
                                                        $sugges->db->from("tbl_suggestion");
                                                        $sugges->db->where("suggestion_status_delete != ", "del");
                                                        $sugges->db->where("FK_subject_id", $value["subject_id"]);
                                                        $sugges_query = $sugges->db->get()->result_array();
                                                        if ($sugges_query != null) {
                                                            ?>
                                                            <h5><u>มติที่ประชุมจากการปิดตรวจ</u></h5>
                                                        <?php } ?>
                                                        <?php
                                                        $subject_id = $value["subject_id"];
                                                        foreach ($sugges_query as $value_sugges) {
                                                            $sugges_id = $value_sugges['suggestion_id'];

                                                            $status_id = 0;
                                                            $text_status = "";
                                                            $style = "";
                                                            $array_check = ["success", "progress", "no"];
                                                            $status_query = $sugges->db->select("*")
                                                                            ->from("tbl_status")
                                                                            ->where("FK_suggestion_id", $value_sugges["suggestion_id"])->get()->result_array();
                                                            if ($status_query != null) {
                                                                $status_id = $status_query[0]["status_id"];
                                                                $status_name = $status_query[0]["status_name"];
                                                                if ($status_name == "success") {
                                                                    $text_status = "ดำเนินการแล้ว";
                                                                    $style = 'background-color: #28a745';
                                                                } elseif ($status_name == "progress") {
                                                                    $text_status = "อยู่ระหว่างดำเนินการ";
                                                                    $style = 'background-color: #17a2b8';
                                                                } else {
                                                                    $text_status = "ยังไม่ได้ดำเนินการ";
                                                                    $style = 'background-color: #dc3545';
                                                                }
                                                            } else {
                                                                $text_status = "ยังไม่มีสถานะ";
                                                                $style = 'background-color: red';
                                                            }


                                                            $text_status2 = "ยังไม่มีการติดตาม";
                                                            if ($value_sugges["suggestion_status_follow"] == 0) {
                                                                $text_status2 = "ยังไม่มีการติดตาม";
                                                            } elseif ($value_sugges["suggestion_status_follow"] == 1) {
                                                                $text_status2 = "โทรครั้งที่ 1";
                                                            } elseif ($value_sugges["suggestion_status_follow"] == 2) {
                                                                $text_status2 = "โทรครั้งที่ 2";
                                                            } elseif ($value_sugges["suggestion_status_follow"] == 3) {
                                                                $text_status2 = "ส่งเอกสารครั้งที่ 1";
                                                            } elseif ($value_sugges["suggestion_status_follow"] == 4) {
                                                                $text_status2 = "ส่งเอกสารครั้งที่ 2";
                                                            }
                                                            ?>
                                                            <div class="alert alert-secondary" role="alert" style="color:black">
                                                                <div class="row justify-content-end"  style="color: gray">
                                                                    <div>
                                                                        <!-- Small button groups (default and split) -->
                                                                        <div class="btn-group" id="myDropdown">
                                                                            <button class="btn btn-sm dropdown-toggle" style="<?= $style ?>;color: white;" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <span id="selected"><?= $text_status ?></span>
                                                                            </button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                                <button class="dropdown-item" type="button" onclick="change_status('<?= $subject_id ?>', '<?= $sugges_id ?>', '<?= $status_id ?>', 'success')">ดำเนินการแล้ว</button>
                                                                                <button class="dropdown-item" type="button" onclick="change_status('<?= $subject_id ?>', '<?= $sugges_id ?>', '<?= $status_id ?>', 'progress')">อยู่ระหว่างดำเนินการ</button>
                                                                                <button class="dropdown-item" type="button" onclick="change_status('<?= $subject_id ?>', '<?= $sugges_id ?>', '<?= $status_id ?>', 'no')">ยังไม่ได้ดำเนินการ</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row justify-content-end"  style="color: gray">

                                                                </div>

                                                                <div id="suggestion_name_<?php echo $value_sugges["suggestion_id"] ?>"><?php echo $value_sugges["suggestion_name"] ?></div>

                                                                <div class="row justify-content-end"  style="color: gray">

                                                                    <!--                                                                    suggestion_duedate
                                                                                                                                        anwser_create_date-->
                                                                    <?php
                                                                    $anwser_query = $sugges->db->select("*")
                                                                                    ->from("tbl_anwser")
                                                                                    ->where("anwser_status_delete != ", "del")
                                                                                    ->where("FK_suggestion_id", $value_sugges["suggestion_id"])->get()->result_array();



                                                                    if (count($anwser_query) > 0) {
//                                                                        print_r($anwser_query);


                                                                        foreach ($anwser_query as $value) {
                                                                            $status2_query = $sugges->db->select("*")
                                                                                            ->from("tbl_suggestion")
                                                                                            ->where("suggestion_id", $value["FK_suggestion_id"])->get()->result_array();

                                                                            $date1 = date_create($status2_query[0]["suggestion_duedate"]);
                                                                            $date2 = date_create($value["anwser_respone_date"]);
//                                                                            $date1 = date_create("2020-05-20");
//                                                                            $date2 = date_create("2020-05-19");
                                                                            $diff = date_diff($date1, $date2);

//                                                                            echo '<br>';

                                                                            if ($diff->invert == 1) {
                                                                                $text_ = "เร็ว";
                                                                            } else if ($diff->days == 0) {
                                                                                $text_ = "ปกติ";
                                                                            } else if ($diff->invert == 0) {
                                                                                $text_ = "ล่าช้า " . $diff->days . " วัน";
                                                                            }
                                                                        }
                                                                        ?> <div style="font-size: 0.8em" id='text_status'>สถานะ : <?= $text_ ?></div>
                                                                        <?php
                                                                    } else {
                                                                        
                                                                    }
                                                                    ?>

                                                                </div>
                                                                <div class="row justify-content-end" style="color: gray;font-size: 0.8em">

                                                                    <?php
                                                                    if ($value_sugges["suggestion_docnumber"] != "" || $value_sugges["suggestion_docnumber"] != null) {
                                                                        echo 'เลขที่หนังสือ &nbsp;:&nbsp;&nbsp;<div id="suggestion_docnumber_' . $value_sugges["suggestion_id"] . '">' . $value_sugges["suggestion_docnumber"] . '</div>';
                                                                    }
                                                                    ?>
                                                                    &nbsp;&nbsp;
                                                                    <!--<div>วันที่ส่งรายงาน : <?php echo convert_date($value_sugges["suggestion_startdate"]) ?></div>-->
                                                                </div>
                                                                <div class="row justify-content-end"  style="color: gray">
                                                                    <div style="font-size: 0.8em">วันที่แล้วเสร็จ : <?php echo convert_date($value_sugges["suggestion_duedate"]) ?></div>
                                                                </div>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-8" style="font-size: 10pt;font-weight: bold;">
                                                                        ผู้รับผิดชอบ : <?php echo $value_sugges["suggestion_respon"] ?>
                                                                    </div>
                                                                </div>

                                                                <div style="display: none" id="editsuggestion_name_text_<?= $value_sugges["suggestion_id"] ?>"><?php echo $value_sugges["suggestion_name"] ?></div>

                                                                <div class="d-flex flex-row-reverse">
                                                                    <div class="p-2">
                                                                        <button style="background-color:white;color: black;" type="button" class="open-modal_deletesugges btn btn-outline-secondary btn-sm float-right" data-toggle="modal" data-target="#deletesugges" data-id="<?= $value_sugges["suggestion_id"] ?>" data-status="<?= $status_id ?>">
                                                                            <i class="fas fa-trash-alt" ></i> ลบ
                                                                        </button>
                                                                    </div>
                                                                    <div class="p-2">
                                                                        <button style="background-color:white;color: black;" type="button" class="open-modal_editsugges btn btn-outline-secondary btn-sm float-right" data-toggle="modal" data-target="#editsugges" data-id="<?= $value_sugges["suggestion_id"] ?>" data-data2="<?= $value_sugges["suggestion_respon"] ?>" data-duedate="<?= $value_sugges["suggestion_duedate"] ?>" data-startdate="<?= $value_sugges["suggestion_startdate"] ?>" data-suggestion_status_follow="<?= $value_sugges["suggestion_status_follow"] ?>">
                                                                            <i class="fas fa-edit" ></i> แก้ไข
                                                                        </button>
                                                                    </div>
                                                                    <div class="p-2">
                                                                        <button style="background-color:white;color: black;" type="button" class="open-modal_follow btn btn-outline-secondary btn-sm float-right" data-toggle="modal" data-target="#follow" data-id="<?= $value_sugges["suggestion_id"] ?>" data-text_status = "<?= $text_status2 ?>">
                                                                            <i class="fas fa-file-signature"></i> ขอขยายระยะเวลา
                                                                        </button>
                                                                    </div>
                                                                    <div class="p-2">
                                                                        <button style="background-color:white;color: black;" type="button" class="open-modal_add_anwser btn btn-outline-secondary btn-sm float-right" data-toggle="modal" data-target="#add_anwser" data-id="<?= $value_sugges["suggestion_id"] ?>" data-subject_id="<?= $subject_id ?>" >
                                                                            <i class="fas fa-reply"></i> ผลการติดดามข้อเสนอแนะ
                                                                        </button>
                                                                    </div>
                                                                </div>


                                                                <?php
                                                                $follow_query = $sugges->db->select("*")
                                                                                ->from("tbl_follow")
                                                                                ->where("follow_status_delete !=", "del")
                                                                                ->where("FK_suggestion_id", $value_sugges["suggestion_id"])->get()->result_array();


                                                                if ($follow_query != null) {
                                                                    ?>
                                                                    <?php foreach ($follow_query as $value_follow) { ?>
                                                                        <hr>
                                                                        <div class="row ">
                                                                            <div class="col-12">
                                                                                <div class="card">
                                                                                    <div class="card-header alert-info">
                                                                                        ขอขยายระยะเวลา
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <blockquote class="blockquote mb-0">
                                                                                            <div style="font-size:1.2vw;"><?php echo $value_follow["follow_name"]; ?></div>
                                                                                            <div style="display: none" id="edit_follow_text_<?php echo $value_follow["follow_id"] ?>"> <?php echo $value_follow["follow_name"] ?></div>
                                                                                        </blockquote>
                                                                                        <div class="row justify-content-end" style="color: gray">
                                                                                            <div style="font-size: 0.8em">วันที่ขอขยายเวลา : <?php echo convert_date($value_follow["follow_date"]) ?></div>
                                                                                        </div>
                                                                                        <hr>

                                                                                        <div class="d-flex flex-row-reverse">
                                                                                            <div class="p-2">
                                                                                                <button type="button" style="color: black; margin-left:10px" class="open-modal_deletefollow btn btn-outline-secondary btn-sm float-right" data-toggle="modal" data-target="#deletefollow" data-name="<?php echo $value_follow["follow_name"]; ?>" data-id="<?php echo $value_follow["follow_id"] ?>">
                                                                                                    <i class="fas fa-trash-alt" ></i> ลบ
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="p-2">
                                                                                                <button  type="button" style="color: black;" class="open-modal_edit_follow btn btn-outline-secondary btn-sm float-right" data-toggle="modal" data-target="#edit_follow" data-id="<?php echo $value_follow["follow_id"] ?>" data-date="<?php echo $value_follow["follow_date"] ?>" data-text_status="<?= $text_status2 ?>">
                                                                                                    <i class="fas fa-edit" ></i> แก้ไข
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                <?php } ?>

                                                                <?php
//                                                                $anwser_query = $sugges->db->select("*")
//                                                                                ->from("tbl_anwser")
//                                                                                ->where("anwser_status_delete != ", "del")
//                                                                                ->where("FK_suggestion_id", $value_sugges["suggestion_id"])->get()->result_array();

                                                                if ($anwser_query != null) {
                                                                    ?>
                                                                    <?php foreach ($anwser_query as $value_anwser) { ?>
                                                                        <hr>
                                                                        <div class="row ">
                                                                            <div class="col-12">
                                                                                <div class="card">
                                                                                    <div class="card-header alert-success">
                                                                                        ผลการปฏิบัติตามข้อเสนอแนะ
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <blockquote class="blockquote mb-0">
                                                                                            <div style="font-size:1.2vw;"><?php echo $value_anwser["anwser_name"]; ?></div>
                                                                                            <div style="display: none;" id="edit_anwser_text_<?php echo $value_anwser["anwser_id"]; ?>"> <?php echo $value_anwser["anwser_name"]; ?></div>
                                                                                            <div class="row justify-content-end" style="color: gray">
                                                                                                <!--<div style="font-size: 0.7em">วันที่ส่งรายงาน : <?php echo $value_anwser["suggestion_duedate"] ?></div>-->
                                                                                            </div>
                                                                                        </blockquote>
                                                                                        <div class="row justify-content-end" style="color: gray;font-size: 0.8em" >
                                                                                            <?php
                                                                                            if ($value_anwser["anwser_number_docnumber"] != "" || $value_anwser["anwser_number_docnumber"] != null) {
                                                                                                echo 'เลขที่หนังสือ &nbsp;:&nbsp;&nbsp;<div id=anwser_number_docnumber_' . $value_anwser["anwser_number_docnumber"] . '">' . $value_anwser["anwser_number_docnumber"] . '</div>&nbsp;&nbsp;';
                                                                                            }
                                                                                            ?>
                                                                                            <?php
                                                                                            if ($value_anwser["anwser_docnumber"] != "" || $value_anwser["anwser_docnumber"] != null) {
                                                                                                echo 'เลขที่หนังสือหน่วยรับตรวจ &nbsp;:&nbsp;&nbsp;<div id=anwser_docnumber_' . $value_anwser["anwser_docnumber"] . '">' . $value_anwser["anwser_docnumber"] . '</div>';
                                                                                            }
                                                                                            ?>
                                                                                            &nbsp;&nbsp;<div style="">วันที่รับรายงานตอบกลับ : <?php echo convert_date($value_anwser["anwser_respone_date"]) ?></div>
                                                                                        </div>
                                                                                        <hr>

                                                                                        <div class="d-flex flex-row-reverse">
                                                                                            <div class="p-2">
                                                                                                <button type="button" style="color: black; margin-left:10px" class="open-modal_deleteanwser btn btn-outline-secondary btn-sm float-right" data-toggle="modal" data-target="#deleteanwser" data-id="<?= $value_anwser["anwser_id"] ?>">
                                                                                                    <i class="fas fa-trash-alt" ></i> ลบ
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="p-2">
                                                                                                <button  type="button" style="color: black;" class="open-modal_edit_anwser btn btn-outline-secondary btn-sm float-right" data-toggle="modal" data-target="#edit_anwser" data-id="<?= $value_anwser["anwser_id"] ?>" data-respone_date="<?= $value_anwser["anwser_respone_date"] ?>" data-subject_id="<?= $subject_id ?>" data-anwser_docnumber="<?= $value_anwser["anwser_docnumber"] ?>" data-anwser_number_docnumber_edit="<?= $value_anwser["anwser_number_docnumber"] ?>" data-sugges_id="<?= $sugges_id ?>">
                                                                                                    <i class="fas fa-edit" ></i> แก้ไข
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <hr>
                                            <?php } ?>     
                                            <p><?php echo $links; ?></p>
                                        </div>                          
                                    </div>
                                    <!--<button style="margin: 10px 10px 10px 10px;" type="submit" class="btn btn-success btn-lg float-right">Submit</button>-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $this->load->view('Template/modal');
                ?>
                <?php
                $this->load->view('Template/Footer');
                ?>
                <!-- End of Footer -->
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </body>
    <script>
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            ['blockquote', 'code-block'],
            [{'header': 1}, {'header': 2}], // custom button values
            [{'list': 'ordered'}, {'list': 'bullet'}],
            [{'script': 'sub'}, {'script': 'super'}], // superscript/subscript
            [{'indent': '-1'}, {'indent': '+1'}], // outdent/indent
            [{'direction': 'rtl'}], // text direction

            [{'size': ['small', false, 'large', 'huge']}], // custom dropdown
            [{'header': [1, 2, 3, 4, 5, 6, false]}],
            [{'color': []}, {'background': []}], // dropdown with defaults from theme
            [{'font': []}],
            [{'align': []}],
            ['clean']                                         // remove formatting button
        ];
//        window.addEventListener('DOMContentLoaded', (event) => {
//
//            $.ajax({
//                url: "<?php echo base_url() ?>home/update_process",
//                type: "POST",
//                datatype: "json",
//                data: {
//                    "proj_id": "<?= $this->uri->segment(3) ?>",
//                },
//                success: (function (result) {
//
//                    if (result != <?= $_SESSION["user"]["0"]["PER_CODE"] ?>) {
//                        $(':button').prop('disabled', true);
//                        $(':input').attr('disabled', 'disabled');
//
//                    } else {
//                        setInterval(() => {
//                            $(".leave").css("display", "block");
//                        }, 1000);
//                    }
//                }),
//                error: function (xhr) {
//                    console(xhr.statusText);
//                }
//            });
//        });

  setInterval(() => {
            $.ajax({
                url: "<?php echo base_url() ?>home/update_process",
                type: "POST",
                datatype: "json",
                data: {
                    "proj_id": "<?= $this->uri->segment(3) ?>",
                },
                success: (function (result) {
                    var u = JSON.parse(result)

                    if (u.project_user_process != <?= $_SESSION["user"]["0"]["PER_CODE"] ?>) {
                        $(':button').prop('disabled', true);
                        $(':input').attr('disabled', 'disabled');
                        $("#use").html(u.name)
                        $("#use").css("visibility", "visible");

                    } else if (u.project_user_process == <?= $_SESSION["user"]["0"]["PER_CODE"] ?>) {
                        $(".leave").css("display", "block");

                        $(':button').prop('disabled', false);
                        $(':input').attr('disabled', false);
                        $("#use").html(u.name)
                        $("#use").html(u.name)
                        $("#use").css("visibility", "hidden");


                    }
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }, 1000);


        function change_status(subject_id, sugges_id, status_id, status) {

            $.ajax({
                url: "<?php echo base_url() ?>Status/update_status",
                type: "POST",
                datatype: "json",
                data: {
                    "subject_id": subject_id,
                    "sugges_id": sugges_id,
                    "status_id": status_id,
                    "status_name": status
                },
                success: (function (result) {
                    $('#addsubject').modal('hide');
                    location.reload();
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }
        var quill = new Quill('#editor', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        var quill_edit = new Quill('#editor_edit', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        var quill_addsugges = new Quill('#editor_addsugges', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        var colors = [
            '#000000',
            '#e60000',
            '#ff9900'
        ];
        var background = [
            '#ffffff',
            '#facccc',
            '#ffebcc'
        ];
        var quill_editsugges = new Quill('#editor_editsugges', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        var quill_add_anwser = new Quill('#editor_add_anwser', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        var quill_edit_anwser = new Quill('#editor_edit_anwser', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        var quill_follow = new Quill('#editor_follow', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        var quill_edit_follow = new Quill('#editor_edit_follow', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        $(".open-modal").click(function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var text = "<div style='font-weight: bold'>ต้องการลบ : </div> " + name + " <br><div style='font-weight: bold'>หรือไม่ ?</div>";
            $(".modal-body #project_id_del").val(id);
            $(".modal-body #project_name_del").html(text);
        });
        //เพิ่ม ประเด็น
        $(".open-modal_addsubject").click(function () {
            var id = $(this).data('id');
            $(".modal-body #project_id").val(id);
        });
        //แก้ไข ประเด็น
        $(".open-modal_editsubject").click(function () {
            var id = $(this).data('id');
//            var data = $(this).data('data');
            var data = $("#text_data_subject1_name_" + id).html();
            $(".modal-body #subject_id_edit").val(id);
            var delta = quill_edit.clipboard.convert(data);
            quill_edit.setContents(delta, 'silent');
        });
        //เพิ่ม มติ
        $(".open-modal_addsugges").click(function () {
            var id = $(this).data('id');
//            var data = $(this).data('data');
            var data = $("#text_data_subject1_name_" + id).html();
            $(".modal-body #subject_id").val(id);
            var delta = quill_editsugges.clipboard.convert(data);
            quill_editsugges.setContents(delta, 'silent');
        });
        //แก้ไข มติ
        $(".open-modal_editsugges").click(function () {
            var id = $(this).data('id');
            var data = $("#editsuggestion_name_text_" + id + "").html();
            var data2 = $(this).data('data2');
            var duedate = $(this).data('duedate');
            var startdate = $(this).data('startdate');

            var suggestion_status_follow = $(this).data('suggestion_status_follow');

            $(".modal-body #sugges_id").val(id);
            var delta = quill_editsugges.clipboard.convert(data);
            quill_editsugges.setContents(delta, 'silent');
            $("#suggestion_docnumber_edit").val($("#suggestion_docnumber_" + id).html())

            if (suggestion_status_follow >= 5) {
                $("#suggestion_status_follow").val(suggestion_status_follow)
                $('#checkbox-large1').attr('onClick', 'checkbox(' + suggestion_status_follow + ')');
                $("#checkbox-large1").prop("checked", true);



                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1;
                var yyyy = today.getFullYear();
                if (mm < 10)
                {
                    mm = '0' + mm;
                }
                if (dd < 10)
                {
                    dd = '0' + dd;
                }


                if (mm > 9) {
                    yyyy = parseInt(yyyy) + 1
                }
                var text_day = yyyy + "-09-30"
                $('#edit_duedate').datepicker({
                    format: 'dd/mm/yyyy',
                    minDate: new Date(),
                    todayBtn: true,
                    language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                    thaiyear: true //Set เป็นปี พ.ศ.
                }).datepicker("setDate", new Date(text_day)); //กำหนเป็นวันปัจุบัน

            } else {
                $('#checkbox-large1').attr('onClick', 'checkbox(' + suggestion_status_follow + ')');

                $('#edit_duedate').datepicker({
                    format: 'dd/mm/yyyy',
                    minDate: new Date(),
                    todayBtn: true,
                    language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                    thaiyear: true //Set เป็นปี พ.ศ.
                }).datepicker("setDate", new Date(duedate)); //กำหนเป็นวันปัจุบัน

            }

            $("#respon_edit").val(data2);

//            $('#edit_startdate').datepicker({
//                format: 'dd/mm/yyyy',
//                todayBtn: true,
//                language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
//                thaiyear: true //Set เป็นปี พ.ศ.
//            }).datepicker("setDate", new Date(startdate)); //กำหนดเป็นวันปัจุบัน
        });
        //ลบประเด็น
        $(".open-modal_deletesubject").click(function () {
            var id = $(this).data('id');
//            var name = $(this).data('data');
            var name = $("#text_data_subject1_name_" + id).html();
            var text = "<div style='font-weight: bold'>ต้องการลบประเด็น : </div> " + name + " <br><div style='font-weight: bold'>หรือไม่ ?</div>";
            $(".modal-body #subject_id_del").val(id);
            $(".modal-body #subject_name_del").html(text);
        });
        //ลบมติ
        $(".open-modal_deletesugges").click(function () {
            var id = $(this).data('id');
            var status_id = $(this).data('status');
            var name = $("#editsuggestion_name_text_" + id + "").html();
            var text = "<div style='font-weight: bold'>ต้องการลบมติที่ประชุม : </div> " + name + " <br><div style='font-weight: bold'>หรือไม่ ?</div>";
            console.log(status_id);
            $(".modal-body #sugges_id_del").val(id);
            $(".modal-body #sugges_name_del").html(text);
            $(".modal-body #status_id_del").val(status_id);
        });
        //        ลบผล
        $(".open-modal_deleteanwser").click(function () {
            var id = $(this).data('id');
            var name = $("#edit_anwser_text_" + id + "").html();
            var text = "<div style='font-weight: bold'>ต้องการลบผลการปฏิบัติตามข้อเสนอแนะ : </div> " + name + " <br><div style='font-weight: bold'>หรือไม่ ?</div>";
            $(".modal-body #anwser_id_del").val(id);
            $(".modal-body #anwser_name_del").html(text);
        });
        //ลบการติดตาม
        $(".open-modal_deletefollow").click(function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var text = "<div style='font-weight: bold'>ต้องการลบการขอขยายระยะเวลา : </div> " + name + " <br><div style='font-weight: bold'>หรือไม่ ?</div>";
            $(".modal-body #follow_id_del").val(id);
            $(".modal-body #follow_name_del").html(text);
        });
        //เพิ่มผล
        $(".open-modal_add_anwser").click(function () {
            var id = $(this).data('id');
            var subject_id = $(this).data('subject_id');
            var sugges_text = $("#subject_name_" + subject_id).html();
            var sugges = $("#suggestion_name_" + id).html();
            $(".modal-body #text_sugges").html(sugges);
            $(".modal-body #sugges_id_add_anwser").val(id);
            $(".modal-body #sugges_name_add_anwser").html(sugges);
            $(".modal-body #text_subject").html(sugges_text);
        });
        //แก้ไขผล
        $(".open-modal_edit_anwser").click(function () {
            var id = $(this).data('id');
            var data = $("#edit_anwser_text_" + id + "").html();
            var respone_date = $(this).data('respone_date');
            var sugges_id = $(this).data('sugges_id');
            $(".modal-body #id_edit_anwser").val(id);
            var delta = quill_edit_anwser.clipboard.convert(data);
            quill_edit_anwser.setContents(delta, 'silent');
            var anwser_docnumber = $(this).data("anwser_docnumber");
            var anwser_number_docnumber_edit = $(this).data("anwser_number_docnumber_edit");
            $(".modal-body #anwser_number_docnumber_edit").val(anwser_number_docnumber_edit);
            $(".modal-body #anwser_docnumber_edit").val(anwser_docnumber);
            var subject_id = $(this).data('subject_id');
            var subject_text = $("#subject_name_" + subject_id).html();
            var sugges_text = $("#editsuggestion_name_text_" + sugges_id).html();
            $(".modal-body #text_sugges_edit").html(sugges_text);
            $(".modal-body #text_subject_edit").html(subject_text);
            $('#anwser_respone_date_edit').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true //Set เป็นปี พ.ศ.

            }).datepicker("setDate", new Date(respone_date)); //กำหนดเป็นวันปัจุบัน
        });
        $(".open-modal_follow").click(function () {
            var id = $(this).data('id');
            var text_status = $(this).data('text_status');
            $(".modal-body #follow_sugges_id").val(id);
            $(".modal-body #follow_text").html(text_status);
        });
        $(".open-modal_edit_follow").click(function () {
            var id = $(this).data('id');
            var data = $("#edit_follow_text_" + id + "").html();
            var date = $(this).data('date');
            var text_status = $(this).data('text_status');
            $(".modal-body #follow_text_edit").html(text_status);
            $(".modal-body #edit_follow_sugges_id").val(id);
            var delta = quill_edit_follow.clipboard.convert(data);
            quill_edit_follow.setContents(delta, 'silent');
            $('#edit_follow_date').datepicker({
                format: 'dd/mm/yyyy',
                minDate: new Date(),
                todayBtn: true,
                language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true //Set เป็นปี พ.ศ.
            }).datepicker("setDate", new Date(date)); //กำหนเป็นวันปัจุบัน

        });
        function add() {
            $("#loader").css("display", "block");
            var editor_content = quill.root.innerHTML;
            $.ajax({
                url: "<?php echo base_url() ?>subject/insert_subject",
                type: "POST",
                datatype: "json",
                data: {
                    "project_id": $("#project_id").val(),
                    "subjecttext": editor_content
                },
                success: (function (result) {
                    if (result > 0) {
                        $('#addsubject').modal('hide');
                        location.reload();
                    }
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }

        function edit() {
            $("#loader").css("display", "block");
            var editor_content = quill_edit.root.innerHTML;
            $.ajax({
                url: "<?php echo base_url() ?>subject/update_subject",
                type: "POST",
                datatype: "json",
                data: {
                    "subject_id": $("#subject_id_edit").val(),
                    "subjecttext_edit": editor_content
                },
                success: (function (result) {

                    if (result > 0) {
                        $('#editsubject').modal('hide');
                        location.reload();
                    }
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }

        function addsugges() {
//            $("#loader").css("display", "block");
            var editor_content = quill_addsugges.root.innerHTML;
            var check_box = "";
            if (quill_addsugges.getText().trim().length === 0) {
                quill_addsugges.focus();
                return false;
            }
            if ($("#startdate").val() === "") {
                alert("ระบุวันที่")
                $("#startdate").focus()
                $("#loader").css("display", "none");
                return false;
            }
            if ($("#duedate").val() === "") {
                alert("ระบุวันที่")
                $("#duedate").focus()
                $("#loader").css("display", "none");
                return false;
            }


            if ($("input[type=checkbox][name=checkbox_sugges]:checked").val() == "on") {
                check_box = 5
            }



            $.ajax({
                url: "<?php echo base_url() ?>sugges/insert_sugges",
                type: "POST",
                datatype: "json",
                data: {
                    "subject_id": $("#subject_id").val(),
                    "respon": $("#respon").val(),
                    "suggestext": editor_content,
                    "duedate": $("#duedate").val(),
                    "startdate": $("#startdate").val(),
//                    "suggestion_docnumber_insert": $("#suggestion_docnumber_insert").val()
                    "check_box": check_box
                },
                success: (function (result) {
                    if (result > 0) {
                        $('#addsugges').modal('hide');
                        location.reload();
                    }
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }




        function checkbox(id) {

            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            if (mm < 10)
            {
                mm = '0' + mm;
            }
            if (dd < 10)
            {
                dd = '0' + dd;
            }


            if (mm > 9) {
                yyyy = parseInt(yyyy) + 1
            }
            var text_day = yyyy + "-09-30"


            if (id == "") {
                if ($("input[type=checkbox][name=checkbox_sugges]:checked").val() == "on") {
                    $('#duedate').datepicker({
                        format: 'dd/mm/yyyy',
                        minDate: new Date(),
                        todayBtn: true,
                        language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                        thaiyear: true //Set เป็นปี พ.ศ.
                    }).datepicker("setDate", new Date(text_day));
                } else {
                    $('#duedate').datepicker({
                        format: 'dd/mm/yyyy',
                        minDate: new Date(),
                        todayBtn: true,
                        language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                        thaiyear: true //Set เป็นปี พ.ศ.
                    }).datepicker("setDate", "0"); //กำหนเป็นวันปัจุบัน
                }
            } else if (id >= 5) {
                if ($("input[type=checkbox][name=checkbox_sugges_edit]:checked").val() == "on") {
                    $('#edit_duedate').datepicker({
                        format: 'dd/mm/yyyy',
                        minDate: new Date(),
                        todayBtn: true,
                        language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                        thaiyear: true //Set เป็นปี พ.ศ.
                    }).datepicker("setDate", new Date(text_day));
                } else {
                    $('#edit_duedate').datepicker({
                        format: 'dd/mm/yyyy',
                        minDate: new Date(),
                        todayBtn: true,
                        language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                        thaiyear: true //Set เป็นปี พ.ศ.
                    }).datepicker("setDate", "0"); //กำหนเป็นวันปัจุบัน
                }
            }




        }


        function editsugges() {
            $("#loader").css("display", "block");
            var editor_content = quill_editsugges.root.innerHTML;
            var suggestion_status_follow = $("#suggestion_status_follow").val()
            var check_box = 0;

            if (suggestion_status_follow >= 5) {
                check_box = suggestion_status_follow
                if ($("input[type=checkbox][name=checkbox_sugges_edit]:checked").val() == "on") {
                    check_box = 5
                } else {
                    check_box = 0
                }
            } else if (suggestion_status_follow < 5) {
                if ($("input[type=checkbox][name=checkbox_sugges_edit]:checked").val() == "on") {
                    check_box = 5
                } else {
                    check_box = 0
                }
            }



            $.ajax({
                url: "<?php echo base_url() ?>sugges/update_sugges",
                type: "POST",
                datatype: "json",
                data: {
                    "sugges_id": $("#sugges_id").val(),
                    "suggestext": editor_content,
                    "respon_edit": $("#respon_edit").val(),
                    "edit_duedate": $("#edit_duedate").val(),
                    "edit_startdate": $("#edit_startdate").val(),
//                    "suggestion_docnumber_edit": $("#suggestion_docnumber_edit").val()
                    "check_box": check_box

                },
                success: (function (result) {
                    if (result > 0) {
                        $('#editsugges').modal('hide');
                        location.reload();
                    }
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }

    </script>
    <script>
        window.addEventListener('load', (event) => {
            console.log('page is fully loaded');
            autosize();
        });
        function autosize() {
            var el = document.getElementById("project_name");
            setTimeout(function () {

                el.style.cssText = 'height:auto; padding:0;color:black';
                el.style.cssText = '-moz-box-sizing:content-box';
                el.style.cssText = 'height:' + el.scrollHeight + 'px';
            }, 0);
        }

        function expandTextarea(id) {
            document.getElementById(id).addEventListener('keyup', function () {
                this.style.overflow = 'hidden';
                this.style.height = 0;
                this.style.height = this.scrollHeight + 'px';
            }, false);
        }

        expandTextarea('project_name');
        $('#datepicker_project').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.

        }).datepicker("setDate", new Date("<?= $project_create_date2 ?>")); //กำหนดเป็นวันปัจุบัน


        $('#yearpicker_project').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", new Date("01/01/<?= $project_year - 543 ?>")); //กำหนดเป็นวันปัจุบัน






        $('#duedate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.

        }).datepicker("setDate", "0"); //กำหนดเป็นวันปัจุบัน


        $('#startdate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.

        }).datepicker("setDate", "0"); //กำหนดเป็นวันปัจุบัน

        $('#anwser_respone_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.

        }).datepicker("setDate", "0"); //กำหนดเป็นวันปัจุบัน


        $('#follow_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.

        }).datepicker(); //กำหนดเป็นวันปัจุบัน

    </script>
    <script>

        function del() {
            $("#loader").css("display", "block");
            $.ajax({
                url: "<?php echo base_url() ?>Home/delect_project",
                type: "POST",
                datatype: "json",
                data: {
                    "project_id_del": $("#project_id_del").val()
                },
                success: (function (result) {
                    $('#exampleModal').modal('hide');
                    window.open('<?= base_url() ?>', "_self");
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }

        function del_subject() {
            $("#loader").css("display", "block");
            $.ajax({
                url: "<?php echo base_url() ?>Subject/delete_subject",
                type: "POST",
                datatype: "json",
                data: {
                    "subject_id_del": $("#subject_id_del").val()
                },
                success: (function (result) {
                    if (result > 0) {
                        location.reload();
                    }
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }


        function del_sugges() {
            $("#loader").css("display", "block");
            $.ajax({
                url: "<?php echo base_url() ?>Sugges/delete_sugges",
                type: "POST",
                datatype: "json",
                data: {
                    "sugges_id_del": $("#sugges_id_del").val(),
                    "status_id_del": $("#status_id_del").val()
                },
                success: (function (result) {
                    if (result > 0) {
                        location.reload();
                    }
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }


        function onkeyupdateproject() {
            $.ajax({
                url: "<?php echo base_url() ?>Home/update_project",
                type: "POST",
                datatype: "json",
                data: {
                    "project_name": $("#project_name").val(),
                    "date": $("#datepicker_project").val(),
                    "group": $("#group").val(),
                    "year": $("#yearpicker_project").val(),
                    "project_id": "<?php echo $this->uri->segment(3); ?>",
                    "project_docnumber": $("#project_docnumber").val()
                },
                success: (function () {
                    $("#project_name").val($("#project_name").val());
                }),
                error: function () {
                    console.log(2);
                }
            });
        }

        $("#datepicker_project").change(function () {
            $.ajax({
                url: "<?php echo base_url() ?>Home/update_project",
                type: "POST",
                datatype: "json",
                data: {
                    "project_name": $("#project_name").val(),
                    "date": $("#datepicker_project").val(),
                    "group": $("#group").val(),
                    "year": $("#yearpicker_project").val(),
                    "project_id": "<?php echo $this->uri->segment(3); ?>",
                    "project_docnumber": $("#project_docnumber").val()
                },
                success: (function (result) {
                    $("#datepicker_project").val($("#datepicker_project").val());
                }),
                error: function (result) {
                }
            });
        });
        $("#yearpicker_project").change(function () {
            $.ajax({
                url: "<?php echo base_url() ?>Home/update_project",
                type: "POST",
                datatype: "json",
                data: {
                    "project_name": $("#project_name").val(),
                    "year": $("#yearpicker_project").val(),
                    "date": $("#datepicker_project").val(),
                    "group": $("#group").val(),
                    "project_id": "<?php echo $this->uri->segment(3); ?>",
                    "project_docnumber": $("#project_docnumber").val()
                },
                success: (function (result) {
                    $("#yearpicker_project").val($("#yearpicker_project").val());
                }),
                error: function (result) {
                }
            });
        });
        $("#group").on('change paste', function () {

            $.ajax({
                url: "<?php echo base_url() ?>Home/update_project",
                type: "POST",
                datatype: "json",
                data: {
                    "project_name": $("#project_name").val(),
                    "year": $("#yearpicker_project").val(),
                    "date": $("#datepicker_project").val(),
                    "project_id": "<?php echo $this->uri->segment(3); ?>",
                    "group": $("#group").val(),
                    "project_docnumber": $("#project_docnumber").val()
                },
                success: (function (result) {
                    $("#yearpicker_project").val($("#yearpicker_project").val());
                }),
                error: function (result) {
                }
            });
        })


        $("#project_docnumber").on('change paste keyup', function () {

            $.ajax({
                url: "<?php echo base_url() ?>Home/update_project",
                type: "POST",
                datatype: "json",
                data: {
                    "project_name": $("#project_name").val(),
                    "year": $("#yearpicker_project").val(),
                    "date": $("#datepicker_project").val(),
                    "project_id": "<?php echo $this->uri->segment(3); ?>",
                    "group": $("#group").val(),
                    "project_docnumber": $("#project_docnumber").val()
                },
                success: (function (result) {
                    $("#yearpicker_project").val($("#yearpicker_project").val());
                }),
                error: function (result) {
                }
            });
        })




        function add_anwser() {
            $("#loader").css("display", "block");
            var editor_add_anwser = quill_add_anwser.root.innerHTML;
            $.ajax({
                url: "<?php echo base_url() ?>Anwser/insert_anwser",
                type: "POST",
                datatype: "json",
                data: {
                    "sugges_id_add_anwser": $("#sugges_id_add_anwser").val(),
                    "editor_add_anwser": editor_add_anwser,
                    "anwser_docnumber": $("#anwser_docnumber").val(),
                    "anwser_respone_date": $("#anwser_respone_date").val(),
//                    "anwser_number_docnumber": $("#anwser_number_docnumber").val(),
                    "anwser_number_docnumber": ""
                },
                success: (function (result) {
                    if (result > 0) {
                        location.reload();
                    }
                }),
                error: function (result) {
                }
            });
        }


        function edit_anwser() {
            $("#loader").css("display", "block");
            var editor_edit_anwser = quill_edit_anwser.root.innerHTML;
            $.ajax({
                url: "<?php echo base_url() ?>Anwser/update_anwser",
                type: "POST",
                datatype: "json",
                data: {
                    "id_edit_anwser": $("#id_edit_anwser").val(),
                    "editor_edit_anwser": editor_edit_anwser,
                    "anwser_docnumber": $("#anwser_docnumber_edit").val(),
                    "anwser_respone_date_edit": $("#anwser_respone_date_edit").val(),
//                    "anwser_number_docnumber_edit": $("#anwser_number_docnumber_edit").val()
                    "anwser_number_docnumber_edit": ""
                },
                success: (function (result) {
                    if (result > 0) {
                        location.reload();
                    }
                }),
                error: function (result) {
                }
            });
        }

        function del_anwser() {
            $("#loader").css("display", "block");
            $.ajax({
                url: "<?php echo base_url() ?>Anwser/delete_anwser",
                type: "POST",
                datatype: "json",
                data: {
                    "anwser_id_del": $("#anwser_id_del").val()
                },
                success: (function (result) {
                    if (result > 0) {
                        location.reload();
                    }
                }),
                error: function (xhr) {

                }
            });
        }


        function follow() {
            $("#loader").css("display", "block");
            var editor_follow = quill_follow.root.innerHTML;
            if ($("#follow_date").val() === null || $("#follow_date").val() === "") {
                alert("ระบุวันที่")
                $("#loader").css("display", "none");
                return false;
            } else {

                $.ajax({
                    url: "<?php echo base_url() ?>follow/insert_follow",
                    type: "POST",
                    datatype: "json",
                    data: {
                        "editor_follow": editor_follow,
                        "follow_date": $("#follow_date").val(),
                        "follow_sugges_id": $("#follow_sugges_id").val()
                    },
                    success: (function (result) {
                        console.log(result);
                        if (result > 0) {
                            location.reload();
                        }
                    }),
                    error: function (xhr) {
                        console(xhr.statusText);
                    }
                });
            }

        }
        function follow_edit() {
            $("#loader").css("display", "block");
            var editor_follow = quill_edit_follow.root.innerHTML;
            $.ajax({
                url: "<?php echo base_url() ?>follow/update_follow",
                type: "POST",
                datatype: "json",
                data: {
                    "editor_follow": editor_follow,
                    "edit_follow_date": $("#edit_follow_date").val(),
                    "edit_follow_sugges_id": $("#edit_follow_sugges_id").val()
                },
                success: (function (result) {
                    console.log(result);
                    if (result > 0) {
                        location.reload();
                    }
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }

        function del_follow() {


            $("#loader").css("display", "block");
            $.ajax({
                url: "<?php echo base_url() ?>Follow/delete_follow",
                type: "POST",
                datatype: "json",
                data: {
                    "delete_id_del": $("#follow_id_del").val()
                },
                success: (function (result) {
                    console.log(result);
                    if (result > 0) {
                        location.reload();
                    }
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }

    </script>
</html>


<?php

function convert_date($date) {
    $textday = "";
    $date_ex = explode("-", $date);
    $yyyy = $date_ex[0] + 543;
    $mm = $date_ex[1];
    $dd = $date_ex[2];
    $textday = $dd . "/" . $mm . "/" . $yyyy;


    return $textday;
}

function convert_date_time() {
    $textday = "";
    $date_ex = explode(" ", $date);
    $date_ex2 = explode("-", $date_ex[0]);
    $yyyy = $date_ex2[0] + 543;
    $mm = $date_ex2[1];
    $dd = $date_ex2[2];
    $textday = $dd . "/" . $mm . "/" . $yyyy;
    return $textday;
}
?>

<script>

    $('.toast').toast('show')
    function  leave_detail(per_code, project_id) {
        $.ajax({
            url: "<?php echo base_url() ?>Home/leave_detail",
            type: "POST",
            datatype: "json",
            data: {
                "per_code": per_code,
                "project_id": project_id
            },
            success: (function (result) {
                if (result == 1) {
                    location.href = "<?= base_url("home") ?>";
                }
            }),
            error: function (xhr) {
                console(xhr.statusText);
            }
        });
    }


//    $("#datepicker_project").keydown(function (e) {
//
//        e = e || window.event;
//        var key = e.which || e.keyCode; // keyCode detection
//        var ctrl = e.ctrlKey ? e.ctrlKey : ((key === 17) ? true : false); // ctrl detection
//
//        if (key == 86 && ctrl) {
//            console.log("Ctrl + V Pressed !");
//        } else if (key == 67 && ctrl) {
//            console.log("Ctrl + C Pressed !");
//        }
//
//    }, false);

    $('#datepicker_project').on('keydown', function (e) {
        if (e.which == 13)
            e.stopImmediatePropagation();
    }).datepicker();
    picker_date(document.getElementById("my_date"), {year_range: "-100:+50"});
</script>
