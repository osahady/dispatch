<?php

use App\Models\User;
use App\Jobs\ReconcileAccount;
use Illuminate\Bus\Dispatcher;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

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

    resolve(Dispatcher::class)->dispatch($job);

    $pipeline = new Pipeline(app());
    $pipeline->send($job)->through([])->then(function () use ($job) {
        logger('The job is finished: ' . now());
    });


    return 'done';
    // return view('welcome');
});