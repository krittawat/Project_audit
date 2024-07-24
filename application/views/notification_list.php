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
        <style>
            tr.group,
            tr.group:hover {
                background-color: #ddd !important;
            }
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
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">ประเด็นที่ยังไม่มีการตอบกลับ</h1>
                            <div class="form-group" style="">
                                <button type="button" class="btn btn-success" onclick="window.location.href = '<?= base_url("index.php/Home/insert_view") ?>'">เพิ่มโครงการ</button>
                            </div>
                        </div>

                        <!-- Content Row -->

                        <!-- The Modal -->
                        <div class="col">
                            <div class="card shadow">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">ประเด็นที่ยังไม่มีการตอบกลับ</h6>

                                </div>

                                <!-- Card Body -->
                                <div class="card-body"  style="color: black;background-color: #a0bbc69c">
                                    <form class=""  method="get" action="<?= base_url("notification") ?>">
                                        <div class="row">
                                            <div class="col-sm">

                                            </div>
                                            <div class="col-sm">
                                                <label for="demo">วันที่เรื่มต้น</label>
                                                <div class="input-group mb-3" >
                                                    <input  type="text"  class="datepicker1 form-control form-control-sm" placeholder="วันที่เรื่มต้น" data-date-format="mm/dd/yyyy" name="start_date" id="start_date" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <label for="demo">วันที่สิ้นสุด</label>
                                                <div class="input-group mb-3" >
                                                    <input  type="text"  class="datepicker2 form-control form-control-sm" placeholder="วันที่สิ้นสุด" data-date-format="mm/dd/yyyy" name="end_date" id="end_date" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group float-right">
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> ค้นหา</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <p><?php echo $links; ?></p>
                                    <?php
                                    foreach ($notis as $noti) {
                                        ?>
                                        <div class="row" style="font-size:0.9em ">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">โครงการ</h4><div><?= $noti["project_name"] ?></div>
                                                        <br>
                                                        <h4 class="card-title">ประเด็น</h4><div><?= $noti["subject_name"] ?></div>
                                                        <div>มติที่ประชุมจากการปิดตรวจ<?= $noti["suggestion_name"] ?></div>
                                                        <div class="d-flex flex-row-reverse">
                                                            <div class="p-2">วันที่ : <?= convert_date($noti["project_update_date"]) ?></div>
                                                        </div>
                                                        <a href="<?php echo base_url('Home/project_detail/') . $noti["project_id"] ?>" class="btn btn-primary float-right">รายระเอียด</a>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <p><?php echo $links; ?></p>
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
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
        <?php
        $this->load->view('Template/js');
        ?>
    </body>
    <script>
        var datepicker = $('.datepicker1').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker(); //กำหนดเป็นวันปัจุบัน

        $('.datepicker2').datepicker({
            format: 'dd/mm/yyyy',

            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker(); //กำหนดเป็นวันปัจุบัน



        $(document).ready(function () {
            var page = 0;
            var table = $('#empTable').DataTable({
                columnDefs: [
                    {type: 'numeric', targets: 0},
                    {width: "11%", "targets": 3},
                ],
                "autoWidth": false,
                processing: true,
                serverSide: true,
                serverMethod: 'post',
                stateSave: true,
                ajax: {
                    "type": "POST",
                    'url': '<?= base_url("index.php/Notification/ajaxfile") ?>',
                    'data': {
                        'start_date': $("#start_date").val(),
                        'end_date': $("#end_date").val()
                    }
                },
                'columns': [
                    {data: 'subject_name'},
                    {data: 'suggestion_name'},
                    {data: 'project_name'},
                    {data: 'project_create_date'},
                    {data: 'project_id'},
                ],
//                rowGroup: {
//                    dataSrc: "project_name",
//                    endRender: function (rows, group) {
//
//                    },
//                }
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;

                    api.column(2, {page: 'current'}).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="5" style="font-weight: bold;">โครงการ :  ' + group + '</td></tr>'
                                    );

                            last = group;
                        }
                    });
                }
            });
            table.columns([2]).visible(false);
        });




        $(document).ready(function () {
            var table = $('#empTable').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#start_date, #end_date').keyup(function () {
                table.draw();
            });
        });


        $('.datepicker1').change(function () {
            var table = $('#empTable').DataTable();
            table.draw();
        });

    </script>
</html>


<?php

function convert_date($date) {
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