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
                            <h1 class="h3 mb-0 text-gray-800">ระบบแจ้งเตือน</h1>
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
                                    <h6 class="m-0 font-weight-bold text-primary">การแจ้งเตือน</h6>

                                </div>

                                <!-- Card Body -->
                                <div class="card-body" style="color: black;background-color: #a0bbc69c">

                                    <div class="row">
                                        <div class="col-2">

                                        </div>
                                        <div class="col-5">
                                            <label for="demo">ค้นหาช่วงวันที่ออกรายงานฉบับสมบูรณ์ ตั้งแต่วันที่</label>
                                            <div class="input-group mb-3" >
                                                <input  type="text"  class="datepicker1 form-control form-control-sm" placeholder="ตั้งแต่วันที่" data-date-format="mm/dd/yyyy" name="date" id="start_date" readonly autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <label for="demo">ถึงวันที่</label>
                                            <div class="input-group mb-3" >
                                                <input  type="text"  class="datepicker2 form-control form-control-sm" placeholder="ถึงวันที่" data-date-format="mm/dd/yyyy" name="date" id="end_date" readonly autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <table style="color: black;background-color: white" id="empTable" class="table table-striped table-bordered cell-border responsive" >
                                        <thead style="color: black">
                                            <tr>
                                                <th>โครงงการ</th>
                                                <th>ประเด็นที่</th>
                                                <th>มติที่ประชุมจากการปิดตรวจ</th>
                                                <th>เลขที่รายงานฉบับสมบูรณ์</th>
                                                <th>วันที่ส่งรายงานฉบับสมบูรณ์</th>
                                                <th>สถานะ</th>
                                                <th>รายละเอียด</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr >
                                                <td>โครงงการ</td>
                                                <td>ประเด็นที่</td>
                                                <td>มติที่ประชุมจากการปิดตรวจ</td>
                                                <td>เลขที่รายงานฉบับสมบูรณ์</td>
                                                <td>วันที่ส่งรายงานฉบับสมบูรณ์</td>
                                                <td>สถานะ</td>
                                                <td>รายละเอียด</td>
                                            </tr>
                                        </tbody>
                                        <tfoot >
                                            <tr>
                                                <th>โครงงการ</th>
                                                <th>ประเด็นที่</th>
                                                <th>มติที่ประชุมจากการปิดตรวจ</th>
                                                <th>เลขที่รายงานฉบับสมบูรณ์</th>
                                                <th>วันที่</th>
                                                <th>สถานะ</th>
                                                <th>รายละเอียด</th>
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
        ?>
        <?php
//        $this->load->view('Template/notification');
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
                columnDefs: [

                ],
                "autoWidth": false,
                processing: true,
                serverSide: true,
                serverMethod: 'post',
                stateSave: true,
                ajax: {
                    "type": "POST",
                    'url': '<?= base_url("index.php/Notification/ajaxfile") ?>',
//                    'data': {
//                        'start_date': $("#start_date").val(),
//                        'end_date': $("#end_date").val()
//                    }
                    "data": function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                'columns': [
                    {data: 'project_name'},
                    {data: 'subject_name'},
                    {data: 'suggestion_name'},
                    {data: 'suggestion_docnumber'},
                    {data: 'project_create_date'},
                    {data: 'suggestion_id'},
                    {data: 'project_id'},
                ],
//                "aoColumns": [
//                    {sWidth: '1%'},
//                    {sClass: "classDataTable"}
//                ],

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
                    api.column(0, {page: 'current'}).data().each(function (group, i) {



                        if (last !== group) {
                            $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="6" style="font-weight: bold;">รายการผลตรวจสอบ/โครงการ :  ' + group + '</td></tr>'
                                    );
                            last = group;
                        }
                    });

                }
            });
            table.columns([0]).visible(false);
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
        $('.datepicker2').change(function () {
            var table = $('#empTable').DataTable();
            table.draw();
        });

    </script>
</html>


