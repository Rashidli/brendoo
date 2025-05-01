<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:list-comments|create-comments|edit-comments|delete-comments', ['only' => ['index','show']]);
        $this->middleware('permission:create-comments', ['only' => ['create','store']]);
        $this->middleware('permission:edit-comments', ['only' => ['edit']]);
        $this->middleware('permission:delete-comments', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::query()->orderByDesc('created_at')->with('customer','product')->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->is_accept = !$comment->is_accept;
        $comment->save();
        return redirect()->back()->with('message',$comment->is_accept ? 'Qəbul edildi' : 'Rədd edildi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('message','Komment silindi');
    }
}
