@extends('layout')

@section('page_title')
register | rocklegend
@overwrite

@section('content')

<div class="small-12 hide-for-medium-up">
	<div class="display-table"><div class="vertical-middle"><hr /></div></div>
</div>

<div class="small-12 show-for-small-only columns decoration-blue">

	<h2 class="bg-blue first">login</h2>

	@if($errors->count() > 0 && Input::old('login') != "")
		<div class="alert-box error">
			{!! $errors->first() !!}
		</div>
	@endif

	{!! Form::open(array('route' => 'login.process', 'id' => 'form-login', 'data-abide')) !!}
		{!! Form::hidden('login', '1') !!}
		<div class="row">
			<div class="medium-12 columns">
				{!!	Form::labelWithInput(
						'username_login', 
						'strings.profile.username', 
						Input::old('username_login'), 
						$errors, 
						'text', 
						array('required'), 
						'required'
					) 
				!!}
			</div>
			<div class="medium-12 columns">
				{!!	Form::labelWithInput(
						'password_login', 
						'strings.profile.password', 
						Input::old('password_login'), 
						$errors, 
						'password', 
						array(
							'required'
						),
						'required'
					) 
				!!}
			</div>
		</div>
		<div class="row">
			<div class="medium-12 columns">
				<button type="submit" class="bg-blue"><i class="fa fa-sign-in"></i> Login</button>
			</div>
		</div>
	{!! Form::close() !!}

	<hr style="show-for-small-only" />

</div>


<div class="small-12 medium-6 medium-pull-3 columns decoration-green">

	<h2 class="bg-green first">Create a new rocklegend!</h2>

	@if($errors->count() > 0)
		<div class="alert-box error">
			{!! $errors->first() !!}
		</div>
	@endif

	<p>rocklegend is currently in <b class="t-green">public beta</b>!</p>
	<p>Sign up here to try what we're working on, and make sure to check our updates on our <a href="http://facebook.com/rocklegendgame" target="_blank">facebook page</a> or <a href="https://twitter.com/share?text={{urlencode('Get your early access code for #thisisrocklegend at')}}&url={{urlencode(url(''))}}" target="_blank" data-lang="en">twitter account</a>!</p>
	
	{!! Form::open(array('route' => 'register', 'id' => 'form-register', 'data-abide')) !!}
		{!! Form::hidden('register', '1') !!}

		<div class="row">
			<div class="medium-6 columns">
				{!!	Form::labelWithInput(
						'username', 
						'strings.profile.username', 
						Input::old('username'), 
						$errors, 
						'text', 
						array('required','maxlength' => 20), 
						array(
							'key' => 'max.string',
							'values' => array(
									'max' => 20,
									'attribute' => Lang::get('strings.profile.username')
								)
						)
					) 
				!!}
			</div>

			<div class="medium-6 columns">
				{!!	Form::labelWithInput(
						'email', 
						'strings.email', 
						Input::old('email'), 
						$errors, 
						'email', 
						array('required','email'), 
						'email'
					) 
				!!}
			</div>
		</div>
		<div class="row">
			<div class="medium-6 columns">
				{!! 	Form::labelWithInput(
						'password', 
						'strings.profile.password', 
						'', 
						$errors, 
						'password', 
						array(
							'required',
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
			<div class="medium-6 columns">
				{!! 	Form::labelWithInput(
						'password_confirm',
						'strings.profile.password_confirm',
						'',
						$errors,
						'password',
						array(
							'required',
							'equalto' => 'password'
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
		<div class="row">
			<div class="medium-12 columns">
				<p><a href="#" class="ajax" id="signup-code-toggle">Click here</a> if you've got a special signup code.</p> 
				<div id="signup-code-input" style="display: none;">
				{!! Form::labelWithInput(
						'code',
						'strings.signup.code',
						'',
						$errors,
						'text'			
					)
				!!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="medium-12 columns">
				<button type="submit" class="bg-green"><i class="fa fa-pencil"></i> Sign Up!</button> 
			</div>
		</div>

	{!! Form::close() !!}

</div>

@stop

@section('footer-scripts')
<script type="text/javascript">
jQuery(function($){
	$('#signup-code-toggle').on('click', function(e){
		e.preventDefault();

		$(this).parent().fadeOut();
		$('#signup-code-input').fadeIn();
	});

	$('input[name="username"]').bind('keypress', function (event) {
	    var regex = new RegExp("^[a-zA-Z0-9]+$");
	    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	    if (!regex.test(key)) {
	       event.preventDefault();
	       return false;
	    }
	});
});
</script>
@stop
