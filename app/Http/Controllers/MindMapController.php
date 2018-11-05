<?php

namespace App\Http\Controllers;
use App\User;
use App\Book;
use App\MindMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MindMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return !Auth::check() ? abort(404) : User::find(Auth::id())->mindmaps;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        return User::find(Auth::id())->mindmaps()->create(
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
        $mindmap = MindMap::find($id);
        if((Auth::user() && $mindmap->user_id == Auth::id()) || $mindmap->is_public)
            return $mindmap;
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
        $mindmap = MindMap::find($id);
        if($mindmap->user_id != Auth::id())return abort(404);
        $data = $request->input('data', false);
        return array($mindmap->update($data));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $mindmap = MindMap::find($id);
        if($mindmap->user_id != Auth::id())return abort(404);
        if($mindmap->delete()){
            return $mindmap->delete();
        }else{
            return abort(404);
        }
    }
}
