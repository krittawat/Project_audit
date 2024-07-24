
<script>
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
                    var page = value["value2"].row - 1
                    noti(value["value2"].project_id, value["project_name"].project_name, value["value2"].suggestion_name, page)

                });



            }),
            error: function (xhr) {
                console(xhr.statusText);
            }
        });
    });

    function noti(project_id, project_name, text, page) {


        $.notify({
// options
            icon: 'glyphicon glyphicon-warning-sign',
            title: '<div style="color:red">แจ้งเตือน สาย 2 </div>',
            message: '<div style="color:red" class="max-lines">โครงการ ' + project_name + '</div>มติที่ประชุม<div class="max-lines">' + text + '</div>',
            url: '<?= base_url("index.php/Home/project_detail/") ?>' + project_id + '?per_page=' + page,
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