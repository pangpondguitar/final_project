<html>

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
    </style>

</head>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('/assets/my-fonts/Sarabun-ExtraLight.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('/assets/my-fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('/assets/my-fonts/Sarabun-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('/assets/my-fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('/assets/my-fonts/Sarabun-BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
            font-size: 15px !important;
        }

        .fs {
            font-size: 15px;
        }

        h6 {
            padding: 0px, 0px, 0px, 0px;
            margin: 0px, 0px, 0px, 0px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .page_break {
            page-break-before: always;
        }

        .page2 {
            size: A4 landscape;
        }
    </style>
</head>

<body>
    <div class="App container mt-5">
        <img src="/assets/img/logo-sru.jpg" alt="" style="width:50px">
        <div id="title" class="text-center">
            <label for="" class="text-center">มคอ.3</label>
            <label for="" class="text-center">แผนการสอนของรายวิชา</label>
            <label for="" class="text-center">ภาคเรียนที่ 2 ปีการศึกษา 2556</label>
        </div>
        @foreach($subject as $item)
        <div id="divToPrint" class="font-sb">
            <table class="h1 mt-5 border border-dark table ">
                <tbody>
                    <tr>
                        <td>
                            <label class="fs"> ชื่อสถาบันอุดมศึกษา มหาวิทยาลัยราชภัฏสุราษฎร์ธานี</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for=""> คณะ/สาขา/วิชาเอก วิทยาศาสตร์และเทคโนโลยี สาขาวิทการคอมพิวเตอร์</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label> 1. รหัสวิชาและชื่อรายวิชา</label>
                            <div class="d-flex align-items-start ">
                                <div class="me-4">
                                    <label for="">รหัสวิชา {{$item->subjects->s_num}} </label>
                                </div>
                                <div>
                                    <label class="fw-normal">ชื่อวิชา (ไทย) {{$item->subjects->s_name}}</label><br>
                                    <label class="fw-normal">ชื่อวิชา (อังกฤษ) {{$item->subjects->s_name2}}</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>2. จำนวนหน่วยกิต</label>
                            <label class="fw-normal">{{$item->subjects->s_credit}}</label><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>3. ชื่อหลักสูตรและประเภทของรายวิชา</label><br>
                            <label class="fw-normal">Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                Eligendi
                                itaque laborum iure cupiditate quas quasi, dolorum quo sequi modi quaerat commodi
                                fugiat,
                                <br>
                                sit optio excepturi animi dicta et distinctio sapiente!</label><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>4. คำอธิบายรายวิชา</label>
                            <label for="">ภาษาไทย</label><br>
                            <label class="fw-normal">Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                Eligendi
                                itaque laborum iure cupiditate quas quasi, dolorum quo sequi modi quaerat commodi
                                fugiat,<br>
                                sit optio excepturi animi dicta et distinctio sapiente!</label><br>
                            <label for=""> ภาษาอังกฤษ</label><br>
                            <label class="fw-normal">Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                Eligendi
                                itaque laborum iure cupiditate quas quasi, dolorum quo sequi modi quaerat commodi
                                fugiat,
                                sit optio excepturi animi dicta et distinctio sapiente!</label><br>

                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        @endforeach
    </div>
</body>

</html>