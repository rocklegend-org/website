@extends('layout')

@section('page_title')
Settings | rocklegend
@overwrite

@section('content')

<div data-equalizer>

	<div class="small-12 medium-10 columns medium-push-1">
		@if(Session::has('success'))
			<div class="alert-box success clearfix">
				{{ Session::get('success') }}
			</div>
		@endif

		@if($errors->count() > 0)
			<div class="alert-box error">
				{{ $errors->first() }}
			</div>
		@endif

		@if(Session::has('error') && Session::get('error') == 'image-upload')
			<div class="alert-box error">
				The uploaded avatar file must be a valid image.
			</div>
		@endif
	</div>

	<div class="small-12 medium-5 medium-push-1 columns decoration-blue" data-equalizer-watch>

		<h2 class="bg-blue first">@lang('strings.profile.settings')</h2>

		{{--<p>Change your keyboard settings, profile image, and more right here.</p>--}}


		{!! Form::open(array('route' => 'profile.settings', 'id' => 'form-profile-settings', 'data-abide', 'files' => true)) !!}
			<h2>Profile</h2>
			<div class="row">
				<div class="medium-6 columns">
					<label for="profile_image">Profile Image
					{!! Form::file('profile_image') !!}
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-6 columns">
					{!! Form::labelWithInput(
							'password', 
							'strings.profile.password', 
							'', 
							$errors, 
							'password', 
							array(
								'pattern' => 'password'
							),
							array(
								'key' => 'min.string',
								'values' => array(
					  				'min' => 5,
					  				'attribute' => Lang::get('strings.profile.password')
					  			)
							)
						)
					!!}
				</div>
			</div>
			<div class="row">
				<div class="medium-6 columns">
					{!! Form::labelWithInput(
							'password_confirm',
							'strings.profile.password_confirm',
							'',
							$errors,
							'password',
							array(
								'equalto' => 'password',
								'pattern' => 'password'
							),
							array(
								'key' => 'same',
								'values' => array(
									'attribute' => Lang::get('strings.profile.password_confirm'),
									'other'	=> Lang::get('strings.profile.password')
								)
							)
						)
					!!}
				</div>
			</div>
			
			<h2>Keyboard</h2>
			<label for="play_mode">Default Play Mode:</label>
			<select name="play_mode">
				<option value="tap" {{$user->setting('play_mode') == 'tap' ? 'selected' : ''}}>Tapping</option>
				<option value="strum" {{$user->setting('play_mode') == 'strum' ? 'selected' : ''}}>Strum</option>
			</select>
			<p>Click on the Button you want to change, and press the new key you want to use.</p>
			<div class="row">
				<div class="medium-6 columns">
					<table>
						<tr>
							<th colspan="5">Standard</td>
						</tr>
						<tr>
						@for($i = 1; $i <= 5; $i++)
							<td>
								<button type="button" class="changeKey bg-{{ Config::get('game.buttonColors.'.$i)}} no-margin" data-name="key_lane{{$i}}">{{ chr($user->setting('key_lane'.$i))}}</button>
								<input type="hidden" name="key_lane{{$i}}" value="{{ $user->setting('key_lane'.$i) }}" />
								<input type="text" value="" id="key_lane{{$i}}_tf" class="hide-for-small-up" />
							</td>
						@endfor
						</tr>
						<tr>
							<th colspan="5">Alternative</td>
						</tr>
						<tr>
						@for($i = 1; $i <= 5; $i++)
							<td>
								<button type="button" class="changeKey bg-{{ Config::get('game.buttonColors.'.$i)}} no-margin" data-name="key_alt_lane{{$i}}">{{ chr($user->setting('key_alt_lane'.$i)) }}</button>
								<input type="hidden" name="key_alt_lane{{$i}}" value="{{ $user->setting('key_alt_lane'.$i) }}" />
								<input type="text" value="" id="key_alt_lane{{$i}}_tf" class="hide-for-small-up" />
							</td>
						@endfor
						</tr>
						<tr>
							<th colspan="5">Quick Restart&nbsp;&nbsp;
								<button type="button" class="changeKey bg-{{ Config::get('game.buttonColors.1')}} no-margin" data-name="quick_restart">{{ chr($user->setting('quick_restart')) }}</button>
								<input type="hidden" name="quick_restart" value="{{ $user->setting('quick_restart') }}" />
								<input type="text" value="" id="quick_restart_tf" class="hide-for-small-up" />
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<button type="submit"><i class="fa fa-check"></i> Save!</button>
				</div>
			</div>
			{!! csrf_field() !!}
		{!! Form::close() !!}

	</div>
	
	<div class="clear show-for-small-only"></div>
	<hr class="show-for-small-only" />

	<div class="small-12 medium-5 medium-push-1 columns" data-equalizer-watch>
		<div class="row">

			<div class="small-12 decoration-red columns">
				<h1 class="first bg-red">Editor Settings</h1>

				{!! Form::open(array('route' => 'profile.settings.editor', 'id' => 'form-editor-settings', 'data-abide')) !!}
					{!! csrf_field() !!}

					<h2>Auto-Save</h2>
					<div class="row margin-bottom">
						<div class="medium-6 columns">
							<label for="autosave">
							<input type="checkbox" value="{{ $user->setting('autosave') }}" name="autosave" {{ $user->setting('autosave') ? 'checked="checked"' : '' }}/>
							 Auto-Save
						</div>
					</div>
					<div class="row">
						<div class="medium-10 columns">
							{!! 	Form::labelWithInput(
									'autosave_interval', 
									'strings.editor.autosave_interval', 
									$user->setting('autosave_interval'), 
									$errors, 
									'text', 
									array(
										'required',
										'number'
									),
									'numeric'
								);
							!!}
						</div>
					</div>	
					<div class="row">
						<div class="medium-12 columns">
							<button type="submit"><i class="fa fa-check"></i> Save!</button>
						</div>
					</div>	
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@stop