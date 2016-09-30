$(document).on("click", ".btn-follow", function(){
	var btn = $(this);
	var csrfToken = $(this).data("csrfToken");
	var follow_id = $(this).data("id");
	var url = $(this).data("url");
	var cancelUrl = $(this).data("cancelUrl");

	if (!$(this).hasClass('disabled')) {
		if (!$(this).hasClass('btn-already-follow')) {
			$.ajax({
				type: 'post',
				url: url,
				data: {
					follow_id: follow_id,
					xhr: 'true',
					_token: csrfToken
				}
			}).done(function (response) {
				btn.addClass('btn-already-follow').find('span').text('현재 팔로우 중입니다.');
			});
		} else {
			$.ajax({
				type: 'post',
				url: cancelUrl,
				data: {
					follow_id: follow_id,
					xhr: 'true',
					_token: csrfToken
				}
			}).done(function (response) {
				btn.removeClass('btn-already-follow').find('span').text('팔로우');
			});
		}	
	}
	return false; 
});

$(document).on("submit", ".login-form", function(){
	$('.wrap-login .loading-icon').fadeIn(300);
});

$(document).on("click", ".ul-sns-login li", function(){
	$('.wrap-login .loading-icon').fadeIn(300);
});


$(function(){
	var infoLength = $('.wrap-register .require-info').length;

	// 빈값 에러
	$('.require-info').bind("keyup blur", function(){

		if ($(this).hasClass('user-name')) {
			var userName = $(this).val();
			var csrfToken = $(this).data("csrfToken");
			var url = $(this).data("url");
			var rule = /[ \{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]/gi; //특수문자 

			if (rule.test(userName)) {
				userName = userName.replace(rule, "");
				$(this).val(userName);
			} else {
				if (userName == '') {
					$('.condition').text("별명을 입력해주세요.").addClass('error');
				} else {
					$.ajax({
						type : 'post',
						url : url,
						data : {
							name: userName,
							_token: csrfToken,
							xhr: 'true'
						}
					}).done(function (data){
						if (data == 'already') {
							$('.condition').text("이미 사용중인 별명입니다.").addClass('error');
							$('.wrap-register .btn-regist').addClass('disabled');
						} else if (data == 'none') {
							$('.condition').text("사용 가능한 별명입니다.").removeClass('error');
							$('input[name=name]').removeClass('errorfocus');

							if ($('.wrap-register .error').length == 0 && $('.i-agree').length == 2) {
								$('.wrap-register .btn-regist').removeClass('disabled');
							} else {
								$('.wrap-register .btn-regist').addClass('disabled');
							} 
						}
					});	
				}
			}
		} 

		if ($(this).hasClass('user-email')) {
			var userEmail = $(this).val();
			var csrfToken = $(this).data("csrfToken");
			var url = $(this).data("url");
			var regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i; 

			if (userEmail == '') {
				$('.box-email .desc').text("이메일을 입력해주세요.").addClass('error');
			} else {
				$.ajax({
					type : 'post',
					url : url,
					data : {
						email: userEmail,
						_token: csrfToken,
						xhr: 'true'
					}
				}).done(function (data){
					if (data == 'already') {
						$('.box-email .desc').text("이미 사용중인 이메일입니다.").addClass('error');
						$('.wrap-register .btn-regist').addClass('disabled');
					} else if (data == 'none') {
						if (!regExp.test(userEmail)) {
							$('.box-email .desc').text("이메일 형식이 올바르지 않습니다.").addClass('error');
						} else {
							$('.box-email .desc').text("사용 가능한 이메일입니다.").removeClass('error');
							$('input[name=email]').removeClass('errorfocus');	
						}
						
						if ($('.wrap-register .error').length == 0 && $('.i-agree').length == 2) {
							$('.wrap-register .btn-regist').removeClass('disabled');
						} else {
							$('.wrap-register .btn-regist').addClass('disabled');
						} 
					}
				});	
			}
		}

		if ($(this).hasClass('onlynum')) {
			var value = $(this).val();
			var rule = /[^0-9]/;
			
			if (value.length >= 3) {
				$(this).removeClass('error errorfocus');
			}

			if (rule.test(value)) {
				value = value.replace(rule, "");
				$(this).val(value);
			}
		}

		for (var i = 0; i < infoLength; i++) {

			if ($('.require-info').eq(i).val() == '') { // 빈값이면 에러 넣기
				$('.require-info').eq(i).addClass('error');
			} else { 
				$('.require-info').eq(i).removeClass('error');	// 값이 있으면 에러 제거
			}
		}

		if ($('.wrap-register .error').length == 0 && $('.i-agree').length == 2) {
			$('.wrap-register .btn-regist').removeClass('disabled');
		} else {
			$('.wrap-register .btn-regist').addClass('disabled');
		} 
	});

});

$(document).on("click", ".wrap-register .box-right .box-agree label", function(){
	$(this).toggleClass('i-agree');

	if ($('.wrap-register .error').length == 0 && $('.i-agree').length == 2) {
		$('.wrap-register .btn-regist').removeClass('disabled');
	} else {
		$('.wrap-register .btn-regist').addClass('disabled');
	}
});

$(document).on("click", ".btn-regist", function(){
	registValidation();
});

$(document).on("submit", ".regist-form", function(){
	registValidation();
});

$(document).on('focus', '.wrap-register .box-right .box-required input', function(){
	$(this).removeClass('errorfocus');
});

function registValidation() {
	setTimeout(function() {
		if (!$(this).hasClass('disabled')) {

		// validation
		if ($('input[name=p_num1]').val().length < 3) {
			$('input[name=p_num1]').addClass('errorfocus');
			}

			if ($('input[name=p_num2]').val().length < 3) {
				$('input[name=p_num2]').addClass('errorfocus');
			}

			if ($('input[name=p_num3]').val().length < 4) {
				$('input[name=p_num3]').addClass('errorfocus');
			}

			var regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i; 

			if ($('input[name=email]').val() == '' || !regExp.test($('input[name=email]').val())) {
				$('input[name=email]').addClass('errorfocus');
			}

			if ($('input[name=password_confirmation]').val() != $('input[name=password]').val()) {
				$('input[name=password_confirmation]').addClass('errorfocus');
			}

			if ($('.wrap-register .condition').hasClass('error')) {
				$('input[name=name]').addClass('errorfocus');					
			}

			// 에러가 없다면 submit
			if ($('.errorfocus').length == 0) {
				$('.wrap-register .box-right div').fadeOut(300);
				$('.wrap-register .box-right .loading-icon').fadeIn(300);
				$('.regist-form').submit();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}, 300);
}

$(document).on("click", "#reset-password-submit", function(){
	var url = $(this).data('url');
	var csrfToken = $(this).data('csrfToken');
	var email = $('input[name=email]').val();
	var rule = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i; 

	if (!rule.test(email)) {
		$('.wrap-find-password .box-layout').animate({'padding-top':88},300,function(){
			$('.box-response .success').fadeOut(300);
			$('.box-response .failed').fadeIn(300);
		});
	} else {
		$('.wrap-find-password .loading-icon').fadeIn(300);
		$('.form-group').animate({'opacity':0},300);
		$('.box-response p').fadeOut(300);

		$.ajax({
			type: 'post',
			url: url,
			data: {
				email: email,
				_token: csrfToken,
				xhr: 'true'
			}
		}).done(function (response){
			if (response == 'passwords.sent') {
				// success
				$('.wrap-find-password .loading-icon').fadeOut(300);
				$('.form-group').animate({'opacity':1},300);
				$('.wrap-find-password .box-layout').animate({'padding-top':88},300,function(){
					$('.box-response .success').fadeIn(300);
					$('.box-response .failed').fadeOut(300);	
				});
			} else {
				// failed
				$('.wrap-find-password .loading-icon').fadeOut(300);
				$('.form-group').animate({'opacity':1},300);
				$('.wrap-find-password .box-layout').animate({'padding-top':88},300,function(){
					$('.box-response .success').fadeOut(300);
					$('.box-response .failed').fadeIn(300);
				});
			}
		});
	}
	return false;
});

// 개인정보수정 - 비밀번호 변경
$(document).on("click", ".box-password-change label", function(){
	$('.box-change-password').toggle();
	$("input[name=new_password]").val("");
	$("input[name=new_password_confirmation]").val("");
});

// 개인정보수정 validation
$(document).on("submit", ".update-profile", function(){
	var new_password = $("input[name=new_password]");
	var new_password_check = $("input[name=new_password_confirmation]");
	var p_num1 = $('input[name=p_num1]');
	var p_num2 = $('input[name=p_num2]');
	var p_num3 = $('input[name=p_num3]');

	if (p_num1.val().length < 3) {
		p_num1.addClass('errorfocus');
		return false;
	}

	if (p_num2.val().length < 3) {
		p_num2.addClass('errorfocus');
		return false;
	}

	if (p_num3.val().length < 4) {
		p_num3.addClass('errorfocus');
		return false;
	}

	if (new_password.val().length < 6) {
		new_password.addClass('errorfocus');
	}

	if (new_password.val() != new_password_check.val()) {
		new_password_check.addClass('errorfocus');
		return false;
	}

});

$(document).on("focus", ".box-change-password input", function(){
	$(this).removeClass("errorfocus");
});








