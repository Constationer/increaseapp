<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProposalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//Dashboard
Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});
//Members
Route::prefix('member')->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('member.index');
    Route::get('/create', [MemberController::class, 'create'])->name('member.create');
    Route::get('/getData', [MemberController::class, 'getData'])->name('member.getData');
    Route::post('/store', [MemberController::class, 'store'])->name('member.store');
    Route::delete('/{id}', [MemberController::class, 'destroy'])->name('member.delete');
    Route::get('/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/{id}', [MemberController::class, 'update'])->name('member.update');
});
//Members
Route::prefix('payment')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::get('/getData', [PaymentController::class, 'getData'])->name('payment.getData');
    Route::post('/store', [PaymentController::class, 'store'])->name('payment.store');
    Route::put('/{id}/approve', [PaymentController::class, 'approve'])->name('payment.approve');
    Route::put('/{id}/reject', [PaymentController::class, 'reject'])->name('payment.reject');
});
//Proposal
Route::prefix('proposal')->group(function () {
    Route::get('/', [ProposalController::class, 'index'])->name('proposal.index');
    Route::get('/create', [ProposalController::class, 'create'])->name('proposal.create');
    Route::get('/getData', [ProposalController::class, 'getData'])->name('proposal.getData');
    Route::post('/store', [ProposalController::class, 'store'])->name('proposal.store');
    Route::delete('/{id}', [ProposalController::class, 'destroy'])->name('proposal.delete');
    Route::get('/{id}/edit', [ProposalController::class, 'edit'])->name('proposal.edit');
    Route::put('/{id}', [ProposalController::class, 'update'])->name('proposal.update');
});
//Announcement
Route::prefix('announcement')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('announcement.index');
    Route::get('/create', [AnnouncementController::class, 'create'])->name('announcement.create');
    Route::get('/getData', [AnnouncementController::class, 'getData'])->name('announcement.getData');
    Route::post('/store', [AnnouncementController::class, 'store'])->name('announcement.store');
    Route::delete('/{id}', [AnnouncementController::class, 'destroy'])->name('announcement.delete');
    Route::get('/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcement.edit');
    Route::put('/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');
});

Auth::routes();

Route::get('/logout', [DashboardController::class, 'logout'])->name('logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
