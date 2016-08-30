<!-- resources/views/emails/password.blade.php -->

<table style="width:500px; border:1px solid #d4d4d4; box-shadow:0 0 2px rgba(0,0,0,0.3); background:#fff;">
	<tbody>
		<tr>
			<td>
				<div style="text-align:center; padding:10px 0 10px;">
					<a href="{{ url('/') }}"><img style="width:100px;" src="{{ url('/images/logo.png') }}" alt=""></a>				
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<h1 style="border-top:1px solid #d4d4d4; font-size:22px; font-weight:bold; color:#565656; margin:0 20px 10px; padding:20px 0 0;">
					비밀번호 초기화
				</h1>
				<p style="font-size:14px; color:#565656; line-height:1.6; padding:0 20px;">
					C.GALLERY 비밀번호 초기화 메일입니다.<br>
					아래의 버튼을 클릭하여 비밀번호를 변경해주세요.
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<div style="position:relative; height:50px; margin:20px;">
					<a class="go" style="position:absolute; display:block; padding:13px 0 0; top:0; left:0; right:0; bottom:0; text-decoration:none; text-align:center; font-size:14px; color:#fff; background:#ed642c; border:1px solid #ed642c; border-bottom:3px solid #d35826; box-shadow: inset 0 1px #f2c0b5; border-radius:5px;" href="{{ url('password/reset/'.$token) }}">비밀번호 변경하러 가기</a>
				</div>
			</td>
		</tr>	
	</tbody>
</table>

