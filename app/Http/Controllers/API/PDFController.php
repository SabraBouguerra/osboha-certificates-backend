<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\API\BaseController;


use PDF;
use Illuminate\Http\Request;
use TCPDF_FONTS;

class PDFController extends BaseController
{



    public function generatePDFViwe()
    {
        return view('certificate.layout');
    }

    public function generatePDF()
    {
        


        // set document information
        PDF::SetCreator('PDF_CREATOR');
        PDF::SetAuthor('Nicola Asuni');
        PDF::SetTitle('TCPDF Example 051');
        PDF::SetSubject('TCPDF Tutorial');
        PDF::SetKeywords('TCPDF, PDF, example, test, guide');

        // set header and footer fonts
        PDF::setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

        // set default monospaced font
        PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(0);
        PDF::SetFooterMargin(0);

        // remove default footer
        PDF::setPrintFooter(false);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            PDF::setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        PDF::SetFont('Calibri', '', 48);

        // add a page
        PDF::AddPage();


        // -- set new background ---

        // get the current page break margin
        $bMargin = PDF::getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = PDF::getAutoPageBreak();
        // disable auto-page-break
        PDF::SetAutoPageBreak(false, 0);
        // set bacground image
        // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
        $img_file = 'C:\Users\someO\Desktop\laravel\osboha-certificates-backend\public\asset\images\certTemp.jpg';
        PDF::Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        PDF::SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        PDF::setPageMark();


        PDF::writeHTML(view('certificate.layout', ['name' => 'admin'])->render(), true, false, true, false, '');
        //Close and output PDF document
        PDF::Output('example_051.pdf', 'I');
    }
}
