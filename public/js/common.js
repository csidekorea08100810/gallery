// ----- pjax ------
$(document).pjax('a:not([data-skip-pjax])', '#pjax-container');
$(document).on('pjax:start', function() { NProgress.start(); });
$(document).on('pjax:end',   function() { NProgress.done();  });
// ----- pjax ------


// ----- facebook login -----
window.fbAsyncInit = function() {
FB.init({
  appId      : '322237758119021',
  xfbml      : true,
  version    : 'v2.7'
});
};

(function(d, s, id){
 var js, fjs = d.getElementsByTagName(s)[0];
 if (d.getElementById(id)) {return;}
 js = d.createElement(s); js.id = id;
 js.src = "//connect.facebook.net/en_US/sdk.js";
 fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
// ----- facebook login -----

// ----- 모달창 -----
function modalOpen(type, error_message) {
	var message = $('#modal .message');
	var report = $('#modal .box-report');
	var confirm = $('#modal .box-confirm');
	var ok = $('#modal .box-ok');

	switch (type) {
		case 'comment_delete_confirm':
			message.text("댓글을 삭제하시겠습니까?");
			report.hide();
			ok.hide();
			confirm.show();
			break;
		case 'comment_report':
			message.text("댓글 신고 사유를 작성해주세요.");
			report.show();
			ok.hide();
			confirm.hide();
			$('#modal .form-report').attr("data-type", "comment_report");
			$('#modal textarea').val("").removeClass('errorfocus');
			break;
		case 'article_report':
			message.text("게시글 신고 사유를 작성해주세요.");
			report.show();
			ok.hide();
			confirm.hide();
			$('#modal .form-report').attr("data-type", "article_report");
			$('#modal textarea').val("").removeClass('errorfocus');
			break;
		case 'ok':
			message.html(error_message);
			report.hide();
			confirm.hide();
			ok.show();
			break;
		case 'confirm':
			message.html(error_message);
			report.hide();
			ok.hide();
			confirm.show();
			break;
	}
	$('.blackcover').fadeIn(150);
	$('#modal').fadeIn(150);
}

function modalClose() {
	$('#modal, .blackcover').fadeOut(150);
}

function modalDataSet(report_content_id, reporter_id) {
	$('#modal .form-report').attr('data-content', report_content_id);
	$('#modal .form-report').attr('data-reporter', reporter_id);
}

$(document).on("click", "#modal .btn-no, #modal .btn-ok", function(){
	modalClose();
	return false;
});
// ----- 모달창 -----

$(document).on('submit', '.form-search', function(){
	if ($('.form-search input[name=search_query]').val().length) {
		$('.form-search').submit();
	} else {
		return false;
	}
});

// ----- 신고하기 -----
$(document).on("submit", ".form-report", function(){

	var form = $('.form-report');
	var url = form.attr('action');
	var content = form.find('textarea').val();
	var csrfToken = form.find('input[name=_token]').val();
	var type = form.data('type');
	var reporter_id = form.data('reporter');
	var report_content_id = form.data('content');

	if (!content) {
		form.find('textarea').addClass('errorfocus');
	} else {
		$.ajax({
			type:'post',
			url:url,
			data: {
				_token: csrfToken,
				content: content,
				type: type,
				reporter_id: reporter_id,
				report_content_id: report_content_id,
				xhr: 'true'
			}
		}).done(function (data){
			$('#modal .box-report').slideUp(200);
			$('#modal .message').text('신고가 접수되었습니다.');

			setTimeout(function(){
				modalClose();			
			}, 1000);
		}).error(function(){

		});	
	}

	return false;
});

$(document).on("focus", ".form-report textarea", function(){
	$(this).removeClass('errorfocus');
});
// ----- 신고하기 -----



