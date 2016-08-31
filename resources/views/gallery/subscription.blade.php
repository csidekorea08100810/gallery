@extends('layouts/gallery')
@section('title')
@endsection
@section('content')
<div class="wrap-index">
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
	{!! $articles->links() !!}
</div>
@endsection