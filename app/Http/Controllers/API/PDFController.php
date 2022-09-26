<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Certificates;
use App\Models\Question;
use App\Models\Thesis;
use App\Models\User;
use App\Models\UserBook;
use Illuminate\Http\Request;
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


        $pdf = PDF::loadView('certificate');

        return $pdf->download('itsolutionstuff.pdf');
    }
}
