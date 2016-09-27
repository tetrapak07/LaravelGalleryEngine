@extends('part_app')

@section('content')
<div class="container" style='width:auto;  margin-top: 20px;'>

    <div class="col-md-13 col-md-offset">
        
        <div class="panel panel-default">
            
            <div class="panel-heading">Edit Albom "{{ $albom->name }}"</div>

            <div class="panel-body">

                {!! Form::model($albom, ['method' => 'PATCH', 'route' => ['admin.alboms.update', $albom->id],'role'=>'form','class'=>'block small center login','style'=>'height:80%', 'files'=>true]) !!}
                @include('admin/alboms/_partials/form', ['submit_text' => 'Edit Albom'])
                {!! Form::close() !!}  

            </div>

        </div>

    </div>

</div>
@stop

