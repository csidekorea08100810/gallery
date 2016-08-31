@extends('layouts.gallery')

@section('title')
:: 비밀번호 재설정
@endsection

@section('content')
<div class="wrap-register wrap-find-password wrap-reset-password">
	<h2>
		비밀번호 재설정
		<span class="welcome">
			가입하신 계정의 비밀번호를 재설정합니다.<br>
			가입하신 이메일 주소와 비밀번호, 비밀번호 확인을 입력해주세요.
		</span>
	</h2>
	<div class="box-layout">
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Whoops!</strong> There were some problems with your input.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
			{!! csrf_field() !!}
			<input type="hidden" name="token" value="{{ $token }}">

			<div class="form-group">
				<label class="col-md-4 control-label">이메일 주소</label>
				<input type="email" class="form-control" name="email" value="{{ old('email') }}">
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label">비밀번호</label>
				<input type="password" class="form-control" name="password">
				<p class="desc">최소 6자 이상의 영문, 숫자 조합</p>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label">비밀번호 확인</label>
				<input type="password" class="form-control" name="password_confirmation">
			</div>

			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button type="submit" class="btn btn-primary">
						비밀번호 재설정하기
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- <div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Reset Password</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
						{!! csrf_field() !!}
						<input type="hidden" name="token" value="{{ $token }}">

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Reset Password
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div> -->
@endsection
