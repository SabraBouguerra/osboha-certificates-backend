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

        // $userBook = UserBook::find($id);
        // $degrees = Certificates::where('user_book_id',$id);
        // $thesis = Thesis::where('user_book_id',$id);
        // $questions = Question::where('user_book_id',$id);
        // $generalInformations = Thesis::where('user_book_id',$id);
        // $user = User::find($userBook->user_id);


        // $pdf = PDF::loadView('certificate');
 PDF::SetTitle('Hello World');
  PDF::AddPage();
  PDF::Write(0, 'ييي ي');
  PDF::Output('hello_world.pdf');
        // return $pdf->download('itsolutionstuff.pdf');
    }
}
