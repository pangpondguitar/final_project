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
            src: url("{{ public_path('/assets/my-fonts2/Sarabun-ExtraLight.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('/assets/my-fonts2/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('/assets/my-fonts2/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('/assets/my-fonts2/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('/assets/my-fonts2/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
            font-size: 20px !important;
            margin-left: 40px;
            margin-right: 40px;
            margin-top: 10px;
        }

        .fs-20 {
            font-size: 22px !important;
        }

        .fs-18 {
            font-size: 20px !important;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .border-none {
            border: none !important;
        }

        .page_break {
            page-break-before: always;
        }

        .page2 {
            size: A4 landscape;
        }

        #main {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .d-flex {
            display: flex;
            justify-content: center;
            flex-wrap: nowrap;
        }

        .p-0 {
            padding-top: 0;
            padding-bottom: 0;
        }

        .m-0 {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .ms-10 {
            margin-left: 10px;
        }

        .ms-25 {
            margin-left: 25px;
        }

        div.title2 {
            text-indent: 10px;
        }

        div.b {
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <div class="App container mt-5">

        <div id="main">
            <img src="data:image/jpeg;base64,{{ $base64Image }}" alt="Your Image" style="width: 120px;" class="text-center">
        </div>
        @if($subject->subjects->doc_type == 1)
        <h6 for="" class="fs-20 p-0 m-0 text-center">มคอ.3</h6>
        @else
        <h6 for="" class="fs-20 p-0 m-0 text-center">มคอ.4</h6>
        @endif
        <h6 class="fs-20 p-0 m-0 text-center">แผนการสอนของรายวิชา</h6>
        <h6 class="fs-20 p-0 m-0 text-center">{{$subject->subjects->s_num}} {{$subject->subjects->s_name}}</h6>
        <h6 class="fs-20 p-0 m-0 text-center " style="margin-bottom: 25px;">ภาคเรียนที่ {{$subject->terms->t_name}} ปีการศึกษา {{$subject->terms->t_year}}</h6>
        <div id="divToPrint" class="font-sb">
            <table class="h1 mt-5 border border-dark table ">
                <tbody>
                    <tr>
                        <td>
                            <h6 class="fs-18 ms-10 m-0 p-0"> ชื่อสถาบันอุดมศึกษา มหาวิทยาลัยราชภัฏสุราษฎร์ธานี
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6 class="fs-18 ms-10 m-0 p-0"> คณะ/สาขา/วิชาเอก วิทยาศาสตร์และเทคโนโลยี สาขาวิทการคอมพิวเตอร์
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td>

                            <span class="fs-18 ms-10 m-0 p-0" style="font-weight: bold;"> 1. รหัสวิชาและชื่อรายวิชา</span>
                            <table class="border-none">
                                <tbody class="border-none">
                                    <tr class="border-none">
                                        <td class="border-none" style="width: 20%;">
                                            <label for="" class="ms-25">รหัสวิชา {{$subject->subjects->s_num}} </label>
                                        </td>
                                        <td class="border-none ms-25">
                                            <div class="ms-25">
                                                <label class="fw-normal ">ชื่อวิชา (ไทย) {{$subject->subjects->s_name}}</label><br>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none"></td>
                                        <td class="border-none ms-10">
                                            <div class="ms-25">

                                                <label class="fw-normal ">ชื่อวิชา (อังกฤษ) {{$subject->subjects->s_name2}}</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6 class="m-0 p-0 ms-10 fs-18">2. จำนวนหน่วยกิต</h6>
                            <label class="fw-normal ms-25" style="margin-left: 25px;">{{$subject->subjects->s_credit}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6 class="p-0 m-0 fs-18 ms-10">3. ชื่อหลักสูตรและประเภทของรายวิชา</h6>
                            <div class="ms-25">
                                <label> ชื่อหลักสูตร {{$subject->subjects->courses->c_name}}</label><br>
                                <label> ประเภทของรายวิชา
                                    
                             @if($subject->subjects->doc_type == 1)
                                กลุ่มวิชาเฉพาะด้านเลือก
                                @else
                                ฝึกประสบการณ์วิชาชีพหรือสหกิจศึกษา

                                @endif
                            </label>

                               


                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @foreach($subdes as $item)
                            <h6 class="p-0 m-0 fs-18  ms-10">4. คำอธิบายรายวิชา</h6>
                            <h6 for="" class="p-0 m-0 fs-18  ms-25">ภาษาไทย</h6>
                            <div class="ms-10">
                                <div class="b" style="width: 600px">
                                    <label for="" class="">{!! $item->sd_title !!}</label>
                                </div>
                            </div>
                            <h6 for="" class="p-0 m-0 fs-18  ms-25">ภาษาอังกฤษ</h6>
                            <div class="ms-10">
                                <div class="b" style="width: 600px">
                                    <label for="" class="">{!! $item->sd_title_eng !!}</label>

                                </div>
                            </div>

                            @endforeach
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
