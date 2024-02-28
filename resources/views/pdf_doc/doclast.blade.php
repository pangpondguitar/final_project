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
            src: url("{{ public_path('/assets/my-fonts/Sarabun-ExtraLightItalic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('/assets/my-fonts/Sarabun-Italic.ttf') }}") format('truetype');
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
        }

        .fs-16 {
            font-size: 16px !important;
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

        .text-start {
            text-align: left !important;
        }
    </style>
</head>

<body>
    <div class="" id="result_sub">
        <h6 class="fs-14">7. การวัดและประเมินผลการศึกษา</h6>

        <table class="table1">
            <thead>
                <tr>
                    <td style="width:80%;">
                        <h6 class="fs-14">รายการ</h6>
                    </td>
                    <td>
                        <h6 class="fs-14">ร้อยละ</h6>
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($measure_list as $item)
                <tr>
                    <td class="fs-14 text-start">
                        <div style="margin-left: 5px;"> {{ $item->ml_title}}</div>
                    </td>
                    <td class="fs-14 ">
                        {{ $item->ml_value}}
                    </td>
                </tr>
                @endforeach


            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <h6> รวม</h6>
                    </td>

                    <td>
                        <h6> {{$sum_measure_list}}</h6>
                    </td>


                </tr>
            </tfoot>
        </table>

        <h6 class="fs-14" style="margin-top: 20px;">8. ทรัพยากรประกอบการเรียนการสอน</h6>
        @foreach($resource as $item)
        <div style="margin-left: 25px;"> {!! $item->rs_title !!}</div>
        @endforeach
        <h6 class="fs-14" style="margin-top: 20px;">9. คณะกรรมการบริหารรายวิชา/อาจารย์ผู้สอนรายวิชา</h6>
    </div>
</body>

</html>