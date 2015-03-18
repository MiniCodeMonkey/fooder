@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Hi {{ $name }}! Where do you want to go tonight?</h1>

			{!! Form::open(['url' => 'ride']) !!}

			<div class="form-group">
				{!! Form::select('product', $products, null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::text('destination', null, ['class' => 'form-control input-lg', 'placeholder' => '1600 Pennsylvania Avenue Northwest, Washington, DC']) !!}
			</div>

			{!! Form::submit('Take me there, with some food along the way', ['class' => 'btn btn-primary']) !!}

			{!! Form::close() !!}


		</div>
	</div>
</div>
@endsection
