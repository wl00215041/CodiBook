<?php

namespace App\Http\Controllers;
use App\User;
use App\Book;
use App\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return !Auth::check() ? abort(404) : User::find(Auth::id())->books;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return User::find(Auth::id())->books()->create(
            [
                'name'=> $request->input('name'),
                'description'=> $request->input('description','')
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        if((Auth::user() && $book->user_id == Auth::id()) || $book->is_public)
            return $book;
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if($book->user_id != Auth::id())return abort(404);
        $modifyDate = array();
        $markdown = $request->input('markdown', false);
        $isPublic = $request->input('isPublic', false);
        $name = $request->input('name', false);
        $description = $request->input('description', false);
        if($markdown) $modifyDate['markdown'] = $markdown;
        if($isPublic) $modifyDate['is_public'] = ($isPublic == 'public') ? true : false;
        if($name) $modifyDate['name'] = $name;
        if($description) $modifyDate['description'] = $description;
        return array($modifyDate,$book->update($modifyDate));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        if($book->user_id != Auth::id())return abort(404);
        if($book->delete()){
            return Response::make("", 204);
        }else{
            return abort(404);
        }
    }
}
