<?php

use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::resource('task_statuses', TaskStatusController::class)->except('show');
Route::resource('labels', LabelController::class)->except('show');
Route::resource('tasks', TaskController::class);

require __DIR__ . '/auth.php';
