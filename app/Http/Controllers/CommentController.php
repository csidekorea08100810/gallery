<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Article;

use App\Comment;

use App\User;

use Validator;

class CommentController extends Controller
{
    function store($article_id, Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'name' => 'required',
    		//'secret' => 'required',
    		'content' => 'required|max:300'
		]);

		if ($validator->fails()) {
			return response()->json([
				'errors' => $validator->errors()->all()
			], 433);
		}

		$comment = new Comment;
		$comment->article_id = $article_id;
		$comment->name = $request->name;
		$content = $request->content;
		$comment->secret = false;
		$comment->deleted = false;
		$comment->user_id = auth()->user()->id;
		$comment->content = $content;

		$comment->save();

		return view('comment/_comment', [
			'comment' => $comment
		]);
    }

    function destroy($article_id, $id) 
    { 
    	$comment = Comment::find($id);
    	$comment->deleted = true;
    	$comment->save();
    }
}
