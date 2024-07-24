<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url() ?>assets/vendor/jquery/jquery.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url() ?>assets/vendor/jquery-easing/jquery.easing.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo base_url() ?>assets/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<!--<script src="<?php echo base_url() ?>assets/vendor/chart.js/Chart.js"></script>-->

<!-- Page level custom scripts -->
<!--<script src="<?php echo base_url() ?>assets/js/demo/chart-area-demo.js"></script>-->
<!--<script src="<?php echo base_url() ?>assets/js/demo/chart-pie-demo.js"></script>-->

<script type="text/javascript" src="<?= base_url() ?>assets/bootstrap-datepicker-master/dist/js/bootstrap-datepicker-custom.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/bootstrap-datepicker-master/js/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/summernote-master/dist/summernote-bs4.js") ?>"></script>

<script type="text/javascript" src="<?php echo base_url("assets/datatable/dataTables.js") ?>"></script>

<script type="text/javascript" src="<?php echo base_url("assets/datatable/DataTables/js/dataTables.bootstrap4.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/datatable/RowGroup/js/rowGroup.bootstrap4.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/datatable/Responsive/js/responsive.bootstrap4.js") ?>"></script>

<script src="<?= base_url() ?>assets/fileinput/js/plugins/piexif.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/fileinput/js/plugins/sortable.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/fileinput/js/fileinput.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/fileinput/js/locales/fr.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/fileinput/js/locales/es.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/fileinput/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/fileinput/themes/explorer-fas/theme.js" type="text/javascript"></script>

<script src="<?= base_url() ?>assets/quill.js" type="text/javascript"></script>

<script src="<?= base_url() ?>assets/js/bootstrap-notify.js" type="text/javascript"></script>


<!--<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(function () {
        OneSignal.init({
            appId: "6098e903-32a0-498c-9b07-706af43f2011",
            notifyButton: {
                enable: true,
            },
            allowLocalhostAsSecureOrigin: true,
        });
    });
</script>-->



<script>
    function checkPhoneKey() {
        return false;
    }


    $(function () {

        $.ajax({
            url: "<?php echo base_url() ?>notification/alert2",
            type: "POST",
            datatype: "json",
            data: {

            },
            success: (function (result) {

                var obj = JSON.parse(result);
                $.each(obj, function (index, value) {
                    noti("1", index, value);
                });
            }),
            error: function (xhr) {
                console(xhr.statusText);
            }
        });
    });

    function noti(project_id, project_name, suggestion_name) {
        var text = ""
        $.each(suggestion_name, function (index, value) {

            text += '<div>' + value.suggestion_name + '</div><br>';
        });
        console.log(text);
        $.notify({
            // options
            icon: 'glyphicon glyphicon-warning-sign',
            title: '<div style="color:red">แจ้งเตือน ที่ยังไม่ได้ดำเนินการติดตาม</div>',
            message: '<div style="color:red" class="max-lines">โครงการ ' + project_name + '<div>มติที่ประชุม</div>' + text + '</div>',
            url: '<?php echo base_url("Home/project_detail/") ?>' + project_id,
            target: '_blank'
        }, {
            // settings
            element: 'body',
            position: null,
            type: "info",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "bottom",
                align: "right"
            },
            offset: 10,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert" style="border: 2px solid black;">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
        });
    }
</script>