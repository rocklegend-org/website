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

	<p>Alright, just enter your new password here and you'll be able to login with it from now on.</p>

	{!! Form::open(array('route' => 'password.reset.process', 'id' => 'form-password-reset', 'data-abide')) !!}
		<input type="hidden" value="{{$code}}" name="code" />
		<input type="hidden" value="{{$id}}" name="id" />
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
				<button type="submit" class="bg-red"><i class="fa fa-pencil"></i> Change my password!</button> 
			</div>
		</div>

	{!! Form::close() !!}

</div>

<div class="small-12 medium-3 columns">&nbsp;</div>
@stop