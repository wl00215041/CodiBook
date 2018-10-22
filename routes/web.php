<?php
use App\User;
use App\Book;
use App\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

Route::get('/public', function(){
    return view('public');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


Route::post('/books', function (Request $request) {
    
})->name('CreateBook');

Route::resource('books', 'BookController');
Route::resource('mindmaps', 'MindMapController');
