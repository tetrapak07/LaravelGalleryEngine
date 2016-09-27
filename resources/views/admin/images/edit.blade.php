@extends('part_app')

@section('content')
<div class="container" style='width:auto;  margin-top: 20px;'>

    <div class="col-md-13 col-md-offset">
        
        <div class="panel panel-default">
            
            <div class="panel-heading">Edit Image "{{ $image->title }}" with ID "{{ $image->id }}" </div>

            <div class="panel-body">

                {!! Form::model($image, ['method' => 'PATCH', 'route' => ['admin.images.update', $image->id],'role'=>'form','class'=>'block small center login','style'=>'height:80%', 'files'=>true]) !!}
                @include('admin/images/_partials/form', ['submit_text' => 'Edit Image', 'alboms' => $alboms])
                {!! Form::close() !!}  

            </div>

        </div>

    </div>

</div>
@stop


