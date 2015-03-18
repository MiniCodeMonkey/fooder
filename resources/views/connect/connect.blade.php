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

			@if (isset($url))
				<a href="{!! $url !!}" class="btn btn-primary btn-lg">Connect with Über</a>
			@endif
		</div>
	</div>
</div>
@endsection
