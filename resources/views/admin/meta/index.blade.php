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

	<div class="col-md-10 col-md-offset">
   <div class="panel panel-default">
				<div class="panel-heading">Administration Panel - Meta Auto Generation</div>

				<div class="panel-body">

           <input class="btn primary" type="submit" value="Add New Title Part" id="add-title">
           <input class="btn primary" type="submit" value="Remove Last Title Part" id="remove-title">
           <br><br>
             {!! Form::open(array('url' => 'admin/meta_auto', 'method' => 'POST')) !!}
             <div class="form-group">
               {!! Form::label('test', 'тестовый запуск:') !!}
               <br>
               <input class="test" type="checkbox" name="test" value="1" id="test">
            </div>
             <div class="form-group">
               {!! Form::label('allAlbomsGen', 'Все альбомы:') !!}
               <br>
               <input class="allAlbomsGen" type="checkbox" name="allAlbomsGen" value="1" id="allAlbomsGen">
            </div>
          <div class="form-group albmId">
             {!! Form::label('Albom', 'Albom:') !!}
            <select class="form-control" name="albom" id="albom">
               @foreach ($alboms as $albom)
               <option  value="{{$albom->id}}" @if (old('albom')&&(old('albom') == $albom->id))) selected @elseif(isset($oldAlbomId)&&($oldAlbomId == $albom->id)) selected @endif >
                           {{$albom->title}}
               </option>
               @endforeach
           </select>
         </div>
           <div id="title-parts">
              <div class="form-group">
                 {!! Form::label('word_title1', 'Первая часть title (слова через запятую)') !!}
               <textarea class="form-control" name="word_title1" cols="50" rows="2" id="word_title1">{{old('word_title1') ? old('word_title1') :''}}</textarea>
              </div>

               <div class="form-group">
                 {!! Form::label('word_title2', 'Вторая часть title') !!}
               <textarea class="form-control" name="word_title2" cols="50" rows="2" id="word_title2">{{old('word_title2') ? old('word_title2') :''}}</textarea>
              </div>
               @if(old('title_word_count')>=3)
               {{-- */ $var = old('title_word_count'); /* --}}
               @for ($i =3; $i <= $var; $i++)
                 <div class="form-group" id="word-title-part{{$i}}">
                 {!! Form::label('word_title'.$i, $i.'-я часть title') !!}
                 <textarea class="form-control" name="word_title{{$i}}" cols="50" rows="2" id="word_title{{$i}}">{{old('word_title'.$i) ? old('word_title'.$i) :''}}</textarea>
                 </div>
               @endfor
               @endif
              <input class="form-control" name="title_word_count" type="hidden" value="{{old('title_word_count') ? old('title_word_count') :'2'}}" id="title_word_count">
           </div>

           <div class="form-group">
              {!! Form::label('word_descr_begin', 'Начальное слово(-ва) description (через запятую)') !!}
            <textarea class="form-control" name="word_descr_begin" cols="50" rows="2" id="word_descr_begi">{{old('word_descr_begin') ? old('word_descr_begin') :''}}</textarea>
           </div>

           <div class="form-group">
              {!! Form::label('word_descr_end', 'Конечное слово(-ва) description') !!}
            <textarea class="form-control" name="word_descr_end" cols="50" rows="2" id="word_descr_end">{{old('word_descr_end') ? old('word_descr_end') :''}}</textarea>
           </div>

           <div class="form-group">
              {!! Form::label('word_content_end', 'Конечное слово(-ва) content') !!}
            <textarea class="form-control" name="word_content_end" cols="50" rows="2" id="word_content_end">{{old('word_content_end') ? old('word_content_end') :''}}</textarea>
           </div>


           {!! Form::submit('Generate', ['class'=>'btn btn-primary']) !!}

           {!! Form::close() !!}

        </div>

    </div>
</div>

</div>


@include('admin.js')

