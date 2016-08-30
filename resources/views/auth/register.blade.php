@extends('layouts/gallery')

@section('title')
:: 회원가입
@endsection

@section('content')

@if (count($errors) > 0)
	<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

<style>
	.jcrop-holder div {
  -webkit-border-radius: 50% !important;
  -moz-border-radius: 50% !important;
  border-radius: 50% !important;
  margin: -1px;
}
</style>
<span class="blackcover"></span>

	<!-- 이미지 크롭 -->
		<div class="box-modal-crop">
			<h4>미리보기 이미지 설정</h4>
			<div class="box-image">
				<img src="" alt="" id="target">
			</div>
			<a href="" class="confirm">이미지 확인</a>
		</div>
		<div id="preview-pane" class="register blind">
			<div class="preview-container">
				<img src="{{ url('uploads/foo.jpg') }}" alt="" class="preview-target">
			</div>
		</div>
	<!-- 이미지 크롭 -->


<div class="wrap-register">
	<h2>
		회원 가입
		<span class="welcome">
			예술향유 문화공간에 오신것을 환영합니다.<br>
			간단한 정보 제공으로 회원가입 하실 수 있습니다.
		</span>
	</h2>
	<form class="regist-form" method="POST" action="{{ url('/auth/register') }}" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<div class="box-left box-layout">
			<h3>개인정보취급방침</h3>
			<div class="cover">
				<textarea name="" id="" cols="30" rows="10" readonly>@include('auth.private')</textarea>
			</div>
			<h3>이용약관</h3>
			<div class="cover">
				<textarea name="" id="" cols="30" rows="10" readonly>@include('auth.use')</textarea>
			</div>
		</div>
		<div class="box-right box-layout">
			<div class="box-register">
				<h3>정보 입력</h3>	
				<!-- 이미지 사이즈 -->
				<input type="hidden" name="image_w" value="">
				<input type="hidden" name="image_h" value="">
				<input type="hidden" name="image_x" value="">
				<input type="hidden" name="image_y" value="">
				<!-- 이미지 사이즈 -->
				<div class="box-profile">
					<div class="box-left">
						<div class="box-thumbnail" id="image-preview">
				        	<a class="btn-thumbnail" href="#">
								<div class="desc-box">
									<img src="{{ url('images/profile2.png') }}" alt="" class="profile">
								</div>
							</a>
						    <input class="blind" type="file" name="image" id="image-upload" accept="image/*"/>
				        </div>
				        <p class="desc">* <span class="required">100 x 100</span> 픽셀 크기의 이미지를 권장합니다.</p>	
				    </div>
			        <div class="box-input">
			        	<div class="box-nickname">
			        		<p class="desc">* 한번 정한 별명은 변경할 수 없습니다. <span class="point">(필수)</span></p>
							<label class="">별명</label>
							<input type="text" class="user-name require-info" name="name" value="{{ old('name') }}" placeholder="별명을 입력해주세요." data-csrf-token="{{ csrf_token() }}" data-url="{{ url('/articles/usercheck') }}" maxlength="10">
							<p class="condition error">
								별명을 입력해주세요.
							</p>
						</div>
						<div>
							<label for="">자기소개</label>
							<textarea name="introduction" id="" cols="30" rows="5" placeholder="자기소개를 입력해주세요."></textarea>
						</div>
			        </div>	
				</div>
				<p class="recommend">* 아래의 정보를 <span class="required">빠짐없이</span> 입력해주세요.</p>	
				<div class="box-required cf">
					<div class="box-input">
						<div class="box-phone">
							<label class="">휴대폰 번호</label>
							<div class="box-num box-info">
								<input class="require-info onlynum" type="text" name="p_num1" maxlength="3">
								<input class="require-info onlynum" type="text" name="p_num2" maxlength="4">
								<input class="require-info onlynum" type="text" name="p_num3" maxlength="4">
							</div>
						</div>

						<div class="box-info box-email">
							<label class="">이메일</label>
							<input type="email" class="require-info user-email" name="email" value="{{ old('email') }}" placeholder="이메일을 입력해주세요." data-csrf-token="{{ csrf_token() }}" data-url="{{ url('/articles/emailcheck') }}">
							<p class="desc">비밀번호 찾기시에 사용됩니다.</p>
						</div>

						<div class="box-info box-password">
							<label class="">비밀번호</label>
							<input type="password" class="require-info" name="password" placeholder="비밀번호를 입력해주세요.">
							<p class="desc">최소 6자 이상의 영문, 숫자 조합</p>
						</div>

						<div class="box-info">
							<label class="">비밀번호 확인</label>
							<input type="password" class="require-info password-check" name="password_confirmation" placeholder="비밀번호를 확인해주세요.">
						</div>		
					</div>		
				</div>
				<div class="box-agree">
					<div>
						<input class="blind" type="checkbox" name="agree1" id="agree1">
						<label for="agree1">개인정보취급방침에대한 내용을 충분히 읽고 이해하였으며 이에 동의합니다.</label>
					</div>
					<div>
						<input class="blind" type="checkbox" name="agree2" id="agree2">
						<label for="agree2">이용약관에대한 내용을 충분히 읽고 이해하였으며 이에 동의합니다.</label>
					</div>
				</div>
			</div>	
			<img src="{{ url('/images/spinner.gif') }}" alt="" class="loading-icon">
		</div>
		<a href="#" class="btn-regist disabled" type="submit" class="">
			회원가입
		</a>
	</form>
</div>
@endsection

