@extends('layouts/gallery')
@section('title')
@endsection
@section('content')
<div class="wrap-index wrap-artist">
	<h2 class="h2-search">키워드 '<span class="point">{{ $query }}</span>'로 검색한 결과입니다.</h2>
	@if (count($tag_articles) == 0 && count($articles) == 0 && count($users) == 0)
		<h2 class="none">
			<img src="{{ url('/images/smile.png') }}" alt="">
			키워드 '<span class="point">{{ $query }}</span>'에 대한 검색 결과가 없습니다.<br>
			단어의 철자가 정확한지 확인해 보세요.<br>
			검색어의 단어 수를 줄이거나 더 일반적인 검색어로 다시 검색해 보세요.
		</h2>
	@endif
	@if (count($tag_articles) > 0)
		<h3>
			태그
			@if (count($r_tag_articles) > 8 && !isset($_GET['all']))
				<p>검색 결과가 더 남아있습니다. 더 보시겠습니까?<a href="{{ url('/search?search_query='.$_GET['search_query'].'&all=tag') }}">검색결과 더보기</a></p>
			@endif
		</h3>
		<ul class="ul-like-articles">
			@foreach($tag_articles->all() as $article)
				<li class="li-data">
					<a href="{{ url('/articles/'.$article->id) }}">
						<div class="box-image">
							<img src="{{ url('/uploads/'.$article->image) }}" alt="">
						</div>
						<div class="box-tag">
							@foreach( explode(',',$article->tag) as $tag)
								<span class="tag">#{{ $tag }}</span>
							@endforeach
						</div>
						<div class="box-info">
							<div class="box-profile-image">
								@if ($article->user->image != '')
									<img src="{{ url('/uploads/'.$article->user->image) }}" alt="">
								@else 
									<img src="{{ url('/images/profile2.png') }}" alt="">
								@endif
							</div>
							<p class="title">{{ $article->title }}</p>
							<p class="writer">by. {{ $article->user->name }}</p>
						</div>
						<div class="box-etc">
							<ul>
								<li>
									<span class="icon"><i class="fa fa-eye" aria-hidden="true"></i></span>
									<span class="count">{!! count(array_filter(explode(',',$article->hit))) !!}</span>
								</li>
								<li>
									<span class="icon"><i class="fa fa-heart" aria-hidden="true"></i></span>
									<span class="count">{!! count(array_filter(explode(',',$article->like))) !!}</span>
								</li>
								<li>
									<span class="icon"><i class="fa fa-comment" aria-hidden="true"></i></span>
									<span class="count">{!! count($article->comments->where('deleted', 0)) !!}</span>
								</li>
							</ul>
						</div>
					</a>
				</li>
			@endforeach
		</ul>
		@if (isset($_GET['all']))
			{!! $tag_articles->links() !!}
		@endif
	@endif
	@if (count($articles) > 0)
		<h3>
			게시물
			@if (count($r_articles) > 8 && !isset($_GET['all']))
				<p>검색 결과가 더 남아있습니다. 더 보시겠습니까?<a href="{{ url('/search?search_query='.$_GET['search_query'].'&all=article') }}">검색결과 더보기</a></p>
			@endif
		</h3>
		<ul class="ul-like-articles">
			@foreach($articles->all() as $article)
				<li class="li-data">
					<a href="{{ url('/articles/'.$article->id) }}">
						<div class="box-image">
							<img src="{{ url('/uploads/'.$article->image) }}" alt="">
						</div>
						<div class="box-info">
							<div class="box-profile-image">
								@if ($article->user->image != '')
									<img src="{{ url('/uploads/'.$article->user->image) }}" alt="">
								@else 
									<img src="{{ url('/images/profile2.png') }}" alt="">
								@endif
							</div>
							<p class="title">{{ $article->title }}</p>
							<p class="writer">by. {{ $article->user->name }}</p>
						</div>
						<div class="box-etc">
							<ul>
								<li>
									<span class="icon"><i class="fa fa-eye" aria-hidden="true"></i></span>
									<span class="count">{!! count(array_filter(explode(',',$article->hit))) !!}</span>
								</li>
								<li>
									<span class="icon"><i class="fa fa-heart" aria-hidden="true"></i></span>
									<span class="count">{!! count(array_filter(explode(',',$article->like))) !!}</span>
								</li>
								<li>
									<span class="icon"><i class="fa fa-comment" aria-hidden="true"></i></span>
									<span class="count">{!! count($article->comments->where('deleted', 0)) !!}</span>
								</li>
							</ul>
						</div>
					</a>
				</li>
			@endforeach
		</ul>
		@if (isset($_GET['all']))
			{!! $articles->links() !!}
		@endif
	@endif
	@if (count($users) > 0)
		<h3>
			아티스트
			@if (count($r_users) > 10 && !isset($_GET['all']))
				<p>검색 결과가 더 남아있습니다. 더 보시겠습니까?<a href="{{ url('/search?search_query='.$_GET['search_query'].'&all=user') }}">검색결과 더보기</a></p>
			@endif
		</h3>
		<ul class="ul-follow-users">
			@foreach($users as $user)
				<li class="li-data">
					<a href="{{ url('/userpage/'.$user->id.'?category=works') }}">
						<div class="box-profile">
							<div class="box-image">
								@if ($user->image != '')
									<img src="{{ url('/uploads/'.$user->image) }}" alt="">
								@else
									<img src="{{ url('/images/profile2.png') }}" alt="">
								@endif
							</div>	
							<p class="name">{{ $user->name }}</p>
						</div>
					</a>
					<div class="box-etc">
						<ul>
							<li>
								<span class="icon"><i class="fa fa-file-image-o" aria-hidden="true"></i></span>
								<span class="count">{!! count($user->articles) !!}</span>
							</li>
							<li>
								<span class="icon"><i class="fa fa-heart" aria-hidden="true"></i></span>
								<span class="count">{{ $user->liked }}</span>
							</li>
							<li>
								<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
								<span class="count">{!! count(array_filter(explode(',',$user->follower))) !!}</span>
							</li>
						</ul>
					</div>

					<div class="box-article">
						<ul>
							@foreach($user->articles->where('deleted', 0)->take(8) as $article)
								<li><a href="{{ url('/articles/'.$article->id) }}"><img src="{{ url('/uploads/'.$article->image) }}" alt="{{ $article->title }}"></a></li>
							@endforeach
						</ul>
					</div>

					<div class="box-act">
						@if (!auth()->guest())
							@if (in_array('*'.$user->id.'*', explode(',',auth()->user()->follow)))
								<a class="btn-follow btn-already-follow" data-id="{{ $user->id }}" data-cancel-url="{{ url('/followcancel') }}" data-url="{{ url('/follow') }}" data-csrf-token="{{ csrf_token() }}" href="#"><i class="fa fa-star" aria-hidden="true"></i> <span>현재 팔로우 중입니다.</span></a>
							@else
								@if ($user->id == auth()->user()->id)
									<a class="btn-follow disabled" href="#"><span>본인입니다.</span></a>
								@else
									<a class="btn-follow" data-id="{{ $user->id }}" data-cancel-url="{{ url('/followcancel') }}" data-url="{{ url('/follow') }}" data-csrf-token="{{ csrf_token() }}" href="#"><i class="fa fa-star" aria-hidden="true"></i> <span>팔로우</span></a>
								@endif
							@endif
						@else
							<a class="btn-follow" href="{{ url('/auth/login') }}"><i class="fa fa-star" aria-hidden="true"></i> <span>팔로우</span></a>
						@endif
					</div>
				</li>
			@endforeach
		</ul>
		@if (isset($_GET['all']))
			{!! $users->links() !!}
		@endif
	@endif
</div>
@endsection