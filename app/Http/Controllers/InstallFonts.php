<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use PDF;
use TCPDF_FONTS;

class InstallFonts extends BaseController
{

    public function istall()
    {

        $path = '/var/www/html/osboha-certificates-backend/vendor/tecnickcom/tcpdf/fonts/arial.ttf';
        $test = TCPDF_FONTS::addTTFfont($path, 'TrueTypeUnicode', '', 32);
        print_r($test);


        $path = '/var/www/html/osboha-certificates-backend/vendor/tecnickcom/tcpdf/fonts/arialbd.ttf';
        $test = TCPDF_FONTS::addTTFfont($path, 'TrueTypeUnicode', '', 32);
        print_r($test);


        $path = '/var/www/html/osboha-certificates-backend/vendor/tecnickcom/tcpdf/fonts/calibri.ttf';
        $test = TCPDF_FONTS::addTTFfont($path, 'TrueTypeUnicode', '', 32);
        print_r($test);


        $path = '/var/www/html/osboha-certificates-backend/vendor/tecnickcom/tcpdf/fonts/calibrib.ttf';
        $test = TCPDF_FONTS::addTTFfont($path, 'TrueTypeUnicode', '', 32);
        print_r($test);
    }
}
