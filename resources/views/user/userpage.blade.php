@extends('layouts/gallery')
@section('title')
:: {{ $user->name }}
@endsection
@section('content')
<div class="wrap-profile">
	<div class="box-profile">
		<div class="box-card">
			<div class="box-cover">
				@if ($user->image != '')
					<img src="{{ url('/uploads/'.$user->image) }}" alt="">
				@else
					<img src="{{ url('/images/profile2.png') }}" alt="">
				@endif
			</div>
			<div class="box-info">
				<p class="name">{{ $user->name }}</p>
				<p class="intro">
					@if ($user->intro != '')
						{{ $user->intro }}
					@else
						자기소개가 없습니다.
					@endif 
				</p>
			</div>
			<div class="box-act">
				@if (!auth()->guest())
					@if (in_array('*'.$user->id.'*', explode(',',auth()->user()->follow)))
						<a class="btn-follow btn-already-follow" data-id="{{ $user->id }}" data-cancel-url="{{ url('/followcancel') }}" data-url="{{ url('/follow') }}" data-csrf-token="{{ csrf_token() }}" href="#"><i class="fa fa-star" aria-hidden="true"></i> <span>현재 팔로우 중입니다.</span></a>
					@else
						<a class="btn-follow" data-id="{{ $user->id }}" data-cancel-url="{{ url('/followcancel') }}" data-url="{{ url('/follow') }}" data-csrf-token="{{ csrf_token() }}" href="#"><i class="fa fa-star" aria-hidden="true"></i> <span>팔로우</span></a>
					@endif
				@endif
			</div>
		</div>
	</div>
	<div class="box-sub-menu">
		<ul>
			@if ($category == '' || $category == 'works')
				<li class="on">
			@else
				<li>
			@endif
				<a href="{{ url('/userpage/'.$user->id.'?category=works') }}">
					<p class="name">작품</p>
					<p class="count">{{ $count_aritlces }}</p>
				</a>
			</li>
			@if ($category == 'likes')
				<li class="on">
			@else
				<li>
			@endif
				<a href="{{ url('/userpage/'.$user->id.'?category=likes') }}">
					<p class="name">좋아요</p>
					<p class="count">{{ $count_like }}</p>
				</a>
			</li>
			@if ($category == 'follow')
				<li class="on">
			@else
				<li>
			@endif
				<a href="{{ url('/userpage/'.$user->id.'?category=follow') }}">
					<p class="name">팔로우</p>
					<p class="count">{!! count(array_filter(explode(',',$user->follow))) !!}</p>
				</a>
			</li>
			@if ($category == 'follower')
				<li class="on">
			@else
				<li>
			@endif
				<a href="{{ url('/userpage/'.$user->id.'?category=follower') }}">
					<p class="name">팔로워</p>
					<p class="count">{!! count($followers) !!}</p>
				</a>
			</li>

		</ul>
	</div>
	<span id="bg" class="bg-profile" data-bg="{{ $user->image != '' ? url('/uploads/'.$user->image) : '' }}"></span>
</div>
<script>
	$(function(){
		var profileHeight = $('.wrap-profile').height();
		$('.wrap-mypage').css({'padding-top':profileHeight});

		var bgImg = $('#bg').data('bg');

		$('#bg').backgroundBlur({
		    imageURL : bgImg,
		    blurAmount : 50,
		    imageClass : 'bg-blur'
		});

	});
</script>
<div class="wrap-mypage">
	<div class="box-content">
		@if (count($articles) > 0)
			<div class="box-like-content">
				<h2>{{ $title }}</h2>
				<ul class="ul-like-articles">
					@foreach($articles as $article)
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
				{!! $articles->links() !!}
			</div>
		@endif
		<!-- 팔로워 / 팔로우 리스트 -->
		@if (count($users) > 0)
			<div class="box-like-content">
				<h2>{{ $title }}</h2>
				<ul class="ul-follow-users">
					@foreach($users as $user)
						<li class="li-data">
							@if(!auth()->guest()) 
								<a href="{{ $user->id == auth()->user()->id ? url('/mypage/'.$user->id.'?category=works') : url('/userpage/'.$user->id.'?category=works') }}">
							@else
								<a href="#">
							@endif
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
										<span class="count">{!! count($user->articles->where('deleted', 0)) !!}</span>
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
				{!! $users->links() !!}
			</div>
		@endif

		@if(isset($_GET['category']))
			@if(($_GET['category'] == '' || $_GET['category'] == 'works') && count($articles) == 0)
				<p class="none-article">
					<span><i class="fa fa-picture-o" aria-hidden="true"></i></span>
					작성한 작품이 없습니다.
				</p>
			@elseif($_GET['category'] == 'likes' && count($articles) == 0)
				<p class="none-article">
					<span><i class="fa fa-picture-o" aria-hidden="true"></i></span>
					좋아요한 작품이 없습니다.
				</p>
			@elseif($_GET['category'] == 'follow' && count($users) == 0)
				<p class="none-article">
					<span><i class="fa fa-star-o" aria-hidden="true"></i></span>
					관심 아티스트가 없습니다.
				</p>
			@elseif($_GET['category'] == 'follower' && count($users) == 0)
				<p class="none-article">
					<span><i class="fa fa-star-o" aria-hidden="true"></i></span>
					팬이 없습니다.
				</p>
			@endif
		@endif
	</div>
</div>
@endsection