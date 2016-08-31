@extends('layouts/gallery')
@section('title')
@endsection
@section('content')
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