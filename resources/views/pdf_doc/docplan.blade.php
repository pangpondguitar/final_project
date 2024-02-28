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
            font-size: 11px !important;
            padding-left: 30px;
            padding-right: 30px;
            padding-top: 10px;
        }

        .fs-14 {
            font-size: 14px !important;
        }

        .fs-16 {
            font-size: 16px !important;
        }

        .table-1 {
            width: 100%;
        }

        .table2 {
            width: 100%;
        }




        table,
        tr,
        td {
            border-collapse: collapse;
            border: 1px solid black;
        }

        h6,
        label {
            margin: 0;
            padding: 0;
            font-size: 11px !important;
        }

        .topic {
            margin: 0;
            padding: 0;
            font-size: 11px !important;
        }

        th,
        td {
            padding: 8px;

            vertical-align: top;
            margin: 0;
            padding: 0;
        }

        .var-middle {
            vertical-align: middle !important;
        }

        .text-center {
            text-align: center;
        }

        label {
            line-height: 0;
        }

        .m-4 {
            margin-right: 15px !important;
        }

        .m-10 {
            margin: 10px !important;
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

        thead {
            display: table-header-group;
        }

        .column {
            width: 75%;
            margin: 0 auto;
            /* จัดตำแหน่งในศูนย์กลาง */
            text-align: center;
            /* จัดตำแหน่งข้อความในศูนย์กลาง */
            /* word-wrap: break-word; */
            /* หรือใช้ overflow-wrap: break-word; */
        }

        .column2 {


            /* จัดตำแหน่งในศูนย์กลาง */
            text-align: start;
            /* จัดตำแหน่งข้อความในศูนย์กลาง */
            word-break: break-all;
        }

        p {
            width: 140px;
            vertical-align: top;
        }

        p.c {
            vertical-align: top;
            word-break: break-all !important;
        }

        div.b {
            word-wrap: break-word;
        }

        .border-none {
            border: none !important;
        }

        .p-8 {
            padding-left: 8px !important;
            padding-right: 8px !important;
            padding-top: 1px !important;

        }

        .py-1 {
            margin-bottom: 2px;
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <div class="" id="result_sub">
        <h6 class="fs-14">6.แผนการสอน</h6>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <td class="text-center m-10" style="width: 10% !important;">
                        <h6 class="m-10">
                            สัปดาห์ที่<br>
                            (จํานวน<br>
                            ชั่วโมง)
                        </h6>
                    </td>
                    @foreach($plan_week_top as $item)
                    <td class="text-center var-middle" style="width: 20% !important;">
                        <div>

                            <div class="column">
                                <h6> {{$item['pt_title']}}</h6>
                            </div>

                        </div>
                    </td>

                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($plan_week as $pwId => $weekItem)
                <tr>
                    <td class="text-center" style="width: 10%;">
                        {{ $weekItem['week'] }} <br>
                        ({{ $weekItem['hour'] }})
                    </td>
                    @foreach($weekItem as $ptId => $items)
                    @if($ptId !== 'week' && $ptId !== 'hour') {{-- Exclude 'week' and 'hour' keys --}}
                    <td class="">
                        <div class="p-8">
                            <table class="border-none">
                                <tbody class="border-none">
                                    @foreach($items as $item)
                                    <tr class="border-none">
                                        <td class="border-none">
                                            <label> {{ $item['order']}}</label>
                                        </td>
                                        <td class="border-none">
                                            <div class="b" style="width: 135px; margin-left:4px"> {{ $item['data']['pwl_title'] }}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                    @endif
                    @endforeach
                </tr>
                @endforeach

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
        <h6 class="fs-14" style="margin-top: 15px;">สรุปจํานวนชั่วโมงที่ใช้ต่อภาคการศึกษา</h6>
        <table class="table2">
            <thead>
                <tr class="text-center var-middle">
                    <td class="var-middle">
                        <h6 class="fs-14">
                            ภาคทฤษฎีการบรรยาย
                        </h6>
                    </td>
                    <td class="var-middle" style="width: 30%;">
                        <h6 class="fs-14">
                            ภาคปฏิบัติ <br>

                            (การฝึกปฏิบัติ/ภาคสนาม/การฝึกงาน)
                        </h6>
                    </td>
                    <td class="var-middle" style="width: 20%;">
                        <h6 class="fs-14">
                            การศึกษาด้วยตนเอง
                        </h6>
                    </td>
                    <td class="var-middle">
                        <h6 class="fs-14">
                            รวม
                        </h6>
                    </td>


                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    @foreach($sum_plan_week as $item)
                    <td class="text-center py-1">
                        <label for="" class="fs-16 text-center">{{$item->psh_describe}}</label>
                    </td>
                    <td class="text-center py-1">
                        <label for="" class="fs-16 text-center">{{$item->psh_practice}}</label>
                    </td>
                    <td class="text-center py-1">
                        <label for="" class="fs-16 text-center">{{$item->psh_self}}</label>
                    </td>
                    <td class="text-center py-1">
                        <label for="" class="fs-16 text-center">{{$item->psh_describe + $item->psh_practice + $item->psh_self}}</label>
                    </td>
                    @endforeach

                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>