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
            font-size: 20px !important;
            margin-left: 30px;
            margin-right: 30px;
            margin-top: 40px;
            margin-bottom: 130px;
        }

        .fs-20 {
            font-size: 20px !important;
            ;
        }

        table {
            align-items: start;

        }

        .table1 {
            margin-left: 40px;
        }

        .table2 {

            width: 100%;
        }

        .table3 {

            margin-left: 60px;
        }

        .table4 {

            margin-left: 95px;
        }


        table,
        tr,
        td {
            border-collapse: collapse;
            align-items: center;
            border: 1px solid black;
        }


        table,
        tr,
        td {
            border-collapse: collapse;
            align-items: start;

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
            text-align: left;
            vertical-align: top;
            margin: 0;
            padding: 0;
        }


        label {
            line-height: 0;
        }

        .m-4 {
            margin-right: 10px !important;
        }

        .ml-3 {
            margin-right: 5px !important;
        }

        .ml-5 {
            margin-left: 61px !important;
        }

        .ml-6 {
            margin-left: 60px;
        }

        .ml-7 {
            margin-left: 81px !important;
        }

        .ml-8 {
            margin-left: 124px !important;
        }

        .ml-9 {
            margin-left: 110px;
        }

        .ml-10 {
            margin-right: 2px !important;
        }


        div.title2 {
            text-indent: 43px;
        }

        div.b {
            word-wrap: break-word;
        }

        .indented-text {
            text-indent: 80px;
        }

        .border-none {
            border: none !important;
        }

        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: start;
        }
    </style>
</head>

<body>
    <h6 class="fs-20">7. การวางแผนและการเตรียมการ</h6>
    @foreach($prep_plan as $item)
    <table class="table1 border-none">
        <tbody class="border-none">
            <tr class="border-none">
                <td class="border-none">
                    <span class="fs-20 m-4">{{$item['topic_num']}}</span>
                </td>
                <td class="m-4 border-none">
                    <span class="fs-20">{{$item['topic']}}</spa>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="ml-5 border-none">
        <table class=" border-none">
            @foreach($item['title'] as $detailItem)
            <tr class="border-none">
                <td class="border-none">
                    <span class="ml-3"> {{$detailItem['num'] }}</span>
                </td>
                <td class="border-none">
                    <div class="b" style="width: 545px;">
                        {{$detailItem['data'] }}
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    @endforeach
    <h6 class="fs-20" style="margin-top: 25px;">8. การวัดและประเมินผลการปฎิบัติของนักศึกษา</h6>
    <span class="ml-6">1. หลักเกณฑ์การประเมิน</span>
    <table class="table2">
        <thead>
            <tr>
                <td style="width:80%;">
                    <h6 class="fs-20 text-center">รายการ</h6>
                </td>
                <td>
                    <h6 class="fs-20 text-center">ร้อยละ</h6>
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach($measure_list as $item)
            <tr>
                <td class="fs-20 text-start">
                    <div style="margin-left: 5px;"> {{ $item->ml_title}}</div>
                </td>
                <td class="fs-20 text-center ">
                    {{ $item->ml_value}}
                </td>
            </tr>
            @endforeach


        </tbody>
        <tfoot>
            <tr>
                <td class="text-center fs-20" style="font-weight: bold;">
                    รวม
                </td>

                <td class="text-center fs-20" style="font-weight: bold;">
                    {{$sum_measure_list}}
                </td>
            </tr>
        </tfoot>
    </table>
    <div>
        @foreach($measure_prac as $item)
        <table class="table3 border-none" style="margin-top: 19px;">
            <tbody class="border-none">
                <tr class="border-none">
                    <td class="border-none">
                        <span class="fs-20 m-4">{{$item['topic_num']}}</span>
                    </td>
                    <td class="m-4 border-none">
                        <span class="fs-20">{{$item['topic']}}</spa>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="ml-7 border-none">
            <table class=" border-none">
                @foreach($item['title'] as $detailItem)
                <tr class="border-none">
                    <td class="border-none">
                        <span class="ml-10"> {{$detailItem['num'] }}</span>
                    </td>
                    <td class="border-none">
                        <div class="b" style="width: 545px;">
                            {{$detailItem['data'] }}
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        @endforeach
    </div>
    <h6 class="fs-20" style="margin-top: 25px;">9. การประเมินและปรับปรุงการดำเนินการของการฝึกประสบการณ์วิชาชีพภาคสนาม</h6>
    <span class="ml-6">1. กระบวนการประเมินการฝึกประสบการณ์ภาคสนามจากผู้เกี่ยวข้อง</span>
    <div>
        @foreach($adjust_people as $item)
        <table class="table4 border-none">
            <tbody class="border-none">
                <tr class="border-none">
                    <td class="border-none">
                        <span class="fs-20 m-4">{{$item['topic_num']}}</span>
                    </td>
                    <td class="m-4 border-none">
                        <span class="fs-20">{{$item['topic']}}</spa>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="ml-8 border-none">
            <table class=" border-none">
                @foreach($item['title'] as $detailItem)
                <tr class="border-none">
                    <td class="border-none">
                        <div class="b" style="width: 545px;">
                            {{$detailItem['data'] }}
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        @endforeach
    </div>
    <span class="ml-6">2. กระบวนการทบทวนผลการประเมินและการวางแผนปรับปรุง</span>
    @foreach($adjust_repeat as $item)
    <div class="b" style="width: 545px;">
        <span class="ml-9">{{$item['adr_title']}}</span>
    </div>
    @endforeach
    <h6 class="fs-20" style="margin-top: 25px;">9. คณะกรรมการบริหารรายวิชา/อาจารย์ผู้สอนรายวิชา</h6>
</body>

</html>
