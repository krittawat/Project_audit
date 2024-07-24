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
                            <h1 class="h3 mb-0 text-gray-800">รายการโครงการ</h1>
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
                                    <h6 class="m-0 font-weight-bold text-primary">รายการโครงการ</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body" style="color: black;background-color: #a0bbc69c">
                                    <form class=""  method="get" action="<?= base_url("home") ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email">ชื่อโครงการ</label>
                                                    <input type="text" class="form-control" placeholder="ชื่อโครงการ" id="search_project_name" name="search_project_name" value="<?= $search; ?>">
                                                    <input type="hidden" class="form-control" placeholder="ชื่อโครงการ" id="per_page" name="per_page" value="<?= $this->input->get("per_page"); ?>">

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
                                    foreach ($projects as $project) {
                                        ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">โครงการ</h5><div><?= $project->project_name ?></div>

                                                        <div class="d-flex flex-row-reverse">
                                                            <div class="p-2">วันที่ : <?= convert_date($project->project_update_date) ?></div>
                                                        </div>
                                                        <a href="<?php echo base_url('Home/project_detail/') . $project->project_id ?>" class="btn btn-primary float-right">รายระเอียด</a>
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
//        $(window).on('resize', function () {
//
//            $('#empTable').DataTable().columns.adjust();
//        });

        $(document).ready(function () {
            var page = 0;

            var table = $('#empTable').DataTable({
                "autoWidth": false,
                processing: true,
                serverSide: true,
                serverMethod: 'post',
                stateSave: true,
                columnDefs: [
                    {type: 'numeric', targets: 0}
                ],
                'ajax': {
                    "type": "POST",
                    'url': '<?= base_url("index.php/home/ajaxfile") ?>'
                },
                'columns': [
                    {data: 'project_name'},
                    {data: 'project_create_date'},
                    {data: 'project_id'},
                ],
                "columnDefs": [
                    {"width": "13%", "targets": 1},
                    {"width": "12%", "targets": 2},
                ],

            });

            $('#empTable').DataTable().on('order', function () {
                if ($('#empTable').DataTable().page() !== page) {
                    $('#empTable').DataTable().page(page).draw('page');
                }
            });

//            $('#empTable tbody').on('dblclick', 'tr', function () {
//                var url = '<?= base_url('index.php/Home/insert_view/') ?>'
//                var row = table.row($(this)).data();
//                console.log(row["project_id"]);
//                window.open(url + row["project_id"], "_self");
//            });

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