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
            #container.handsontable table{
                width:100%;
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

                        <!-- Content Row -->
                        <!-- The Modal -->
                        <div class="col">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                    <button class="open-modal btn btn-danger btn-small float-right trash-alt" data-toggle="modal" data-target="#exampleModal"<i class="far fa-trash-alt"></i>  ลบโครงการ</button>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  style="color: black">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color: black">ลบข้อมูล</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="project_id_del" id="project_id_del" value=""/>
                                                <div id="project_name_del"></div> 
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" onclick="del()">ต้องการลบ</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Modalลบประเด็น -->
                                <div class="modal fade" id="deletesubject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                    
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel" style="color: black">ลบข้อมูล</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="subject_id_del" id="subject_id_del" value=""/>
                                                    <div id="subject_name_del"></div> 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" onclick="del_subject()">ต้องการลบ</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Modalลบมติ -->
                                <div class="modal fade " id="deletesugges" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                 
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color: black">ลบข้อมูล</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="sugges_id_del" id="sugges_id_del" value=""/>
                                                <input type="hidden" name="status_id_del" id="status_id_del" value=""/>
                                                <div id="sugges_name_del"></div> 
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" onclick="del_sugges()">ต้องการลบ</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                            </div>
                                        </div>
                                    </div>  
                                </div>

                                <!-- Modalลบผลตอบ -->
                                <div class="modal fade" id="deleteanwser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color: black">ลบข้อมูล</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="anwser_id_del" id="anwser_id_del" value=""/>
                                                <div id="anwser_name_del"></div> 
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" onclick="del_anwser()">ต้องการลบ</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-body">
                                    <div class="form-group" style="color:black">
                                        <label for="comment">ชื่อโครงการ</label>
                                        <textarea  class="form-control" rows="1" id="project_name"  spellcheck="false" placeholder="ชื่อโครงการ"  name="project_name" onkeyup="onkeyupdateproject()"></textarea>
                                    </div>
                                    <div class="container">
                                        <!--<div id="spreadsheet"></div>-->
                                        <table id="table" style="color: black" class="table table-striped table-bordered table-responsive" style="font-size: 11px; ">
                                            <thead>
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>ประเด็น</th>
                                                    <th>มติที่ประชุม</th>
                                                    <th>วันที่เริ่มดำเนินการ/แล้วเสร็จ</th>
                                                    <th>วันที่ส่งรายงาน</th>
                                                    <th>วันที่รับรายงานตอบกลับ</th>
                                                    <th>ผลการปฏิบัติตามข้อเสนอแนะ</th>
                                                    <th>ดำเนินการแล้ว</th>
                                                    <th>อยู่ระหว่างดำเนินการ</th>
                                                    <th>ยังไม่ได้ดำเนินการ</th>
                                                    <th>วัน เดือน ปีที่ติดตาม</th>
                                                    <th>การติดตาม</th>
                                                    <th>วัน เดือน ปีขอขยายเวลา</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Tiger Nixon</td>
                                                    <td>System Architect</td>
                                                    <td>Edinburgh</td>
                                                    <td>61</td>
                                                    <td>2011/04/25</td>
                                                    <td>$320,800</td>
                                                    <td>Tiger Nixon</td>
                                                    <td>System Architect</td>
                                                    <td>Edinburgh</td>
                                                    <td>61</td>
                                                    <td>2011/04/25</td>
                                                    <td>$320,800</td>
                                                    <td>$320,800</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>ประเด็น</th>
                                                    <th>มติที่ประชุม</th>
                                                    <th>วันที่เริ่มดำเนินการ/แล้วเสร็จ</th>
                                                    <th>วันที่ส่งรายงาน</th>
                                                    <th>วันที่รับรายงานตอบกลับ</th>
                                                    <th>ผลการปฏิบัติตามข้อเสนอแนะ</th>
                                                    <th>ดำเนินการแล้ว</th>
                                                    <th>อยู่ระหว่างดำเนินการ</th>
                                                    <th>ยังไม่ได้ดำเนินการ</th>
                                                    <th>วัน เดือน ปีที่ติดตาม</th>
                                                    <th>การติดตาม</th>
                                                    <th>วัน เดือน ปีขอขยายเวลา</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>                          
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal เพิ่มประเด็น -->
                    <div class="modal fade" id="addsubject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document" >
                            <div class="modal-content" >
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มประเด็น</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input  name="project_id" id="project_id" value="" type="hidden"/>
                                    <div id="editor"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="add()">Save changes</button>
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
            $('#table').DataTable({
                "scrollX": true,
                responsive: false,
                rowGroup: false,
                "autoWidth": false,
                processing: true,
                serverSide: true,
                serverMethod: 'post',
                stateSave: true,
                'ajax': {
                    "type": "POST",
                    'url': '<?= base_url("index.php/notification/detail") ?>'
                },
                'columns': [
                    {data: 'subject_name'},
                    {data: 'subject_name'},
                    {data: 'suggestion_name'},
                    {data: 'suggestion_startdate'},
                    {data: 'anwser_respone_date'},
                    {data: 'anwser_name'},
                    {data: 'anwser_name'},
                    {data: 'anwser_name'},
                    {data: 'anwser_name'},
                    {data: 'anwser_name'},
                    {data: 'anwser_name'},
                    {data: 'anwser_name'},
                    {data: 'anwser_name'},
                    {data: 'anwser_name'},
                ],
            });
        });
        var datatable = [];




//        $(function () {
//
//
//            $.ajax({
//                url: "<?php echo base_url() ?>notification/detail",
//                type: "POST",
//                datatype: "json",
//                data: {
//
//                },
//                success: (function (result) {
//
//                    var obj = JSON.parse(result);
////                    var container = document.getElementById('spreadsheet');
//                    var data = [
//                        ['Jazz', 'Honda', '2019-02-12', '', true, '$ 2.000,00', '#777700'],
//                        ['Civic', 'Honda', '2018-07-11', '', true, '$ 4.000,01', '#007777'],
//                    ];
//                    jexcel(document.getElementById('spreadsheet'), {
//                        data: obj,
//                        columns: [
//                            {type: 'text', title: 'ลำดับ', width: 80},
//                            {type: 'text', title: 'ประเด็น', width: 500},
//                            {type: 'text', title: 'มติที่ประชุม', width: 120},
//                            {type: 'text', title: 'วันที่เริ่มดำเนินการ/แล้วเสร็จ', width: 120},
//                            {type: 'text', title: 'วันที่ส่งรายงาน', width: 80},
//                            {type: 'text', title: 'วันที่รับรายงานตอบกลับ', width: 100},
//                            {type: 'text', title: 'ผลการปฏิบัติตามข้อเสนอแนะ', width: 100},
//                            {type: 'text', title: 'ดำเนินการแล้ว', width: 100},
//                            {type: 'text', title: 'อยู่ระหว่างดำเนินการ', width: 100},
//                            {type: 'text', title: 'ยังไม่ได้ดำเนินการ', width: 100},
//                            {type: 'text', title: 'วัน เดือน ปีที่ติดตาม', width: 100},
//                            {type: 'text', title: 'การติดตาม', width: 100},
//                            {type: 'text', title: 'วัน เดือน ปีขอขยายเวลา', width: 100},
//                        ]
//                    });
//                }),
//                error: function (xhr) {
//                    console(xhr.statusText);
//                }
//            });
//        });

    </script>
</html>


