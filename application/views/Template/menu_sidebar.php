<!--
        <a class="nav-link" href="<?= base_url("Home") ?>">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>รายการโครงการ</span>
        </a>
        <a class="nav-link" href="<?= base_url("Notification") ?>">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Notification</span>
        </a>-->



<?php
$active = "";
$active_follow = "";
$active_home = "";
$active_noti = "";
$active_permission = "";
$active_follow1 = "";
$active_follow2 = "";
$active_follow3 = "";
$active_follow4 = "";
$active_follow5 = "";




if ($controller->uri->segment(1) == "Notification" || $controller->uri->segment(1) == "notification") {
    $active_noti = "active";
} else if ($controller->uri->segment(1) == "follow" || $controller->uri->segment(1) == "Follow") {
    $active_follow = "active";
} else if ($controller->uri->segment(1) == "Home" || $controller->uri->segment(1) == "home") {
    $active_home = "active";
} else if ($controller->uri->segment(1) == "setpermission" || $controller->uri->segment(1) == "Setpermission") {
    $active_permission = "active";
}


if (isset($_GET["group"])) {
    if ($_GET["group"] == 1) {
        $active_follow1 = "active";
    } else if ($_GET["group"] == 2) {
        $active_follow2 = "active";
    } else if ($_GET["group"] == 3) {
        $active_follow3 = "active";
    } else if ($_GET["group"] == 4) {
        $active_follow4 = "active";
    } else if ($_GET["group"] == 5) {
        $active_follow5 = "active";
    }
}
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <br>
    <a href="<?= "http://" . $_SERVER['HTTP_HOST'] . "/project" ?>">
        <div class="text-center">
            <img src="<?= base_url("assets/logo/newlogo.png") ?>" class="rounded" alt="..." width="50%">
        </div>
    </a>

    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="<?= "http://" . $_SERVER['HTTP_HOST'] . "/project" ?>">

        <div class="sidebar-brand-text mx-3"><sup>สำนักตรวจสอบภายใน</sup></div>
    </a>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $active_home ?>">
        <a class="nav-link" href="<?= base_url("Home") ?>">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>รายการผลตรวจสอบ/โครงการ</span></a>
    </li>

    <li class="nav-item <?= $active_follow ?>">
        <a class="nav-link active" href="<?= base_url("Follow") ?> ">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>ระบบติดตาม</span>
        </a>

    </li>

    <li class="nav-item <?= $active_follow1 ?>" style="padding-left: 15px">
        <a class="nav-link" href="<?= base_url("Follow?group=1") ?>">
            <i class="fa fa-users"></i>
            <span>งานตรวจสอบสาย 1</span>
        </a>
    </li>
    <li class="nav-item <?= $active_follow2 ?>" style="padding-left: 15px">
        <a class="nav-link" href="<?= base_url("Follow?group=2") ?>">
            <i class="fa fa-users"></i>
            <span>งานตรวจสอบสาย 2</span>
        </a>
    </li>
    <li class="nav-item <?= $active_follow3 ?>" style="padding-left: 15px">
        <a class="nav-link" href="<?= base_url("Follow?group=3") ?>">
            <i class="fa fa-users"></i>
            <span>งานตรวจสอบสาย 3</span>
        </a>
    </li>
    <li class="nav-item <?= $active_follow4 ?>" style="padding-left: 15px">
        <a class="nav-link" href="<?= base_url("Follow?group=4") ?>">
            <i class="fa fa-users"></i>
            <span>งานตรวจสอบสาย 4</span>
        </a>
    </li>
    <li class="nav-item <?= $active_follow5 ?>" style="padding-left: 15px">
        <a class="nav-link" href="<?= base_url("Follow?group=5") ?>">
            <i class="fa fa-users"></i>
            <span>งานตรวจสอบสาย 5</span>
        </a>
    </li>


    <li class="nav-item <?= $active_noti ?>">
        <a class="nav-link" href="<?= base_url("Notification") ?>">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>ระบบแจ้งเตือน</span>
        </a>
    </li>
<?php

 $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

?>
   <li class="nav-item <?= $active_permission ?>">
        <a class="nav-link" href="<?= $link; ?>/userpermission">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>การจัดผู้ใช้งาน</span>
        </a>
    </li> 





    <!-- Nav Item - Tables -->
    <li class="nav-item" style="display: none">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <div id="txt" style="align-content: center;color: white; text-align: center"></div>

    <!-- Sidebar Toggler (Sidebar) -->
    <!--    <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>-->

</ul>


<script>
    function startTime() {
        var day = ["วันอาทิตย์ ", "วันจันทร์ ", "วันอังคาร ", "วันพุธ ", "วันพฤหัส ", "วันศุกร์ ", "วันเสาร์ "]
        var month = [" มกราคม ", " กุมภาพันธ์ ", " มีนาคม ", " เมษายน ", " พฤษภาคม ", " มิถุนายน ", " กรกฎาคม ", " สิงหาคม ", " กันยายน ", " ตุลาคม", " พฤศจิกายน ", " ธันวาคม "]
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();

        var d = today.getDay();

        m = checkTime(m);
        s = checkTime(s);
        //        console.log(today);
        document.getElementById('txt').innerHTML =
            day[d] + "ที่ " + today.getDate() + month[today.getMonth()] + (parseInt(today.getFullYear()) + 543) + "&nbsp;" + "<br>" + h + ":" + m;
        var t = setTimeout(startTime, 500);
    }
    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }
        ;  // add zero in front of numbers < 10
        return i;
    }
</script>