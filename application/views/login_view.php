<!DOCTYPE html>
<html lang="en">

<head>
    <title>ระบบศูนย์ข้อมูลแนวการตรวจสอบ (Audit Program)</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/Login_v1/images/icons/favicon.ico') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Login_v1/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Login_v1/vendor/animate/animate.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Login_v1/vendor/css-hamburgers/hamburgers.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Login_v1/vendor/select2/select2.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Login_v1/css/util.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Login_v1/css/main.css') ?>">
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="<?php echo base_url('assets/logo/newlogo.png') ?>" alt="IMG">
                </div>
                <form class="login100-form validate-form" action="<?= base_url('login/login_process') ?>" id="myForm">
                    <span class="login100-form-title">
                        <h4>
                            เข้าสู่ระบบ
                        </h4>
                         <h4>
                                ระบบแจ้งเตือนการติดตามผลการปฏิบัติตามข้อเสนอแนะ
                            </h4>   
                            <br>
                            <h6>Member Login</h6>
                    </span>
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="username" placeholder="รหัสพนักงาน" id="username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="รหัสผ่าน" id="password" autocomplete="false">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            Login
                        </button>
                    </div>
                    <!--<div class="text-center p-t-12">
                        <span class="txt1">
                        Forgot
                        </span>
                        <a class="txt2" href="#">
                        Username / Password?
                        </a>
                        </div>-->
                    <div class="text-center p-t-136">
                        <!--<a class="txt2" href="#">-->
                        <!--Create your Account-->
                        <!--<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>-->
                        <!--</a>-->
                    </div>
                </form>
            </div>
        </div>
        <?php
        $this->load->view('Template/modal');
        ?>
    </div>

    <?php
    $this->load->view('Template/js');
    ?>


    <script>
        $(document).ready(function() {
            // Function to handle form submission
            $('#myForm').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Get the form data
                var formData = $(this).serialize();
                var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

                var username = $("#username").val()
                var password = $("#password").val()

                // Perform Ajax post request
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('login/login_process')  ?>', // Replace with your server-side endpoint
                    data: {
                        'username': username,
                        'password': password,
                        [csrfName]: csrfHash
                    },
                    success: function(response) {
                        // Handle the server response (success)
                        var btn_close = $("#myModal_login").find('.modal-footer')
                        btn_close.find('.btn').addClass("btn btn-secondary")
                        console.log('Server response:', response);
					
                        if (response == "success") {
                            $('#myModal_login').modal('show')
                            $("#myModal_login").find('.modal-body').addClass('text-center')
                            $("#myModal_login").find('.modal-body').text("เข้าสู่ระบบสำเร็จ")

                            var counter = 0;
                            var interval = setInterval(function() {
                                counter++;
                                // Display 'counter' wherever you want to display it.
                                if (counter == 1) {
                                    // Display a login box
                                    $("#myModal_login").modal("hide");
                                    clearInterval(interval);
                                    window.location = '<?php echo base_url("") ?>';
                                }
                            }, 1000);
                        } else {
                            $('#myModal_login').modal('show')
                            $("#myModal_login").find('.modal-body').addClass('text-center')
                            $("#myModal_login").find('.modal-body').text("เข้าสู่ระบบไม่สำเร็จ")
                            var btn_close = $("#myModal_login").find('.modal-footer')
                            btn_close.find('.btn').addClass("btn btn-danger")
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error('Error:', error);
                        $('#myModal_login').modal('show')
                        $("#myModal_login").find('.modal-body').addClass('text-center')
                        $("#myModal_login").find('.modal-body').text("เข้าสู่ระบบไม่สำเร็จ")
                        var btn_close = $("#myModal_login").find('.modal-footer')
                        btn_close.find('.btn').addClass("btn btn-danger")
                    }
                });
            });
        });
    </script>

</body>

</html>