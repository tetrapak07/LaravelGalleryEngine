<div class="container">
    
   @if (Session::has('message'))
            <div class="flash alert-info">
                <p>{!! Session::get('message') !!}</p>
            </div>
   @endif
   @if (Session::has('error'))
            <div class="flash alert-danger">
                <p>{!! Session::get('error') !!}</p>
            </div>
   @endif        
   @if ($errors->any())
            <div class='flash alert-danger'>
                @foreach ( $errors->all() as $error )
                <p>{{ $error }}</p>
                @endforeach
            </div>
   @endif
  
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
        @include('admin._partials.error_message')
			<div class="panel panel-default">
				<div class="panel-heading">Administration Panel - Main Page</div>

				<div class="panel-body">
					You are logged in, Admin!
                                     <br><br>   
                                    <a href="/admin/sitemap" class="btn btn-info" >Генерировать Sitemap.xml</a>    
				</div>
                       
                                @include('admin._partials.change_password') 
                               
                                
			</div>

