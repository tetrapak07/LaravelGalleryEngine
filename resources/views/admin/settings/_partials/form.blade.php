<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
     @if ($submit_text=='Edit Setting')
     <input class="form-control" name="name" type="text" value="{{$setting->name}}" id="name" readonly>
     @else
      <input class="form-control" name="name" type="text" value="{{$setting->name}}" id="name">
     @endif

</div>
<div class="form-group">
    {!! Form::label('value', 'Value:') !!}
    
     <textarea class="form-control" name="value" cols="50" rows="10" id="value">{{$setting->value}}</textarea>

</div>
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    @if ($submit_text=='Edit Setting')
    
    <textarea class="form-control" name="description" cols="50" rows="3" id="description" readonly>{{$setting->description}}</textarea>
    @else
     <textarea class="form-control" name="description" cols="50" rows="10" id="description" >{{$setting->description}}</textarea>
    @endif
</div>
<div class="form-group">
    {!! Form::label('rem', 'Rem:') !!}
   
      <input class="form-control" name="rem" type="text" value="{{$setting->rem}}" id="rem">
      
</div>
<div class="form-group">
     <input class="form-control" name="page" type="hidden" value="<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" id="page">
    {!! Form::submit($submit_text, ['class'=>'btn primary']) !!}
    
  
    <input class="btn primary close_win" data-id="{{$setting->id}}" type="reset" value="Close">
</div>

