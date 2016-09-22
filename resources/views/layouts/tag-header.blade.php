<div class="wrap-header cf">
	<div class="box-header">
		<h1 class="logo">
			<a href="{{ url('/') }}">
				<img class="off" src="{{ url('images/logo(84.24px)_bk.png') }}" alt="C.GALLERY">
				<img class="on" src="{{ url('images/logo(84.24px)_wh.png') }}" alt="C.GALLERY">
			</a>
		</h1>
		<ul class="ul-nav cf">
			@if (!auth()->guest())
				<li class="li-nav">
					<a class="{{ strpos($_SERVER['REQUEST_URI'], 'subscription') ? 'on' : ''}}" href="{{ url('/subscription') }}">구독함</a>
				</li>
			@endif
			<li class="li-nav">
				<a class="{{ strpos($_SERVER['REQUEST_URI'], 'works') ? 'on' : ''}}" href="{{ url('/works') }}">갤러리</a>
				<ul class="ul-child">
					<li class="li-child"> <a href="">조건1</a> </li>
					<li class="li-child"> <a href="">조건2</a> </li>
					<li class="li-child"> <a href="">조건3</a> </li>
				</ul>
			</li>

			<li class="li-nav">
				<a class="{{ strpos($_SERVER['REQUEST_URI'], 'artist') ? 'on' : ''}}" href="{{ url('/artist') }}">아티스트</a>
				<ul class="ul-child">
					<li class="li-child"> <a href="">조건1</a> </li>
					<li class="li-child"> <a href="">조건2</a> </li>
					<li class="li-child"> <a href="">조건3</a> </li>
				</ul>
			</li>
		</ul>
		<ul class="ul-user">
			<li class="li-nav li-search">
				<form class="form-search" action="{{ url('/search') }}" method="get">
					<input type="text" name="search_query" id="">
					<button type="submit">
						<img class="off" src="{{ url('/images/search1.png') }}" alt="검색돋보기 버튼">
						<img class="on" src="{{ url('/images/search1w.png') }}" alt="검색돋보기 버튼">
					</button>	
				</form>
			</li>
			@if(auth()->guest())				
				<li class="li-nav">
					<a class="link-login" href="{{ url('/auth/login') }}">로그인</a>
				</li>
				<li class="li-nav">
					<a class="btn-upload disabled" href="{{ url('auth/login') }}">업로드</a>
				</li>
			@else
				<li class="li-nav li-global">
					<a class="btn-alarm" href="{{ url('/alarms/'.auth()->user()->id.'/alarm_check') }}" data-skip-pjax data-id="auth()->user()->id" data-csrf-token="{{ csrf_token() }}">
						<i class="fa fa-globe" aria-hidden="true"></i>
						@if (count(auth()->user()->alarms->where('checked',0)))
							@if (auth()->user()->alarm_check == 0)
								<div class="box-count">
									<span class="count">{{ count(auth()->user()->alarms->where('checked',0)) > 99 ? '99+' : count(auth()->user()->alarms->where('checked',0)) }}</span>
								</div>
							@endif
						@endif
					</a>
					<div class="box-alarm-list">
						@if (count(auth()->user()->alarms))
							<div class="box-set">
								<span class="txt-alarm">알림</span>
								<a class="btn-read-alarm" href="{{ url('/alarms/'.auth()->user()->id.'/read_all_alarm') }}" data-skip-pjax data-csrf-token="{{ csrf_token() }}">
									모두 읽음 표시
								</a>
							</div>
						@endif
						<ul class="ul-alarm">
							@each('gallery.alarm', auth()->user()->alarms->reverse(), 'alarm', 'gallery.no_alarm')
						</ul>
					</div>
				</li>
				<li class="li-nav li-my">
					<a href="{{ url('/mypage/'.auth()->user()->id.'?category=works') }}">
						<div class="box-mini-profile">
							@if (auth()->user()->image == '')
								<img src="{{ url('/images/profile2.png') }}" alt="">
							@else
								<img src="{{ url('/uploads/'.auth()->user()->image) }}" alt="">
							@endif	
						</div>
					</a>
					<ul class="ul-mypage">
						<li><a href="{{ url('/mypage/'.auth()->user()->id.'/edit') }}">개인정보 수정</a></li>
						<li><a href="{{ url('/auth/logout') }}">로그아웃</a>	</li>
					</ul>
				</li>
				<li class="li-nav">
					<a class="btn-upload" href="{{ url('articles/create') }}">업로드</a>
				</li>
			@endif
		</ul>
	</div>
</div>