<div class="container">
    
    @if  (Session::has('message'))
            <div class="flash alert-info">
                <p>{!! Session::get('message') !!}</p>
            </div>
    @endif
    
     @if  (isset($message))
            <div class="flash alert-info">
                <p>{!! $message !!}</p>
            </div>
    @endif
   
   @if (Session::has('error'))
            <div class="flash alert-danger">
                <p>{!! Session::get('error') !!}</p>
            </div>
   @endif
   
    @if  (isset($error_message))
            <div class="flash alert-danger">
                <p>{!! $error_message !!}</p>
            </div>
    @endif
   
   @if ($errors->any())
            <div class='flash alert-danger'>
                @foreach ( $errors->all() as $error )
                <p>{{ $error }}</p>
                @endforeach
            </div>
   @endif
    
    
  
	<div class="col-md-11 col-md-offset">
   <div class="panel panel-default">
				<div class="panel-heading">Administration Panel - Парсер (ВК)</div>

				<div class="panel-body">
            {!! Form::open(array('url' => 'admin/vk_parser', 'method' => 'POST')) !!}
            
           <div class="form-group">
              {!! Form::label('public_id', 'ID паблика (группы) или страницы:') !!}
              <input class="form-control" name="public_id" type="text" value="{{old('public_id') ? old('public_id') : isset($inpt['public_id']) ? $inpt['public_id'] : '' }}" id="public_id">
           </div>
            
            <div class="form-group">
               {!! Form::label('all_alboms', 'Спарсить все альбомы паблика (группы) или страницы:') !!}
               <br>   
               <input class="allAlboms" type="checkbox" name="all_alboms" value="1" id="all_alboms"> 
            </div>
            
            <div class="form-group hidden allCats">
            {!! Form::label('cat', 'Поместить все новые альбомы в категорию') !!}    
            <select class="form-control cats" name="cat" style="" id="cat">
                                         <option value="">Любая категория</option>
                                         @foreach ($categories as $category)
                                         <option  value="{{$category->id}}">
                                                  {{$category->title}}
                                         </option>
                                         @endforeach
             </select>
            </div>    
            
           <div class="form-group albomId">
              {!! Form::label('albom_id', 'ID альбома или "wall" или "saved":') !!}
              <input class="form-control" name="albom_id" type="text" value="{{old('albom_id') ? old('albom_id') : isset($inpt['albom_id']) ? $inpt['albom_id'] : 'wall'}}" id="albom_id">
           </div>
            
           <div class="form-group">
              {!! Form::label('count', 'Max Count:') !!}
              <input class="form-control" name="count" type="text" value="{{old('count') ? old('count') : isset($inpt['count']) ? $inpt['count'] : '1000'}}" id="count">
           </div> 
            
          <div class="form-group">
              {!! Form::label('offset', 'Offset:') !!}
              <input class="form-control" name="offset" type="text" value="{{old('offset') ? old('offset') : isset($inpt['count']) ? $inpt['offset'] : '0'}}" id="offset">
          </div> 
         <div class="form-group">  
             {!! Form::label('Albom', 'Albom:') !!}
            <select class="form-control" name="albom" id="albom">
               @foreach ($alboms as $albom)
               <option  value="{{$albom->id}}" @if (old('albom')&&(old('albom') == $albom->id))) selected @elseif(isset($inpt['albom'])&&($inpt['albom'] == $albom->id)) selected @endif >
                           {{$albom->title}}
               </option>
               @endforeach
           </select>  
         </div>   
           {!! Form::submit('Parse', ['class'=>'btn primary']) !!}
           {!! Form::close() !!}   
        </div>
        
    </div> 
</div>
    
</div>
@include('admin.js')
