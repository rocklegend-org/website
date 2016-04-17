
@if ($errors->has())
	@if ($errors->count() > 1)
		<div class="alert alert-block alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@else
		<div class="alert alert-danger">
			{{ $errors->first() }}
		</div>
	@endif
@endif

@if ($message = Session::get('success'))
	<div class="alert alert-success">
		{{ $message }}
	</div>
@endif