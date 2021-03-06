<?php

namespace App\Http\Controllers;
use App\User;
use App\Book;
use App\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPHtmlParser\Dom;
use App\Utils\MarkdownTableOfContents;

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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return User::find(Auth::id())->books()->create(
            [
                'name'=> $request->input('name'),
                'description'=> $request->input('description','')
            ]
        );
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
        $data = $request->input('data', false);
        return array($book->update($data));
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
            return $book->delete();
        }else{
            return abort(404);
        }
    }

    public function getTOC(Request $request)
    {
        $dom = new Dom;
        $dom->setOptions([
            'preserveLineBreaks' => true, // Set a global option to enable strict html parsing.
        ]);
        $url = $request->input('url');
        $content = file_get_contents($url);
        $dom->load($content);
        //$dom->loadFromUrl($url);
        $markdown = $dom->find('#doc')[0]->text;

        $toc = new MarkdownTableOfContents($markdown, $url);

        return $toc->process();

    }
}
