@extends('layouts/gallery')
@section('title')
@endsection
@section('content')
<div class="wrap_ban">
	<div class="ban ban1"></div>
	<div class="ban ban2"></div>
	<div class="ban ban3"></div>
	<div class="ban ban4"></div>
	<div class="ban ban5"></div>
	<div class="tit_welcome">
		<p class="en">C.GALLERY <span>PLAY CULTURE</span></p>
		<p class="kr">여러분들의 창의력을 펼쳐보세요</p>
	</div>
</div>
<div class="wrap-index">
	<div class="box-main-banner">
		<a href="#">
			<img src="{{ url('/images/banner.jpg') }}" alt="">
		</a>
	</div>
	<h2>C.GALLERY의 최근 게시물입니다.</h2>
	<ul class="main-article">
		@foreach($articles->all() as $article)
			<li>
				<a href="{{ url('/articles/'.$article->id) }}">
					<img src="{{ url('/uploads/'.$article->image) }}" alt="{{ $article->title }}" class="thumbnail">
					<div class="desc-box">
						@if ($article->user->image == '')
							<img src="{{ url('images/profile.png') }}" alt="" class="profile">
						@else
							<img src="{{ url('uploads/'.$article->user->image) }}" alt="" class="profile">
						@endif
						<span class="title">{{ $article->title }}</span>
						<span class="writer">by. {{ $article->writer_key }}</span>
					</div>
				</a>
			</li>
		@endforeach
	</ul>
</div>
@endsection