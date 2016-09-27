@extends('layouts.master')

@section ('meta')

   @if ((isset($image->title))AND(!isset($categoryTitle)))AND(isset($settings->site_name)))
  <title>{{$image->title}} | {{$settings->site_name}}</title>
  @elseif(isset($image->title)AND(isset($categoryTitle))AND(isset($albom->title))AND(isset($settings->site_name)))
  <title>{{$image->title}} | {{$albom->title}} | {{$categoryTitle}} | {{$settings->site_name}}</title>
  @endif

  @if (isset($image->description))
  <meta name="description" content="{{$image->description}}">
  @endif

  @if (isset($image->keywords))
  <meta name="keywords" content="{{$image->keywords}}" >
  @endif

@stop

@section('content')
<div class="container">

@include('_partials.image', ['categoryTitle' => isset($categoryTitle) ? $categoryTitle : NULL, 'albom' => $albom])

@include('_partials.categories')
</div>
@stop

