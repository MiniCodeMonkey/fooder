@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			@if (isset($error))
				<div class="alert alert-danger">
					<strong>Whoops!</strong> {{ $error }}
				</div>
			@endif

			<h1>Let's get started!</h1>
			<h2>First, please connect with your Uber account</h2>

			@if (isset($url))
				<a href="{!! $url !!}" class="btn btn-primary btn-lg">Connect with Uber</a>
			@endif
		</div>
	</div>
</div>
@endsection
