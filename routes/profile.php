<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/{id}', [UserController::class, 'userProfileById']);
