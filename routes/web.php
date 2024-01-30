<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route for displaying the search form
Route::get('/', [ScrapeController::class, 'showScrapeForm'])->name('scrape.form');

// Route for handling the search request
Route::get('/scrape/result', [ScrapeController::class, 'scrape'])->name('scrape.result');
