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

        @font-face {
            font-family: 'Arial';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('/assets/my-fonts2/ArialCE.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
            font-size: 16px !important;
            margin-left: 35px;
            margin-right: 35px;
            margin-top: 10px;
        }


        table,
        tr,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            align-items: center;
            /* table-layout: fixed; */
            /* white-space: nowrap; */

        }




        table {
            table-layout: auto;
            border-collapse: collapse;
            width: 100%;
        }

        .p-0 {
            padding-top: 0;
            padding-bottom: 0;
        }

        .m-0 {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .fs-16 {
            font-size: 16px;
        }

        .fs-18 {
            font-size: 18px;
        }

        .fs-16 {
            font-size: 16px !important;
            padding-bottom: 0px;
            margin-bottom: 0px;
            margin-top: 0px;
            padding-top: 0px;
        }

        .ms-10 {
            margin-left: 10px;
        }

        .ms-7 {
            margin-left: 7px;
        }

        .ms-25 {
            margin-left: 25px;
        }

        div.title2 {
            text-indent: 10px;
        }

        .mx-10 {
            margin-left: 10px !important;
            margin-right: 10px !important;
        }

        .mx-50 {
            margin-left: 50px !important;
            margin-right: 50px !important;
        }

        .h-20 {
            height: 20px !important;
        }

        table tr td {
            height: 0px !important;
            /* ปรับความสูงตามที่ต้องการ */
        }

        table tr {
            height: 0px !important;
            /* ปรับความสูงของแถวตามที่ต้องการ */
        }

        .text-start {
            text-align: left !important;
        }

        div.b {
            word-wrap: break-word;
        }

        .border-none {
            border: none;
        }

        .vc-top {
            vertical-align: top !important;
        }

        .text-start {
            text-align: start !important;
        }
    </style>
</head>

<body>
    <div class="" id="result_sub">
        <h6 class="fs-18 p-0 m-0">5. ผลลัพธ์การเรียนรู้ของรายวิชา</h6>

        <table>
            <thead>
                <tr>
                    <td rowspan="3" style="width: 20% !important; ">
                        <h6 class="fs-16"> จุดมุ่งหมายของรายวิชา</h6>
                    </td>
                    <td colspan="{{$count_all_details}}">
                        <h6 class="p-0 m-0 fs-16 ">ผลลัพธ์การเรียนรู้ตามมาตรฐานคุณวุฒิระดับอุดมศึกษา พ.ศ. 2552</h6>
                    </td>
                    <td colspan="3" rowspan="2">
                        <h6 class="fs-16"> วัตถุประสงค์ของ<br>หลักสูตร</h6>
                    </td>
                </tr>
                <tr>
                    <!-- <td colspan="3">
                        <div class="mx-10"> คุณธรรมและ <br>จริยธรรม</div>
                    </td>
                    <td colspan="3">
                        <div class="mx-10"> ความรู้</div>
                    </td>
                    <td colspan="5">
                        <div class="mx-50"> ทักษะทางปัญญา</div>
                    </td>
                    <td colspan="3">
                        <div class="mx-10"> ทักษะความสัมพันธ์<br>ระหว่างบุลคล<br>และความ<br>รับผิดชอบ</div>
                    </td>
                    <td colspan="3">
                        <div class="mx-10"> ทักษะการ<br>วิเคราะห์เชิง<br>ตัวเลขการ<br>สื่อสารและการ<br>ใช้เทคโนโลยี<br>สารสนเทส</div>
                    </td> -->
                    @foreach($count_list_detail as $item)
                    <td colspan="{{$item->count}}">
                        <div class="mx-10">{{$item->tlr_title}}</div>
                    </td>

                    @endforeach
                </tr>
                <tr>
                    @foreach($list_result_detail as $item)
                    <td>
                        {{ $item['num'] }}
                    </td>
                    @endforeach
                    <td>
                        1
                    </td>
                    <td>
                        2
                    </td>
                    <td>
                        3
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($result_data as $item)
                <tr>
                    <td style="width: 20%;" class="text-start">
                        <table class="border-none">
                            <tbody class="border-none">
                                <tr class="border-none">
                                    <td class="border-none vc-top">
                                        <label> {{ $item['num']}}.</label>
                                    </td>
                                    <td class="border-none text-start">
                                        <div class="b" style="width: 150px; margin-left:4px"> {{$item['title']}}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                    @foreach($list_result_detail as $item)
                    <td>
                        <p>&#x26AB;</p>
                    </td>
                    @endforeach
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>

                </tr>
                @endforeach

            </tbody>
            </thead>
        </table>

    </div>
</body>


</html>
