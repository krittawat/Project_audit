
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>SB Admin 2 - Dashboard</title>  
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
        <link href="./assets/fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
        <link href="./assets/fileinput/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="./assets/fileinput/js/plugins/piexif.js" type="text/javascript"></script>
        <script src="./assets/fileinput/js/plugins/sortable.js" type="text/javascript"></script>
        <script src="./assets/fileinput/js/fileinput.js" type="text/javascript"></script>
        <script src="./assets/fileinput/js/locales/fr.js" type="text/javascript"></script>
        <script src="./assets/fileinput/js/locales/es.js" type="text/javascript"></script>
        <script src="./assets/fileinput/themes/fas/theme.js" type="text/javascript"></script>
        <script src="./assets/fileinput/themes/explorer-fas/theme.js" type="text/javascript"></script>
    </head>


</head>

<body id="page-top">

    <!-- Page Wrapper -->

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-12">
                                <div class="file-loading">
                                    <input id="file-kv-pdf" name="file-kv-pdf[]" type="file" multiple>
                                </div>
                            </div>
                        </div>
     
    <script>
        $('#file-kv-pdf').fileinput({
            uploadUrl: "/upload",
            pdfRendererUrl: 'https://plugins.krajee.com/pdfjs/web/viewer.html',
            // overwriteInitial: false,
            initialPreviewAsData: true,
            browseIcon: '<i class="fa fa-folder-open"></i> ',
            initialPreview: [

            ],
            initialPreviewConfig: [
                {type: 'pdf', size: 3072}
            ]
        });
    </script>

</body>

</html>
