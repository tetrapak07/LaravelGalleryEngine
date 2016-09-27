<div class="form-group">
    {!! Form::label('title', 'Title:') !!}

    <input class="form-control" name="title" type="text" value="{{!old('title') ? $page->title : old('title')}}" id="title">

</div>

<div class="form-group">
    {!! Form::label('description', 'Description:') !!}

    <textarea class="form-control" name="description" cols="50" rows="2" id="description">{{$page->description}}</textarea>

</div>

<div class="form-group">
    {!! Form::label('keywords', 'Keywords:') !!}

    <input class="form-control" name="keywords" type="text" value="{{$page->keywords}}" id="keywords">


</div>
<div class="form-group">
    {!! Form::label('content', 'Content:') !!}

    <!--<input class="form-control" name="content" type="text" value="{{$page->content}}" id="content">-->
     <textarea class="form-control" name="content" cols="50" rows="4" id="content">{{$page->content}}</textarea>


</div>
<div class="form-group " >
    {!! Form::label('category_id', 'Category ID:') !!}
    <select class="form-control pagesCats" name="category_id" id="catAlb{{$page->id}}" data-id="{{$page->id}}" id="category_id">
        <option page-id="{{$page->id}}" value="NULL">Без категории</option>
        @foreach ($categories as $category)
        <option page-id="{{$page->id}}" value="{{$category->id}}" @if ($page->category_id == $category->id) selected @endif>
                {{$category->title}}
        </option>
        @endforeach
    </select>

</div>
<div class="form-group">
    {!! Form::label('page_number', 'Page Number:') !!}

    <input class="form-control" name="page_number" type="text" value="{{$page->page_number}}" id="page_number">

</div>
<div class="form-group">
    {!! Form::label('visible', 'On(1)/Off(0):') !!}

    <input class="form-control" name="visible" type="text" value="{{$page->visible}}" id="visible">


</div>

    <input class="form-control" name="rem" type="hidden" value="{{$page->rem}}" id="rem">

<div class="form-group">
    <input class="form-control" name="page" type="hidden" value="<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" id="page">
    {!! Form::submit($submit_text, ['class'=>'btn primary']) !!}


    <input class="btn primary close_win" data-id="{{$page->id}}" type="reset" value="Close">
</div>

