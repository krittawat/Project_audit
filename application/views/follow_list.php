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
                            <h1 class="h3 mb-0 text-gray-800">ระบบติดตาม</h1>
                        </div>

                        <!-- Content Row -->

                        <!-- The Modal -->
                        <div class="col">
                            <div class="card shadow">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">ติดตาม</h6>

                                </div>

                                <!-- Card Body -->
                                <div class="card-body" style="color: black">

                                    <?php if (isset($_GET["group"])) { ?>
                                        <label class="font-weight-bold">งานตรวจสอบสาย <?= $_GET["group"] ?></label>
                                        <hr>
                                    <?php } ?>


                                    <div class="row">
                                        <div class="col-2">


                                        </div>
                                        <div class="col-5">
                                            <label for="demo">ค้นหาช่วงวันที่แล้วเสร็จ ตั้งแต่วันที่</label>
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
                                    <table style="color: black;background-color: white;width:100%" id="empTable" class="table table-striped table-bordered cell-border" >

                                        <thead style="color: black">
                                            <tr>
                                                <th>โครงงการ</th>
                                                <th>ประเด็นที่</th>
                                                <th>มติที่ประชุมจากการปิดตรวจ</th>
                                                <!--<th>เลขที่หนังสือมติ</th>-->
                                                <th>วันที่แล้วเสร็จ</th>
                                                <th>การติดตาม</th>
                                                <th>สถานะ</th>
                                                <th>รายละเอียด</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr >
                                                <td>โครงงการ</td>
                                                <td>ประเด็นที่</td>
                                                <td>มติที่ประชุมจากการปิดตรวจ</td>
                                                <!--<td>เลขที่หนังสือ</td>-->
                                                <td>วันที่แล้วเสร็จ</td>
                                                <td>การติดตาม</td>
                                                <td>สถานะ</td>
                                                <td>รายละเอียด</td>
                                            </tr>
                                        </tbody>
                                        <tfoot >
                                            <tr>
                                                <th>โครงงการ</th>
                                                <th>ประเด็นที่</th>
                                                <th>มติที่ประชุมจากการปิดตรวจ</th>
                                                <!--<th>เลขที่หนังสือมติ </th>-->
                                                <th>วันที่แล้วเสร็จ</th>
                                                <th>การติดตาม</th>
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

                <!-- Modal แก้การติดตาม -->
                <div class="modal fade" id="followmodaldate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document" >
                        <div class="modal-content" >
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">การติดตาม</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input  type="hidden" id="follow_sugges_id">
                                <input  type="hidden" id="follow_text_status">
                                <input  type="hidden" id="follow_status">
                                <div class="row" id="doc_" style="display: none">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="usr">เลขที่หนังสือ</label>
                                            <input  type="text"  class="form-control" placeholder="เลขที่หนังสือ"  name="doc_number" id="doc_number" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!--<div id="date_">0000</div>-->
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="usr">ผู้ดำเนินติดตาม :</label>
                                            <input  type="text"  class="datepicker form-control" placeholder="ผู้ดำเนินติดตาม" name="person_follow" id="person_follow">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="usr">วันที่ :</label>
                                            <input  type="text"  class="datepicker form-control" placeholder="วันที่ติดตาม" data-date-format="mm/dd/yyyy" name="follow_date" id="follow_date" onkeypress="return false" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="follow_status_update()">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="modal fade" id="modalthree" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document" >
                        <div class="modal-content" >
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" >การติดตาม ไตรมาส</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input  type="hidden" id="follow_sugges_id2">
                                <input  type="hidden" id="follow_text_status2">
                                <input  type="hidden" id="follow_status2">
                                <div id="follow_text2" class="font-weight-bold"></div><br>
                                <div class="row" id="doc_">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="usr">เลขที่หนังสือ</label>
                                            <input  type="text"  class="form-control" placeholder="เลขที่หนังสือ"  name="doc_number2" id="doc_number2" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!--<div id="date_">0000</div>-->
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="usr">ผู้ดำเนินติดตาม :</label>
                                            <input  type="text"  class="datepicker form-control" placeholder="ผู้ดำเนินติดตาม" name="person_follow2" id="person_follow2">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="usr">วันที่ :</label>
                                            <input  type="text"  class="datepicker form-control" placeholder="วันที่ติดตาม" data-date-format="mm/dd/yyyy" name="follow_date2" id="follow_date2" onkeypress="return false" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="follow_status_update2()">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>


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

        $('#follow_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker(); //กำหนดเป็นวันปัจุบัน


        $('#follow_date2').datepicker({
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
                "scrollX": true,
                ajax: {
                    "type": "POST",
                    'url': '<?= base_url("index.php/follow/ajaxfile") ?>',
                    'data': {
//                        'start_date': $("#start_date").val(),
//                        d.group = '<?= $this->input->post("group") ?>'
                    },
                    "data": function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.group = '<?= $this->input->get("group") ?>'
                    }
                },
                'columns': [
                    {data: 'project_name'},
                    {data: 'subject_name'},
                    {data: 'suggestion_name'},
//                    {data: 'suggestion_docnumber'},
                    {data: 'suggestion_duedate'},
                    {data: 'suggestion_id'},
                    {data: 'suggestion_startdate'},
                    {data: 'project_id'},
                ],

                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;
                    api.column(0, {page: 'current'}).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="7" style="font-weight: bold;"><div style="word-wrap: break-word;width:50em;">' + group + '</div></td></tr>'
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
        function change_status_sugges(sugges_id, status, date, doc_number, person) {
            var text_status = ""
            $(".modal-body #doc_").css("display", "none");
            $(".modal-body #doc_number").val("");
            $('#follow_date').val("")

            if (status == 0) {
                text_status = "ยังไม่มีการติดตาม";
                $.ajax({
                    url: "<?php echo base_url() ?>Follow/change_status_follow",
                    type: "POST",
                    datatype: "json",
                    data: {
                        "sugges_id": sugges_id,
                        "status": 0,
                        "follow_date": "",
                        "follow_doc": ""
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
            } else if (status == 1) {
                text_status = "โทรครั้งที่ 1";
                $("#followmodaldate").modal();
                $(".modal-body #follow_sugges_id").val(sugges_id);
                $(".modal-body #follow_text_status").val(text_status);
                $(".modal-body #follow_status").val(status);
            } else if (status == 2) {
                text_status = "โทรครั้งที่ 2";
                $("#followmodaldate").modal();
                $(".modal-body #follow_sugges_id").val(sugges_id);
                $(".modal-body #follow_text_status").val(text_status);
                $(".modal-body #follow_status").val(status);
            } else if (status == 3) {
                text_status = "ส่งเอกสารครั้งที่ 1";
                $(".modal-body #doc_").css("display", "block");
                $("#followmodaldate").modal();
                $(".modal-body #follow_sugges_id").val(sugges_id);
                $(".modal-body #follow_text_status").val(text_status);
                $(".modal-body #follow_status").val(status);
                if (doc_number != 0) {
                    $(".modal-body #doc_number").val(doc_number);
                }


            } else if (status == 4) {
                text_status = "ส่งเอกสารครั้งที่ 2";
                $(".modal-body #doc_").css("display", "block");
                $("#followmodaldate").modal();
                $(".modal-body #follow_sugges_id").val(sugges_id);
                $(".modal-body #follow_text_status").val(text_status);
                $(".modal-body #follow_status").val(status);
                if (doc_number != 0) {
                    $(".modal-body #doc_number").val(doc_number);
                }

            }
            $(".modal-body #person_follow").val(person);
            if (date != 0) {
                $('#follow_date').datepicker({
                    format: 'dd/mm/yyyy',
                    todayBtn: true,
                    language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                    thaiyear: true //Set เป็นปี พ.ศ.

                }).datepicker("setDate", new Date(date)); //กำหนดเป็นวันปัจุบัน
            }

        }


        function change_status_sugges2(sugges_id, status, date, doc_number, person) {
            $("#modalthree").modal();
            $(".modal-body #doc_number2").val("");
            $('#follow_date2').val("")


            $(".modal-body #follow_sugges_id2").val(sugges_id);
            $(".modal-body #follow_text_status2").val(text_status);
            $(".modal-body #follow_status2").val(status);
            var text_status = ""
            if (status == 6) {
                text_status = "ไตรมาส 1";
                $(".modal-body #follow_sugges_id2").val(sugges_id);
                $(".modal-body #follow_text_status2").val(text_status);
                $(".modal-body #follow_status2").val(status);
            } else if (status == 7) {
                text_status = "ไตรมาส 2";
                $(".modal-body #follow_sugges_id2").val(sugges_id);
                $(".modal-body #follow_text_status2").val(text_status);
                $(".modal-body #follow_status2").val(status);
            } else if (status == 7) {
                text_status = "ไตรมาส 3";
                $(".modal-body #follow_sugges_id2").val(sugges_id);
                $(".modal-body #follow_text_status2").val(text_status);
                $(".modal-body #follow_status2").val(status);
            } else if (status == 9) {
                text_status = "ไตรมาส 4";
                $(".modal-body #follow_sugges_id2").val(sugges_id);
                $(".modal-body #follow_text_status2").val(text_status);
                $(".modal-body #follow_status2").val(status);
            }
            $("#follow_text2").html(text_status)

            $(".modal-body #person_follow2").val(person);
            if (doc_number != 0) {
                $(".modal-body #doc_number2").val(doc_number);
            }
            if (date != 0) {
                $('#follow_date2').datepicker({
                    format: 'dd/mm/yyyy',
                    todayBtn: true,
                    language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                    thaiyear: true //Set เป็นปี พ.ศ.

                }).datepicker("setDate", new Date(date)); //กำหนดเป็นวันปัจุบัน
            }
        }


        function follow_status_update() {

            var follow_text_status = $("#follow_text_status").val()
            var follow_sugges_id = $("#follow_sugges_id").val()
            var follow_date = $("#follow_date").val()
            var follow_status = $("#follow_status").val()
            var follow_doc = $("#doc_number").val()
            var person_follow = $("#person_follow").val()


            if (follow_date == "") {
                alert("ระบุวันที่")
                $("#follow_date").focus()
                return false
            }

            $.ajax({
                url: "<?php echo base_url() ?>Follow/change_status_follow",
                type: "POST",
                datatype: "json",
                data: {
                    "sugges_id": follow_sugges_id,
                    "status": follow_status,
                    "follow_date": follow_date,
                    "follow_doc": follow_doc,
                    "person_follow": person_follow
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


        function follow_status_update2() {

            var follow_text_status = $("#follow_text_status2").val()
            var follow_sugges_id = $("#follow_sugges_id2").val()
            var follow_date = $("#follow_date2").val()
            var follow_status = $("#follow_status2").val()
            var follow_doc = $("#doc_number2").val()
            var person_follow = $("#person_follow2").val()



            if (follow_date == "") {
                alert("ระบุวันที่")
                $("#follow_date2").focus()
                return false
            }

            $.ajax({
                url: "<?php echo base_url() ?>Follow/change_status_follow_three",
                type: "POST",
                datatype: "json",
                data: {
                    "sugges_id": follow_sugges_id,
                    "status": follow_status,
                    "follow_date": follow_date,
                    "follow_doc": follow_doc,
                    "person_follow": person_follow
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



        function noti() {
            var request = require('request');
            request({
                method: 'POST',
                uri: 'https://notify-api.line.me/api/notify',
                header: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                auth: {
                    bearer: 'vBESmBZRFWGSb64IQnbt63sltEglv4cXMgGOX0OtDUn', //token
                },
                form: {
                    message: 'ทดสอบ', //ข้อความที่จะส่ง
                },
            }, (err, httpResponse, body) => {
                if (err) {
                    console.log(err)
                } else {
                    console.log(body)
                }
            })


            $.ajax({
                url: "<?php echo base_url() ?>Follow/change_status_follow",
                type: "POST",
                datatype: "json",
                data: {
                    "sugges_id": sugges_id,
                    "status": status
                },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(username + ":" + password));
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
    </script>
</html>


