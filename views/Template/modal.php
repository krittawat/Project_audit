<style>
    .custom-control-lg .custom-control-label::before,
    .custom-control-lg .custom-control-label::after {
        top: 0.1rem !important;
        left: -2rem !important;
        width: 1.25rem !important;
        height: 1.25rem !important;
    }

    .custom-control-lg .custom-control-label {
        margin-left: 0.5rem !important;
        font-size: 1rem !important;
    }

    .form-check label {
        padding-left:  -0.9em;
        font-size: 1.1em;
        font-weight: 500;
    }
    .form-check-input[type=checkbox] {
        padding-left:  -0.9em;
        border-radius: 2em;
        height: 1.2em;
        width: 1.2em;
    }

</style>



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
<div class="modal fade" id="deleteanwser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                    
    <div class="modal-dialog" role="document">
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
                <br>
                <?php if (strpos($project_name, 'บริหารสถานี') != TRUE && $project_type_edit == "office") { ?>
                    <div class="form-group form-group-default">
                        <label>ระดับความสำคัญของผลการตรวจสอบ</label>
                        <select class="form-control" id="Select_center" style="color: black;">
                            <option value="0">-- โปรดเลือก ระดับความสำคัญของผลการตรวจสอบ  --</option>
                            <option value="1">ต่ำ</option>
                            <option value="2">กลาง</option>
                            <option value="3">สูง</option>
                            <option value="4">-- ไม่มีข้อเสนอแนะ  --</option>
                        </select>
                    </div>

                    <div class="form-group form-group-default">
                        <label>ประเภทข้อตรวจพบ</label>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="O" id="check_o">
                                        <span class="form-check-sign">&nbsp; &nbsp;  O </span>
                                    </label>
                                </div>                               
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="F" id="check_f">
                                        <span class="form-check-sign">&nbsp; &nbsp;  F </span>
                                    </label>
                                </div>                               
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="C" id="check_c">
                                        <span class="form-check-sign">&nbsp; &nbsp;  C </span>
                                    </label>
                                </div>                               
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="IT" id="check_it">
                                        <span class="form-check-sign">&nbsp; &nbsp;  IT</span>
                                    </label>
                                </div>                              
                            </div>
                        </div>
                        <br>
                    </div>
                <?php } else {
                    ?>
                    <div class="form-group form-group-default">
                        <label>หัวข้อประเด็น</label>
                        <select class="form-control" id="Select_station" style="color: black;">
                            <option value="0">-- โปรดเลือก หัวข้อประเด็นการตรวจสอบสถานี --</option>
                            <?php foreach ($type_station as $key => $value) { ?>
                                <option value="<?php echo $value["type_subject_value"] ?>"><?php echo $value["type_subject_name"] ?></option>
                            <?php } ?>
                            <!--<option value="no">--ไม่มีประเด็น --</option>-->
                        </select>
                    </div>
                <?php }
                ?>

                <div class="form-group">

                    <label for="usr">มติที่ประชุมจากการปิดตรวจ</label>
                    <div class="col">
                        <div class="custom-control-lg custom-control custom-checkbox" style="top: 0.5rem;">
                            <input class="custom-control-input" id="checkbox-large-no_sugges" type="checkbox"  name="no_sugges" value="no_sugges"/>
                            <label class="custom-control-label" for="checkbox-large-no_sugges">
                                ไม่มีมติที่ประชุมจากการปิดตรวจ
                            </label>
                        </div>
                    </div>
                </div>

            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="add()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal การติดตาม -->
<div class="modal fade" id="follow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">การขอขยายระยะเวลา</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input  type="hidden" id="follow_sugges_id">
                <!--<div id="follow_text" >...</div><br>-->
                เหตุผลการขอขยายระยะเวลา :

                <div id="editor_follow"></div><br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="usr">วันที่ขยายเวลา :</label>
                            <input  type="text"  class="datepicker form-control" placeholder="วันที่ขยายเวลา" data-date-format="mm/dd/yyyy" name="follow_date" id="follow_date" onkeypress="return false" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="follow()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal แก้การติดตาม -->
<div class="modal fade" id="edit_follow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แก้การขอขยายระยะเวลา</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input  type="hidden" id="edit_follow_sugges_id">
                <!--<div id="follow_text_edit">...</div><br>-->
                เหตุผลการขอขยายระยะเวลา :
                <div id="editor_edit_follow"></div><br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="usr">วันที่ขยายเวลา :</label>
                            <input  type="text"  class="datepicker form-control" placeholder="วันที่ขยายเวลา" data-date-format="mm/dd/yyyy" name="edit_follow_date" id="edit_follow_date" onkeypress="return false" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="follow_edit()">Save changes</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal แก้ไขประเด็น -->
<div class="modal fade" id="editsubject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แก้ไขประเด็น</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input  name="subject_id_edit" id="subject_id_edit" value="" type="hidden"/>
                <div id="editor_edit"></div>
                <br>
                <?php
                if (strpos($project_name, 'บริหารสถานี') != TRUE) {
                    $selected0 = "";
                    $selected1 = "";
                    $selected2 = "";
                    $selected3 = "";
                    $selected4 = "";

                    if ($array_subject[0]["subject_priority"] == 0) {
                        $selected0 = "selected";
                    } else if ($array_subject[0]["subject_priority"] == 1) {
                        $selected1 = "selected";
                    } else if ($array_subject[0]["subject_priority"] == 2) {
                        $selected2 = "selected";
                    } else if ($array_subject[0]["subject_priority"] == 3) {
                        $selected3 = "selected";
                    } else if ($array_subject[0]["subject_priority"] == 4) {
                        $selected4 = "selected";
                    }

                    $check_o = "";
                    $check_f = "";
                    $check_c = "";
                    $check_it = "";

                    $array_json_subject_priority_type = json_decode($array_subject[0]["subject_priority_type"]);

                    if ($array_json_subject_priority_type != null) {
                        if ($array_json_subject_priority_type[0] == "O") {
                            $check_o = "checked";
                        }
                        if ($array_json_subject_priority_type[1] == "F") {
                            $check_f = "checked";
                        }
                        if ($array_json_subject_priority_type[2] == "C") {
                            $check_c = "checked";
                        }
                        if ($array_json_subject_priority_type[3] == "IT") {
                            $check_it = "checked";
                        }
                    }
                    ?>
                    <div class="form-group form-group-default">
                        <label>ระดับความสำคัญของผลการตรวจสอบ</label>
                        <select class="form-control" id="Select_center_edit" style="color: black;">
                            <option value="0" <?php echo $selected0 ?>>-- โปรดเลือก ระดับความสำคัญของผลการตรวจสอบ  --</option>
                            <option value="1" <?php echo $selected1 ?>>ต่ำ</option>
                            <option value="2" <?php echo $selected2 ?>>กลาง</option>
                            <option value="3" <?php echo $selected3 ?>>สูง</option>
                            <option value="4" <?php echo $selected4 ?>>-- ไม่มีข้อเสนอแนะ  --</option>
                        </select>
                    </div>
                    <div class="form-group form-group-default">
                        <label>ประเภทข้อตรวจพบ</label>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="O" id="check_o_edit" <?php echo $check_o ?>>
                                        <span class="form-check-sign">&nbsp; &nbsp;  O </span>
                                    </label>
                                </div>                               
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="F" id="check_f_edit" <?php echo $check_f ?>>
                                        <span class="form-check-sign">&nbsp; &nbsp;  F </span>
                                    </label>
                                </div>                               
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="C" id="check_c_edit" <?php echo $check_c ?>>
                                        <span class="form-check-sign">&nbsp; &nbsp;  C </span>
                                    </label>
                                </div>                               
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="IT" id="check_it_edit" <?php echo $check_it ?>>
                                        <span class="form-check-sign">&nbsp; &nbsp;  IT</span>
                                    </label>
                                </div>                              
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="form-group form-group-default">
                        <label>หัวข้อประเด็น</label>
                        <select class="form-control" id="Select_station_edit" style="color: black;">
                            <option value="0">-- โปรดเลือก หัวข้อประเด็นการตรวจสอบสถานี --</option>
                            <?php
                            foreach ($type_station as $key => $value) {
                                if ($value["type_subject_value"] == $array_subject[0]["subject_priority_station"]) {
                                    $selected = 'selected';
                                } else if ($value["type_subject_value"] != $array_subject[0]["subject_priority_station"]) {
                                    $selected = '';
                                }
                                ?>
                                <option value="<?php echo $value["type_subject_value"] ?>" <?php echo $selected ?>><?php echo $value["type_subject_name"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php }
                ?>
                <!--                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="no_sugges" >
                                        <span class="form-check-sign">&nbsp; &nbsp;  IT</span>
                                    </label>
                                </div>  -->
                <br>
                <div class="form-group">
                    <label for="usr">มติที่ประชุมจากการปิดตรวจ</label>
                    <div class="col">
                        <div class="custom-control-lg custom-control custom-checkbox" style="top: 0.5rem;">
                            <input class="custom-control-input" id="checkbox-large-no_sugges_edit" type="checkbox"  name="no_sugges_edit" value="no_sugges"/>
                            <label class="custom-control-label" for="checkbox-large-no_sugges_edit">
                                ไม่มีมติที่ประชุมจากการปิดตรวจ
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="edit()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal เพิ่มมติที่ประชุม -->
<div class="modal fade" id="addsugges" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มมติที่ประชุม</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input  name="subject_id" id="subject_id" value="" type="hidden"/>
                <div id="editor_addsugges"></div>
                <br>
                <div class="form-group">
                    <label for="usr">ผู้รับผิดชอบ :</label>
                    <input type="text" class="form-control" id="respon" >
                    <div style="color: gray">* กรณีผู้รับผิดชอบหลายคนให้ เว้นวรรค</div>
                </div>
                <!--                <div class="form-group">
                                    <label for="usr">เลขที่หนังสือ :</label>
                                    <input type="text" class="form-control" id="suggestion_docnumber_insert" >
                                    <div style="color: gray">* กรณีเลขที่หนังสือมากกว่า 1 ให้เว้นวรรค</div>
                                </div>-->
                <div class="row">
                    <!--                    <div class="col-6">
                                            <div class="form-group">
                                                <label for="usr">วันที่ส่งรายงาน :</label>
                                                <input  type="text"  class="datepicker form-control" placeholder="วันที่" data-date-format="mm/dd/yyyy" name="startdate" id="startdate"  required="" onkeypress="return false" autocomplete="off">
                                            </div>
                                        </div>-->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="usr">วันที่แล้วเสร็จ :</label>
                            <input  type="text"  class="datepicker form-control" placeholder="วันที่" data-date-format="mm/dd/yyyy" name="duedate" id="duedate"  required="" onkeypress="return false" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">

                            <label for="usr">ไม่สามารถกำหนดวันที่แล้วเสร็จได้ :</label>
                            <div class="custom-control-lg custom-control custom-checkbox" style="top: 0.5rem;">
                                <input class="custom-control-input" id="checkbox-large" type="checkbox"  name="checkbox_sugges" onclick="checkbox('')"/>
                                <label class="custom-control-label" for="checkbox-large">
                                    ไม่สามารถกำหนดวันที่แล้วเสร็จได้
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addsugges()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal แก้ไขมติที่ประชุม -->
<div class="modal fade" id="editsugges" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แก้ไขมติที่ประชุม</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input  name="sugges_id" id="sugges_id" value="" type="hidden"/>
                <input  name="suggestion_status_follow" id="suggestion_status_follow" value="" type="hidden"/>
                <div id="editor_editsugges"></div>
                <br>
                <div class="form-group">
                    <label for="usr">ผู้รับผิดชอบ:</label>
                    <input type="text" class="form-control" id="respon_edit" >
                    <div style="color: gray">* กรณีผู้รับผิดชอบหลายคนให้ เว้นวรรค</div>
                </div>
                <!--                <div class="form-group">
                                    <label for="usr">เลขที่หนังสือ :</label>
                                    <input type="text" class="form-control" id="suggestion_docnumber_edit" >
                                    <div style="color: gray">* กรณีเลขที่หนังสือมากกว่า 1 ให้เว้นวรรค</div>
                                </div>-->
                <div class="row">
                    <!--                    <div class="col-6">
                                            <div class="form-group">
                                                <label for="usr">วันที่ส่งรายงาน :</label>
                                                <input  type="text"  class="datepicker form-control" placeholder="วันที่ส่งรายงาน" data-date-format="mm/dd/yyyy" name="edit_startdate" id="edit_startdate"  onkeypress="return false" autocomplete="off">
                                            </div>
                                        </div>-->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="usr">วันที่แล้วเสร็จ :</label>
                            <input  type="text"  class="datepicker form-control" placeholder="วันที่เริ่มดำเนิการ" data-date-format="mm/dd/yyyy" name="edit_duedate" id="edit_duedate"  onkeypress="return false" autocomplete="off">
                        </div>
                    </div>



                    <div class="col-6">
                        <div class="form-group">
                            <label for="usr">ไม่สามารถกำหนดวันที่แล้วเสร็จได้ :</label>
                            <div class="custom-control-lg custom-control custom-checkbox" style="top: 0.5rem;">
                                <input class="custom-control-input" id="checkbox-large1" type="checkbox"  name="checkbox_sugges_edit" onclick="checkbox('')"/>
                                <label class="custom-control-label" for="checkbox-large1">
                                    ไม่สามารถกำหนดวันที่แล้วเสร็จได้
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editsugges()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal เพิ่มผลการติดตาม -->
<div class="modal fade" id="add_anwser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">เพิ่มผลการปฏิบัติตามข้อเสนอแนะ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container">
                    <div class="row">
                        <div class="col-6 float-left">
                            <label for="usr" class="font-weight-bold">ประเด็น</label>
                            <div ><p id="text_subject" style=" width:100%;
                                     word-wrap: break-word;"></p></div>
                            <label for="usr" class="font-weight-bold">มติที่ประชุม</label>
                            <div ><p id="text_sugges" style=" width:100%;
                                     word-wrap: break-word;"></p></div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="usr" class="font-weight-bold">ผลการปฏิบัติตามข้อเสนอแนะ</label>
                                <!--<div id="sugges_name_add_anwser"></div>-->
                                <div id="editor_add_anwser"></div>
                                <br>
                                <div class="row">
                                    <!--                                    <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="usr">เลขที่หนังสือ :</label>
                                                                                <input  type="text"  class="form-control" placeholder="เลขที่หนังสือ" name="anwser_number_docnumber" id="anwser_number_docnumber" autocomplete="off">
                                                                                <div style="color: gray">* กรณีเลขที่หนังสือมากกว่า 1 ให้เว้นวรรค</div>
                                                                            </div>
                                    
                                                                        </div>-->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="usr">เลขที่หนังสือตอบกลับ :</label>
                                            <input  type="text"  class="form-control" placeholder="เลขที่หนังสือ" name="anwser_docnumber" id="anwser_docnumber" autocomplete="off">
                                            <div style="color: gray">* กรณีเลขที่หนังสือหน่วยรับตรวจมากกว่า 1 ให้เว้นวรรค</div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="usr">วันที่รับรายงานตอบกลับ :</label>
                                            <input  type="text"  class="datepicker form-control" placeholder="วันที่รับรายงานตอบกลับ" data-date-format="mm/dd/yyyy" name="anwser_respone_date" id="anwser_respone_date"  onkeypress="return false" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input  name="sugges_id_add_anwser" id="sugges_id_add_anwser" value="" type="hidden"/>
                        </div>
                    </div>
                </div>





            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="add_anwser()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal แก้ไขผลการติดตาม -->
<div class="modal fade" id="edit_anwser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">แก้ไขผลการปฏิบัติตามข้อเสนอแนะ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container">
                    <div class="row">
                        <div class="col-6 float-left">
                            <label for="usr" class="font-weight-bold">ประเด็น</label>
                            <div ><p id="text_subject_edit" style=" width:100%;
                                     word-wrap: break-word;"></p></div>
                            <label for="usr" class="font-weight-bold">มติที่ประชุม</label>
                            <div ><p id="text_sugges_edit" style=" width:100%;
                                     word-wrap: break-word;"></p></div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="usr" class="font-weight-bold">ผลการปฏิบัติตามข้อเสนอแนะ</label>
                                <div id="editor_edit_anwser"></div>
                                <br>
                                <div class="row">
                                    <!--                                    <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="usr">เลขที่หนังสือ :</label>
                                                                                <input  type="text"  class="form-control" placeholder="เลขที่หนังสือ" name="anwser_number_docnumber_edit" id="anwser_number_docnumber_edit" autocomplete="off">
                                                                                <div style="color: gray">* กรณีเลขที่หนังสือมากกว่า 1 ให้เว้นวรรค</div>
                                                                            </div>
                                                                        </div>-->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="usr">เลขที่หนังสือตอบกลับ :</label>
                                            <input  type="text"  class="form-control" placeholder="เลขที่หนังสือ" name="anwser_docnumber_edit" id="anwser_docnumber_edit" autocomplete="off">
                                            <div style="color: gray">* กรณีเลขที่หนังสือหน่วยรับตรวจมากกว่า 1 ให้เว้นวรรค</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="usr">วันที่รับรายงานตอบกลับ :</label>
                                            <input  type="text"  class="datepicker form-control" placeholder="วันที่รับรายงานตอบกลับ" data-date-format="mm/dd/yyyy" name="anwser_respone_date_edit" id="anwser_respone_date_edit"  onkeypress="return false" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input  name="id_edit_anwser" id="id_edit_anwser" value="" type="hidden"/>
                        </div>
                    </div>


                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="edit_anwser()">Save changes</button>
            </div>
        </div>
    </div>
</div>



<!-- Modalลบการคติดตาม -->
<div class="modal fade" id="deletefollow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                    
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color: black">ลบข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="follow_id_del" id="follow_id_del" value=""/>
                <div id="follow_name_del"></div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="del_follow()">ต้องการลบ</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="add_condition" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มเงื่อนไข</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input  name="subject_id" id="subject_id_condition" value="" type="hidden"/>
                <input  name="sugges_id" id="sugges_id_condition" value="" type="hidden"/>
                <input  name="status_id" id="status_id_codition" value="" type="hidden"/>
                <input  name="status" id="status_condition" value="" type="hidden"/>                


                <div id="editor_addcondition"></div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="add_condition()">Save changes</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal แก้ไขติดเงื่อนไข -->
<div class="modal fade" id="edit_condition" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">แก้ไขเงื่อนไข</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--<input   id="subject_id_condition_edit" value="" type=""/>-->
                <!--<input  id="sugges_id_condition_edit" value="" type=""/>-->
                <!--<input   id="status_id_codition_edit" value="" type=""/>-->
                <input  id="condition_id" value="" type=""/>                


                <div id="editor_editcondition"></div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="edit_condition()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modalลบการคติดตาม -->
<div class="modal fade" id="delete_condition" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                    
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color: black">ลบเงื่อนไข</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="condition_id_del" value=""/>
                <div id="condition_name_del"></div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="delete_condition()">ต้องการลบ</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
<script>

    $(".open-modal_edit_condition").click(function () {
        var id = $(this).data('id');
        $("#condition_id").val(id)
        var condition_text = $(this).data('condition_text');
        var delta = quill_editcondition.clipboard.convert(condition_text);
        quill_editcondition.setContents(delta, 'silent');
    });

    $(".open-modal_delete_condition").click(function () {
        var id = $(this).data('id');
        $("#condition_id_del").val(id)
        var condition_text = $(this).data('condition_text');
        var delta = quill_editcondition.clipboard.convert(condition_text);
        console.log(condition_text);
        var text = "<div style='font-weight: bold'>ต้องการลบเงื่อนไข : </div> " + condition_text + " <br><div style='font-weight: bold'>หรือไม่ ?</div>";

        $("#condition_name_del").html(text)
//        quill_editcondition.setContents(delta, 'silent');
    });


    function edit_condition() {
        var id = $("#condition_id").val()
        if (quill_editcondition.getText().trim().length === 0) {
            quill_editcondition.focus();
            return false;
        } else {
            var editor_quill_addcondition = quill_editcondition.root.innerHTML;
            $.ajax({
                url: "<?php echo base_url() ?>Status/update_condition",
                type: "POST",
                datatype: "json",
                data: {
                    "condition_id": id,
                    "condition_text": editor_quill_addcondition
                },
                success: (function (result) {
                    location.reload();
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        }
    }
    
        function delete_condition() {
        var id = $("#condition_id_del").val()
   
            $.ajax({
                url: "<?php echo base_url() ?>Status/delete_condition",
                type: "POST",
                datatype: "json",
                data: {
                    "condition_id": id,
   
                },
                success: (function (result) {
                    location.reload();
                }),
                error: function (xhr) {
                    console(xhr.statusText);
                }
            });
        
    }
</script>