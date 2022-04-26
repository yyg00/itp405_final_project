<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use Auth;
class CommentController extends Controller
{
    public function getComments($id)
    {
        $comments = Comment::with(['user'])->where('recipe_id', '=', $id)->orderBy('created_at', 'desc')->get();
        return $comments;
    }

    public function store(Request $request, $id)
    {
        $this->authorize('create', Comment::class);
        $user = Auth::user();
        $request->validate([
            'comment_body' => 'required|max:256',
        ]);
        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->comment_body = $request->input('comment_body');
        $comment->recipe_id = $id;
        $comment->save();
        return redirect()
                ->route('recipe.show', [
                    'id' => $id,
                ])
                ->with('success', "Comment successfully added.");
    }
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $this->authorize('update', $comment);
        $request->validate([
            'edited_comment_body_'.$id => 'required|max:256',
        ]);
        $comment->comment_body = $request->input('edited_comment_body_'.$id);
        $comment->save();
        return redirect()
        ->route('recipe.show', [
            'id' => $comment->recipe_id,
        ])
        ->with('success', "Comment successfully edited.");
    }
    public function delete(Request $request, $id)
    {
        $comment = Comment::find($id);
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect()
        ->route('recipe.show', [
            'id' => $comment->recipe_id,
        ])
        ->with('success', "Comment successfully deleted.");
    }
}
