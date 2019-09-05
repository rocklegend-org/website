<?php $user = User::current(); ?>

<div class="small-12 medium-10 columns text-right" data-equalizer-watch>
	<div class="display-table" data-equalizer-watch>
		<div class="info hide-for-small small-12 columns text-right">
			<a href="{{route('profile', array('username' => strtolower($user->username)))}}" title="Your Profile" class="no-tooltip">
				<span class="username">
					{{ $user->username}}
				</span>
			</a>
		</div>
		<div class="clear"></div>
		<ul class="navigation row">
			<li>
				<a href="{{ URL::route('conversation') }}" class="bg-yellow {{ Request::is('conversations*') ? 'active' : ''}}" title="Messages">
					<i class="fa fa-envelope"></i> @lang('strings.conversations')
				</a>
			</li>
			<li>
				<a href="{{ URL::route('profile.settings') }}" class="bg-blue {{ Request::is('profile/settings*') ? 'active' : ''}}" title="Your Settings">
					<i class="fa fa-gear"></i> @lang('strings.profile.settings')
				</a>
			</li>
			<li class="last">
				<a href="{{ URL::route('logout') }}" class="bg-black" title="Logout">
					<i class="fa fa-sign-out"></i> @lang('auth.logout')
				</a>
			</li>
		</ul>
	</div>
</div>
<div class="medium-2 column profile-image hide-for-small" data-equalizer-watch>
	<a href="{{route('profile', array('username' => strtolower($user->username)))}}" title="Your Profile" class="no-tooltip">
		<div data-equalizer-watch data-image="{{ $user->getAvatarUrl() }}">
		</div>
	</a>
</div>