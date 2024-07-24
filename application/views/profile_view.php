<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ระบบแจ้งเตือนการติดตามผลการปฏิบัติตามข้อเสนอแนะ</title>
    <link href="<?= base_url() ?>assets/vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>/assets/css/sb-admin-2.css" rel="stylesheet">




    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="<?= base_url() ?>assets/fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
    <link href="<?= base_url() ?>assets/fileinput/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css" />

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>assets/fileinput/js/plugins/piexif.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/fileinput/js/plugins/sortable.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/fileinput/js/fileinput.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/fileinput/js/locales/fr.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/fileinput/js/locales/es.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/fileinput/themes/fas/theme.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/fileinput/themes/explorer-fas/theme.js" type="text/javascript"></script>


    <script src="<?= base_url() ?>assets/bootbox/bootbox.min.js" type="text/javascript"></script>


    <link href="<?= base_url() ?>assets/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.css" rel="stylesheet">
    <script type="text/javascript" src="<?= base_url() ?>assets/bootstrap-datepicker-master/dist/js/bootstrap-datepicker-custom.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/bootstrap-datepicker-master/js/locales/bootstrap-datepicker.th.js"></script>




    <style>
        /*Profile Pic Start*/
        .picture-container {
            position: relative;

            text-align: center;
        }

        .picture {
            width: 180px;
            height: 180px;
            background-color: #999999;
            border: 4px solid #CCCCCC;
            color: #FFFFFF;
            border-radius: 50%;
            margin: 0px auto;
            overflow: hidden;
            transition: all 0.2s;
            -webkit-transition: all 0.2s;
        }

        .picture:hover {
            border-color: #2ca8ff;
        }

        .content.ct-wizard-green .picture:hover {
            border-color: #05ae0e;
        }

        .content.ct-wizard-blue .picture:hover {
            border-color: #3472f7;
        }

        .content.ct-wizard-orange .picture:hover {
            border-color: #ff9500;
        }

        .content.ct-wizard-red .picture:hover {
            border-color: #ff3b30;
        }

        .picture input[type="file"] {
            cursor: pointer;
            display: block;
            height: 100%;
            left: 0;
            opacity: 0 !important;
            position: absolute;
            top: 0;
            width: 20%;
        }

        .picture-src {
            width: 100%;

        }

        /*Profile Pic End*/
    </style>
    </style>
</head>

<body id="page-top" onload="startTime()">
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
                        <div class="card shadow">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">โปรไฟล์</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body " style="color: black;background-color: #e3e3e3;">
                                <form class="form form-vertical" action="<?= base_url("profile/upload_image_user") ?>" method="post" enctype="multipart/form-data" id="form" name="form">
                                    <div class="picture-container">
                                        <input name="check_pic" id="check_pic" type="hidden" value="2">
                                        <div class="picture">
                                            <img src="<?= $image_profile ?>" class="picture-src" id="wizardPicturePreview" title="">
                                            <input type="file" id="files" name="files[]" style=" left: 40%;  cursor: pointer;" accept="image/x-png,image/gif,image/jpeg">
                                        </div>
                                        <br>
                                        <h6 class="">Choose Picture</h6>
                                        <p id="size"></p>
                                        <hr>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="usr">ชื่อ:</label>
                                                    <input type="text" class="form-control" id="name" value="<?= $_SESSION["user"]["0"]["FIRST_NAME"] ?>" name="name">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="usr">นามสกุล:</label>
                                                    <input type="text" class="form-control" id="lastname" value="<?= $_SESSION["user"]["0"]["LAST_NAME"] ?>" name="lastname">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="usr">กลุ่มงานตรวจสอบ : </label>
                                                    <input type="text" class="form-control" id="permission" value="<?= $_SESSION["user"]["0"]["group"] ?>" name="permission">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="usr">สิทธิ์ : (97 = ง.บท.สตส. 98,99 = Admin 0 =
                                                        ผู้ใช้งานปกติ )</label>
                                                    <input type="text" class="form-control" id="permission" value="<?= $_SESSION["user"]["0"]["level"] ?>" name="permission">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <p>
                                                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2" onclick="pass();">แก้ไขรหัสผ่าน</button>
                                                </p>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                                                            <div class="card card-body">
                                                                <div class="form-group">
                                                                    <label for="usr">ยืนยันรหัสผ่าน:</label>
                                                                    <input type="hidden" class="form-control" id="check_password_input" name="check_password_input">
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="usr">รหัสผ่าน:</label>
                                                                        <input type="password" class="form-control" id="pass1" name="pass1">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="usr">ยืนยันรหัสผ่าน:</label>
                                                                        <input type="password" class="form-control" id="pass2" name="pass2">
                                                                    </div>
                                                                </div>
                                                                <div class="text-danger" style="display: none">*
                                                                    รหัสผ่านไม่ตรงกัน</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-block">ยืนยัน</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    $(document).ready(function() {
        // Prepare the preview for profile picture
        $("#files").change(function() {
            readURL(this);

            const fi = document.getElementById('files');
            // Check if any file is selected. 



            if (fi.files.length > 0) {
                console.log("fi.files.length", fi.files.length)
                const i = fi.files.length
                for (i; i <= fi.files.length - 1; i++) {
                    const fsize = fi.files.item(i).size;
                    const file = Math.round((fsize / 1024));
                    // The size of the file. 
                    if (file >= 3400) {
                        document.getElementById('size').innerHTML = '<b style="color:red;">' +
                            file + '</b> KB';
                        $("#check_pic").val("0");
                    } else if (file < 3400) {
                        document.getElementById('size').innerHTML = '<b>' +
                            file + '</b> KB';
                        $("#check_pic").val("1");
                    }
                }
            }



        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#pass2").keyup(function() {
        var pass1 = $("#pass1").val()
        var pass2 = $("#pass2").val()
        if (pass1 == pass2) {

        } else {
            $(".text-danger").css("display", "block")
        }
    });



    function pass() {
        if (!$("#multiCollapseExample1").hasClass('show')) {
            $("#check_password_input").val("1");
        } else {
            $("#check_password_input").val("2");
        }
    }

    $(document).ready(function(event) {
        $('form[name=form]').submit(function(event) {

            if ($("#check_pic").val() == 0) {
                alert("ไฟล์รูปภาพใหญ่เกินไป")
                return false
            }

            if (!$("#multiCollapseExample1").hasClass('show')) {} else {
                var pass1 = $("#pass1").val()
                var pass2 = $("#pass2").val()
                if (pass1 !== pass2) {
                    console.log("ไม่ตรง");
                    $(".text-danger").css("display", "block")
                    setInterval(function() {
                        $(".text-danger").css("display", "none")
                    }, 5000);
                    return false
                } else if (pass1 == "") {
                    $("#check_password_input").val("2");
                } else if (pass2 == "") {
                    $("#check_password_input").val("2");
                } else if (pass2 == "" || pass1 == "") {
                    $("#check_password_input").val("2");
                } else {
                    $(".text-danger").css("display", "none")
                    console.log("ตรง");
                }
            }


        });
    });
</script>

</html>