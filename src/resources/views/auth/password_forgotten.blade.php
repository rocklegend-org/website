@extends('layout')

@section('page_title')
reset your password | rocklegend
@overwrite

@section('content')

<div class="small-12 medium-3 columns">
&nbsp;
</div>

<div class="small-12 medium-6 columns decoration-red">

	<h2 class="bg-red first">Forgot your password?</h2>

	@if($errors->count() > 0 && Input::old('register') != "")
		<div class="alert-box error">
			{{ $errors->first() }}
		</div>
	@endif

	@if(isset($success) && $success == 'sent_mail')
		<p>Alright, we just sent you an email with the next step to reset your password.<br />
		<br />
		<a href="/">Go back to home</a></p>
	@else
		<p>So, just enter your email address here and we'll check if you really registered and send you instructions to reset your password!</p>

		{!! Form::open(array('route' => 'password.forgotten', 'id' => 'form-password-forgotten', 'data-abide')) !!}
			<div class="row">
				<div class="medium-6 columns">
					{!!	Form::labelWithInput(
							'email', 
							'strings.email', 
							Input::old('email'), 
							$errors, 
							'text', 
							array('required'), 
							'required'
						) 
					!!}
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<button type="submit" class="bg-red"><i class="fa fa-pencil"></i> Let's do the reset!</button> 
				</div>
			</div>

		{!! Form::close() !!}
	@endif
</div>

<div class="small-12 medium-3 columns">&nbsp;</div>
@stop