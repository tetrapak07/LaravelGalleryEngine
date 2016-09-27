@extends('layouts.master')

@section ('meta')
  
  @if (isset($settings))
  <title>Результат поиска: "{{$query}}" | {{$settings->site_name}}</title>
  @else
  <title>Поиск по сайту "{{$query}}"</title>
  @endif
  <meta name="description" content="Пользовательский поиск по сайту {{$query}}">

  <meta name="keywords" content="поиск, найти" >

@stop

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Search</div>

            <div class="panel-body">
                Введите поисковый запрос
                <br>
                <div class="form-group">
                    <input class="form-control" name="q" type="text" value="{{$query}}" id="this-search">
                </div>

                <form method="GET" action="/search" accept-charset="UTF-8" class="form-inline" id="serch-form">
                    <input class="btn btn-info" type="submit" value="Search" id="search">
                </form>

            </div>
        </div>
        @include('_partials.alboms', ['categoryTitle' => $query ])  
    </div>
       
</div>

@include('_partials.categories')  
@stop
