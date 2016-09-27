<div class="form-group">
    {!! Form::label('title', 'Title:') !!}

    <input class="form-control" name="title" type="text" value="{{!old('title') ? $albom->title : old('title')}}" id="title">

</div>
@if ($submit_text!='New Albom')
<div class="form-group">
    {!! Form::label('slug', 'Slug:') !!}

    <input class="form-control" name="slug" type="text" value="{{$albom->slug}}" id="slug" disabled>

</div>
@endif
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}

    <textarea class="form-control" name="description" cols="50" rows="2" id="description">{{$albom->description}}</textarea>

</div>

<div class="form-group">
    {!! Form::label('keywords', 'Keywords:') !!}

    <input class="form-control" name="keywords" type="text" value="{{$albom->keywords}}" id="keywords">


</div>
<div class="form-group">
    {!! Form::label('content', 'Content:') !!}

 
      <textarea class="form-control" name="content" cols="50" rows="3" id="content">{{$albom->content}}</textarea>

</div>
<div class="form-group">
    {!! Form::label('thumb', 'thumb:') !!}

    <input class="form-control" name="thumb" type="text" value="{{$albom->thumb}}" id="thumb">

        <br>
          <div class="controls">
          {!! Form::file('image') !!}

        </div>

</div>
<div class="form-group">
    {!! Form::label('rem', 'Rem:') !!}

    <input class="form-control" name="rem" type="text" value="{{$albom->rem}}" id="rem">


</div>
<div class="form-group">
    {!! Form::label('visible', 'On(1)/Off(0):') !!}

    <input class="form-control" name="visible" type="text" value="{{$albom->visible}}" id="visible">


</div>
<div class="form-group">
    <input class="form-control" name="page" type="hidden" value="<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" id="page">
    {!! Form::submit($submit_text, ['class'=>'btn primary']) !!}

    <input class="form-control" name="catSel" type="hidden" value="<?php if (isset($_GET['catSel'])) echo $_GET['catSel']; else echo ''; ?>" id="catSel">
    <input class="form-control" name="limit" type="hidden" value="<?php if (isset($_GET['limit'])) echo $_GET['limit']; else echo '10'; ?>">
    <input class="btn primary close_win" data-id="{{$albom->id}}" type="reset" value="Close">
</div>



