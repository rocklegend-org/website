@extends('stats.layout')

@section('content')
	<br />
	<b>Users:</b> {{$users}}<br />
	<b>Songs:</b> {{$songs}}<br />
	<b>Artists:</b> {{$artists}}<br />
	<b>Albums:</b> {{$albums}}<br />
	<b>Tracks:</b> {{$tracks}}<br />
	<b>Scores:</b> {{$scores}}<br />
	<b>Scores by:</b> {{$scoresByUsers}} Users<br />
	<b>Comments:</b> {{$comments}}<br />

	<hr />

	<div class="heading-sec">
		<h1>Latest Comments</h1>
	</div>
	<div class="comments-container" data-page="1">
	@foreach($latestComments as $comment)
		<div class="comment-single">
			<div class="profile-image">
				<img src="{{ $comment->user->getAvatarUrl() }}" alt="{{ $comment->user->username }}" height="25" />
			</div>
			<div class="comment-meta">
				<small>
					{{ date('d.m.Y h:m', strtotime($comment->created_at)) }}
				</small>
			</div>
			<div class="profile-info">
				<a href="{{ route('profile', array('username' => $comment->user->username)) }}">{{ $comment->user->username }}</a>
			</div>

			<div class="clear"></div>

			<p class="comment">{{ $comment->comment }}</p>

			<div class="comment-replys">
				@foreach($comment->replys as $reply)
					<div class="comment-single">
						<div class="profile-image">
							<img src="{{ $reply->user->getAvatarUrl() }}" alt="{{ $reply->user->username }}" height="15" />
						</div>
						<div class="comment-meta">
							<small>
								{{ date('d.m.Y h:m', strtotime($reply->created_at)) }}
							</small>
						</div>
						<div class="profile-info">
							<a href="{{ route('profile', array('username' => $reply->user->username)) }}">{{ $reply->user->username }}</a>
						</div>


						<div class="clear"></div>

						<p class="comment">{{ $reply->comment }}</p>
					</div>
				@endforeach
			</div>

			<div class="comment-options">
				<a href="{{ route('game.play', array('artist' => $comment->track->song->artist->slug, 'song' => $comment->track->song->slug, 'track' => $comment->track_id)) }}" target="_blank">go to track</a> |
				<a href="/app/admin-stats.json?key=thisismaisbaron&page=delete_comment&comment_id={{$comment->id}}" class="delete-btn">delete comment</a>
			</div>
		</div>
	@endforeach
	</div>


@stop
