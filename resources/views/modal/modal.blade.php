<span class="blackcover"></span>
<div id="modal">
	<p class="message"></p>
	<div class="box-report">
		<form class="form-report" action="{{ url('/report') }}" method="post">
			{{ @csrf_field() }}
			<textarea name="report_content" id="" cols="30" rows="5" placeholder="신고 사유는 최대 1,000자까지 작성할 수 있습니다." maxlength="1000"></textarea>
			<div class="box-act box-report">
				<button type="submit">신고하기</button>
				<a href="#" data-skip-pjax class="btn-no">취소</a>		
			</div>
		</form>
	</div>
	<div class="box-act box-confirm">
		<a href="#" data-skip-pjax class="btn-yes">확인</a>
		<a href="#" data-skip-pjax class="btn-no">취소</a>
	</div>
	<div class="box-act box-ok">
		<a href="#" data-skip-pjax class="btn-ok">확인</a>
	</div>
</div>