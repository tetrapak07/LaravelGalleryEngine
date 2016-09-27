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
				<div class="panel-heading">Administration Panel - Фотографии</div>

				<div class="panel-body">
            <a class="delete_selected btn btn-danger disabled">Delete Selected</a>

            <div class="col-md-13 col-md-offset" style="float:right;">
            {!! Form::open(array('class' => 'form-inline', 'method' => 'POST', 'url' => '/admin/images/filter')) !!}

             <input class="form-control" name="limit" type="text" value="{{isset($limit) ? $limit : '10'}}" placeholder="макс. кол-во (шт.)">
             <select class="form-control albomus" name="albSel" style="width:200px">
                                         <option value="">Любой альбом</option>
                                         @foreach ($alboms as $albom)
                                         <option  value="{{$albom->id}}"  @if(isset($albomSel)&&($albom->id == $albomSel)) selected @endif>
                                                  {{$albom->title}}
                                         </option>
                                         @endforeach
             </select>
             <input type="checkbox" name="sort" @if(isset($sort)&&($sort == 'desc')) checked @endif />desc(set)/asc
             {!! Form::submit('apply', array('class' => 'btn btn-info')) !!}
             {!! Form::close() !!}
             </div>
            {!! link_to_route('admin.images.create', 'Create New Image', array() ,array('class' => '', 'data-toggle'=>'modal', 'data-target'=>'#createImage') ) !!}<br><br>
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
                             <th>Albom</th>
                             <th>Title</th>
                             <th>Alt</th>
                             <th>Capt.</th>
                             <th>Descr.</th>
                           
                             <th>Cont.</th>
                           
                             <th>Thumb</th>
                             <th>
                              <div>
                                  <input type="checkbox" id="SelectAllVisible" data-url="images"> Visible
                              </div>
                             </th>
                             <th>Operations</th>
                         </tr>
                     </thead>
                     <tbody>
                        @foreach ($images as $image)
                         <tr>
                             <td>
                                 <div>
                                     <input type="checkbox" class="images-delete" id="id{{$image->id}}" data-id="{{$image->id}}">
                                 </div>
                             </td>
                             <td class="delete_toggler">{{$image->id}}</td>
                             <td>
                                 <div class="form-group block" data-id="{{$image->id}}">

                                     <select class="form-control albs" id="alb{{$image->id}}" data-id="{{$image->id}}" style="">
                                         @foreach ($alboms as $albom)
                                         <option albom-id="{{$albom->id}}" value="{{$image->id}}" @if ($image->albom_id == $albom->id) selected @endif>
                                                  {{$albom->title}}
                                         </option>
                                         @endforeach
                                     </select>

                                 </div>
                             </td>
                             <td>
                                 <div data-toggle="tooltip" data-placement="bottom" title="{{$image->title}}">
                                     {!!mb_strimwidth($image->title, 0, 10, "...")!!}
                                 </div>
                             </td>
                             <td>
                                 <div data-toggle="tooltip" data-placement="bottom" title="{{$image->alt_text}}">
                                     {!!mb_strimwidth($image->alt_text, 0, 10, "...")!!}
                                 </div>
                             </td>
                             <td>
                                 <div data-toggle="tooltip" data-placement="bottom" title="{{$image->caption}}">
                                     {!!mb_strimwidth($image->caption, 0, 10, "...")!!}
                                 </div>
                             </td>
                             <td>
                                 <div data-toggle="tooltip" data-placement="bottom" title="{{$image->description}}">
                                     {!!mb_strimwidth($image->description, 0, 10, "...")!!}
                                 </div>
                             </td>
                         
                             <td>
                                 <div data-toggle="tooltip" data-placement="bottom" title="{{$image->content}}">
                                     {!!mb_strimwidth($image->content, 0, 10, "...")!!}
                                 </div>
                             </td>
                             <!--<td>{{$image->rem}}</td>-->
                              <td style="height:130px;width:130px"><img src="{{$image->url_thumb}}" style="height:130px;width:130px"></td>
                             <td>
                              <input type="checkbox" class="visible-change" data-url="images" name="visible" @if($image->visible==1) checked @endif data-id="{{$image->id}}">
                             </td>
                             <td>
                                 <a href="/admin/images/{{$image->id}}/edit?page=<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" class="btn btn-info" data-toggle="modal" data-target="#editImage{{$image->id}}">Edit</a>
                                 <div id="editImage{{$image->id}}" class="modal fade" >
                                     <div class="modal-dialog">
                                         <div class="modal-content" style="width:860px">

                                         </div>
                                     </div>
                                 </div>

                                 <a href="/admin/images/del/{{$image->id}}?page=<?php if (isset($_GET['page'])) echo $_GET['page']; ?>&albSel={{$image->albom_id}}" class="btn btn-danger" data-toggle="modal" data-target="#delImage{{$image->id}}">Delete</a>

                                 <div id="delImage{{$image->id}}"  class="modal fade">
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

                 @if ($images && (!isset($all)))

                    @if (!isset($limit))
                    {!! $images->appends(Input::except('page'))->render() !!}
                    <ul class="pagination">
                    <li><a href="/admin/images/all">All</a></li>
                    </ul>
                    @else
                    <ul class="pagination">
                    <li><a href="/admin/images">1</a></li>
                    </ul>
                    @endif

                 @else
                 <ul class="pagination">
                 <li><a href="/admin/images">1</a></li>
                 </ul>
                 @endif
                 <input type="hidden" id="pageNumb" value="<?php if (isset($_GET['page'])) echo $_GET['page']; else echo '1'; ?>">
             </div>
        </div>

    </div>
</div>

</div>

@include('admin._partials.del-modal', ['url' => '/admin/images/del_many'])

@include('admin._partials.modal', ['elementId' => 'createImage', 'alboms' => $alboms])

@include('admin.js')

