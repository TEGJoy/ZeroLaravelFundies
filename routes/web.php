<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\DashboardController;
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



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('tournaments', TournamentController::class);
Route::get('/tournaments/{tournament}/join', [WaitingListController::class, 'join'])->name('tournaments.join');
Route::post('/tournaments/{tournament}/joinHandler', [WaitingListController::class, 'joinHandler'])->name('tournaments.joinHandler');
Route::put('/tournaments/{tournament}/setState',[TournamentController::class, 'setState'])->name('tournaments.setState');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/showAll', [DashboardController::class, 'showAll'])->name('dashboard.showAll');
Route::get('/waitinglist', [WaitingListController::class, 'index'])->name('waitinglist.index');
Route::delete('waitinglist/{waitinglist}', [WaitingListController::class, 'destroy'])->name('waitinglist.destroy');
Route::get('/waitinglist/{waitinglist}', [WaitingListController::class, 'show'])->name('waitinglist.show');
