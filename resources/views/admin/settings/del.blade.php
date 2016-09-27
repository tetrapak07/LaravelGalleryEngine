@extends('part_app')

@section('content')
<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete setting with id "{{$id}}"</h4>
      </div>
      <div class="modal-body">
        <p>Are you shure?</p>
      </div>
      <div class="modal-footer">
          {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('admin.settings.destroy', $id))) !!}
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
         <input class="form-control" name="page" type="hidden" value="<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" id="page">
                {!! Form::submit('Yes', array('class' => 'btn btn-primary')) !!}
                     
             {!! Form::close() !!}
      </div>
@stop

