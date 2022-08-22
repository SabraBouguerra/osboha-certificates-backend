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



 //users routes

    Route::group(['prefix' => 'userbook'], function () {
        Route::get('/', [UserBookController::class, 'index'])->middleware(['auth:api','role:admin|reviewer']);
        Route::post('/', [UserBookController::class, 'store'])->middleware(['auth:api','userBook']);
        Route::get('/{id}', [UserBookController::class, 'show'])->middleware(['auth:api']);
        Route::patch('/', [UserBookController::class, 'update'])->middleware(['auth:api','role:admin|reviewer']);
        Route::delete('/', [UserBookController::class, 'delete'])->middleware(['auth:api','role:admin|reviewer']);

    });

// Books routes
Route::group(['prefix' => 'books'], function () {
    Route::get('/', [BooksController::class, 'index'])->middleware(['auth:api']);
    Route::post('/', [BooksController::class, 'store'])->middleware(['auth:api', 'role:admin']);
    Route::get('/{id}', [BooksController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/', [BooksController::class, 'update'])->middleware(['auth:api','role:admin']);
    Route::delete('/', [BooksController::class, 'delete'])->middleware(['auth:api','role:admin']);

});


//Users routes

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store'])->middleware(['auth:api','role:user|admin']);
    Route::get('/{id}', [UserController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/', [UserController::class, 'update'])->middleware(['auth:api','role:user|admin']);
    Route::delete('/', [UserController::class, 'delete'])->middleware(['auth:api' ,'role:user|admin']);
});


//thesis routes
Route::group(['prefix' => 'thesises'], function () {
    Route::get('/', [ThesisController::class, 'index']);
    Route::post('/', [ThesisController::class, 'store'])->middleware(['auth:api','role:user|admin']);
    Route::get('/{id}', [ThesisController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/', [ThesisController::class, 'update'])->middleware(['auth:api', 'role:user|admin']);
    Route::delete('/', [ThesisController::class, 'delete'])->middleware(['auth:api','role:user|admin']);
    Route::patch('add-degree/{id}',[ThesisController::class,"addDegree"])->middleware(['auth:api','role:admin|reviewer']);
    Route::get('final-degree/{id}',[ThesisController::class,"finalDegree"])->middleware(['auth:api']);
    Route::post('upload/{id}',[ThesisController::class,"uploadPhoto"])->middleware(['auth:api']);
    Route::patch('update-photo/{id}',[ThesisController::class,"updatePhoto"]);
});

//questions routes
Route::group(['prefix' => 'questions'], function () {
    Route::get('/', [QuestionController::class, 'index'])->middleware(['auth:api','role:reviewer|admin']);
    Route::post('/', [QuestionController::class, 'store'])->middleware(['auth:api','role:user|admin']);
    Route::get('/{id}', [QuestionController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/', [QuestionController::class, 'update'])->middleware(['auth:api', 'role:user|admin']);
    Route::delete('/', [QuestionController::class, 'delete'])->middleware(['auth:api','role:user|admin']);
    Route::patch('add-degree/{id}',[QuestionController::class,"addDegree"])->middleware(['auth:api','role:admin|reviewer']);
    Route::get('final-degree/{id}',[QuestionController::class,"finalDegree"])->middleware(['auth:api']);
});

//certificates routes
Route::group(['prefix' => 'certificates'], function () {
    Route::get('/', [CertificatesController::class, 'index'])->middleware(['auth:api','role:reviewer|admin']);
    Route::post('/', [CertificatesController::class, 'store'])->middleware(['auth:api','role:admin|reviewer']);
    Route::get('/{id}', [CertificatesController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/', [CertificatesController::class, 'update'])->middleware(['auth:api','role:admin|reviewer']);
    Route::delete('/', [CertificatesController::class, 'delete'])->middleware(['auth:api','role:admin']);

});


//general informations routes
Route::group(['prefix' => 'general-informations'], function () {
    Route::get('/', [GeneralInformationsController::class, 'index'])->middleware(['auth:api','role:reviewer|admin']);
    Route::post('/', [GeneralInformationsController::class, 'store'])->middleware(['auth:api','role:user|admin']);
    Route::get('/{id}', [GeneralInformationsController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/', [GeneralInformationsController::class, 'update'])->middleware(['auth:api', 'role:user|admin']);
    Route::delete('/', [GeneralInformationsController::class, 'delete'])->middleware(['auth:api','role:user|admin']);
    Route::patch('add-degree/{id}',[GeneralInformationsController::class,"addDegree"])->middleware(['auth:api','role:admin|reviewer']);
    Route::get('final-degree/{id}',[GeneralInformationsController::class,"finalDegree"])->middleware(['auth:api']);
});


//fqa routes
Route::group(['prefix' => 'fqa'], function () {
    Route::get('/', [FQAController::class, 'index'])->middleware(['auth:api']);
    Route::post('/', [FQAController::class, 'store'])->middleware(['auth:api','role:admin']);
    Route::get('/{id}', [FQAController::class, 'show'])->middleware(['auth:api']);
    Route::patch('/', [FQAController::class, 'update'])->middleware(['auth:api','role:admin']);
    Route::delete('/', [FQAController::class, 'delete'])->middleware(['auth:api','role:admin']);
});
