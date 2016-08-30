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
            <li> {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<span class="blackcover"></span>

	<script language="Javascript">
	    $(function() {

    		// Create variables (in this scope) to hold the API and image size
		    var jcrop_api,
		        boundx,
		        boundy,

		        // Grab some information about the preview pane
		        $preview = $('#preview-pane'),
		        $pcnt = $('#preview-pane .preview-container'),
		        $pimg = $('#preview-pane .preview-container img'),

		        xsize = $pcnt.width(),
		        ysize = $pcnt.height();

	    	function showCoords(c) {
		        // variables can be accessed here as
		        // c.x, c.y, c.x2, c.y2, c.w, c.h

		        var rx = xsize / c.w,
		        	ry = ysize / c.h;
		        
		        if (parseInt(c.w) > 0) {
			        //var rx = xsize / c.w * c.w;
			        //var ry = ysize / c.h * c.h;

			        $pimg.css({
			            width: Math.round(rx * boundx) + 'px',
			            height: Math.round(ry * boundy) + 'px',
			            marginLeft: '-' + Math.round(rx * c.x) + 'px',
			            marginTop: '-' + Math.round(ry * c.y) + 'px'
			        });
			    }

		    	$('input[name=image_w]').val(c.w);
		        $('input[name=image_h]').val(c.h);
		        $('input[name=image_x]').val(c.x);
		        $('input[name=image_y]').val(c.y);
		    
			}

			$(document).on('change', '#image-upload', function() {
				
				// Todo destroy Jcrop
				// ...

			    if(window.FileReader) {
			        var reader = new FileReader();
			        reader.onload = function(e) {

			        	if ($("#image-upload").val() != '') {

			        		$pimg.attr('src',reader.result);
				            real_width = $pimg[0].naturalWidth;
				            real_height = $pimg[0].naturalHeight;	
			        	
				            if (real_width > 1200) {
				            	alert("가로 사이즈가 1200픽셀보다 작은 이미지를 업로드해주세요.");
				            } else {
				            	if (real_width < 290) {
				            		if (real_height < 290) {
				            			alert("가로, 세로 사이즈가 290픽셀보다 큰 이미지를 업로드해주세요.");	
				            		} else {
				            			alert("가로, 세로 사이즈가 290픽셀보다 큰 이미지를 업로드해주세요.");	
				            		}
				            	} else {
				            		if (real_height < 290) {
				            			alert("가로, 세로 사이즈가 290픽셀보다 큰 이미지를 업로드해주세요.");	
				            		} else {
					            		$('.box-modal-crop').fadeIn();
							        	$('.blackcover').fadeIn();
							        	$('.box-image').children().remove();
										$('.box-image').append("<img id='target'>").show();

						            	$('#target').attr('src',reader.result);
						            	$pimg.attr('src',reader.result);
						            	$('#target').css({'width':'auto','height':'auto'});
								        $('#target').Jcrop({
								        	onChange:    showCoords,
								        	onSelect:    showCoords,
								            bgColor:     'black',
								            bgOpacity:   .4,
								            setSelect:   [ 100, 100, 50, 50 ],
								            aspectRatio: 1 / 1,
								            minSize: [290, 290],
								        }, function(){
										    // Use the API to get the real image size
										    var bounds = this.getBounds();
										    boundx = bounds[0];
										    boundy = bounds[1];

										    // Store the API in the jcrop_api variable
										    _jcrop_api = this;

										    // Move the preview into the jcrop container for css positioning
										    $preview.appendTo(_jcrop_api.ui.holder);
									    });

								        modal = $('.box-modal-crop');
									    modalWidth = modal.width();
									    modal.css({'margin-left':-modalWidth/2});
									}
				            	}
				            }
				        }
				    }
			        reader.readAsDataURL(this.files[0]);  
			    }
			});

	        
		
	    });
	</script>

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
		<form action="{{ url('/articles/'.$article->id) }}" method="POST" id="upload-article" enctype="multipart/form-data">
	        {{ csrf_field() }}
	        {{ method_field('PUT') }}
	        <input type="hidden" name="category" value="{{ $article->category }}">
	        <input type="hidden" name="creative" value="{{ $article->creative }}">
	        <input type="hidden" name="profit" value="{{ $article->profit }}">
	        <input type="hidden" name="share" value="{{ $article->share }}">
	        <input type="hidden" name="open" value="{{ $article->open }}">
			<!-- 이미지 사이즈 -->
			<input type="hidden" name="image_w" value="">
			<input type="hidden" name="image_h" value="">
			<input type="hidden" name="image_x" value="">
			<input type="hidden" name="image_y" value="">
			<!-- 이미지 사이즈 -->

	        <h2>작품의 정보를 입력해주세요.</h2>
	        <div class="box-thumbnail" id="image-preview">
	        	<div id="preview-pane" class="">
					<div class="preview-container">
						<img src="{{ url('/uploads/'.$article->image) }}" alt="" class="preview-target" style="margin-left: 0px; margin-top: 0px;">
					</div>
				</div>
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
				<script type="text/javascript">
					$(function(){

						// 이미지 썸네일 미리보기
						$('.confirm').click(function(){
							$(".box-thumbnail #preview-pane").remove();
							$("#preview-pane").clone().prependTo(".box-thumbnail");
							$(".box-thumbnail #preview-pane").removeClass("blind");
							$('.box-modal-crop').fadeOut();
							$('.blackcover').fadeOut();
							return false;
						});
						
					});

					// 제목 미리보기
					$(document).on("keyup", '#upload-title', function() {
						$('.box-thumbnail .title').text($(this).val());
					});

					// 썸네일 첨부 클릭
					$(document).on("click", ".btn-thumbnail", function(){
						$("#image-upload").click();
						return false;
					});
				</script>
				<p class="desc">* <span class="point">580 x 580</span> 픽셀 크기의 이미지를 권장합니다.<span class="required">(필수)</span></p>
	        </div>
	        <div class="box-condition">
	        	<div class="box-title">
		        	<span class="title">제목을 입력해주세요. <span class="required">(필수)</span></span>
			        <input type="text" name="title" id="upload-title" placeholder="제목을 입력해주세요." maxlength="100" value="{{ $article->title }}">
		        </div>
		        <div class="box-category">
		        	<span class="title">카테고리를 선택해주세요.<span class="required">(필수)</span></span>
		        	<ul class="cf category-select">
		        		<li class="category-selected">
		        			<p>
		        				@if ($article->category == 0)
			        				카테고리1
		        				@elseif ($article->category == 1)
									카테고리2
		        				@elseif ($article->category == 2)
									카테고리3
		        				@elseif ($article->category == 3)
									카테고리4
		        				@endif
		        			</p>
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
		        <script>
			        // 업로드 카테고리 선택
			        $(document).on("click", ".category-selected p", function() {
			        	$(this).addClass('open');
			        	$('.category-list').show();
			        });

			        // 업로드 카테고리 선택
			        $(document).on("click", ".category-list a", function() {
			        	var category = $(this).text();
			        	var index = $(this).parent().index();
			        	var tag = $('.box-tag input').val();

			        	$('.category-selected p').text(category).removeClass('open');
			        	$('#tags').addTag($(this).text());	

			        	if ($('.tag').length > 5) {
			        		$('.box-alert').show();
			        				setTimeout(function(){
			        					$('.box-alert').fadeOut(500);
			        				},1000);
			        		$('.tag:first').remove();
			        	}
			        	
			        	$('input[name=category]').val(index);
			        	$('.category-list').hide();
			        	return false;
			        });
		        </script>
		        <div class="box-category box-tag">
		        	<span class="title">태그를 입력해주세요. <span class="desc">(엔터키 입력시 태그 생성)</span></span>
		        	<div class="wrap-tag">
		        		<input type="text" placeholder="태그를 입력해주세요." name="tags" id="tags" maxlength="10" value="{{ $article->tag }}">
		        	</div>
		        	<div class="box-alert">
	        			태그는 5개까지 입력 가능합니다.
	        		</div>
		        </div>
		        <script>
			        // 태그 인풋
			        $(function(){
			        	$('#tags').tagsInput();
			        	$('#tags_addTag input').attr("maxlength", 10).css({'width':'auto','display':'inline-block;'});
			        	$('#tags_tag').on('keypress', function (event){
			        		if (event.keyCode == 13) {
			        			if ($('.tag').length > 5) {
			        				$('.box-alert').show();
			        				setTimeout(function(){
			        					$('.box-alert').fadeOut(500);
			        				},1000);
			        				$('.tag:last').remove();
			        			}
			        		}
			        	});
			        });
		        </script>
		        <div class="box-category box-license box-creative">
		        	<span class="title">크리에이티브 커먼즈 라이선스를 적용하겠습니까?</span>
		        	<ul class="cf">
		        		@if ($article->creative == 0)
			        		<li>
			        			<input class="blind" type="radio" name="creative_select" id="creative1" value="" checked="checked">
			        			<label for="creative1">네</label>
			        		</li>
			        		<li>
			        			<input class="blind" type="radio" name="creative_select" id="creative2" value="">
			        			<label for="creative2">아니오</label>
			        		</li>
		        		@else
		        			<li>
			        			<input class="blind" type="radio" name="creative_select" id="creative1" value="">
			        			<label for="creative1">네</label>
			        		</li>
			        		<li>
			        			<input class="blind" type="radio" name="creative_select" id="creative2" value="" checked="checked">
			        			<label for="creative2">아니오</label>
			        		</li>
		        		@endif
		        	</ul>
		        </div>
		        <div class="box-category box-license box-profit">
		        	<span class="title">영리 목적 이용을 허락합니까?</span>
		        	<ul class="cf">
		        		@if ($article->profit == 0)
			        		<li>
			        			<input class="blind" type="radio" name="profit_select" id="profit1" value="" checked="checked">
			        			<label for="profit1">네</label>
			        		</li>
			        		<li>
			        			<input class="blind" type="radio" name="profit_select" id="profit2" value="" >
			        			<label for="profit2">아니오</label>
			        		</li>
		        		@else
		        			<li>
			        			<input class="blind" type="radio" name="profit_select" id="profit1" value="" disabled>
			        			<label for="profit1">네</label>
			        		</li>
			        		<li>
			        			<input class="blind" type="radio" name="profit_select" id="profit2" value="" disabled checked="checked">
			        			<label for="profit2">아니오</label>
			        		</li>
		        		@endif
		        	</ul>
		        </div>
		        <div class="box-category box-license box-share">
		        	<span class="title">공유하는 저작물에 변경을 허락합니까?</span>
		        	<ul class="cf">
		        		@if ($article->creative == 0)
			        		@if ($article->share == 0)
				        		<li>
				        			<input class="blind" type="radio" name="share_select" id="share1" value="">
				        			<label for="share1">네</label>
				        		</li>
				        		<li>
				        			<input class="blind" type="radio" name="share_select" id="share2" value="">
				        			<label for="share2">동일한 조건하에 수정 가능함</label>
				        		</li>
				        		<li>
				        			<input class="blind" type="radio" name="share_select" id="share3" value=""  checked="checked">
				        			<label for="share3">아니오</label>
				        		</li>
			        		@elseif ($article->share == 1)
								<li>
				        			<input class="blind" type="radio" name="share_select" id="share1" value="">
				        			<label for="share1">네</label>
				        		</li>
				        		<li>
				        			<input class="blind" type="radio" name="share_select" id="share2" value="" checked="checked">
				        			<label for="share2">동일한 조건하에 수정 가능함</label>
				        		</li>
				        		<li>
				        			<input class="blind" type="radio" name="share_select" id="share3" value="">
				        			<label for="share3">아니오</label>
				        		</li>
			        		@else
								<li>
				        			<input class="blind" type="radio" name="share_select" id="share1" value="">
				        			<label for="share1">네</label>
				        		</li>
				        		<li>
				        			<input class="blind" type="radio" name="share_select" id="share2" value="">
				        			<label for="share2">동일한 조건하에 수정 가능함</label>
				        		</li>
				        		<li>
				        			<input class="blind" type="radio" name="share_select" id="share3" value="" checked="checked">
				        			<label for="share3">아니오</label>
				        		</li>
			        		@endif
			        	@else
			        		@if ($article->share == 0)
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
			        		@elseif ($article->share == 1)
								<li>
				        			<input class="blind" type="radio" name="share_select" id="share1" value="" disabled>
				        			<label for="share1">네</label>
				        		</li>
				        		<li>
				        			<input class="blind" type="radio" name="share_select" id="share2" value="" disabled checked="checked">
				        			<label for="share2">동일한 조건하에 수정 가능함</label>
				        		</li>
				        		<li>
				        			<input class="blind" type="radio" name="share_select" id="share3" value="" disabled>
				        			<label for="share3">아니오</label>
				        		</li>
			        		@else
								<li>
				        			<input class="blind" type="radio" name="share_select" id="share1" value="" disabled>
				        			<label for="share1">네</label>
				        		</li>
				        		<li>
				        			<input class="blind" type="radio" name="share_select" id="share2" value="" disabled>
				        			<label for="share2">동일한 조건하에 수정 가능함</label>
				        		</li>
				        		<li>
				        			<input class="blind" type="radio" name="share_select" id="share3" value="" disabled checked="checked">
				        			<label for="share3">아니오</label>
				        		</li>
			        		@endif
			        	@endif
		        	</ul>
		        </div>
		        <div class="box-category box-license box-open">
		        	<span class="title">공개여부를 선택해주세요.</span>
		        	<ul class="cf">
		        		@if ($article->open == 0)
			        		<li>
			        			<input class="blind" type="radio" name="open" id="open1" value="" checked="checked">
			        			<label for="open1">공개</label>
			        		</li>
			        		<li>
			        			<input class="blind" type="radio" name="open" id="open2" value="">
			        			<label for="open2">비공개</label>
			        		</li>
		        		@else
							<li>
			        			<input class="blind" type="radio" name="open" id="open1" value="">
			        			<label for="open1">공개</label>
			        		</li>
			        		<li>
			        			<input class="blind" type="radio" name="open" id="open2" value="" checked="checked">
			        			<label for="open2">비공개</label>
			        		</li>
		        		@endif
		        	</ul>
		        </div>
		        <div class="box-category box-license box-copyright">
		        	<span class="title">저작권 표시</span>
		        	@if ($article->creative == 0)
			        	<p class="copyright blind">Copyright © <span id="name">big****</span> All Rights Reserved.</p>
			        	<p class="license show">
			        		<img class="license1" src="{{ url('/images/ccl1on.png') }}" alt="">
							<img class="license2" src="{{ url('/images/ccl2on.png') }}" alt="">
							@if ($article->profit == 0)
								<img class="license3 blind" src="{{ url('/images/ccl3on.png') }}" alt="">
							@else
								<img class="license3" src="{{ url('/images/ccl3on.png') }}" alt="">
							@endif

							@if ($article->share == 2)
								<img class="license4" src="{{ url('/images/ccl4on.png') }}" alt="">
								<img class="license5 blind" src="{{ url('/images/ccl5on.png') }}" alt="">
							@elseif ($article->share == 1)
								<img class="license4 blind" src="{{ url('/images/ccl4on.png') }}" alt="">
								<img class="license5" src="{{ url('/images/ccl5on.png') }}" alt="">
							@else
								<img class="license4 blind" src="{{ url('/images/ccl4on.png') }}" alt="">
								<img class="license5 blind" src="{{ url('/images/ccl5on.png') }}" alt="">
							@endif
			        	</p>
		        	@else
			        	<p class="copyright">Copyright © <span id="name">big****</span> All Rights Reserved.</p>
			        	<p class="license">
			        		<img class="license1" src="{{ url('/images/ccl1on.png') }}" alt="">
							<img class="license2" src="{{ url('/images/ccl2on.png') }}" alt="">
							@if ($article->profit == 1)
								<img class="license3" src="{{ url('/images/ccl3on.png') }}" alt="">
							@endif

							@if ($article->share == 2)
								<img class="license4" src="{{ url('/images/ccl4on.png') }}" alt="">
							@elseif ($article->share == 1)
								<img class="license5" src="{{ url('/images/ccl5on.png') }}" alt="">
							@endif
			        	</p>
		        	@endif
		        </div>
			</div>

			<script>
				// 업로드 라이선스
				$(document).on("click", ".box-creative label", function(){
					var index = $(this).parent().index();

					if (index == 0) {
						// 활성화
						$('.box-profit input, .box-share input').removeAttr("disabled");

						// 저작권 표시 변경
						$('.box-copyright .copyright').hide();
						$('.box-copyright .license').show();
						
					} else {
						// 비활성화
						$('.box-profit input, .box-share input').attr("disabled", "disabled");
						
						// 저작권 표시 변경
						$('.box-copyright .copyright').removeClass('blind').show();
						$('.box-copyright .license').hide();
					}

				});

				// 영리 목적 허락
				$(document).on("click", ".box-profit label", function() {
					var index = $(this).parent().index();

					if (index == 0) {
						$('.license3').addClass('blind');
					} else {
						$('.license3').removeClass('blind');
					}

				});

				// 공유 저작물 허락
				$(document).on("click", ".box-share label", function() {
					var index = $(this).parent().index();

					if (index == 0) {
						$('.license4').addClass('blind');
						$('.license5').addClass('blind');
					} else if (index == 1) {
						$('.license4').addClass('blind');
						$('.license5').removeClass('blind');
					} else {
						$('.license4').removeClass('blind');
						$('.license5').addClass('blind');
					}

				});

			</script>

			 <h2>작품의 내용을 입력해주세요. <span class="required">(필수)</span></h2>
			 <br>
			<textarea name="smarteditor" id="smarteditor" cols="30" rows="30">{{ $article->body }}</textarea>
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
	
	<script type="text/javascript">
	//스마트 에디터
	$(function(){
	    //전역변수선언
	    var editor_object = [];
	     
	    nhn.husky.EZCreator.createInIFrame({
	        oAppRef: editor_object,
	        elPlaceHolder: "smarteditor",
	        sSkinURI: "{{ url('/editor/SmartEditor2Skin.html') }}",	
	        htParams : {
	            // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
	            bUseToolbar : true,             
	            // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
	            bUseVerticalResizer : true,     
	            // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
	            bUseModeChanger : true, 
	        }
	    });

	    $(document).on("click", "#agree-upload", function() {
	    	$('#savebutton').toggleClass('disabled');
	    });
	     
	    //전송버튼 클릭이벤트
	    $("#savebutton").click(function(){

	    	if ($(this).hasClass('disabled')) {
	    		return false;
	    	} else {
	    		//id가 smarteditor인 textarea에 에디터에서 대입
		        editor_object.getById["smarteditor"].exec("UPDATE_CONTENTS_FIELD", []);
		         
		        // 이부분에 에디터 validation 검증
		        var error = [];

		        // if ($('input[type=file]').val() == '') {
		        // 	error.push('썸네일 이미지를 업로드해주세요.');
		        // 	$('.box-upload .box-thumbnail').addClass('error');
		        // }

		        if ($('input[name=title]').val() == '') {
		        	error.push('제목을 입력해주세요.');
		        	$('.box-upload #upload-title').addClass('error');	
		        }

		        if ($('input[name=category]').val() == '') {
		        	error.push('카테고리를 선택해주세요.'); 	
		        	$('.box-upload .box-category > ul li.category-selected p').addClass('error');	
		        }

		        if ($('.tag').length < 1) {
		        	error.push('태그를 최소 1개 이상 입력해주세요.'); 	
		        	$('.box-upload .box-tag .wrap-tag').addClass('error');	
		        }

		        if (error.length > 0) {
		        	alert(error.join("\n"));
		        } else {
		        	$('input[name=creative]').val($('.box-creative').find('input:checked').parent().index()); // 크리에이티브 값
					$('input[name=profit]').val($('.box-profit').find('input:checked').parent().index()); // 영리목적 값
					$('input[name=share]').val($('.box-share').find('input:checked').parent().index()); // 공유 저작물 값
					$('input[name=open]').val($('.box-open').find('input:checked').parent().index()); // 공개 여부 값

			        //폼 submit
			        $("#upload-article").submit();
			        return false;
		        }
		        
	    	}
	    });

		// 에러 제거 및 썸네일 업로드
		$(document).on("change",'input[type=file]', function() {
			if ($(this).val() != '') {
				$('.box-upload .box-thumbnail').removeClass('error');
			} 
		});

		$(document).on("blur",'input[name=title]', function() {
			if ($(this).val() != '') {
				$(this).removeClass('error');
			}
		});

		$(document).on("blur",'#tags_tag', function() {
			if ($('.tag').length > 0) {
				$('.box-upload .box-tag .wrap-tag').removeClass('error');
			}
		});

		$(document).on("click",'.box-upload .box-category > ul li.category-list li a', function() {
			if ($('input[name=category]').val() != '') {
				$('.box-upload .box-category > ul li.category-selected p').removeClass('error');
			}
		});
		$('.box-upload .box-agree .check input').removeAttr('checked');
	});
	
	</script>

@endsection