@extends('dashboard/layout')

@section('content')

	<div class="col-md-6">

		<div class="panel panel-default">

			<div class="panel-heading">

				<span class="panel-title"><i class="fa fa-user"></i> Create Signup Code</span>

			</div>

			{!! Form::open(array('id' => 'create-code-form', 'action' => 'Dashboard\\SignupCodeController@store' )) !!}

			<div class="panel-body">

				{!! Form::label('code').": ".Form::text('code') !!}<br />
				{!! Form::label('amount').": ".Form::text('amount') !!}<br />
				{!! Form::label('active_from').": ".Form::text('active_from', date("Y-m-d H:i:s", time()), array('class' => 'datepicker')) !!}<br />
				{!! Form::label('active_to').": ".Form::text('active_to',date("Y-m-d H:i:s", strtotime('+30 days')), array('class' => 'datepicker')) !!}<br />

			</div>

			<div class="panel-footer">

				{!! Form::submit('Save', array('class' => 'btn btn-primary')) !!}

			</div>

			{!! Form::close() !!}

		</div>

	</div>

	<script type="text/javascript">
		jQuery.curCSS = jQuery.css;
		$(function(){
			$('.datepicker').each(function(){
				self = $(this);
				$(this).DatePicker({
					calendars: 1,
					starts: 1,
					date: $(this).val(),
					current: $(this).val(),
					format: 'Y-m-d 00:00:00',
					onBeforeShow: function(){
						self.DatePickerSetDate(self.val(), true);
					},
					onChange: function(formated, dates){
						self.val(formated);
					}
				})
			});
		});
	</script>

@stop