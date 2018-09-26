<?php
use App\User;
use App\Book;
use App\Note;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Books as BookResource;
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

Route::get('/books', function () {
    return !Auth::check() ? abort(404) : User::find(Auth::id())->books;
})->name('Books');

Route::post('/books', function (Request $request) {
    return User::find(Auth::id())->books()->create(
        [
            'name'=> $request->input('name'),
            'description'=> $request->input('description','')
        ]
    );
})->name('CreateBook');

Route::get('/book/{id}', function($id){
    $book = Book::find($id);
    if((Auth::user() && $book->user_id == Auth::id()) || $book->is_public)
        return $book;
    return abort(404);
})->name('GetBook');

Route::put('/book/{id}', function($id, Request $request){
    $book = Book::find($id);
    if($book->user_id != Auth::id())return abort(404);
    $modifyDate = array();
    $markdown = $request->input('markdown', false);
    $isPublic = $request->input('isPublic', false);
    if($markdown) $modifyDate['markdown'] = $markdown;
    if($isPublic) $modifyDate['is_public'] = ($isPublic == 'public') ? true : false;
    return array($modifyDate,$book->update($modifyDate));
})->name('UpdateBook');


