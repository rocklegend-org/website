@extends('layout')

@section('page_title')
{{ $user->username }}'s profile | rocklegend
@overwrite

@section('content')

<div class="hide-for-small medium-2 columns">&nbsp;</div>

<form method="post" action="" id="profile-edit-form">
<div class="small-12 medium-8 columns">
	<div class="row">
		<div class="small-12 medium-12 columns">
			<table width="100%" style="border: none;">
				<tr>
					<td width="33%">
						<img src="{{ $user->getAvatarUrl() }}" alt="{{$user->username}}" />
						
					</td>
					<td class="text-center">
						<h1>{{ $user->username }}</h1>
						<br />
						@if($user->official_tracker == 1)
							<h3 class="bg-blue no-margin">official tracker</h3>
						@endif
						@if(Sentry::findUserById($user->id)->inGroup(Sentry::findGroupByName('Admin')))
							<h3 class="bg-yellow no-margin">admin</h3>
						@endif
					</td>
					<td width="33%" class="text-right">
						<small>member since {{ date('d.m.Y', strtotime($user->created_at))}}</small>
						<br />
						<small>last login {{ date('d.m.Y', strtotime($user->last_login)) }}</small>
						@if(User::current()->id == $user->id)
						<br />
						<a href="{{ route('profile.edit') }}">edit profile</a>
						@endif
					</td>
				</tr>
			</table>
			<hr />
			<div class="row">
				<div class="text-center small-12 columns">
					<small>Your name won't be visible for anyone. It helps us to correctly address you should we ever contact you.</small>
				</div>
				<div class="small-6 columns">
					<strong>First Name</strong>
					<input type="text" value="{{$user->first_name}}" name="first_name" />
				</div>
				<div class="small-6 columns">
					<strong>Last Name</strong>
					<input type="text" value="{{$user->last_name}}" name="last_name" />
				</div>
			</div>
			<strong>About You</strong>
			<p>You can also use <a href="http://markdown.de/syntax/index.html" target="_blank">markdown syntax</a> :)</p>
			<textarea name="bio" placeholder="Tell the community about yourself :)" style="width: 100%; height:100px;">{{ $user->bio != '' ? $user->bio : ''}}</textarea>

			<strong>Country: </strong><select name="country">
				{{Country::getList()}}
			</select>

			<br />

			<strong>Which City do you live in?</strong>
			<input type="text" value="{{{$user->city}}}" placeholder="Vienna" name="city" />

			<strong>Tell us your favorite artists :)</strong>
			<input type="text" value="{{{$user->favorite_bands}}}" name="favorite_bands" />

			<strong>Which instruments do you play?</strong>
			<input type="text" value="{{{$user->instruments_played}}}" name="instruments_played" />

			<div class="text-center">
				<input type="submit" value="Save changes!" class="btn bg-green" />
			</div>
		</div>
		<div class="small-6 medium-4 columns text-right">
			
		</div>
		<div class="clear"></div>
	</div>
</div>
</form>

<div class="hide-for-small medium-2 columns">&nbsp;</div>

{{ HTML::script('assets/js/dashboard/Chart.min.js') }}
@stop

@section('footer-scripts')
	<script type="text/javascript">
	$(function(){
		$('select[name="country"] option[value="{{$user->country}}"]').attr('selected', true);
	});
	</script>
@stop