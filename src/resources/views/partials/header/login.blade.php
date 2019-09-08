<div class="small-12 medium-10 columns text-right" data-equalizer-watch>
	<div class="inline-block show-for-medium-up">
		{!! Form::open(array('route' => 'login.process', 'id' => 'form-login', 'data-abide', 'class' => 'force-reload compressed')) !!}
			{!! Form::hidden('login', '1') !!}
			<div class="row">
				<div class="medium-4 medium-offset-2 columns">
					{!!	Form::labelWithInput(
							'username', 
							'strings.profile.usernameOrEmail', 
							Input::old('username'), 
							$errors, 
							'text', 
							array('required', 'class' => ''), 
							'required',
							true
						) 
					!!}
				</div>
				<div class="medium-4 columns">
					{!!	Form::labelWithInput(
							'password', 
							'strings.profile.password', 
							Input::old('password'), 
							$errors, 
							'password', 
							array(
								'required'
							),
							'required',
							true
						) 
					!!}
				</div>
				<div class="medium-2 end columns">
					<a href="#" onclick="$(this).closest('form').submit();" class="small full-width btn bg-blue no-margin-right force-reload"><i class="fa fa-sign-in"></i>&nbsp;</a>
				</div>
				<input type="submit" class="hide-for-small-up" value="Login" />
			</div>
			<div class="row">
				<div class="medium-12 columns">
					@if($errors->count() > 0 && Input::old('login') != "")
						<div class="alert-box inline error">
							{!! $errors->first() !!}
						</div>&nbsp;&nbsp;
					@endif
					<span class="hide forgot-password-link"><a href="{{ route('password.forgotten') }}">Did you forget your password?</a> &nbsp;|&nbsp;</span>
					<a href="{{ route('login') }}">Register</a><br />and become a rocklegend.
				</div>
			</div>
		{!! Form::close() !!}

	</div>

	<div class="row show-for-small-only">
		<div class="small-12 columns">
			<a href="{{ route('login') }}" class="{{ Request::is('login*') ? 'active' : ''}}">
				<i class="fa fa-sign-in"></i> login | register
			</a><br />and become a rocklegend.
		</div>
	</div>
</div>			
<div class="medium-2 column profile-image hide-for-small" data-equalizer-watch>
	<div data-equalizer-watch data-image="/assets/images/frontend/default-avatar.png"></div>
</div>