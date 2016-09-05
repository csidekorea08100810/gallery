@if ($comment->deleted == 0)
	<li class="li-data comment">
		<div class="box-writer">
			<span class="writer">{{ $comment->name }}</span>
			<span class="reg-date">{{ $comment->created_at }}</span>
		</div>
		<div class="comment-content">
			<?php $content = e($comment->content); ?>
			@foreach (array_combine(array_filter(explode(',',$comment->mention)), array_filter(explode(',',$comment->mention_id))) as $mention => $mention_id)
				<?php $content = str_replace('@'.$mention, "<a class='mention' href='".url('/userpage/'.$mention_id)."'>$mention</a>", $content); ?>
			@endforeach 
			{!! nl2br($content) !!}
			<div class="box-report">
				@if(!auth()->guest())
					@if($comment->name != auth()->user()->name)
						<a class="btn-reply" href="#">답글 달기</a>
						<a class="btn-comment-report" href="#" data-type="comment_report" data-report-content-id="{{ $comment->id }}" data-reporter-id="{{ auth()->user()->id }}">신고</a>
					@else
						<a href="{{ url('/articles/'.$comment->article_id.'/comments/'.$comment->id) }}" class="btn-delete-comment" data-skip-pjax data-csrf-token="{{ csrf_token() }}" data-type="comment_delete_confirm">삭제</a>
					@endif
				@endif
			</div>
		<a class="profile" href="{{ url('/userpage/'.$comment->user->id) }}">
			@if ($comment->user->image == '')
				<img src="{{ url('/images/profile2.png') }}" alt="">
			@else 
				<img src="{{ url('/uploads/'.$comment->user->image) }}" alt="">
			@endif
		</a>
	</li>
@endif