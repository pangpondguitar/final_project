<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('/assets/my-fonts/Sarabun-Regular.ttf') }}") format('truetype');
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
            src: url("{{ public_path('/assets/my-fonts/Sarabun-Bold.ttf') }}") format('truetype');
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
            font-size: 12px !important;
        }
    </style>
</head>

<body>
    <div class="App container mt-5">

        <div id="title">
            <label for="" class="text-center">มคอ.3</label>
            <label for="" class="text-center">แผนการสอนของรายวิชา</label>
            <label for="" class="text-center">ภาคเรียนที่ 2 ปีการศึกษา 2556</label>
        </div>
        <div id="divToPrint" class="font-sb">
            <table class="h1 mt-5">
                <tbody>
                    <tr>
                        <td>
                            <label for=""> ชื่อสถาบันอุดมศึกษา มหาวิทยาลัยราชภัฏสุราษฎร์ธานี</label>
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
                                    <label for="">รหัสวิชา SCS0401 </label>
                                </div>
                                <div>
                                    <label class="fw-normal">ชื่อวิชา (ไทย)</label><br>
                                    <label class="fw-normal">ชื่อวิชา (อังกฤษ)</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>2. จำนวนหน่วยกิต</label>
                            <label class="fw-normal">3(2-2-5)</label><br>
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
        <div class="" id="result_sub">
            <label for="">5. ผลลัพธ์การเรียนรู้ของรายวิชา</label>
            <table>
                <thead>
                    <tr>
                        <td class="th20 fz-12">
                            <small>คุณธรรมและจริยธรรม</small>
                        </td>
                        <td class="th20 fz-12">
                            ความรู้
                        </td>
                        <td class="th20 fz-12">
                            ทักษะทางปัญญา
                        </td>
                        <td>
                            ทักษะความ <br> สัมพันธ์ระหว่างบุลคล<br> และความรับผิดชอบ
                        </td>
                        <td>
                            ทักษะการวิเคราะห์<br> เชิงตัวเลขการสื่อสาร <br> และการใช้เทคโนโลยี<br> สารสนเทส
                        </td>
                        <td>
                            วัตถุประสงค์<br> ของหลักสูตร
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
        <button class="btn btn-primary" @click="printDocument()">Export To PDF</button>
    </div>

</body>

</html>