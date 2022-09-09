<?php

use App\Http\Controllers\API\UserBookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BooksController;
use App\Http\Controllers\API\CertificatesController;
use App\Http\Controllers\API\FQAController;
use App\Http\Controllers\API\GeneralInformationsController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\ThesisController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BookCategoryController;
use App\Http\Controllers\API\BookTypeController;
use App\Http\Controllers\API\EmailVerificationController;
use App\Models\Question;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);


//category routes
Route::group(['prefix' => 'category'], function () {
    Route::get('/', [BookCategoryController::class, 'index'])->middleware(['auth:api','role:admin']);
    Route::post('/', [BookCategoryController::class, 'store'])->middleware(['auth:api','role:admin']);
    Route::get('/{id}', [BookCategoryController::class, 'show'])->middleware(['auth:api','role:admin']);
    Route::patch('/{id}', [BookCategoryController::class, 'update'])->middleware(['auth:api','role:admin']);
    Route::delete('/{id}', [BookCategoryController::class, 'destroy'])->middleware(['auth:api','role:admin']);
});
//type routes
Route::group(['prefix' => 'type'], function () {
    Route::get('/', [BookTypeController::class, 'index'])->middleware(['auth:api','role:admin']);
    Route::post('/', [BookTypeController::class, 'store'])->middleware(['auth:api','role:admin']);
    Route::get('/{id}', [BookTypeController::class, 'show'])->middleware(['auth:api','role:admin']);
    Route::patch('/{id}', [BookTypeController::class, 'update'])->middleware(['auth:api','role:admin']);
    Route::delete('/{id}', [BookTypeController::class, 'destroy'])->middleware(['auth:api','role:admin']);
});
 //users routes
    Route::group(['prefix' => 'userbook'], function () {
        Route::get('/', [UserBookController::class, 'index'])->middleware(['auth:api','role:admin|reviewer']);
        Route::post('/', [UserBookController::class, 'store'])->middleware(['auth:api','userBook']);
        Route::get('/count',[UserBookController::class,"checkOpenBook"])->middleware(['auth:api']);
        Route::get('/stage-status/{id}',[UserBookController::class,"getStageStatus"])->middleware(['auth:api']);
        Route::get('/{id}', [UserBookController::class, 'show'])->middleware(['auth:api']);
        Route::patch('/{id}', [UserBookController::class, 'update'])->middleware(['auth:api','role:admin|reviewer']);
        Route::delete('/{id}', [UserBookController::class, 'destroy'])->middleware(['auth:api','role:admin|reviewer']);
    });

// Books routes
Route::group(['prefix' => 'books'], function () {
    Route::get('/', [BooksController::class, 'index'])->middleware(['auth:api']);
    Route::post('/', [BooksController::class, 'store'])->middleware(['auth:api', 'role:admin']);
    Route::get('/user',[BooksController::class ,'getBooksForUser'])->middleware(['auth:api']);
    Route::get('/user/{id}',[BooksController::class ,'getOpenBook'])->middleware(['auth:api']);
    Route::get('/{id}', [BooksController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/{id}', [BooksController::class, 'update'])->middleware(['auth:api','role:admin']);
    Route::delete('/{id}', [BooksController::class, 'destroy'])->middleware(['auth:api','role:admin']);

});


//Users routes

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index'])->middleware(['auth:api','role:admin']);
    Route::post('/', [UserController::class, 'store'])->middleware(['auth:api','role:user|admin']);
    Route::get('/{id}', [UserController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/activate/{id}',[UserController::class, 'activeUser'])->middleware(['auth:api','role:admin|reviewer']);
    Route::patch('/{id}', [UserController::class, 'update'])->middleware(['auth:api','role:user|admin']);
    Route::delete('/{id}', [UserController::class, 'destroy'])->middleware(['auth:api' ,'role:user|admin']);
    Route::get('/list/un-active', [UserController::class, 'listUnactiveUser'])->middleware(['auth:api' ,'role:user|admin']);
    Route::get('/list/un-active-reviwers-auditors', [UserController::class, 'listUnactiveReviwers'])->middleware(['auth:api' ,'role:user|admin']);
    Route::post('/upload-pdf',[UserController::class, 'uploadPdf'])->middleware((['auth:api']));
});


//thesis routes
Route::group(['prefix' => 'thesises'], function () {
    Route::get('/', [ThesisController::class, 'index']);
    Route::post('/', [ThesisController::class, 'store'])->middleware(['auth:api','role:user|admin']);
    Route::get('final-degree/{id}',[ThesisController::class,"finalDegree"])->middleware(['auth:api']);
    Route::get('status/{status}',[ThesisController::class,"getByStatus"])->middleware(['auth:api']);
    Route::get('/{id}', [ThesisController::class, 'show'])->middleware(['auth:api']);
    Route::patch('update-photo/{id}',[ThesisController::class,"updatePhoto"]);
    Route::patch('audit-thesis/{id}',[ThesisController::class,"auditThesis"]);
    Route::patch('/{id}', [ThesisController::class, 'update'])->middleware(['auth:api', 'role:user|admin']);
    Route::delete('/{id}', [ThesisController::class, 'destroy'])->middleware(['auth:api','role:user|admin']);
    Route::patch('add-degree/{id}',[ThesisController::class,"addDegree"])->middleware(['auth:api','role:admin|reviewer']);
    Route::post('upload/{id}',[ThesisController::class,"uploadPhoto"])->middleware(['auth:api']);

});

//questions routes
Route::group(['prefix' => 'questions'], function () {
    Route::get('/', [QuestionController::class, 'index']);
    Route::post('/', [QuestionController::class, 'store']);
    Route::get('status/{status}',[Question::class,"getByStatus"])->middleware(['auth:api']);
    Route::get('/{id}', [QuestionController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/{id}', [QuestionController::class, 'update'])->middleware(['auth:api', 'role:user|admin']);
    Route::delete('/{id}', [QuestionController::class, 'destroy'])->middleware(['auth:api','role:user|admin']);
    Route::patch('add-degree/{id}',[QuestionController::class,"addDegree"])->middleware(['auth:api','role:admin|reviewer']);
    Route::get('final-degree/{id}',[QuestionController::class,"finalDegree"])->middleware(['auth:api']);
});

//certificates routes
Route::group(['prefix' => 'certificates'], function () {
    Route::get('/', [CertificatesController::class, 'index'])->middleware(['auth:api','role:reviewer|admin']);
    Route::post('/', [CertificatesController::class, 'store'])->middleware(['auth:api','role:admin|reviewer']);
    Route::get('/{id}', [CertificatesController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/{id}', [CertificatesController::class, 'update'])->middleware(['auth:api','role:admin|reviewer']);
    Route::delete('/{id}', [CertificatesController::class, 'destroy'])->middleware(['auth:api','role:admin']);

});


//general informations routes
Route::group(['prefix' => 'general-informations'], function () {
    Route::get('/', [GeneralInformationsController::class, 'index'])->middleware(['auth:api','role:reviewer|admin']);
    Route::post('/', [GeneralInformationsController::class, 'store'])->middleware(['auth:api','role:user|admin']);


    Route::get('/user_book_id/{user_book_id}', [GeneralInformationsController::class, 'GetByUserBookId'])->middleware(['auth:api']);
    Route::get('/{id}', [GeneralInformationsController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/{id}', [GeneralInformationsController::class, 'update'])->middleware(['auth:api', 'role:user|admin']);
    Route::delete('/{id}', [GeneralInformationsController::class, 'destroy'])->middleware(['auth:api','role:user|admin']);
    Route::patch('add-degree/{id}',[GeneralInformationsController::class,"addDegree"])->middleware(['auth:api','role:admin|reviewer']);
    Route::get('final-degree/{id}',[GeneralInformationsController::class,"finalDegree"])->middleware(['auth:api']);
});


// fqa routes
Route::group(['prefix' => 'fqa'], function () {
    Route::get('/', [FQAController::class, 'index'])->middleware(['auth:api']);
    Route::post('/', [FQAController::class, 'store'])->middleware(['auth:api','role:admin']);
    Route::get('/{id}', [FQAController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/{id}', [FQAController::class, 'update'])->middleware(['auth:api','role:admin']);
    Route::delete('/{id}', [FQAController::class, 'destroy'])->middleware(['auth:api','role:admin']);
});



Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:api');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:api');
