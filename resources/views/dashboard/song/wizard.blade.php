@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>Song <i>create</i></h1>
	</div>

	<div class="wizard-form-h">
		<div id="wizard" class="swMain">
			<ul class="anchor">
				<li><a class="{{ $step == 1 ? 'selected' : 'disabled' }}" isdone="1" rel="1"><span class="stepDesc">1</span></a></li>
				<li><a class="{{ $step == 2 ? 'selected' : 'disabled' }}" isdone="0" rel="2"><span class="stepDesc">2</span></a></li>
			</ul>

			{{ Form::open(array('id' => 'create-song-form--basic-data', 'url' => $formUrl, 'files' => true )) }}
			<div class="stepContainer" style="height: 286px;">
				<div id="step-{{ $step }}" class="content" style="display: block;">
					<h2 class="StepTitle">{{ $stepTitle }}</h2>

					{{ $form }}

					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div class="actionBar">
					<div class="msgBox">
						<div class="content"></div>
						<a href="#" class="close">X</a>
					</div>
					<div class="loader">Loading</div>
					{{ Form::submit('Next Step!', array('class' => 'buttonFinish')) }}
				</div>
			</div>
			{{ Form::close() }}

		</div>
	</div>

@stop