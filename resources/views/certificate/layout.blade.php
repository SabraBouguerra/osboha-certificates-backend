<!DOCTYPE html>
<html>

<head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->

</head>


<style>
.get-certificate-btn {
  position: fixed;
  font-size: 20px;
}

.page-content {
  margin-top: 30%;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  width: 80%;
}

.pageWithCertificate{
  background-image: url("{{asset('asset/images/test.png')}}");
  font-family: "Calibri, sans-serif";
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
  width: 210mm;
  height: 297mm; 
  background-size: cover;
  background-position: center;
  margin: auto auto;
  color: black;
}
.page {
 background-image: url("{{asset('asset/images/certificateWithouSignature.png')}}");
  font-family: "Calibri, sans-serif";
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
  width: 210mm;
  height: 297mm;
  background-size: cover;
  background-position: center;
  margin: auto auto;
  color: black;
}
#mainpage{
  overflow-x:auto;
}
.page p,.pageWithCertificate p {
  font-size: 14pt;
  margin-left: 1px;
  margin-bottom: 10pt;
  line-height: 150%;
  direction: rtl;
  text-align: right;
}

.page .main-header ,.pageWithCertificate .main-header {
  line-height: 115%;
  font-weight: bold;
  font-size: 36pt;
}

.page .sub-header, .pageWithCertificate .sub-header {
  line-height: 115%;
  font-size: 18pt;
  font-weight: bold;
}

.page .break-space , .pageWithCertificate .break-space{
  line-height: 115%;
}

.important-text {
  font-weight: bold;
}

.highlight {
  background-color: yellow;
  color: black;
}

.quote {
  font-size: 10pt !important;
}
 
</style> 

<body>
  <div class="w-100 text-center">
    <div id="export">
      <button
        class="get-certificate-btn btn btn-primary mb-2 w-25"
        @click="exportToPDF"
      >
        تحميل الشهادة ك ملف pdf
      </button>
    </div>
    <div id="mainpage">
      <div class="pageWithCertificate">
        <div class="page-content">
          <p style="text-align: center">
            <span style="font-size: 30pt; font-family: 'Arial', sans-serif"
              >بسم الله الرحمن الرحيم
            </span>
          </p>
          <p class="break-space">&nbsp;</p>
          <p>التاريخ: </p>

          <p class="main-header" style="text-align: center">
            <u><span>توثيق إنجاز قارئ</span></u>
          </p>
          <p style="text-align: center">
            <strong v-if="information.book.level">مستوى الكتاب: </strong>
          </p>
          <p>
            <strong><span style="font-size: 13px"> </span></strong>
          </p>
          <p>
            تثبت هذه الوثيقة من مشروع صناعة القرّاء (أصبوحة 180) بأن 
            <span class="important-text"> 
       </span>،

            قد حصل عليها بموجب المعايير المتبعة
            قد طبق معايير القراءة المنهجية من خلال إنجازه قراءة كتاب
            . ويثمن المشروع جهوده المبذولة وسعيه
            الحثيث في زيادة حصيلته المعرفية، ورغبته باستمرارية التعلم عبر
            القراءة المنهجية؛ ليبني صرحه المعرفيّ الذي يؤسّس لما بعده من
            الأفعال، والتي تؤدي بدورها إلى النّهضة الحقيقيّة على المستوى الفردي
            والجماعي، فينفع أمّته ويساهم في بناء نهضتها نحو القوّة والتطور
            والرفعة.
          </p>
          <p class="break-space">&nbsp;</p>
          <p class="break-space">&nbsp;</p>
          <p>
            علمًا أن مشروع أصبوحة 180 هو الحاضنة الأساسية للقرّاء، بصفته المشروع
            الأكبر عربيّاً لصناعة الفكر، مُركزًا على عوامل الفكر عن طريق استثمار
            القراءة المنهجيّة ونواتجها؛ لصناعة مجتمع واعٍ قادرٍ على الوصول
            للنّهضة، وتحقيق التنمية مستعيناً بالتكنولوجيا الحديثة.
          </p>
        </div>
 
    ¦
      </div>
      <div class="page">
        <div class="page-content">
          <p class="sub-header">التقييم الفردي لحامل هذه الشهادة</p>
          <p class="break-space">&nbsp;</p>
          <p>
            <span>يهدف مشروع أصبوحة </span><span>180 </span
            ><span>
              إلى رفع كفاءة التعلم من خلال القراءة المنهجية لدى القارئ وذلك من
              خلال تعميق أهمية الكتابة التوثيقية المصاحبة للقراءة و المتمثلة في
              تنظيم وحفظ أوعية المعرفة، وتيسير سبل الإفادة من محتوياتها؛ لأغراض
              المناقشة والمقارنة، بهدف تحقيق أقصى درجات الإفادة منها، و</span
            ><span
              >استثمار أكبر قدر ممكن من النتاج الفكري لتتحول القراءة عند القارئ
              من مجرد اكتساب إلى عملية تبادلية فيها الاكتساب والنتاج المتولد
              عنها</span
            ><span
              >، إيمانًا منا أن إعمال الذهن فيما تتعلم، وتوثيقه كتابيًا يعد
              وسيلة أساسية للابتكار والتطور وتحقيق النهضة.</span
            >
          </p>
          <p>
            <span
              >لقد قام فريق مختص بمتابعة القارئ و قام فريق مدرب على تقييم إنجازه
              ضمن خطة منهجية ومعايير محددة مسبقًا، اعتمدت على قراءة الأفكار
              الأساسية والفرعية الموجودة في الكتاب، وتقديم تغذية راجعة للأطروحات
              المقدّمة للمساهمة في رفع استفادة الفرد من حصيلة ما قد قرأ وتعزيز
              مهارات القراءة الفعّالة من خلال مناقشات وحوارات، وتمكينه من ترسيخ
              أفكار المادة المقروءة وتحويلها إلى أسئلة معرفية، وكلمات دلالية،
              وملخصات مرجعية، وأطروحات ناتجة عن حصاد ذلك كله.</span
            >
          </p>
          <p>
            <strong
              ><span
                ><br />
                <u>التقديرات التي حصل عليها القارئ كما يلي: </u></span
              ></strong
            >
          </p>

          <p>
            - السؤال العام المقدم من القارئ تقديره (
            
            <span
              class="(degrees.general_summary_grade <= 100 && degrees.general_summary_grade > 94) ? 'highlight' : ''">امتياز</span>
            <strong><span style="color: #00b050">||</span></strong>
            <span
              class="(degrees.general_summary_grade <= 94 && degrees.general_summary_grade > 89) ? 'highlight' : ''">ممتاز</span>
            <strong><span style="color: #00b050">||</span></strong>
            <span
              class="(degrees.general_summary_grade <= 89 && degrees.general_summary_grade > 84) ? 'highlight' : ''">جيد
              جدا</span>
            <strong><span style="color: #00b050">||</span></strong>
            <span
              class="(degrees.general_summary_grade <= 84 && degrees.general_summary_grade > 79) ? 'highlight' : ''">جيد</span>
            <strong><span style="color: #00b050">||</span></strong>
            <span
              class="(degrees.general_summary_grade <= 79 && degrees.general_summary_grade > 69) ? 'highlight' : ''">مقبول)</span>
          </p>
          <p>
            - الأسئلة المعرفية المقدمة من القارئ تقديرها (
            <span
              v-bind:class="(degrees.check_reading_grade <= 100 && degrees.check_reading_grade > 94) ? 'highlight' : ''">امتياز</span>
            <strong><span style="color: #00b050">||</span></strong>
            <span
              v-bind:class="(degrees.check_reading_grade <= 94 && degrees.check_reading_grade > 89) ? 'highlight' : ''">ممتاز</span>
            <strong><span style="color: #00b050">||</span></strong>
            <span
              v-bind:class="(degrees.check_reading_grade <= 89 && degrees.check_reading_grade > 84) ? 'highlight' : ''">جيد
              جدا</span>
            <strong><span style="color: #00b050">||</span></strong>
            <span
              v-bind:class="(degrees.check_reading_grade <= 84 && degrees.check_reading_grade > 79) ? 'highlight' : ''">جيد</span>
            <strong><span style="color: #00b050">||</span></strong>
            <span
              v-bind:class="(degrees.check_reading_grade <= 79 && degrees.check_reading_grade > 69) ? 'highlight' : ''">مقبول)</span>

          </p>
        </div>
      </div>
  
  
    </div>
  </div>

</body>
</html>