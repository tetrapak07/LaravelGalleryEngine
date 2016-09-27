<div class="form-group">
    {!! Form::label('title', 'Title:') !!}

    <input class="form-control" name="title" type="text" value="{{$category->title}}" id="title">

</div>
@if ($submit_text!='New Category')
<div class="form-group">
    {!! Form::label('slug', 'Slug:') !!}

    <input class="form-control" name="slug" type="text" value="{{$category->slug}}" id="slug" disabled>

</div>
@endif
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}

    <textarea class="form-control" name="description" cols="50" rows="1" id="description" disabled>{{$category->description}}</textarea>

</div>
<div class="form-group">
    {!! Form::label('keywords', 'Keywords:') !!}

    <input class="form-control" name="keywords" type="text" value="{{$category->keywords}}" id="keywords" disabled>


</div>
<div class="form-group">
    {!! Form::label('content', 'Content:') !!}

    <input class="form-control" name="content" type="text" value="{{$category->content}}" id="content" disabled>


</div>
<div class="form-group">
    {!! Form::label('rem', 'Rem:') !!}

    <input class="form-control" name="rem" type="text" value="{{$category->rem}}" id="rem">


</div>
<div class="form-group">
    {!! Form::label('visible', 'On(1)/Off(0):') !!}

    <input class="form-control" name="visible" type="text" value="{{$category->visible}}" id="visible">


</div>
<div class="form-group">
    <input class="form-control" name="page" type="hidden" value="<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" id="page">
    {!! Form::submit($submit_text, ['class'=>'btn primary']) !!}


    <input class="btn primary close_win" data-id="{{$category->id}}" type="reset" value="Close">
</div>

