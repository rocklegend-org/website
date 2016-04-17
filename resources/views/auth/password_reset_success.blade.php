@extends('layout')

@section('page_title')
reset your password | rocklegend
@overwrite

@section('content')

<div class="small-12 medium-3 columns">
&nbsp;
</div>

<div class="small-12 medium-6 columns decoration-red">

	<h2 class="bg-red first">Welcome back!</h2>

	@if($errors->count() > 0 && Input::old('register') != "")
		<div class="alert-box error">
			{!! $errors->first() !!}
		</div>
	@endif

	<p>Done! You may now login with your new password!</p>

	{!! Form::open(array('route' => 'login.process', 'id' => 'form-login-full', 'data-abide')) !!}
		{!! Form::hidden('login', '1'); !!}
		<div class="row">
			<div class="medium-12 columns">
				{!!	Form::labelWithInput(
						'username', 
						'strings.profile.username', 
						Input::old('username'), 
						$errors, 
						'text', 
						array('required'), 
						'required'
					) 
				!!}
			</div>
			<div class="medium-12 columns">
				{!!	Form::labelWithInput(
						'password', 
						'strings.profile.password', 
						Input::old('password'), 
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
				<button type="submit" class="bg-red"><i class="fa fa-sign-in"></i> Login</button>
			</div>
		</div>
	{!! Form::close() !!}
</div>

<div class="small-12 medium-3 columns">&nbsp;</div>
@stop