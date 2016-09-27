@extends('layouts.master')

@section ('meta')

  @if ((isset($albom->title))AND(!isset($categoryTitle)))
  <title>{{$albom->title}}</title>
  @elseif(isset($albom->title)AND(isset($categoryTitle))AND(isset($settings->site_name)))
  <title>{{$albom->title.' | '}}{{$categoryTitle.' | '}}{{$settings->site_name}}</title>
   @elseif(isset($albom->title)AND(isset($categoryTitle))AND(!isset($settings->site_name)))
  <title>{{$albom->title.' | '}}{{$categoryTitle}}</title>
  @endif

  @if (isset($albom->description))
  <meta name="description" content="{{$albom->description}}">
  @endif

  @if (isset($albom->keywords))
  <meta name="keywords" content="{{$albom->keywords}}" >
  @endif

@stop

@section('content')
<div class="container">
  
@include('_partials.images', ['categoryTitle' => isset($categoryTitle) ? $categoryTitle : NULL])  
    
@include('_partials.categories')    
</div>
@stop

