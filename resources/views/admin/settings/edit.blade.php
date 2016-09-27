@extends('part_app')

@section('content')
<div class="container" style='width:auto;  margin-top: 20px;'>

    <div class="col-md-13 col-md-offset">
        
        <div class="panel panel-default">
            
            <div class="panel-heading">Edit Setting "{{ $setting->name }}"</div>

            <div class="panel-body">

                {!! Form::model($setting, ['method' => 'PATCH', 'route' => ['admin.settings.update', $setting->id],'role'=>'form','class'=>'block small center login','style'=>'height:80%']) !!}
                @include('admin/settings/_partials/form', ['submit_text' => 'Edit Setting'])
                {!! Form::close() !!}  

            </div>

        </div>

    </div>

</div>
@stop

