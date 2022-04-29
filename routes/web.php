<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::view( '/', 'homepage' );

Route::controller( CandidateController::class )->prefix( 'candidates' )->group( function () {
    Route::get( '/list', 'index' );
    Route::post( '/contact', 'contact' );
    Route::post( '/hire', 'hire' );
} );
