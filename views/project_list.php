<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ระบบ Follow Up</title>
        <?php
        $this->load->view('Template/css');
        ?>

        <style>

            td {
                /*white-space: nowrap;*/
                word-wrap: break-word;
                width: 2%
            }

            .wrapok {
                word-wrap: break-word;
                width: 2%
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
                            <h1 class="h3 mb-0 text-gray-800">รายการผลตรวจสอบ/โครงการ</h1>
                            <div class="form-group text-right" style="">
                                <button type="button" class="btn btn-success" onclick="window.location.href = '<?= base_url("index.php/Home/insert_view?project_type=office") ?>'"><i class="fa fa-paste"></i> เพิ่มโครงการตรวจสอบส่วนกลาง</button>
                                <br>
                                <button type="button" class="btn btn-primary" onclick="window.location.href = '<?= base_url("index.php/Home/insert_view?project_type=station") ?>'" style="margin-top: 0.5em"> <i class="fa fa-bus"></i> เพิ่มโครงการตรวจสอบส่วนภูมิภาค</button>
                            </div>
                        </div>

                        <!-- Content Row -->


                        <!-- The Modal -->
                        <div class="col">
                            <div class="card shadow">


                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">รายการผลตรวจสอบ/โครงการ</h6>

                                </div>

                                <!-- Card Body -->
                                <div class="card-body" style="color: black;background-color: #a0bbc69c">
                                    <div class="row">
                                        <div class="col-2">

                                        </div>
                                        <div class="col-5">
                                            <label for="demo">ค้นหาช่วงวันที่ออกรายงานฉบับสมบูรณ์ ตั้งแต่วันที่</label>
                                            <div class="input-group mb-3" >
                                                <input  type="text"  class="datepicker1 form-control form-control-sm" placeholder="วันที่เรื่มต้น" data-date-format="mm/dd/yyyy"  id="start_date" readonly autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <label for="demo">ถึงวันที่</label>
                                            <div class="input-group mb-3" >
                                                <input  type="text"  class="datepicker2 form-control form-control-sm" placeholder="วันที่สิ้นสุด" data-date-format="mm/dd/yyyy" id="end_date" readonly autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <table style="color: black;background-color: white" id="empTable" class="table table-striped table-bordered cell-border responsive" >
                                        <thead style="color: black">
                                            <tr>
                                                <th>ผลตรวจสอบ/โครงการ</th>
                                                <th>สาย</th>
                                                <th>ปีงบประมาณ</th>
                                                <th>วันที่ส่งรายงานฉบับสมบูรณ์</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <tr >
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><a href="#"></a></td>
                                            </tr>
                                        </tbody>
                                        <tfoot >
                                            <tr>
                                                <th>ผลตรวจสอบ/โครงการ</th>
                                                <th>สาย</th>
                                                <th>ปีงบประมาณ</th>
                                                <th>วันที่ส่งรายงานฉบับสมบูรณ์</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
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
//        $this->load->view('Template/notification');
        ?>
    </body>
    <script>
        $('.datepicker1').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            autoclose: true,
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
                    'url': '<?= base_url("index.php/home/ajaxfile") ?>',
                    "data": function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                'columns': [
                    {data: 'project_name'},
                    {data: 'project_group'},
                    {data: 'project_year'},
                    {data: 'project_create_date'},
                    {data: 'project_id'},
                ],
                "columnDefs": [
                    {"width": "70%", "targets": 0},

                    {"width": "10%", "targets": 2},
                    {"width": "20%", "targets": 4},
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