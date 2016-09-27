<h1>{{isset($image->title)&&($image->title != '') ? $image->title : ''}} 
    @if (isset($albom->slug)) >> <a class="various"  href="/albom/{{$albom->slug}}" title="{{$albom->title}}">{{$albom->title}}</a> @endif 
    @if (isset($categoryTitle)&&($categoryTitle != NULL)) >> <a class="various"  href="/category/{{$lastCatSlug}}" title="{{ $categoryTitle}}">{{ $categoryTitle }}</a> @endif
    </h1>
<p style="text-align: justify">{!! isset($image->content)&&($image->content!='') ? $image->content : '' !!}</p>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
      <a href="/image/{{$previousImage->slug}}" class="pull-left"><<< Назад</a>
  </div> 
  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
      <a href="/image/{{$nextImage->slug}}" class="pull-right">Вперед >>></a>
  </div>   
</div>
<br>
<div class="row">
<img class="img-responsive" src="{{$image->url}}" alt="{{$image->alt_text}}" 
     width="{{isset($image->width)&&($image->width != '') ? $image->width : '' }}" 
     height="{{isset($image->height)&&($image->height != '') ? $image->height : '' }}"> 
</div>
<br>

</br>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
      <a href="/image/{{$previousImage->slug}}" class="pull-left"><<< Назад</a>
  </div> 
  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
      <a href="/image/{{$nextImage->slug}}" class="pull-right">Вперед >>></a>
  </div>   
</div>
</br>
