@if (isset($categories))
<div class="col-md-12 col-md-offset">
    <div class="panel panel-default">
        <div class="panel-heading">Разделы:</div>
        <div class="panel-body">
            <ul class="list-group">
                <li class="list-group-item" style="display: inline;margin-right: 5px;padding: 3px;"><a  href="/" title="Все категории">Все</a></li>
                @foreach ($categories as $category)

                @if ($category->slug!='all')
                <li class="list-group-item" style="display: inline;margin-right: 5px;padding: 3px;">
                    <a class="various"  href="/category/{{ $category->slug}}" title="{{ $category->title }}">{{ $category->title }}</a>
                </li>
                @endif

                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

