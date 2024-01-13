<?php

use App\Models\User;
use App\Jobs\ReconcileAccount;
use Illuminate\Bus\Dispatcher;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Bus;

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
    $user = User::find(1);
    $job = new ReconcileAccount($user);

    Bus::dispatch($job);


    return 'done';
    // return view('welcome');
});