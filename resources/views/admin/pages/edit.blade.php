@extends('part_app')

@section('content')
<div class="container" style='width:auto;  margin-top: 20px;'>

    <div class="col-md-13 col-md-offset">
        
        <div class="panel panel-default">
            
            <div class="panel-heading">Edit Page "{{ $page->title }} number {{$page->page_number}}"</div>

            <div class="panel-body">

                {!! Form::model($page, ['method' => 'PATCH', 'route' => ['admin.pages.update', $page->id],'role'=>'form','class'=>'block small center login','style'=>'height:80%']) !!}
                @include('admin/pages/_partials/form', ['submit_text' => 'Edit Page'])
                {!! Form::close() !!}  

            </div>

        </div>

    </div>

</div>
@stop

