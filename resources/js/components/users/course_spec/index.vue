
<script>

//importing bootstrap 5 and pdf maker Modules

import pdfMake from 'pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts.js';
import htmlToPdfmake from 'html-to-pdfmake';

export default {
    data() {
        return {
            // Replace 'your-dynamic-image-path.jpg' with the actual path or URL of your dynamic image
            imagePath: '/assets/img/logo-sru.jpg',
        };
    },
    methods: {
        getBase64ImageFromURL(url) {
            return new Promise((resolve, reject) => {
                var img = new Image();
                img.setAttribute("crossOrigin", "anonymous");
                img.onload = () => {
                    var canvas = document.createElement("canvas");
                    canvas.width = img.width;
                    canvas.height = img.height;
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0);
                    var dataURL = canvas.toDataURL("image/png");
                    resolve(dataURL);
                };
                img.onerror = error => {
                    reject(error);
                };
                img.src = url;
            });
        },
        async printDocument() {

            pdfMake.vfs = pdfFonts.pdfMake.vfs // 2. set vfs pdf font
            pdfMake.fonts = {
                // download default Roboto font from cdnjs.com
                Roboto: {
                    normal: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Regular.ttf',
                    bold: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Medium.ttf',
                    italics: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Italic.ttf',
                    bolditalics: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-MediumItalic.ttf'
                },
                // Kanit Font
                Sarabun: { // 3. set Kanit font
                    normal: 'Sarabun-Regular.ttf',
                    bold: 'Sarabun-Medium.ttf',
                    italics: 'Sarabun-Italic.ttf',
                    bolditalics: 'Sarabun-MediumItalic.ttf'
                },

            }
            pdfMake.vfs = pdfFonts.pdfMake.vfs;
            //get table html
            const title = document.getElementById('title');
            const pdfTable = document.getElementById('divToPrint');

            //html to pdf format
            var html = htmlToPdfmake(pdfTable.innerHTML);
            var titlepdf = htmlToPdfmake(title.innerHTML);
            console.log(html);
            pdfMake.vfs = pdfFonts.pdfMake.vfs;
            const documentDefinition = {
                content: [

                    {
                        image: await this.getBase64ImageFromURL(
                            "/assets/img/logo-sru.jpg"
                        ),
                        width: 70,
                        height: 80,
                        style: 'center',
                        margin: [5, 2, 10, 20]
                    },
                    titlepdf,
                    html
                ],
                styles: {
                    center:
                    {
                        alignment: 'center'
                    }

                },

                defaultStyle: { // 4. default style 'KANIT' font to test
                    font: 'Sarabun'
                }
            }

            pdfMake.createPdf(documentDefinition).open();

        },

    },
}
</script>

<template>
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

        <button class="btn btn-primary" @click="printDocument()">Export To PDF</button>
    </div>
</template>

<style>
.img-logo {
    width: 50px;
    height: auto;
}
</style>
