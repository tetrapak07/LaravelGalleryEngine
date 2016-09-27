<div class="col-lg-6 col-md-6 col-sm-6">
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}

    <input class="form-control" name="title" type="text" value="{{!old('title') ? $image->title : old('title')}}" id="title">

</div>
@if ($submit_text!='New Albom')
<div class="form-group">
    {!! Form::label('slug', 'Slug:') !!}

    <input class="form-control" name="slug" type="text" value="{{$image->slug}}" id="slug" disabled>

</div>
@endif
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}

    <textarea class="form-control" name="description" cols="50" rows="2" id="description">{{$image->description}}</textarea>

</div>

<div class="form-group">
    {!! Form::label('caption', 'Caption:') !!}

    <input class="form-control" name="caption" type="text" value="{{$image->caption}}" id="caption">

</div>

<div class="form-group">
    {!! Form::label('keywords', 'Keywords:') !!}

    <input class="form-control" name="keywords" type="text" value="{{$image->keywords}}" id="keywords">


</div>
<div class="form-group">
    {!! Form::label('content', 'Content:') !!}

    <textarea class="form-control" name="content" cols="50" rows="4" id="content">{{$image->content}}</textarea>


</div>


<div class="form-group">
    {!! Form::label('visible', 'On(1)/Off(0):') !!}

    <input class="form-control" name="visible" type="text" value="{{$image->visible}}" id="visible">


</div>
<div class="form-group">
    <input class="form-control" name="page" type="hidden" value="<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" id="page">
    {!! Form::submit($submit_text, ['class'=>'btn primary']) !!}


    <input class="btn primary close_win" data-id="{{$image->id}}" type="reset" value="Close">
</div>
</div>

<div class="col-lg-6 col-md-6 col-sm-6">
<div class="form-group">
    {!! Form::label('thumb', 'Thumb:') !!}
    <input class="form-control" name="url_thumb" type="text" value="{{$image->url_thumb}}" id="url_thumb">
    {!! Form::label('url', 'Url:') !!}
    <input class="form-control" name="url" type="text" value="{{$image->url}}" id="url">

    <br>
    <div class="picture-preview">
    <img src="{{$image->url}}" style="width:100%">
    </div>
</div>

<div class="form-group">
    {!! Form::label('alt_text', 'Alt:') !!}

    <input class="form-control" name="alt_text" type="text" value="{{$image->alt_text}}" id="alt_text">

</div>

<div class="form-group">
    {!! Form::label('notes', 'Notes:') !!}

    <input class="form-control" name="notes" type="text" value="{{$image->notes}}" id="notes">

</div>

<select class="form-control" name="albom_id" type="text" style="" id="albom_id">
        @foreach ($alboms as $albom)
        <option albom-id="{{$albom->id}}" value="{{$albom->id}}" @if ($image->albom_id == $albom->id) selected @endif>
                {{$albom->title}}
        </option>
        @endforeach
</select>
<input class="form-control" name="albSel" type="hidden" value="{{$image->albom_id}}" id="albSel">
</div>