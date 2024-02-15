<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            font-size: 14px !important;
            margin-left: 35px;
            margin-right: 35px;
            margin-top: 10px;
        }

        .fs-14 {
            font-size: 14px !important;
            ;
        }

        table {
            align-items: center;

        }

        .table1 {
            margin-left: 20px;
        }

        .table2 {
            width: 100%;
        }




        table,
        tr,
        td {
            border-collapse: collapse;
            align-items: center;
            border: 1px solid black;
        }

        h6,
        label {
            margin: 0;
            padding: 0;
            font-size: 14px !important;
        }

        .topic {
            margin: 0;
            padding: 0;
            font-size: 14px !important;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
            /* vertical-align: top; */
            margin: 0;
            padding: 0;
        }


        label {
            line-height: 0;
        }

        .m-4 {
            margin-right: 15px !important;
        }



        div.title2 {
            white-space: pre-line;
            /* Preserve newlines */
        }

        div.title2::first-line {
            text-indent: 0;
            /* No indentation for the first line */
        }

        div.title2:not(:first-line) {
            text-indent: 30px;
            /* Indentation for lines other than the first */
        }
    </style>
</head>

<body>
    <div class="" id="result_sub">
        <h6 class="fs-14">6.แผนการสอน</h6>
        <table>
            <thead>
                <tr>
                    <td>
                        <h6>
                            สัปดาห์ที่<br>
                            (จํานวน<br>
                            ชั่วโมง)
                        </h6>
                    </td>
                    <td>
                        <h6>
                            ผลลัพธ์การเรียนรู้รายวิชา<br>
                            (CLOs)
                        </h6>
                    </td>
                    <td>
                        <h6> หัวข้อบรรยาย</h6>
                    </td>
                    <td>
                        <h6> วิธีการสอน</h6>
                    </td>
                    <td>
                        <h6> สื่อการสอน</h6>
                    </td>
                    <td>
                        <h6>
                            วิธีการและเครื่องมือ
                            ประเมินผลการสอน
                        </h6>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        1 <br>
                        (4)
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        1 <br>
                        (4)
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        1 <br>
                        (4)
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                    <td>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                        <div class="title2">
                            <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                        </div>
                    </td>
                </tr>

            </tbody>
            <tfoot>
                <td>
                    17
                </td>
                <td colspan="5">
                    <label for="">สอบปลายภาคเรียน</label>
                </td>
            </tfoot>
        </table>

        <h6 class="fs-14 " style="margin-top: 15px;">สรุปจํานวนชั่วโมงที่ใช้ต่อภาคการศึกษา</h6>
        <table class="table2">
            <thead>
                <tr>
                    <td>
                        <h6>
                            ภาคทฤษฎีการบรรยาย
                        </h6>
                    </td>
                    <td>
                        <h6>
                            ภาคปฏิบัติ

                            (การฝึกปฏิบัติ/ภาคสนาม/การฝึกงาน)
                        </h6>
                    </td>
                    <td>
                        <h6>
                            การศึกษาด้วยตนเอง
                        </h6>
                    </td>
                    <td>
                        <h6>
                            รวม
                        </h6>
                    </td>


                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <label for="">30</label>
                    </td>
                    <td>
                        <label for="">30</label>
                    </td>
                    <td>
                        <label for="">30</label>
                    </td>
                    <td>
                        <label for="">135</label>
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
