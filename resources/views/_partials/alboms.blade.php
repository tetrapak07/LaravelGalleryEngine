<h1>{{ ($categoryTitle != NULL) ? $categoryTitle.' - ' : '' }} {{isset($settings->title)&&($settings->title != '') ? $settings->title  : ''}}</h1>

@if ($alboms && count($alboms))

  {!! $alboms->appends(Input::except('page'))->render() !!}

@endif
<p style="text-align: justify">{!! isset($settings->content)&&($settings->content!='') ? $settings->content : '' !!}</p>

<div class="row">
   
    @foreach ($alboms as $albom)
    @if (count($albom->categories->all())>0)
    <div class="picture-preview col-lg-2 col-md-2 col-sm-2 col-12">

        <div class="thumbnail" data-toggle="tooltip" data-placement="top" title="{{$albom->description}}">

            <a href="/albom/{{$albom->slug}}">
             <p class="text-center">{{$albom->title}}</p>
                <img src="{{$albom->thumb}}" title="{{$albom->title}}" alt="{{$albom->title}}">
            </a>
            <div class="caption">

                <dl class="picture-behaviour">

                    <dt >Категории:</dt>
                    <br>

                      @foreach ($albom->categories->all() as $albomCategory)
                      <dd><a href="/category/{{$albomCategory->slug}}" title="{{$albomCategory->title}}">{{$albomCategory->title}}</a></dd>
                      @endforeach
                      <dt >Добавлено:</dt>
                      <dd>{{$albom->updated_at}}</dd>

                </dl>
            </div>
        </div>
    </div>
    @endif
    @endforeach

</div>


@if ($alboms && count($alboms))

  {!! $alboms->appends(Input::except('page'))->render() !!}

@endif




