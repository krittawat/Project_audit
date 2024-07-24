<!-- Custom fonts for this template-->
<link href="<?php echo base_url("assets/vendor/fontawesome-free/css/all.css") ?>" rel="stylesheet" type="text/css">
<!--<link href="<?php echo base_url("assets/css/fontgoogle.css") ?>" rel="stylesheet">-->

<!-- Custom styles for this template-->
<link href="<?php echo base_url("assets/css/sb-admin-2.css") ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url("assets/summernote-master/dist/summernote-bs4.css") ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/datatable/DataTables/css/dataTables.bootstrap4.css") ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/datatable/RowGroup/css/rowGroup.bootstrap4.css") ?>">

<link rel="stylesheet" href="<?php echo base_url("assets/datatable/Responsive/css/responsive.bootstrap4.css") ?>">

<link href="<?= base_url() ?>assets/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.css" rel="stylesheet">

<link href="<?= base_url() ?>assets/fileinput/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>

<link href="<?= base_url() ?>assets/quill.snow.css" rel="stylesheet">


<style>
    body{   
        color: black   !important;
    }
    input{   
        color: black   !important;
    }
    .datepicker{
        color: black !important;
    } 


    #loader {
        width: 100%;
        height: 100%;
        top: 0px;
        left: 0px;
        position: fixed;
        display: block;
        opacity: 0.9;
        background-color: #fff;
        z-index: 10000000 !important;
        text-align: center;
    }

    .max-lines {
        display: block;/* or inline-block */
        text-overflow: ellipsis;
        word-wrap: break-word;
        overflow: hidden;
        max-height: 3.6em;
        line-height: 1.8em;
    }
    .x::after {
        content: "...";
        position: absolute;
    }
    #menu:hover {
        color: yellow;
    }

</style>