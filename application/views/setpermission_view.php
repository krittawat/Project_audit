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
                                <h6 class="m-0 font-weight-bold text-primary">รายชื่อผู้ใช้งานระบบ</h6>
                                <h6 class="m-0 font-weight-bold text-primary">

                                    <button class="btn btn-lg btn-primary" style=""
                                        onclick="window.location.href = '<?php echo base_url('setpermission/insert_user') ?>'">
                                        <i class="fa fa-address-book"></i> เพิ่มผู้ใช้งาน
                                    </button>
                                </h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body " style="color: black;background-color: #e3e3e3;">
                                <table style="color: black;background-color: white" id="empTable"
                                    class="table table-striped table-bordered cell-border responsive">
                                    <thead style="color: black">
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อ - สกุล</th>
                                            <th>ตำแหน่ง</th>
                                            <th>สถานะการใช้งาน</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><a href="#"></a></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อ - สกุล</th>
                                            <th>ตำแหน่ง</th>
                                            <th>สถานะการใช้งาน</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
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



    $(document).ready(function () {
        // Prepare the preview for profile picture
        $("#files").change(function () {
            readURL(this);

            const fi = document.getElementById('files');
            // Check if any file is selected. 
            if (fi.files.length > 0) {
                for (const i = 0; i <= fi.files.length - 1; i++) {
                    const fsize = fi.files.item(i).size;
                    const file = Math.round((fsize / 1024));
                    // The size of the file. 
                    if (file >= 3400) {
                        document.getElementById('size').innerHTML = '<b style="color:red;">'
                            + file + '</b> KB';
                        $("#check_pic").val("0");
                    } else if (file < 3400) {
                        document.getElementById('size').innerHTML = '<b>'
                            + file + '</b> KB';
                        $("#check_pic").val("1");
                    }
                }
            }



        });
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#pass2").keyup(function () {
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


    var page = 0;
    var table = $('#empTable').DataTable({
        "oLanguage": {
            "sLengthMenu": "แสดง _MENU_ รายการ", // **dont remove _MENU_ keyword**
        },
        "info": false,
        "language": {
            "search": "ค้นหา :",
            "paginate": {
                "previous": "ย้อนกลับ",
                "next": "ถัดไป"
            }

        },
        "bAutoWidth": false,
        "autoWidth": false,
        processing: true,
        serverSide: true,
        serverMethod: 'post',
        stateSave: true,
        'ajax': {

            "type": "POST",
            'url': '<?= base_url("index.php/setpermission/ajaxfile") ?>',
            "data": function (d) {
                // d.start_date = $('#start_date').val();
                // d.end_date = $('#end_date').val();
            }
        },
        'columns': [
            { data: 'no' },
            { data: 'name' },
            { data: 'POSITION' },
            { data: 'status' },
            { data: 'tools' },

        ],
        "columnDefs": [
            // { "width": "70%", "targets": 0 },

            { "width": "3%", "targets": 0 },
            { "width": "15%", "targets": 3 },
            { "width": "15%", "targets": 4 },
        ]

    });
    $('#empTable').DataTable().on('order', function () {
        if ($('#empTable').DataTable().page() !== page) {
            $('#empTable').DataTable().page(page).draw('page');
        }
    });
    $('.datepicker2').change(function () {
        var table = $('#empTable').DataTable();
        table.draw();
    });


    function update_status(percode, status) {
        if (status == 1) {
            status = 0
        } else {
            status = 1
        }
        $.ajax({
            url: "<?php echo base_url() ?>setpermission/update_status",
            type: "POST",
            datatype: "json",
            data: {
                "per_code": percode,
                "status": status,
            },
            success: (function (result) {

                table.ajax.reload();


            }),
            error: function (xhr) {
                console(xhr.statusText);
            }
        });
    }
</script>

</html>