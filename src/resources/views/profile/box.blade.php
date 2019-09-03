<div class="profile-tooltip">
	<div class="titlebar">
		<div class="profile-image">
			<img src="{{$user->getAvatarUrl()}}" alt="{{$user->username}}" />
		</div>
		<a href="{{ route('profile', array('username' => $user->username)) }}" class="no-tooltip">{{$user->username}}</a>
	</div>

	<div class="info-badge songs-played bg-blue">
		{{ number_format($user->scores->count() + $user->oldScores->count(), 0, ',', '.') }}
		<i class="fa fa-play t-white"></i>
	</div>
	<div class="info-badge songs-played bg-yellow">
		{{ number_format($user->scores()->sum('score') + $user->oldScores()->sum('score'), 0, ',', '.') }}
		<i class="fa fa-trophy t-white"></i>
	</div>

	@if($user->badges()->count() > 0)
	<br />
	@foreach($user->badges as $badge)
		<?php $badge_direct = $badge->badge; ?>
		<a href="{{asset('assets/images/frontend/badges/'.$badge_direct->image)}}" rel="group" class="fancybox">
			<img src="{{asset('assets/images/frontend/badges/'.$badge_direct->image)}}" width="25" alt="{{$badge_direct->description}}" />
		</a>
	@endforeach

	<br /><br />
	@endif

	<div class="body">
		@include('profile.partials.followLink')
		@include('profile.partials.messageLink')
	</div>

</div>