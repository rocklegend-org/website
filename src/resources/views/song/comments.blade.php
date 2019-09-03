<div class="comments-module" data-track-id="{{ $track->id }}">
	<h2 class="bg-red">Leave a comment!</h2>
	{!! Form::open(array('class' => 'ajax', 'data-cb' => 'appendTrackComment', 'url' => route('track.comment.post', array('track' => $track->id)))) !!}
		{!! csrf_field() !!}
		{!! Form::textarea('comment', $comment) !!}
		{!! Form::submit('Post comment!') !!}
	{!! Form::close() !!}
	<h2>Comments</h2>
	<div class="comments-container" data-track-id="{{$track->id}}" data-page="1">
	@foreach($comments as $key => $comment)
		<div class="comment-single">
			<div class="profile-image">
				<img src="{{ $comment->user->getAvatarUrl() }}" alt="{{ $comment->user->username }}" height="25" />
			</div>
			<div class="comment-meta">
				<small>
					{{ Date::parse($comment->created_at)->ago() }}
				</small>
			</div>
			<div class="profile-info">
				<a href="{{ route('profile', array('username' => $comment->user->username)) }}">{{ $comment->user->username }}</a>
			</div>


			<div class="clear"></div>

			<p class="comment">{!! Helper\RLString::beautify($comment->comment) !!}</p>

			<div class="comment-replys">
				@foreach($comment->replys as $reply)
					<div class="comment-single">
						<div class="profile-image">
							<img src="{{ $reply->user->getAvatarUrl() }}" alt="{{ $reply->user->username }}" height="15" />
						</div>
						<div class="comment-meta">
							<small>
								{{ Date::parse($reply->created_at)->ago() }}
							</small>
						</div>
						<div class="profile-info">
							<a href="{{ route('profile', array('username' => $reply->user->username)) }}">{{ $reply->user->username }}</a>
						</div>


						<div class="clear"></div>

						<p class="comment">{!! Helper\RLString::beautify($reply->comment) !!}</p>
					</div>
				@endforeach
			</div>

			<div class="comment-options" data-track-id="{{$track->id}}">
				<a href="{{route('track.comment.reply', array('comment' => $comment->id))}}" class="ajax comment-reply">Reply</a>
			</div>
		</div>
		@if($key == 9)
			@break
		@endif
	@endforeach
	</div>
	<div class="text-center">
		<ul class="comments-pagination" data-track-id="{{$track->id}}">
		<?php
			for($p = 1; $p <= $pageCount; $p++)
			{
				echo '<li>
						<a href="'.route('track.comments', array('track' => $track->id, 'page' => $p)).'" 
							class="ajax'.(($p == $currentPage) ? ' active' : '').'" 
							data-page="'.$p.'">'.$p.'
						</a>
					</li>';
			}
		?>
		</ul>
	</div>
</div>