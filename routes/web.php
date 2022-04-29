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

Route::get( '/', function () {
    return view( 'homepage' );
} );

Route::get( 'candidates-list', [CandidateController::class, 'index'] );
Route::post( 'candidates-contact', [CandidateController::class, 'contact'] );
Route::post( 'candidates-hire', [CandidateController::class, 'hire'] );
