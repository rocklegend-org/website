@extends('layout')

@section('page_title')
{{ $user->username }}'s badges | rocklegend
@overwrite

@section('content')

<div class="hide-for-small medium-2 columns">&nbsp;</div>

<div class="small-12 medium-8 columns">
	<div class="row">
		<div class="small-12 columns" style="height: 100%;">
			<table width="100%" class="profile-stats" style="border: none;">
				<tr>
					<td style="text-align:center; width:33%;" class="bg-black">
						<span class="stats">{{Date::parse($user->created_at)->diffInDays()}}</span> days
					</td>
					<td style="text-align:center;" class="bg-green"><span class="stats">{{count($user->badges)}}</span> badges
					</td>
					<td style="text-align:center;" class="bg-red">
						<span class="stats">{{ number_format($user->scores->count(), 0, ',', '.') }}</span> songs
					</td>
				</tr>
			</table>
		</div>
		<div class="small-8 medium-9 columns">
			<img src="{{ $user->getAvatarUrl() }}" alt="{{$user->username}}" class="left" />
			<div style="position:relative; top: -3px; left: 10px;">
				<h1>{{ $user->username }}</h1>&nbsp;&nbsp;
				<span 
					title="Followed by {{$user->followers()->count()}} user(s)">
					<i class="fa fa-eye"></i> {{ $user->followers()->count() }}
				</span>
				<br />
				<div style="height: 2px;"></div>
				@if($user->official_tracker == 1)
					<h3 class="bg-blue no-margin">official tracker</h3>
				@endif
				@if(Sentinel::findUserById($user->id)->inRole('admin'))
					<h3 class="bg-yellow no-margin">admin</h3>
				@endif
			</div>
			<div class="clear"></div>
		</div>
		<div class="small-4 medium-3 columns text-right end">
			<small>
				member since {{ date('d.m.Y', strtotime($user->created_at))}}
				<br />
				last login {{ date('d.m.Y', strtotime($user->last_login)) }}
			</small>
			@if(User::current()->id == $user->id)
				<br />
				<a href="{{ route('profile.edit') }}">edit profile</a>
			@endif
			@include('profile.partials.followLink')
			@include('profile.partials.messageLink')
		</div>

		<div class="small-12 medium-8 columns">
			<p>
				<h3 class="bg-black">My Badges</h3>&nbsp;&nbsp;&nbsp;<small><a href="{{route('badges')}}">all available badges</a></small>
			</p>
			@if($user->badges()->count() <= 0)
				<p>{{$user->username}} doesn't have any badges yet :(</p>
			@endif
			<div style="max-height: 860px; overflow: auto;">
				@foreach($user->badges()->orderBy('created_at', 'DESC')->get() as $badge)
					@include('profile.partials.badge', array('badge' => $badge))
				@endforeach
			</div>
		</div>
		<div class="small-12 medium-4 columns">
			<p>
				<h3 class="right">Latest highscores</h3>
				<div class="clear"></div>
				<div class="highscore-list">
				<?php 
					$scores = DB::table(
								DB::raw('(SELECT * FROM highscores WHERE user_id = '.$user->id.' ORDER BY score DESC) scores')
							)->select(
								DB::raw('scores.*')
							)->leftJoin('users', 'users.id', '=', 'scores.user_id')
							->where('score','>',0)
							->orderBy('created_at', 'DESC')
							->groupBy('track_id')
							->take(5)
							->get();
				?>
				@foreach($scores as $key=>$score)
					<?php 
					$score = Highscore::where('created_at','=',$score->created_at)
									->where('user_id','=',$score->user_id)
									->first();
					 ?>
					@include('partials.scores.user.single', array('showUser' => false))
				@endforeach
				</div>
			</p>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="hide-for-small medium-2 columns">
	@include('profile.partials.navigation')
</div>

@stop