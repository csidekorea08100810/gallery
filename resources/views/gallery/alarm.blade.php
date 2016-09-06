<?php 
$date1 = new DateTime(date('Y-m-d H:i:s')); // 현재 날짜
$date2 = new DateTime($alarm->created_at); // 업로드 날짜
$diff = date_diff($date1, $date2);

if ((int)$diff->format('%i') > 0) {
	if ((int)$diff->format('%h') > 0) {
		if ((int)$diff->format('%d') > 0) {
			if ((int)$diff->format('%m') > 0) {
				if ((int)$diff->format('%y') > 0) {
					$date = $diff->format('%y').'년 전';
				}else {
					$date = $diff->format('%m').'달 전';		
				}
			} else {
				$date = $diff->format('%d').'일 전';		
			}
		} else {
			$date = $diff->format('%h').'시간 전';	
		}
	} else {
		$date = $diff->format('%i').'분 전';
	}
} else {
	$date = '방금 전';
}
?>
<li class="li-alarm">
	<a class="{{ $alarm->checked ? 'checked' : '' }}" href="{{ $alarm->url }}" data-csrf-token="{{ csrf_token() }}" data-id="{{ $alarm->id }}" data-url="{{ url('/alarms/'.$alarm->id.'/check') }}" data-skip-pjax>
		<div class="box-thumb">
			<img src="{{ $alarm->image != '' ? url('/uploads/'.$alarm->image) : url('/images/profile2.png') }}" alt="">
		</div>
		@if ($alarm->type == 'mention')
			<p>
				<span class="name">{{ $alarm->mention_name }}</span>님이 댓글에서 회원님을 언급했습니다.
			</p>
			<div class="box-info">
				<span class="icon comment"><i class="fa fa-commenting" aria-hidden="true"></i></span> <span class="time">{{ $date }}</span>
			</div>
		@elseif ($alarm->type == 'comment')
			<p>
				<span class="name">{{ $alarm->mention_name }}</span>님이 회원님의 게시글에 댓글을 달았습니다.
			</p>
			<div class="box-info">
				<span class="icon comment"><i class="fa fa-commenting" aria-hidden="true"></i></span> <span class="time">{{ $date }}</span>
			</div>
		@elseif ($alarm->type == 'article')
			<p>
				<span class="name">{{ $alarm->mention_name }}</span>님이 새로운 게시물을 올렸습니다.
			</p>
			<div class="box-info">
				<span class="icon article"><i class="fa fa-picture-o" aria-hidden="true"></i></span>  <span class="time">{{ $date }}</span>
			</div>
		@elseif ($alarm->type == 'like')
			<p>
				<span class="name">{{ $alarm->mention_name }}</span>님이 회원님의 게시물을 좋아합니다.
			</p>
			<div class="box-info">
				<span class="icon like"><i class="fa fa-heart" aria-hidden="true"></i></span>  <span class="time">{{ $date }}</span>
			</div>
		@elseif ($alarm->type == 'follow')
			<p>
				<span class="name">{{ $alarm->mention_name }}</span>님이 회원님을 팔로우합니다.
			</p>
			<div class="box-info">
				<span class="icon follow"><i class="fa fa-star" aria-hidden="true"></i></span> <span class="time">{{ $date }}</span>
			</div>
		@endif	 
	</a>
</li>