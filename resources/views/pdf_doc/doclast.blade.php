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
            font-size: 18px !important;
            margin-left: 35px;
            margin-right: 35px;
            margin-top: 10px;
        }


        .fs-18 {
            font-size: 20px !important;
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
        <h6 class="fs-18">7. การวัดและประเมินผลการศึกษา</h6>

        <table class="table1">
            <thead>
                <tr>
                    <td style="width:80%;">
                        <h6 class="fs-18">รายการ</h6>
                    </td>
                    <td>
                        <h6 class="fs-18">ร้อยละ</h6>
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($measure_list as $item)
                <tr>
                    <td class="fs-18 text-start">
                        <div style="margin-left: 5px;"> {{ $item->ml_title}}</div>
                    </td>
                    <td class="fs-18 ">
                        {{ $item->ml_value}}
                    </td>
                </tr>
                @endforeach


            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <h6 class="fs-18"> รวม</h6>
                    </td>

                    <td>
                        <h6 class="fs-18"> {{$sum_measure_list}}</h6>
                    </td>


                </tr>
            </tfoot>
        </table>

        <h6 class="fs-18" style="margin-top: 20px;">8. ทรัพยากรประกอบการเรียนการสอน</h6>
        @foreach($resource as $item)
        <div style="margin-left: 25px;" class="fs-18"> {!! $item->rs_title !!}</div>
        @endforeach
        <h6 class="fs-18" style="margin-top: 20px;">9. คณะกรรมการบริหารรายวิชา/อาจารย์ผู้สอนรายวิชา</h6>
        <label for="" style="margin-left: 38px;" class="fs-18">9.1 คณะกรรมการบริหารรายวิชา</label>
        @foreach($committees as $item)
        <div>
            <label for="" class="fs-18" style="margin-left: 56px;">{{$item['num']}}. {{$item['teacher']}}</label>
        </div>

        @endforeach
        <label for="" style="margin-left: 38px;" class="fs-18">9.2 อาจารย์ผู้สอนรายวิชา</label>
        @foreach($teachers as $item)
        <div>
            <label for="" class="fs-18" style="margin-left: 56px;">{{$item['num']}}. {{$item['teacher']}}</label>
        </div>

        @endforeach
    </div>
</body>

</html>