<h1>{{isset($albom->title)&&($albom->title != '') ? $albom->title : ''}} @if (isset($categoryTitle)&&($categoryTitle != NULL)) - <a class="various"  href="/category/{{$lastCatSlug}}" title="{{ $categoryTitle}}">{{ $categoryTitle }}</a> @endif </h1>


<p style="text-align: justify">{!! isset($albom->content)&&($albom->content!='') ? $albom->content : '' !!}</p>

 @if ($images && (!isset($all)))

                    @if (!isset($limit))
                    <!--noindex-->
                   {!! str_replace('a href', 'a rel="nofollow" href', $images->appends(Input::except('page'))->render()) !!}
                    <!--/noindex-->
                    <ul class="pagination">
                    <li><a href="/albom/{{$albom->slug}}/all">All</a></li>
                    </ul>
                    @else
                    <!--noindex-->
                    <ul class="pagination">
                    <li><a href="/albom/{{$albom->slug}}/?page=1" rel="nofollow">1</a></li>
                    </ul>
                    <!--/noindex-->
                    @endif

                 @else
                 <!--noindex-->
                 <ul class="pagination">
                 <li><a href="/albom/{{$albom->slug}}/?page=1" rel="nofollow">1</a></li>
                 </ul>
                 <!--/noindex-->
 @endif

<div class="row">
 
    @foreach ($images as $image)
    <div class="picture-preview col-lg-2 col-md-2 col-sm-2 col-10">

        <div class="thumbnail"  data-toggle="tooltip" style="width:150px;height:150px" data-placement="top" title="{{$image->content}}">
          <a href="{{$image->url}}" class="various" rel="group1" title="{{$image->title}}">
                <img src="{{$image->url_thumb}}" alt="{{$image->alt_text}}" style="max-width:100px;max-height:100px">

          </a>
         <span class="caption"><a href="/image/{{$image->slug}}">@if (!isset($image->caption)OR($image->caption == ''))<i style="font-size:12px">ОПИСАНИЕ</i> @endif <i style="font-size:12px">{{$image->caption}}</i> </a></span>
        </div>



    </div>
    @endforeach
</div>

 @if ($images && (!isset($all)))

                    @if (!isset($limit))
                    <!--noindex-->
                    {!! str_replace('a href', 'a rel="nofollow" href', $images->appends(Input::except('page'))->render()) !!}
                    <!--/noindex-->
                    <ul class="pagination">
                    <li><a href="/albom/{{$albom->slug}}/all">All</a></li>
                    </ul>
                    @else
                    <!--noindex-->
                    <ul class="pagination">
                    <li><a href="/albom/{{$albom->slug}}/?page=1" rel="nofollow">1</a></li>
                    </ul>
                    <!--/noindex-->
                    @endif

                 @else
                 <!--noindex-->
                 <ul class="pagination">
                 <li><a href="/albom/{{$albom->slug}}/?page=1" rel="nofollow">1</a></li>
                 </ul>
                 <!--/noindex-->
 @endif

 <span id="top-link-block" class="hidden">
    <a href="#top" class="well well-sm"  onclick="$('html,body').animate({scrollTop:0},'slow');$('#top-link-block').hide();return false;">
        <i class="glyphicon glyphicon-chevron-up"></i> Ап
    </a>
</span><!-- /top-link-block -->
