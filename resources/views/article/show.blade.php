@extends('layouts/gallery')
@section('title')
	:: {{ $article->title }}
@endsection

@section('article_title')
{{ $article->title }}
@endsection

@section('article_content')
{!! trim(strip_tags(str_replace('src="upload/', 'src="/editor/upload/', $article->body))) !!}
@endsection


@section('content')
<div class="wrap-show cf">
	@foreach($errors->all() as $error)
		{{ $error }}
	@endforeach
	@include('modal/modal')
	<div class="box-show" data-csrf-token="{{ csrf_token() }}" data-url="{{ url('/articles/'.$article->id.'/more') }}">
		<div class="box-header">
			<h2>{{ $article->title }}</h2>
			<span class="info">
				@if ($article->category == 0)
					카테고리A
				@elseif ($article->category == 1)
					카테고리B
				@elseif ($article->category == 2)
					카테고리C
				@elseif ($article->category == 3)
					카테고리D
				@endif
				/
				{!! substr(str_replace('-', '. ', $article->created_at),0,18) !!}
				<br>
				조회수 : {!! count(explode(',',$article->hit)) !!}
			</span>
		</div>
		<div class="content">
			{!! str_replace('src="upload/', 'src="/editor/upload/', $article->body) !!}
		</div>
		<div class="box-act">
			<div class="box-tag">
				@foreach(explode(',', $article->tag) as $tag)
					<a href="{{ url('/search?search_query='.$tag) }}">#{{ $tag }}</a>
				@endforeach
			</div>
			<div class="box-left">
				<div class="box-like">
					@if (auth()->guest())
						<a class="btn-like" href="#" data-name=""> 
							<i class="fa fa-heart-o" aria-hidden="true"></i> 
							<i class="fa fa-heart" aria-hidden="true"></i>
						</a>
						<span class="like-count">{{ count(array_filter(explode(',',$article->like))) }}</span>
						<span class="like-txt"> 좋아요를 누르시면 작가님께 큰 힘이 됩니다.</span>	
					@else
						@if (!in_array('*'.auth()->user()->name.'*', explode(',',$article->like)))
							<a class="btn-like" href="{{ url('/articles/'.$article->id.'/like') }}" data-skip-pjax data-name="{{ auth()->user()->name }}" data-csrf-token="{{ csrf_token() }}"> 
								<i class="fa fa-heart-o" aria-hidden="true"></i> 
								<i class="fa fa-heart" aria-hidden="true"></i>
							</a>
							<span class="like-count">{{ count(array_filter(explode(',',$article->like))) }}</span>
							<span class="like-txt"> 좋아요를 누르시면 작가님께 큰 힘이 됩니다.</span>	
						@else
							<span class="already-like"> <i class="fa fa-heart" aria-hidden="true"></i> </span>
							<span class="like-count">{{ count(array_filter(explode(',',$article->like))) }}</span>
							<span class="liked-txt">이미 좋아요를 누르셨습니다.</span>	
						@endif
					@endif
					
				</div>	
			</div>
			<div class="box-menu-right">
				@if ($article->creative == 1)
					<div class="box-copyright">
						Copyright © <span class="writer">{{ $article->writer_key }}</span> All Rights Reserved.
					</div>
				@else
					<div class="box-ccl">
						<img src="{{ url('/images/ccl1on.png') }}" alt="">
						<img src="{{ url('/images/ccl2on.png') }}" alt="">
						@if ($article->profit == 1)
							<img src="{{ url('/images/ccl3on.png') }}" alt="">
						@endif

						@if ($article->share == 2)
							<img src="{{ url('/images/ccl4on.png') }}" alt="">
						@elseif ($article->share == 1)
							<img src="{{ url('/images/ccl5on.png') }}" alt="">
						@endif
					</div>
				@endif
				<div class="box-share">
					<a class="btn-share btn-fb" href="#" onclick="window.open('http://www.facebook.com/sharer/sharer.php?u={{ URL::current() }}', '_blank', 'width=550 height=400')"><i class="fa fa-facebook" aria-hidden="true"></i></a>
					<a class="btn-share btn-fb" href="#" onclick="window.open('https://twitter.com/intent/tweet?text=TEXT&url={{ URL::current() }}', '_blank', 'width=550 height=400')"><i class="fa fa-twitter" aria-hidden="true"></i></a>
				</div>
				@if(auth()->guest())

				@elseif ($article->writer_key == auth()->user()->name)
					<a class="btn-list" href="{{ url('/articles/'.$article->id.'/edit') }}">수정</a>
					<a class="btn-list btn-delete" href="#" data-id="{{ $article->id }}" data-url="{{ url('/articles/'.$article->id) }}" data-csrf-token="{{ csrf_token() }}">삭제</a>
				@else
					<a class="btn-list btn-article-report" data-type="article_report" data-reporter-id="{{ auth()->user()->id }}" data-report-content-id="{{ $article->id }}" data-skip-pjax href="#">신고</a>
				@endif
				<a class="btn-list" href="{{ url('/works') }}">목록</a>
			</div>
		</div>
		<div class="box-delete-complete">
			<img src="{{ url('/images/smile.png') }}" alt="">
			<p>게시글이 정상적으로 삭제 되었습니다.</p>
			<a class="btn-list" href="{{ url('/works') }}">게시글 목록보기</a>
		</div>

		<div class="box-comment">
			<h3>댓글을 남겨주세요.</h3>
			<div class="box-write">
				<form id="form-comment" action="{{ url('/articles/'.$article->id.'/comments') }}" method="post" {{ auth()->guest() ? 'disabled' : '' }}>
					<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
					<input type="hidden" name="mention" value="">
					@if (!auth()->guest())
						<input type="hidden" name="name" value="{{ auth()->user()->name }}">
					@endif
					<table>
						<tbody>
							<tr>
								<td>
									<div class="box-profile">
										@if(auth()->guest())
											<img src="{{ url('/images/profile2.png') }}" alt="">
										@elseif(auth()->user()->image == '')
											<img src="{{ url('/images/profile2.png') }}" alt="">
										@else 
											<img src="{{ url('/uploads/'.auth()->user()->image) }}" alt="">
										@endif
									</div>
								</td>
								<td>
									<textarea name="content" id="multi-users" cols="30" rows="10" placeholder="{{ auth()->guest() ? '회원만 댓글을 작성할 수 있습니다. 로그인 해주세요.' : '댓글을 남겨주세요. 타인을 향한 욕설이나 비방의 글은 제재를 당할 수 있습니다.' }}" {{ auth()->guest() ? 'disabled' : '' }}></textarea>	
									<span class="desc">'@'를 입력하면 멘션할 수 있습니다.</span>
								</td>
								<td>
									<button type="submit" class="btn-submit {{ auth()->guest() ? 'disabled' : '' }}" {{ auth()->guest() ? 'disabled' : '' }}>댓글 쓰기</button>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div class="box-data">
				<ul class="comments">
					@each('comment/_comment', $article->comments->reverse(), 'comment')
				</ul>
			</div>
			@include('comment.mention')
		</div>
	</div>
	<div class="box-remote">
		<h3>작가의 프로필</h3>
		<div class="box-profile cf">
			<div class="image">
				<a href="{{ url('/userpage/'.$article->user->id) }}">
					@if($article->user->image == '')
						<img src="{{ url('/images/profile2.png') }}" alt="{{ $article->user->name }}">
					@else 
						<img src="{{ url('/uploads/'.$article->user->image) }}" alt="{{ $article->user->name }}">
					@endif
				</a>
			</div>
			<span class="job">Artist</span>
			<span class="id">{{ $article->writer_key }}</span>
			<p class="introduce">
				@if($article->user->intro != '')
					{{ $article->user->intro }}
				@else
					자기소개가 없습니다.
				@endif
			</p>
			@if (!auth()->guest())
				@if ($article->user->id != auth()->user()->id)
					@if (in_array('*'.$article->user->id.'*', explode(',',auth()->user()->follow)))
						<a class="btn-follow btn-already-follow" data-id="{{ $article->user->id }}" data-cancel-url="{{ url('/followcancel') }}" data-url="{{ url('/follow') }}" data-csrf-token="{{ csrf_token() }}" href="#"><i class="fa fa-star" aria-hidden="true"></i> <span>현재 팔로우 중입니다.</span></a>
					@else
						<a class="btn-follow" data-id="{{ $article->user->id }}" data-cancel-url="{{ url('/followcancel') }}" data-url="{{ url('/follow') }}" data-csrf-token="{{ csrf_token() }}" href="#"><i class="fa fa-star" aria-hidden="true"></i> <span>팔로우</span></a>
					@endif
				@endif
			@endif 
		</div>
		@if (count($writer_articles))
			<div class="box-other-article">
				<h4>작가의 다른 작품들</h4>
				<ul class="ul-article">
					@foreach($writer_articles as $article)
						<li class="easing">
							<a href="{{ url('/articles/'.$article->id) }}">
								<img src="{{ url('/uploads/'.$article->image) }}" alt="">	
							</a>
						</li>
					@endforeach
				</ul>
			</div>
		@endif
	</div>
	<div class="box-relate-article">
		<h2>위와 관련된 작품들입니다.</h2>
		<ul class="main-article">
			@each('article.related_article', $related_articles->all(), 'article')
		</ul>
	</div>
</div>
@endsection