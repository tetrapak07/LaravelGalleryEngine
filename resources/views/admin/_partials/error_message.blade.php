@if (Session::has('message'))
		<div class="flash alert-info">
			<p>{{ Session::get('message') }}</p>
		</div>
	@endif
	
  @if ($errors->any())
		<div class='flash alert-danger'>
			@foreach ( $errors->all() as $error1 )
				<p>{{ $error1 }}</p>
			@endforeach
		</div>
	@endif
  
  @if (isset($error))
		<div class='flash alert-danger'>
				<p>{{ $error }}</p>
		</div>
	@endif
  
   @if (isset($message))
		<div class='flash alert-info'>
				<p>{{ $message}}</p>
		</div>
	@endif


