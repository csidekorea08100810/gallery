<li>
	<a href="{{ url('/articles/'.$article->id) }}" data-name="유저네임">
		<img src="{{ url('/uploads/'.$article->image) }}" alt="{{ $article->title }}" class="thumbnail">
		<div class="desc-box">
			@if($article->user->image == '')
				<img class="profile" src="{{ url('/images/profile.png') }}" alt="">
			@else 
				<img class="profile" src="{{ url('/uploads/'.$article->user->image) }}" alt="">
			@endif
			<span class="title">{{ $article->title }}</span>
			<span class="writer">by. {{ $article->writer_key }}</span>
		</div>
	</a>
</li>