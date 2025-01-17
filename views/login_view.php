
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login ระบบแจ้งเตือนการติดตามผลการปฏิบัติตามข้อเสนอแนะ</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="<?php echo base_url('assets/Login_v1/images/icons/favicon.ico') ?>" />

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Login_v1/vendor/bootstrap/css/bootstrap.min.css') ?>">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Login_v1/fonts/font-awesome-4.7.0/css/font-awesome.min.css') ?>">

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
                    <!--                    <div class="login100-pic js-tilt" data-tilt>
                                            <img src="<?php echo base_url('assets/Login_v1/images/img-01.png') ?>" alt="IMG">
                                        </div>-->

                    <form class="login100-form validate-form" action="<?= base_url('login/login_process') ?>" method="POST">
                        <span class="login100-form-title">
                            <h4>
                                ระบบแจ้งเตือนการติดตามผลการปฏิบัติตามข้อเสนอแนะ
                            </h4>   
                            <br>
                            <h6>Member Login</h6>
                        </span>
                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" name="user" placeholder="รหัสพนักงาน">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" name="password" placeholder="รหัสผ่าน">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
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
        </div>

        <script src="<?php echo base_url('assets/Login_v1/vendor/jquery/jquery-3.2.1.min.js') ?>" type="838469935c7057bdda175706-text/javascript"></script>

        <script src="<?php echo base_url('assets/Login_v1/vendor/bootstrap/js/popper.js') ?>" type="838469935c7057bdda175706-text/javascript"></script>
        <script src="<?php echo base_url('assets/Login_v1/vendor/bootstrap/js/bootstrap.min.js') ?>" type="838469935c7057bdda175706-text/javascript"></script>

        <script src="<?php echo base_url('assets/Login_v1/vendor/select2/select2.min.js') ?>" type="838469935c7057bdda175706-text/javascript"></script>

        <script src="<?php echo base_url('assets/Login_v1/vendor/tilt/tilt.jquery.min.js') ?>" type="838469935c7057bdda175706-text/javascript"></script>
        <script type="838469935c7057bdda175706-text/javascript">
            $('.js-tilt').tilt({
            scale: 1.1
            })
        </script>

        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="838469935c7057bdda175706-text/javascript"></script>
        <script type="838469935c7057bdda175706-text/javascript">
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-23581568-13');
        </script>

        <script src="<?php echo base_url('assets/Login_v1/js/main.js') ?>" type="838469935c7057bdda175706-text/javascript"></script>
        <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="838469935c7057bdda175706-|49" defer=""></script></body>
</html>
