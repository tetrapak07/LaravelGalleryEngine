@extends('layouts.master')

@section ('meta')

  @if ((isset($settings->title))AND(isset($settings->site_name))AND(!isset($categoryTitle)))
  <title>{{$settings->title.' | '}}{{$settings->site_name}}</title>
  @elseif(isset($settings->title)AND(isset($categoryTitle))AND(isset($settings->site_name)))
  <title>{{$settings->title.' | '}}{{$categoryTitle.' | '}}{{$settings->site_name}}</title>
  @elseif(isset($settings->title)AND(isset($categoryTitle))AND(isset($sets->site_name)))
  <title>{{$settings->title.' | '}}{{$categoryTitle.' | '}}{{$sets->site_name}}</title>
  @elseif(isset($settings->title)AND(isset($categoryTitle))AND(!isset($sets->site_name))AND(!$settings->site_name))
  <title>{{$settings->title.' | '}}{{$categoryTitle}}</title>
  @elseif(isset($settings->title)AND(!isset($categoryTitle))AND(!isset($settings->site_name)))
  <title>{{$settings->title}}</title>
  @endif

  @if (isset($settings->description))
  <meta name="description" content="{{$settings->description}}">
  @endif

  @if (isset($settings->keywords))
  <meta name="keywords" content="{{$settings->keywords}}" >
  @endif

@stop

@section('content')
<div class="container">
  
@include('_partials.alboms', ['categoryTitle' => $categoryTitle])      
    
@include('_partials.categories')    
</div>
@stop

