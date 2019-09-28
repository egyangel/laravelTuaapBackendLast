<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Events\ApplicationUpdatedByUser;
use App\MyApp;
use Symfony\Component\Process\Process;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/slack', function () {
    $myApp = MyApp::find(1);
   // dd($myApp);
    //moveFiles
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $process = new Process(['dir']);
    } else {

    }
    dd();


    //  $process = new Process(['cp','','assets/img/logo-w.png','assets/img/logo-w.png']);
    $process->start();
    $process->wait();
    dump($process->getStatus());
    dump($process->getExitCode());
    dump($process->getErrorOutput());
    dd($process->getOutput());
   // event(new ApplicationUpdatedByUser($myApp));
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/myapp', 'MyAppController');
