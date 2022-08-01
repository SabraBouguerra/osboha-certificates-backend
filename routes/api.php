<?php

use App\Http\Controllers\API\UserBookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BooksController;
use App\Http\Controllers\API\CertificatesController;
use App\Http\Controllers\API\GeneralInformationsController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\ThesisController;
use App\Http\Controllers\API\UserContoller;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);

Route::resource('books', BooksController::class);
Route::resource('userbook', UserBookController::class);
Route::resource('users', UserContoller::class);
Route::resource('thesises', ThesisController::class);
Route::resource('questions', QuestionController::class);
Route::resource('certificates', CertificatesController::class);
Route::resource('general-informations', GeneralInformationsController::class);
Route::patch('general-informations/add-degree/{id}',[GeneralInformationsController::class,"addDegree"]);
Route::get('general-informations/final-degree/{id}',[GeneralInformationsController::class,"finalDegree"]);
Route::patch('thesises/add-degree/{id}',[ThesisController::class,"addDegree"]);
Route::get('thesises/final-degree/{id}',[ThesisController::class,"finalDegree"]);
Route::patch('questions/add-degree/{id}',[QuestionController::class,"addDegree"]);
Route::get('questions/final-degree/{id}',[QuestionController::class,"finalDegree"]);



