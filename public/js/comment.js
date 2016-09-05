// 댓글 달기 
$(document).on('submit', '#form-comment', function() {
	var form = $(this);

	if (form.hasClass('disabled')) {
		modalOpen('ok','회원만 댓글을 작성할 수 있습니다.');
		return false;
	}

	var csrfToken = $(this).find('[name=csrf-token]').val();
	var name = $(this).find('[name=name]').val();
	var input = $(this).find('textarea');
	var mention = $(this).find('[name=mention]').val();
	var content = input.val();

	if (!content) {
		modalOpen('ok','댓글 내용을 입력해주세요.');
		$('textarea[name=content]').addClass('error').on('focus.validation-error', function() {
			$(this).removeClass('error').off('focus.validation-error');
		});
		return false;
	}

	$.ajax({
		type:'post',
		url: form.attr('action'),
		data:{
			_token: csrfToken,
			name: name,
			mention: mention,
			content: content
		}
	}).done(function (data) {
		var comment = $(data).prependTo('.comments').hide().fadeIn(300);
		form.get(0).reset();
	}).error(function(xhr) {
		if (xhr.responseJSON && xhr.responseJSON.errors) {
			modalOpen('ok',xhr.responseJSON.errors[0]);
		} else {
			modalOpen('ok','댓글 쓰기 실패!');
		}
	});

	return false;
});

// 답글달기 다시 만들기
// $(document).on("click", ".btn-reply", function() {
// 	var name = $(this).closest('li').find('.writer').text();

// 	$('textarea[name=content]').val('@'+name+' ').focus();

// 	return false;
// });


// 댓글 삭제
$(document).on("click", ".btn-delete-comment", function() {

	var link = $(this);
	var url = link.attr('href');
	var csrfToken = link.data('csrfToken');
	var type = link.data('type');

	modalOpen(type);

	$('#modal .btn-yes').click(function(){
		$.ajax({
			type: 'delete',
			url: url,
			data: {
				_token: csrfToken
			}
		}).done(function() {
			link.closest('.comment').fadeOut(500, function() {
				$(this).remove();
			});	
			modalClose();
		}).error(function() {
			modalOpen('ok','에러!');
		});
	});


	return false;
});

// 댓글 신고
$(document).on("click", ".btn-comment-report", function() {
	var link = $(this);
	var type = link.data("type");
	var reporter_id = link.data('reporterId');
	var report_content_id = link.data('reportContentId');

	modalOpen(type);
	modalDataSet(report_content_id, reporter_id);
	return false;
});