@extends('layout')

@section('page_title')
{{ $user->username }}'s profile | rocklegend
@overwrite

@section('content')

<div class="hide-for-small medium-2 columns">
	<div class="profile-follows text-right">
		<h3 class="bg-green">Follows</h3>
		<br />
		@foreach($user->follows as $f)
			<a href="{{$f->user->profileUrl()}}" style="padding-right: 4px;"><img src="{{$f->user->getAvatarUrl()}}" style="height: 15px; position:relative; top: 0px;" />&nbsp;&nbsp;{{$f->user->username}}</a>
			<br />
		@endforeach

		@if($user->follows()->count() <= 0)
			This user does not follow anyone :(
		@endif
	</div>
</div>

<div class="small-12 medium-8 columns">
	<div class="row">
		<div class="small-12 columns" style="height: 100%;">
			<table width="100%" class="profile-stats" style="border: none;">
				<tr>
					<td style="text-align:center;" class="bg-black">
						<span class="stats">{{ number_format($user->scores()->sum('notes_hit') + $user->oldScores()->sum('notes_hit'), 0, ',','.') }}</span> notes
					</td>
					<td style="text-align:center;" class="bg-green">
						<span class="stats">{{ number_format($user->scores()->sum('score') + $user->oldScores()->sum('score'), 0, ',', '.') }}</span> score
					</td>
					<td style="text-align:center;" class="bg-red">
						<span class="stats">{{ number_format($user->scores->count() + $user->oldScores()->count(), 0, ',', '.') }}</span> songs
					</td>
				</tr>
			</table>
		</div>
		<div class="small-8 medium-9 columns ">
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
				<h3 class="bg-black">About Me</h3>
				<br />
				{!! $user->bio != '' ? Helper\RLString::beautify($user->bio) : $user->username.' has not added any about text yet.'!!}
			</p>

			<p>
				<strong>Country</strong>
				<br />
				{{{ $user->getCountry != '' ? $user->getCountry->name : 'none' }}}
			</p>

			<p>
				<strong>My favorite artists </strong>
				<br />
				{{{ $user->favorite_bands != '' ? $user->favorite_bands : '-' }}}
			</p>
			
			<p>
				<strong>I play these instruments: </strong> 
				<br />
				{{{ $user->instruments_played != '' ? $user->instruments_played : '-' }}}
			</p>

			<?php $badge = $user->badges()->orderBy('created_at','DESC')->first(); ?>

			@if(!is_null($badge))
				<h3 class="bg-yellow">Latest badge</h3> <small><a href="{{$user->badgesUrl()}}">show all</a></small>

				@include('profile.partials.badge')
				<div class="clear"></div>
			@endif
			
			@if($user->official_tracker)
				<h3 class="bg-blue">Created tracks</h3>
				@include('profile.partials.tracks_list', array('tracks' => $user->tracks()->where('status',2)->orderBy('id', 'DESC')->get()))
			@endif

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

{!! HTML::script('assets/js/dashboard/Chart.min.js') !!}
@stop