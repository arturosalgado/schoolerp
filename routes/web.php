<?php

use App\Http\Controllers\CredentialsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/credentials/{school}/{student}', [CredentialsController::class, 'show'])
    ->name('credentials.show')
    ->middleware(['auth']);

// Credentials routes
Route::get('/credentials/{school}/{student}', [CredentialsController::class, 'show'])
    ->name('credentials.show')
    ->middleware(['auth']);

Route::post('/credentials/{school}/update-photo-position', [CredentialsController::class, 'updatePhotoPosition'])
    ->name('credentials.update-photo-position')
    ->middleware(['auth']);

Route::post('/credentials/{school}/update-text-position', [CredentialsController::class, 'updateTextPosition'])
    ->name('credentials.update-text-position')
    ->middleware(['auth']);

Route::post('/credentials/{school}/update-back-position', [CredentialsController::class, 'updateBackPosition'])
    ->name('credentials.update-back-position')
    ->middleware(['auth']);

Route::post('/credentials/{school}/reset-positions', [CredentialsController::class, 'resetAllPositions'])
    ->name('credentials.reset-positions')
    ->middleware(['auth']);


