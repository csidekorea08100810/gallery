// 게시글 쓰기
$(function(){
	for (var i = 0; i < $('.upload-error li').length; i++) {
		var error = $('.upload-error li').eq(i).text();

		if (error == ' The title field is required.') {
			errorMessage = '제목을 입력해주세요.';
		} else if (error == ' The smarteditor field is required.') {
			errorMessage = '내용을 입력해주세요.';
		} else if (error == ' The image field is required.') {
			errorMessage = '썸네일 이미지를 업로드 해주세요.';
		} else {
			errorMessage = '카테고리를 선택해주세요.';
		}

		$('.upload-error li').eq(i).text(errorMessage);
	}

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
		            	modalOpen('ok',"가로 사이즈가 1200픽셀보다 작은 이미지를 업로드해주세요.");
		            } else {
		            	if (real_width < 290) {
		            		if (real_height < 290) {
		            			modalOpen('ok',"가로, 세로 사이즈가 290픽셀보다 큰 이미지를 업로드해주세요.");	
		            		} else {
		            			modalOpen('ok',"가로, 세로 사이즈가 290픽셀보다 큰 이미지를 업로드해주세요.");	
		            		}
		            	} else {
		            		if (real_height < 290) {
		            			modalOpen('ok',"가로, 세로 사이즈가 290픽셀보다 큰 이미지를 업로드해주세요.");	
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
								    _jcrop_api.animateTo([0,0,0,0]);

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

	// 이미지 썸네일 미리보기
	$('.confirm').click(function(){
		$(".box-thumbnail #preview-pane").remove();
		$("#preview-pane").clone().prependTo(".box-thumbnail");
		$(".box-thumbnail #preview-pane").removeClass("blind");
		$('.box-modal-crop').fadeOut();
		$('.blackcover').fadeOut();
		return false;
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

    // 태그 인풋
    $('#tags').tagsInput();
	$('#tags_addTag input').attr("maxlength", 10).css({'width':'auto','display':'inline-block;'});
	$('#tags_tag').on('keypress', function (event){
		// -------- 2016. 8. 30 수정 ---------
		if ($('.tag').length >= 5) { 
			if ($('.tag').length > 5) {
				$('.box-alert').show();
				setTimeout(function(){
					$('.box-alert').fadeOut(500);
				},1000);	
			}
			$(this).val("");
			return false;
		}
		// -------- 2016. 8. 30 수정 ---------
		// if (event.keyCode == 13 || event.keyCode == 188 || event.keyCode == 224) {
		// 	if ($('.tag').length > 5) {
		// 		$('.tag:nth-child(5) + .tag').remove();
		// 		$('.box-alert').show();
		// 		$(this).val("");
		// 		setTimeout(function(){
		// 			$('.box-alert').fadeOut(500);
		// 		},1000);
		// 		$('.tag:last').remove();
		// 		return false;
		// 	}
		// }
	});

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

	//전역변수선언
	if ($('#smarteditor').length > 0) {
		var editor_object = [];
     
	    nhn.husky.EZCreator.createInIFrame({
	        oAppRef: editor_object,
	        elPlaceHolder: "smarteditor",
	        sSkinURI: "/editor/SmartEditor2Skin.html",	
	        htParams : {
	            // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
	            bUseToolbar : true,             
	            // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
	            bUseVerticalResizer : true,     
	            // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
	            bUseModeChanger : true, 
	        }
	    });
	
	}
    
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

	        if (!$('input[type=file]').hasClass('edit')) {
	        	if ($('input[type=file]').val() == '') {
		        	error.push('썸네일 이미지를 업로드해주세요.');
		        	$('.box-upload .box-thumbnail').addClass('error');
		        }	
	        }

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
	        	// alert(error.join("\n"));
	        	var message = error.join("<br>");
	        	modalOpen('ok', message);
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

	//---------- wk 2016.08.25 수정 ----------

	// $(document).on("blur",'input[name=title]', function() {
	// 	if ($(this).val() != '') {
	// 		$(this).removeClass('error');
	// 	}
	// });

	// $(document).on("blur",'#tags_tag', function() {
	// 	if ($('.tag').length > 0) {
	// 		$('.box-upload .box-tag .wrap-tag').removeClass('error');
	// 	}
	// });

	$(document).on("focus",'input[name=title]', function() {
			$(this).removeClass('error');
	});

	
	$(document).on("focus",'#tags_tag', function() {
			$('.box-upload .box-tag .wrap-tag').removeClass('error');
	});
	
	//---------- wk 2016.08.25 수정 ----------

	$(document).on("click",'.box-upload .box-category > ul li.category-list li a', function() {
		if ($('input[name=category]').val() != '') {
			$('.box-upload .box-category > ul li.category-selected p').removeClass('error');
		}
	});

	$('.box-upload .box-agree .check input').removeAttr('checked');
});


// 게시글 삭제
$(document).on("click", ".btn-delete", function(){

	var url = $(this).data('url');
	var csrfToken = $(this).data('csrfToken');

	modalOpen('confirm', "삭제하신 게시글은 복구가 불가능합니다.<br>정말 삭제하시겠습니까?");

	$('.btn-yes').click(function(){
		
		$.ajax({
			type: 'delete',
			url: url,
			data: {
				_token: csrfToken,
				xhr: 'true'
			}
		}).done(function (data){
			$('.box-show').stop().animate({'height':288},300,function(){
				$('.box-delete-complete').fadeIn(300);
			});
			$('.box-show div').fadeOut(300);
			modalClose();
		});
	
		return false;
	});
		
	return false;
});

// 좋아요
$(document).on("click", '.btn-like', function(){
	if (!$(this).hasClass('btn-like-clicked')) {
		var url = $(this).attr('href');
		var csrfToken = $(this).data('csrfToken');
		var name = $(this).data('name');

		if (name != '') {
			$.ajax({
				type:'post',
				url: url,
				data:{
					_token: csrfToken,
					name: name,
				}
			}).done(function (data){
				$('.btn-like').addClass('btn-like-clicked');
				$('.like-count').text(parseInt($('.like-count').text())+1);
				$('.like-txt').addClass('liked-txt').text('좋아요를 누르셨습니다.');
			});
		} else {
			modalOpen('ok','로그인 후 이용가능합니다.');
		}

	}						
	return false;
});

// 게시글 신고
$(document).on("click", ".btn-article-report", function() {
	var link = $(this);
	var type = link.data("type");
	var reporter_id = link.data('reporterId');
	var report_content_id = link.data('reportContentId');

	modalOpen(type);
	modalDataSet(report_content_id, reporter_id);
	return false;
});

