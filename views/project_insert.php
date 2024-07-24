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
            textarea {
                color: black !important;
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

                    <!-- End of Topbar -->
                    <?php
                    $this->load->view('Template/topbar');
                    ?>
                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Content Row -->

                        <!-- The Modal -->
                        <div class="col">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">เพิ่มกิจกรรมตรวจสอบ <?php
                                        if ($_GET["project_type"] == "office") {
                                            echo "ส่วนกลาง";
                                        } else {
                                             echo "ส่วนภูมิภาค";
                                        }
                                        ?>
                                    </h6>
                                    <!--<button class="open-modal btn btn-danger btn-small float-right trash-alt" data-toggle="modal" data-target="#exampleModal" data-id="<?= $project_id ?>" data-name="<?= $project_name ?>"><i class="far fa-trash-alt"></i>  ลบ</button>-->
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



                                <!-- Card Body -->
                                <form action="<?= $url_form ?>" method="POST">
                                    <div class="card-body">
                                        <label for="demo">เลขที่รายยงานผลการตรวจสอบ</label>
                                        <div class="input-group mb-3" >
                                            <input  type="text" class="form-control" placeholder="เลขที่หนังสือ"  name="project_docnumber" id="project_docnumber" >
                                        </div>

                                        <label for="demo">วันที่ส่งรายงานฉบับสมบูรณ์</label>
                                        <div class="input-group mb-3" >
                                            <input  type="text"  class="datepicker form-control" placeholder="วันที่ส่งรายงานฉบับสมบูรณ์" data-date-format="mm/dd/yyyy" name="date" id="date" required="" value="<?= $project_create_date ?>" onkeypress="return false" autocomplete="off">
                                        </div>

                                        <div class="form-group" style="color:black">
                                            <label for="comment">ชื่อกิจกรรมตรวจสอบ/โครงการ</label>
                                            <textarea  class="form-control" rows="1" id="txtarea"  spellcheck="false" placeholder="ชื่อโครงการ"  name="project_name" required><?= $project_name ?></textarea>
                                        </div>

                                        <label for="demo">ปีงบประมาณ</label>
                                        <div class="input-group mb-3" >
                                            <input  type="text"  class="datepicker form-control" placeholder="ปีงบประมาณ" data-date-format="YYYY" name="year" id="year" required="">
                                        </div>

                                        <label for="demo">งานตรวจสอบสาย</label>
                                        <div class="input-group mb-3" >
                                            <input  type="number" min="1" max="6" class="form-control" placeholder="กลุ่มงานตรวจสอบสาย"  name="group" id="group" required="" value="<?= $_SESSION["user"]["0"]["group"] ?>">
                                        </div>
                                        <input  type="hidden"  class="form-control" placeholder="ประเภท"  name="project_type" id="project_type"  value="<?= $_GET["project_type"] ?>">
                                        <!--<button type="submit" class="btn btn-success float-right">Submit</button>-->
                                        <div class="d-flex flex-row-reverse">
                                            <button type="submit" class="btn btn-success">บันทึก</button>
                                        </div>
                                        <div class="chart-area">
                                            <canvas id="myAreaChart"></canvas>
                                        </div>
                                    </div>
                                </form>
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
        window.addEventListener('load', (event) => {
            console.log('page is fully loaded');
            autosize()
        });
        function autosize() {
            var el = document.getElementById("txtarea");
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

        expandTextarea('txtarea');
<?php if ($yyyy != "" or $mm != "" or $dd != "") { ?>
            var year = <?= $yyyy ?>;
            var month = <?= $mm ?>;
            var day = <?= $dd ?>;
            var realDate = new Date(year, month - 1, day); // months are 0-based!
<?php } else { ?>
            var realDate = "0"
<?php } ?>

        $('#date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", realDate); //กำหนดเป็นวันปัจุบัน

        $('#year').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", new Date()); //กำหนดเป็นวันปัจุบัน


    </script>


    <script>
        $(".open-modal").click(function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var text = "ต้องการลบ : " + name + " หรือไม่"
            $(".modal-body #project_id_del").val(id);
            $(".modal-body #project_name_del").html(text);
        });
        function del() {

            $.ajax({
                url: "<?php echo base_url() ?>/index.php/Home/delect_project",
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



    </script>
</html>


