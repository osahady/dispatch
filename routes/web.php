<?php

use App\Models\User;
use App\Jobs\ReconcileAccount;
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

Route::get('/', function (Filesystem $file) {
    $pipeline = app(Pipeline::class);

    $pipeline->send('hello freaking world')
             ->through([
                function ($string, $next){
                    $string = ucwords($string);

                    return $next($string);
                },
                 function ($string, $next){
                    $string = str_ireplace('freaking', '', $string);

                    return $next($string);
                },
                ReconcileAccount::class

             ])
             ->then(function ($string){
                dump($string);
             });
    return 'done';
    return view('welcome');
});