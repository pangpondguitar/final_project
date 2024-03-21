<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <title>
        Soft UI Dashboard by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&family=Sarabun&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src='build/pdfmake.min.js'></script>
    <script src='build/vfs_fonts.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <script src="../node_modules/@ckeditor/ckeditor5-vue/dist/ckeditor.js"></script>

    @vite('resources/js/app.js')
    <style>
        body {
            font-family: 'Kanit', sans-serif !important;
        }

        .card .card-body {
            font-family: 'Kanit', sans-serif !important;
        }

        .font-sb {
            font-family: "Sarabun", sans-serif;
        }

        .swal2-popup {
            display: none;
            position: relative;
            box-sizing: border-box;
            flex-direction: column;
            justify-content: center;
            width: 32em;
            max-width: 100%;
            padding: 1.25em;
            border: none;
            border-radius: 5px;
            background: #ffffff;
            font-family: inherit;
            font-size: 1rem;
        }

        .swal2-styled:focus {
            outline: none;
            box-shadow: none;
        }

        .swal2-title {
            position: relative;
            max-width: 100%;
            margin: 0 0 0.4em;
            padding: 0;
            color: #4a4a4a;
            font-size: 1.875em;
            font-weight: 600;
            text-align: center;
            text-transform: none;
            word-wrap: break-word;
        }

        .swal2-container.swal2-backdrop-show,
        .swal2-container.swal2-noanimation {
            background: rgb(25 25 26 / 48%);
        }

        .swal2-html-container {
            text-align: center;
        }

        body {
            overflow-y: hidden;
            /* ซ่อน scrollbar ด้านขวา (แนวตั้ง) */
            overflow-x: hidden;
            /* ซ่อน scrollbar ด้านล่าง (แนวนอน) */
        }

        .menu_course_active {
            background-image: linear-gradient(310deg, #141727 0%, #3A416F 100%);
        }

        .menu_course_active .title {
            color: #fff;
        }

        .badge-success {
            color: #67b108;
            background-color: #cdf59b;
        }

        .badge-secondary {
            color: #5974a2;
            background-color: #e4e8ed;
        }

        .badge-info {
            color: #08a1c4;
            background-color: #abe9f7;
        }

        .badge-danger {
            color: #bd0000;
            background-color: #fc9797;
        }

        .badge-warning {
            color: #fbc400;
            background-color: #fef5d3;
        }

        .badge-dark {
            color: #1e2e4a;
            background-color: #8097bf;
        }
    </style>
</head>

<body class="">
    <div id="ofBar" style="display:none">
        <div id="ofBar-logo"> <img alt="creative-tim-logo" src="https://s3.amazonaws.com/creativetim_bucket/static-assets/logo-ct-black.png"></div>
        <div id="ofBar-content"><b>50% off Creative Tim Club!</b> 🎉 Lifetime access to all current &amp; future products. Limited time offer! ✨</div>
        <div id="ofBar-right"><a href="https://www.creative-tim.com/club?ref=ct-demos" target="_blank" id="btn-bar">View Offer</a><a id="close-bar">×</a></div>
    </div>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>


    <main class="main-content mt-0 ps">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-bolder text-info text-gradient">ระบบจัดการหลักสูตร <br>คณะวิทยาศาสตร์และเทคโนโลยี</h3>
                                    <p class="mb-0 text-sm">ระบบจัดการหลักสูตรคณะวิทยาศาสตร์และเทคโนโลยี</p>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <label>Username</label>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" name="username" :value="old('email')" required autofocus autocomplete="username">
                                        </div>
                                        <label>Password</label>
                                        <div class="mb-3">
                                            <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon" name="password" required autocomplete="current-password">
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-info w-100 mt-3 mb-0  text-sm fw-normal">เข้าสู่ระบบ</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Don't have an account?
                                        <a href="javascript:;" class="text-info text-gradient font-weight-bold">Admin</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('/assets/img/pic_login.jpg')"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
        </div>
    </main>



    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script async="" defer="" src="https://buttons.github.io/buttons.js"></script>

    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
    <script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon="{&quot;rayId&quot;:&quot;867cf010994f7dc6&quot;,&quot;version&quot;:&quot;2024.3.0&quot;,&quot;token&quot;:&quot;1b7cbb72744b40c580f8633c6b62637e&quot;}" crossorigin="anonymous"></script>


    <style>
        #ofBar {
            background: #fff;
            z-index: 999999999;
            font-size: 16px;
            color: #333;
            padding: 16px 40px;
            font-weight: 400;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 40px;
            width: 80%;
            border-radius: 8px;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 13px 27px -5px rgba(50, 50, 93, 0.25), 0 8px 16px -8px rgba(0, 0, 0, 0.3), 0 -6px 16px -6px rgba(0, 0, 0, 0.025);
        }

        #ofBar-logo img {
            height: 50px;
        }

        #ofBar-content {
            display: inline;
            padding: 0 15px;
        }

        #ofBar-right {
            display: flex;
            align-items: center;
        }

        #ofBar b {
            font-size: 15px !important;
        }

        #count-down {
            display: initial;
            padding-left: 10px;
            font-weight: bold;
            font-size: 20px;
        }

        #close-bar {
            font-size: 17px;
            opacity: 0.5;
            cursor: pointer;
            color: #808080;
            font-weight: bold;
        }

        #close-bar:hover {
            opacity: 1;
        }

        #btn-bar {
            background-image: linear-gradient(310deg, #141727 0%, #3A416F 100%);
            color: #fff;
            border-radius: 4px;
            padding: 10px 20px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            font-size: 12px;
            opacity: .95;
            margin-right: 20px;
            box-shadow: 0 5px 10px -3px rgba(0, 0, 0, .23), 0 6px 10px -5px rgba(0, 0, 0, .25);
        }

        #btn-bar,
        #btn-bar:hover,
        #btn-bar:focus,
        #btn-bar:active {
            text-decoration: none !important;
            color: #fff !important;
        }

        #btn-bar:hover {
            opacity: 1;
        }

        #btn-bar span,
        #ofBar-content span {
            color: red;
            font-weight: 700;
        }

        #oldPriceBar {
            text-decoration: line-through;
            font-size: 16px;
            color: #fff;
            font-weight: 400;
            top: 2px;
            position: relative;
        }

        #newPrice {
            color: #fff;
            font-size: 19px;
            font-weight: 700;
            top: 2px;
            position: relative;
            margin-left: 7px;
        }

        #fromText {
            font-size: 15px;
            color: #fff;
            font-weight: 400;
            margin-right: 3px;
            top: 0px;
            position: relative;
        }

        #pls-contact-me-on-email {
            position: absolute;
            color: white;
            width: 100%;
            height: 100%;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 999;
            cursor: pointer;
            padding-top: 100px;
            padding-left: 50px;
        }

        @media(max-width: 991px) {}

        @media (max-width: 768px) {
            #count-down {
                display: block;
                margin-top: 15px;
            }

            #ofBar {
                flex-direction: column;
                align-items: normal;
            }

            #ofBar-content {
                margin: 15px 0;
                text-align: center;
                font-size: 18px;
            }

            #ofBar-right {
                justify-content: flex-end;
            }
        }
    </style>


</body>
<script>
    function Delete(elem) {
        Swal.fire({
            title: 'ยืนยันรายการ?',
            text: "ยืนยันรายการอีกครั้ง!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aeaeae',
            confirmButtonText: 'ยืนยันรายการ!',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {
                let target = elem.getAttribute('data-target')
                location.href = target
            }
        });
    }
</script>

</html>