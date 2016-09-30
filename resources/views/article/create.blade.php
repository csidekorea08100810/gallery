@extends('layouts/gallery')
@section('title')
	:: 업로드
@endsection
@section('content')

@if (count($errors) > 0)
<div class="box-upload-error">
	<h3>업로드에 실패했습니다.</h3>
    <ul class="upload-error">
        @foreach($errors->all() as $error)
            <li>- {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@include('modal/modal')

	<!-- 이미지 크롭 -->
		<div class="box-modal-crop">
			<h4>미리보기 이미지 설정</h4>
			<div class="box-image">
				<img src="" alt="" id="target">
			</div>
			<a href="" class="confirm">이미지 확인</a>
		</div>
		<div id="preview-pane" class="blind">
			<div class="preview-container">
				<img src="{{ url('uploads/foo.jpg') }}" alt="" class="preview-target">
			</div>
		</div>
	<!-- 이미지 크롭 -->


	<div class="box-upload">
		<span class="txt-upload">C.GALLERY UPLOAD</span>
		<form action="{{ url('/articles') }}" method="POST" id="upload-article" enctype="multipart/form-data">
	        {{ csrf_field() }}
	        <input type="hidden" name="category" value="{{ old('category') }}">
	        <input type="hidden" name="creative" value="0">
	        <input type="hidden" name="profit" value="0">
	        <input type="hidden" name="share" value="0">
	        <input type="hidden" name="open" value="1">
			<!-- 이미지 사이즈 -->
			<input type="hidden" name="image_w" value="">
			<input type="hidden" name="image_h" value="">
			<input type="hidden" name="image_x" value="">
			<input type="hidden" name="image_y" value="">
			<!-- 이미지 사이즈 -->

	        <h2>작품의 정보를 입력해주세요.</h2>
	        <div class="box-thumbnail" id="image-preview">
	        	<a class="btn-thumbnail" href="#">
					<div class="desc-box">
						@if (auth()->user()->image == '')
							<img src="{{ url('images/profile.png') }}" alt="" class="profile">
						@else
							<img src="{{ url('uploads/'.auth()->user()->image) }}" alt="" class="profile">
						@endif
						<span class="title">&nbsp;</span>
						<span class="writer">by. {{ auth()->user()->name }}</span>
					</div>
				</a>
			    <input class="blind" type="file" name="image" id="image-upload" accept="image/*"/>
				<p class="desc">* <span class="point">580 x 580</span> 픽셀 크기의 이미지를 권장합니다.<span class="required">(필수)</span></p>
	        </div>
	        <div class="box-condition">
	        	<div class="box-title">
		        	<span class="title">제목을 입력해주세요. <span class="required">(필수)</span></span>
			        <input type="text" name="title" id="upload-title" placeholder="제목을 입력해주세요." maxlength="50">
		        </div>
		        <div class="box-category">
		        	<span class="title">카테고리를 선택해주세요.<span class="required">(필수)</span></span>
		        	<ul class="cf category-select">
		        		<li class="category-selected">
		        			<p>작품 카테고리를 선택하세요.</p>
		        		</li>
		        		<li class="category-list">
		        			<ul>
		        				<li> <a href="#">카테고리1</a> </li>
		        				<li> <a href="#">카테고리2</a> </li>
		        				<li> <a href="#">카테고리3</a> </li>
		        				<li> <a href="#">카테고리4</a> </li>
		        			</ul>
		        		</li>
		        	</ul>
		        </div>
		        <div class="box-category box-tag">
		        	<span class="title">태그를 입력해주세요. <span class="desc">(엔터키 입력시 태그 생성)</span></span>
		        	<div class="wrap-tag">
		        		<input type="text" placeholder="태그를 입력해주세요." name="tags" id="tags" maxlength="10">
		        	</div>
		        	<div class="box-alert">
	        			태그는 5개까지 입력 가능합니다.
	        		</div>
		        </div>
		        <div class="box-category box-license box-creative">
		        	<span class="title">크리에이티브 커먼즈 라이선스를 적용하겠습니까?</span>
		        	<ul class="cf">
		        		<li>
		        			<input class="blind" type="radio" name="creative_select" id="creative1" value="">
		        			<label for="creative1">네</label>
		        		</li>
		        		<li>
		        			<input class="blind" type="radio" name="creative_select" id="creative2" value="" checked="checked">
		        			<label for="creative2">아니오</label>
		        		</li>
		        	</ul>
		        </div>
		        <div class="box-category box-license box-profit">
		        	<span class="title">영리 목적 이용을 허락합니까?</span>
		        	<ul class="cf">
		        		<li>
		        			<input class="blind" type="radio" name="profit_select" id="profit1" value="" disabled>
		        			<label for="profit1">네</label>
		        		</li>
		        		<li>
		        			<input class="blind" type="radio" name="profit_select" id="profit2" value="" disabled checked="checked">
		        			<label for="profit2">아니오</label>
		        		</li>
		        	</ul>
		        </div>
		        <div class="box-category box-license box-share">
		        	<span class="title">공유하는 저작물에 변경을 허락합니까?</span>
		        	<ul class="cf">
		        		<li>
		        			<input class="blind" type="radio" name="share_select" id="share1" value="" disabled>
		        			<label for="share1">네</label>
		        		</li>
		        		<li>
		        			<input class="blind" type="radio" name="share_select" id="share2" value="" disabled>
		        			<label for="share2">동일한 조건하에 수정 가능함</label>
		        		</li>
		        		<li>
		        			<input class="blind" type="radio" name="share_select" id="share3" value=""  disabled checked="checked">
		        			<label for="share3">아니오</label>
		        		</li>
		        	</ul>
		        </div>
		        <div class="box-category box-license box-open">
		        	<span class="title">공개여부를 선택해주세요.</span>
		        	<ul class="cf">
		        		<li>
		        			<input class="blind" type="radio" name="open" id="open1" value="" checked="checked">
		        			<label for="open1">공개</label>
		        		</li>
		        		<li>
		        			<input class="blind" type="radio" name="open" id="open2" value="">
		        			<label for="open2">비공개</label>
		        		</li>
		        	</ul>
		        </div>
		        <div class="box-category box-license box-copyright">
		        	<span class="title">저작권 표시</span>
		        	<p class="copyright">Copyright © <span id="name">{{ auth()->user()->name }}</span> All Rights Reserved.</p>
		        	<p class="license">
		        		<img class="license1" src="{{ url('/images/ccl1on.png') }}" alt="">
		        		<img class="license2" src="{{ url('/images/ccl2on.png') }}" alt="">
		        		<img class="license3" src="{{ url('/images/ccl3on.png') }}" alt="">
		        		<img class="license4" src="{{ url('/images/ccl4on.png') }}" alt="">
		        		<img class="license5 blind" src="{{ url('/images/ccl5on.png') }}" alt="">
		        	</p>
		        </div>
			</div>
			<h2>작품의 내용을 입력해주세요. <span class="required">(필수)</span></h2>
			<br>
			<textarea name="smarteditor" id="smarteditor" cols="30" rows="30"></textarea>
			<input type="hidden" name="content">
			<div class="box-agree">
				<div class="check">
					<input type="checkbox" name="agree-upload" id="agree-upload" class="blind">
					<label for="agree-upload"></label>
				</div>
				<p>
					본인은 본 콘텐츠를 적법하게 게시할 수 있는 권리자임을 확인하며, <a href="">서비스 운영원칙</a>에 동의합니다.<br>
					* 저작권 등 타인의 권리를 침해하거나 명예를 훼손하는 이미지, 동영상, 음원 등을 게시하는 경우 <a href="">이용약관</a> 및 관련 법률에 의하여 제재를 받으실 수 있습니다.	
				</p>
			</div>
			<div class="box-act">
				<a id="savebutton" class="disabled" href="#">발행</a>
			</div>
		</form>
	</div>	
@endsection