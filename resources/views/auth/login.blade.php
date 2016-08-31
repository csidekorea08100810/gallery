@extends('layouts/gallery')

@section('title')
:: 로그인
@endsection

@section('content')
<div class="wrap-login">
	<div class="box-center">
		<div class="box-info">
			<h2>로그인 <span class="desc">예술향유 문화공간에 어서오세요.</span></h2>

			@if (isset($errors) && count($errors) > 0)
				<strong>Whoops!</strong> There were some problems with your input.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@endif

			<form class="login-form form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
				{!! csrf_field() !!}
				<div class="wrap-input">
					<div class="box-input">
						<div class="box">
							<label class="col-md-4 control-label">이메일</label>				
							<input type="email" class="form-control" name="email" value="{{ old('email') }}">			
						</div>
						<div class="box">
							<label class="col-md-4 control-label">비밀번호</label>
							<input type="password" class="form-control" name="password">		
						</div>					
					</div>	
					<div class="box-login">
						<button type="submit" class="btn btn-primary">로그인</button>
					</div>
					<div class="box-etc">
						<input class="blind" type="checkbox" name="remember" id="remember"> <label for="remember">로그인 상태 유지하기</label>
						<div>
							<a class="btn btn-link" href="{{ url('/password/email') }}">비밀번호 찾기</a>
							<span>/</span>
							<a class="btn btn-link" href="{{ url('/auth/register') }}">회원가입</a>	
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="box-info box-social">
			<h2>소셜 로그인 <span class="desc">소셜 계정으로 로그인하여 문화공간에 참여해보세요.</span></h2>
			<div class="wrap-input">
				<ul class="ul-sns-login">
					<li>
						<a class="sns-fb" href="{{ url('/redirect') }}">
							<span class="icon"><i class="fa fa-facebook" aria-hidden="true"></i></span>
							<span class="txt">페이스북 계정으로 로그인</span>
						</a>
					</li>
					<!-- <li>
						<a class="sns-tw" href="#">
							<span class="icon"><i class="fa fa-twitter" aria-hidden="true"></i></span>
							<span class="txt">트위터 계정으로 로그인</span>
						</a>
					</li> -->
					<li>
						<a class="sns-nv" href="/auth/naver">
							<span class="icon"></span>
							<span class="txt">네이버 계정으로 로그인</span>
						</a>
					</li>
					<!-- <li>
						<a class="sns-ka" href="/auth/kakao">
							<span class="icon"><i class="fa fa-comment" aria-hidden="true"></i></span>
							<span class="txt">카카오 계정으로 로그인</span>
						</a>
					</li> -->
				</ul>
				<div class="box-etc">
				</div>
			</div>
		</div>
	</div>
	<span class="loading-icon">
		<img src="{{ url('/images/spinner.gif') }}" alt="">
	</span>
</div>
@endsection
