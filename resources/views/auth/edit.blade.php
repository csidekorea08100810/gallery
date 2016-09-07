@extends('layouts/gallery')
@section('title')
	:: 개인정보 수정
@endsection
@section('content')
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
	<form class="form-horizontal update-profile" role="form" method="POST" enctype="multipart/form-data" action="{{ url('/mypage/'.auth()->user()->id.'/update') }}">
		{!! csrf_field() !!}
		<div class="box-right box-layout box-update box-update-wd">
			<div class="box-register">
				<h3>개인정보 수정</h3>
				@if (auth()->user()->email == null)
					<div class="social-user">
						{{ auth()->provider ? auth()->provider : auth()->user()->social->provider }} 계정으로 가입하셨습니다.
					</div>	
				@endif
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
									@if (auth()->user()->image != '')
										<img src="{{ url('/uploads/'.auth()->user()->image) }}" alt="" class="profile">
									@else
										<img src="{{ url('/images/profile2.png') }}" alt="" class="profile">
									@endif
								</div>
							</a>
						    <input class="blind" type="file" name="image" id="image-upload" accept="image/*"/>
				        </div>
				        <p class="desc">* <span class="required">100 x 100</span> 픽셀 크기의 이미지를 권장합니다.</p>	
				    </div>
			        <div class="box-input">
			        	<div class="box-nickname">
							<label class="">별명</label>
							<input type="text" class="require-info disabled" value="{{ auth()->user()->name }}" readonly>
						</div>
						<div>
							<label for="">자기소개</label>
							<textarea name="introduction" id="" cols="30" rows="5" placeholder="자기소개를 입력해주세요." maxlength="90">{{ auth()->user()->intro }}</textarea>
						</div>
			        </div>	
				</div>
				<p class="recommend recommend-edit"></p>	
				<div class="box-required cf box-edit-required">
					<div class="box-input box-update">
						<div class="box-phone">
							<label class="">휴대폰 번호</label>
							<div class="box-num box-info">
								<input class="require-info onlynum" type="text" value="{!! substr(auth()->user()->phone, 0, 3) !!}" name="p_num1" maxlength="3">
								<input class="require-info onlynum" type="text" value="{!! substr(auth()->user()->phone, 3, 4) !!}" name="p_num2" maxlength="4">
								<input class="require-info onlynum" type="text" value="{!! substr(auth()->user()->phone, 7, 4) !!}" name="p_num3" maxlength="4">
							</div>
						</div>
						@if (auth()->user()->email != null)
							<div class="box-password-change">
								<input class="blind" type="checkbox" name="change_password" id="change_password">
								<label for="change_password"><span>비밀번호 변경하기</span></label>
							</div>
							<div class="box-change-password">
								<div class="box-info box-password">
									<label class="">새로운 비밀번호</label>
									<input type="password" class="require-info" name="new_password" placeholder="새로운 비밀번호를 입력해주세요.">
									<p class="desc">최소 6자 이상의 영문, 숫자 조합</p>
								</div>

								<div class="box-info">
									<label class="">비밀번호 확인</label>
									<input type="password" class="require-info password-check" name="new_password_confirmation" placeholder="비밀번호를 확인해주세요.">
								</div>		
							</div>
						@endif
					</div>		
				</div>
			
				<div class="box-info">
					<button type="submit" class="btn btn-primary">
						개인정보 수정하기
					</button>
				</div>

			</div>	
			<img src="{{ url('/images/spinner.gif') }}" alt="" class="loading-icon">
		</div>
	</form>
</div>

@endsection