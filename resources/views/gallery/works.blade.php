@extends('layouts/gallery')
@section('title')
@endsection
@section('content')
<div class="wrap-index">
	<div class="box-sort">
		<ul class="ul-works-cate">
			<li><a class="{{ $category == '' ? 'on' : '' }}" href="{{ url('/works') }}">전체보기</a></li>
			<li><a class="{{ $category == 'A' ? 'on' : '' }}" href="{{ url('/works?cate=A') }}">카테고리1</a></li>
			<li><a class="{{ $category == 'B' ? 'on' : '' }}" href="{{ url('/works?cate=B') }}">카테고리2</a></li>
			<li><a class="{{ $category == 'C' ? 'on' : '' }}" href="{{ url('/works?cate=C') }}">카테고리3</a></li>
			<li><a class="{{ $category == 'D' ? 'on' : '' }}" href="{{ url('/works?cate=D') }}">카테고리4</a></li>
		</ul>
		<ul class="ul-works-sort">
			<li><a class="{{ $category == 'new' ? 'on' : '' }}" href="{{ url('/works?cate=new') }}">최신순</a></li>
			<li><a class="{{ $category == 'hit' ? 'on' : '' }}" href="{{ url('/works?cate=hit') }}">조회순</a></li>
			<li><a class="{{ $category == 'like' ? 'on' : '' }}" href="{{ url('/works?cate=like') }}">좋아요순</a></li>
		</ul>
	</div>	
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
	{!! $articles->links() !!}
</div>
@endsection