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
            width: 100%;

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
    </style>
</head>

<body>
    <div class="" id="result_sub">
        <h6 class="fs-14">7. การวัดและประเมินผลการศึกษา</h6>

        <table class="table1">
            <thead>
                <tr>
                    <td>
                        <h6>รายการ</h6>
                    </td>
                    <td>
                        <h6>ร้อยละ</h6>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        การมีส่วนร่วมในชั้นเรียน การเข้าชั้นเรียน การแต่งกาย
                    </td>
                    <td>
                        10
                    </td>
                </tr>
                <tr>
                    <td>
                        แบบฝึกหัดท้ายบทเรียน วิเคราะห์กรณีศึกษาค้นคว้าและการนําเสนอรายงาน
                    </td>
                    <td>
                        10
                    </td>
                </tr>
                <tr>
                    <td>
                        สอบปฏิบัติการใช้โปรแกรมเพื่อหาค่าสถิติที่เกี่ยวข้อง
                    </td>
                    <td>
                        10
                    </td>
                </tr>
                <tr>
                    <td>
                        คะแนนสอบกลางภาค
                    </td>
                    <td>
                        10
                    </td>
                </tr>

                <tr>
                    <td>
                        คะแนนสอบปลายภาค
                    </td>
                    <td>
                        10
                    </td>
                </tr>

            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <h6> คะแนนสอบปลายภาค</h6>
                    </td>
                    <td>
                        <h6> 100</h6>
                    </td>
                </tr>
            </tfoot>
        </table>

        <h6 class="fs-14" style="margin-top: 15px;">8. ทรัพยากรประกอบการเรียนการสอน</h6>
        <label for=""></label>
    </div>
</body>

</html>
