<?php

namespace App\Http\Controllers\API;

 
use App\Http\Controllers\API\BaseController;

 
use PDF;
use Illuminate\Http\Request;
use TCPDF_FONTS;

class PDFController extends BaseController
{
 

 
    public function generatePDF() 
    {
        // $path='C:\Users\someO\Desktop\laravel\osboha-certificates-backend\vendor\tecnickcom\tcpdf\fonts\ArbFONTS-ArabicUIDisplayUltraLight.ttf';
        // $test=TCPDF_FONTS::addTTFfont($path,'TrueTypeUnicode','',32);
    	// dd($test);
        $html = '<h1 style="color:red;">تجربة الخط الأولى</h1>';
        PDF::SetFont('ibmplexsansarabic', '', 10);
        PDF::SetTitle('Hello World');
        
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');

        PDF::Output('hello_world.pdf');
 
    }
}