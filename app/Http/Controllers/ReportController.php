<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Article;

use App\Comment;

use App\URL;

use App\User;

use Validator;

use App\Report;

class ReportController extends Controller
{
    function store(Request $request) {
    	$validator = Validator::make($request->all(), [
            'content' => 'required',
            'type' => 'required',
            'reporter_id' => 'required',
            'report_content_id' => 'required',
        ]);

        if ($validator->fails()) {
			return 'fail';        	
        } else {
        	$report = new Report;

	    	$report->type = $request->type;
	    	$report->report_content_id = $request->report_content_id;
	    	$report->reporter_id = $request->reporter_id;

	    	if ($report->type == 'comment_report') {
	    		$data = Comment::find($request->report_content_id);
	    	} else if ($report->type == 'article_report') {
	    		$data = Article::find($request->report_content_id);
	    	}

	    	$report->reported_id = $data->user_id;
	    	$report->content = $request->content;
	    	$report->save();

	    	return 'success';        	
        }
    }
}
