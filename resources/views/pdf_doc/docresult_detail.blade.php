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
            margin-left: 30px;
            margin-right: 30px;
            margin-top: 55px;
            margin-bottom: 130px;
        }

        .fs-14 {
            font-size: 14px !important;
            ;
        }

        table {
            align-items: start;

        }

        .table1 {
            margin-left: 20px;
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
            margin-right: 14px !important;
        }

        .ml-3 {
            margin-right: 10px !important;
        }

        .ml-5 {
            margin-left: 45px !important;
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
    </style>
</head>

<body>
    <h6 class="fs-14"> วัตถุประสงค์ของหลักสูตร เพื่อผลิตบัณฑิตให้มีคุณลักษณะดังนี้</h6>
    <table class="table1">
        <tbody>
            @php $num = 1; @endphp
            @foreach($objective as $item)
            <tr>
                <td>
                    <span class="m-4">{{ $num++ }}.</span>
                </td>
                <td class="m-4">
                    <div class="b" style="width: 580px;">{!! $item->obj_title !!}</div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <h6 class="fs-14" style="margin-top: 25px;"> รายละเอียดผลลัพธ์การเรียนรู้แต่ละด้านตามมาตรฐานคุณวุฒิระดับอุดมศึกษา ประกอบด้วย</h6>
    @foreach($result_data_detail as $item)
    <table class="table1">
        <tbody>
            <tr>
                <td>
                    <h6 class="fs-14 m-4">{{$item['topic_num']}}</h6>
                </td>
                <td class="m-4">
                    <h6 class="fs-14">{{$item['topic']}}</h6>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="ml-5">
        <table class="table2">
            @foreach($item['details'] as $detailItem)
            <tr>
                <td>
                    <span class="ml-3"> {{$detailItem['num'] }}</span>
                </td>
                <td>
                    <div class="b" style="width: 545px;">
                        {{$detailItem['data'] }}
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    @endforeach

    <!-- <table class="table1">
        <tbody>
            <tr>
                <td>

                    <h6 class="fs-14 m-4">3.</h6>

                </td>
                <td class="m-4">
                    <h6 class="fs-14">ความรู้</h6>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table2">
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>

                </div>
            </td>

        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.2 มีความรับผิดชอบการพัฒนาการเรียนรู้ของตนเอง เคารพกฎระเบียบและข้อบังคับต่างๆ ขององค์กร
                        และสังคม</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.3 สามารถวิเคราะห์ผลกระทบจากการใช้คอมพิวเตอร์ต่อบุคคลองค์กรและสังคม และมีจรรยาบรรณทาง
                        วิชาการและวิชาชีพ</label>
                </div>
            </td>
        </tr>
    </table>
    <table class="table1">
        <tbody>
            <tr>
                <td>

                    <h6 class="fs-14 m-4">3.</h6>

                </td>
                <td class="m-4">
                    <h6 class="fs-14">ความรู้</h6>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table2">
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>
                </div>
            </td>

        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.2 มีความรับผิดชอบการพัฒนาการเรียนรู้ของตนเอง เคารพกฎระเบียบและข้อบังคับต่างๆ ขององค์กร
                        และสังคม</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.3 สามารถวิเคราะห์ผลกระทบจากการใช้คอมพิวเตอร์ต่อบุคคลองค์กรและสังคม และมีจรรยาบรรณทาง
                        วิชาการและวิชาชีพ</label>
                </div>
            </td>
        </tr>
    </table>
    <table class="table1">
        <tbody>
            <tr>
                <td>

                    <h6 class="fs-14 m-4">3.</h6>

                </td>
                <td class="m-4">
                    <h6 class="fs-14">ความรู้</h6>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table2">
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.1 มีคุณธรรม จริยธรรม มีวินัย เสียสละและซื่อสัตย์สุจริต</label>

                </div>
            </td>

        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.2 มีความรับผิดชอบการพัฒนาการเรียนรู้ของตนเอง เคารพกฎระเบียบและข้อบังคับต่างๆ ขององค์กร
                        และสังคม</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.3 สามารถวิเคราะห์ผลกระทบจากการใช้คอมพิวเตอร์ต่อบุคคลองค์กรและสังคม และมีจรรยาบรรณทาง
                        วิชาการและวิชาชีพ</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.3 สามารถวิเคราะห์ผลกระทบจากการใช้คอมพิวเตอร์ต่อบุคคลองค์กรและสังคม และมีจรรยาบรรณทาง
                        วิชาการและวิชาชีพ</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.3 สามารถวิเคราะห์ผลกระทบจากการใช้คอมพิวเตอร์ต่อบุคคลองค์กรและสังคม และมีจรรยาบรรณทาง
                        วิชาการและวิชาชีพ</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.3 สามารถวิเคราะห์ผลกระทบจากการใช้คอมพิวเตอร์ต่อบุคคลองค์กรและสังคม และมีจรรยาบรรณทาง
                        วิชาการและวิชาชีพ</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.3 สามารถวิเคราะห์ผลกระทบจากการใช้คอมพิวเตอร์ต่อบุคคลองค์กรและสังคม และมีจรรยาบรรณทาง
                        วิชาการและวิชาชีพ</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.3 สามารถวิเคราะห์ผลกระทบจากการใช้คอมพิวเตอร์ต่อบุคคลองค์กรและสังคม และมีจรรยาบรรณทาง
                        วิชาการและวิชาชีพ</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.3 สามารถวิเคราะห์ผลกระทบจากการใช้คอมพิวเตอร์ต่อบุคคลองค์กรและสังคม และมีจรรยาบรรณทาง
                        วิชาการและวิชาชีพ</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.3 สามารถวิเคราะห์ผลกระทบจากการใช้คอมพิวเตอร์ต่อบุคคลองค์กรและสังคม และมีจรรยาบรรณทาง
                        วิชาการและวิชาชีพ</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="title2">
                    <label for="" class="title2">1.3 สามารถวิเคราะห์ผลกระทบจากการใช้คอมพิวเตอร์ต่อบุคคลองค์กรและสังคม และมีจรรยาบรรณทาง
                        วิชาการและวิชาชีพ</label>
                </div>
            </td>
        </tr>
    </table> -->
</body>

</html>