<div class="container">

    @if (Session::has('message'))
    <div class="flash alert-info">
        <p>{!! Session::get('message') !!}</p>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="flash alert-danger">
        <p>{!! Session::get('error') !!}</p>
    </div>
    @endif
    @if ($errors->any())
    <div class='flash alert-danger'>
        @foreach ( $errors->all() as $error )
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <div class="col-md-11 col-md-offset">
        <div class="panel panel-default">
            <div class="panel-heading">Administration Panel - Альбомы</div>

            <div class="panel-body">
                <a class="delete_selected btn btn-danger disabled">Delete Selected</a>

                <div class="col-md-13 col-md-offset" style="float:right;">
                    {!! Form::open(array('class' => 'form-inline', 'method' => 'POST', 'url' => '/admin/alboms/filter')) !!}

                    <input class="form-control" name="limit" type="text" value="{{isset($limit) ? $limit : '10'}}" placeholder="макс. кол-во (шт.)">
                    <select class="form-control cats" name="catSel" style="">
                        <option value="">Любая категория</option>
                        @foreach ($categories as $category)
                        <option  value="{{$category->id}}"  @if(isset($catSel)&&($category->id == $catSel)) selected @endif>
                                 {{$category->title}}
                    </option>
                    @endforeach
                </select>
                {!! Form::submit('apply', array('class' => 'btn btn-info')) !!}
                {!! Form::close() !!}
            </div>
            {!! link_to_route('admin.alboms.create', 'Create New Albom', array() ,array('class' => '', 'data-toggle'=>'modal', 'data-target'=>'#createAlbom') ) !!}<br><br>
            <div class="table-responsive">
                <table class="table table-bordered" data-search="true" data-url="">
                    <thead>
                        <tr>
                            <th>
                    <div>
                        <input type="checkbox" id="SelectAll">
                        Select All
                    </div>
                    </th>
                    <th data-sortable="true">ID</th>
                    <th>Caregory</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Content</th>
                    <th>Keywords</th>
                    <th>Rem</th>
                    <th>Photo Small</th>
                    <th>
                    <div>
                        <input type="checkbox" id="SelectAllVisible" data-url="alboms"> Visible
                    </div>
                    </th>
                    <th>Operations</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($alboms as $albom)
                        <tr>
                            <td>
                                <div>
                                    <input type="checkbox" class="alboms-delete" id="id{{$albom->id}}" data-id="{{$albom->id}}">
                                </div>
                            </td>
                            <td class="delete_toggler">{{$albom->id}}</td>
                            <td>
                                <div class="form-group block" data-id="{{$albom->id}}">
                                    <div>
                                        <select class="form-control cats" id="catAlb{{$albom->id}}" data-id="{{$albom->id}}" style="width:90%">
                                            <option value="0" selected>Без категории</option>
                                            @foreach ($categories as $category)
                                            <option albom-id="{{$albom->id}}" value="{{$category->id}}">
                                                {{$category->title}}
                                            </option>
                                            @endforeach
                                        </select>
                                        <a href="#" class="addCat" data-id="0" style="float:right; margin-top: -30px" albom-id="{{$albom->id}}">
                                            <i class="fa fa-fw fa-plus-square"></i>
                                        </a>
                                    </div>
                                    @foreach ($albom->categories->all() as $cats)

                                    <div class="catsSel" alb-id="{{$albom->id}}" cat-id="{{$cats->id}}">
                                        {{$cats->title}}
                                        <a href="#" class="delCat" data-id="{{$cats->id}}" albom-id="{{$albom->id}}">
                                            <i class="fa fa-fw fa-minus-square"></i>
                                        </a>

                                    </div>

                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div data-toggle="tooltip" data-placement="bottom" title="{{$albom->title}}">
                                    {!!mb_strimwidth($albom->title, 0, 10, "...")!!}
                                </div>
                            </td>
                            <td>
                                <div data-toggle="tooltip" data-placement="bottom" title="{{$albom->description}}">
                                    {!!mb_strimwidth($albom->description, 0, 10, "...")!!}
                                </div>
                            </td>

                            <td>
                                <div data-toggle="tooltip" data-placement="bottom" title="{{$albom->content}}">
                                    {!!mb_strimwidth($albom->content, 0, 10, "...")!!}
                                </div>
                            </td>
                            <td>
                                <div data-toggle="tooltip" data-placement="bottom" title="{{$albom->keywords}}">
                                    {!!mb_strimwidth($albom->keywords, 0, 10, "...")!!}
                                </div>
                            </td>
                            <td>{{$albom->rem}}</td>
                            <td><img src="{{$albom->thumb}}" width="130" height="130"></td>
                            <td>
                                <input type="checkbox" class="visible-change" data-url="alboms" name="visible" @if($albom->visible==1) checked @endif data-id="{{$albom->id}}">
                            </td>
                            <td>
                                <a href="/admin/alboms/{{$albom->id}}/edit?page=<?php if (isset($_GET['page'])) echo $_GET['page'];
else echo '1'; ?>&limit={{isset($limit) ? $limit : '10'}}&catSel={{isset($catSel) ? $catSel : ''}}" class="btn btn-info" data-toggle="modal" data-target="#editAlbom{{$albom->id}}">Edit</a>
                                <div id="editAlbom{{$albom->id}}" class="modal fade" >
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                        </div>
                                    </div>
                                </div>

                                <a href="/admin/alboms/del/{{$albom->id}}?page=<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" class="btn btn-danger" data-toggle="modal" data-target="#delAlbom{{$albom->id}}">Delete</a>

                                <div id="delAlbom{{$albom->id}}"  class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($alboms && (!isset($all)))

                @if (!isset($limit))
                {!! $alboms->appends(Input::except('page'))->render() !!}
                <ul class="pagination">
                    <li><a href="/admin/alboms/all">All</a></li>
                </ul>
                @else
                <ul class="pagination">
                    <li><a href="/admin/alboms">1</a></li>
                </ul>
                @endif

                @else
                <ul class="pagination">
                    <li><a href="/admin/alboms">1</a></li>
                </ul>
                @endif
                <input type="hidden" id="pageNumb" value="<?php if (isset($_GET['page'])) echo $_GET['page'];
else echo '1'; ?>">
            </div>
        </div>

    </div>
</div>

</div>

@include('admin._partials.del-modal', ['url' => '/admin/alboms/del_many'])

@include('admin._partials.modal', ['elementId' => 'createAlbom'])

@include('admin.js')
