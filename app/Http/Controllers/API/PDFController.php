<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;

use PDF;

class PDFController extends BaseController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {

       // $path='C:\Users\someO\Desktop\laravel\osboha-certificates-backend\vendor\tecnickcom\tcpdf\fonts\ArbFONTS-ArabicUIDisplayUltraLight.ttf';
        // $test=TCPDF_FONTS::addTTFfont($path,'TrueTypeUnicode','',32);
    	// dd($test);

       PDF::SetFont('aealarabiya', '', 18);
        PDF::SetTitle('Hello World');

        PDF::AddPage();
        PDF::writeHTML(view('certificate',['name'=>'admin'])->render(), true, false, true, false, '');

        PDF::Output('hello_world.pdf');
    }
}
