<?php

use App\Models\User;
use App\Jobs\ReconcileAccount;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = User::first();

    //there is an error in laravel 10.3 version
    //this delay is not working
    ReconcileAccount::dispatch($user)->delay(5);
    return view('welcome');
});