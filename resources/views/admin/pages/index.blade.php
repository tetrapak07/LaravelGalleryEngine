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
  
	<div class="col-md-10 col-md-offset">
   <div class="panel panel-default">
				<div class="panel-heading">Administration Panel - Страницы</div>

				<div class="panel-body">
            <a class="delete_selected btn btn-danger disabled">Delete Selected</a>
            
            <div class="col-md-13 col-md-offset" style="float:right;"> 
            {!! Form::open(array('class' => 'form-inline', 'method' => 'POST', 'url' => '/admin/pages/filter')) !!}

             <input class="form-control" name="limit" type="text" value="{{isset($limit) ? $limit : '10'}}" placeholder="макс. кол-во (шт.)">
             <select class="form-control cats" name="catSel" style="">
                                         <option value="NULL">Без категории</option>
                                         @foreach ($categories as $category)
                                         <option  value="{{$category->id}}"  @if(isset($catSel)&&($category->id == $catSel)) selected @endif>
                                                  {{$category->title}}
                                         </option>
                                         @endforeach
             </select>
             {!! Form::submit('apply', array('class' => 'btn btn-info')) !!}
             {!! Form::close() !!}
             </div>   
             <br><br>
             <div class="table-responsive"> 
                 <table class="table table-bordered" data-search="true" data-url="pages">
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
                             <th>
                              <div>
                                  <input type="checkbox" id="SelectAllVisible" data-url="pages"> Visible
                              </div>
                             </th>
                             <th>Operations</th>
                         </tr>
                     </thead>
                     <tbody>
                        @foreach ($pages as $page)
                         <tr>
                             <td>
                                 <div>
                                     <input type="checkbox" class="pages-delete" id="id{{$page->id}}" data-id="{{$page->id}}">
                                 </div>
                             </td>
                             <td class="delete_toggler">{{$page->id}}</td>
                             <td>
                                 <div class="form-group block" data-id="{{$page->id}}">
                                   
                                     <select class="form-control pagesCats" id="catAlb{{$page->id}}" data-id="{{$page->id}}" style="width:90%">
                                         <option page-id="{{$page->id}}" value="NULL">Без категории</option>
                                         @foreach ($categories as $category)
                                         <option page-id="{{$page->id}}" value="{{$category->id}}" @if ($page->category_id == $category->id) selected @endif>
                                                  {{$category->title}}
                                         </option>
                                         @endforeach
                                     </select>
                                    
                                 </div>    
                             </td>
                             <td>
                                 <div data-toggle="tooltip" data-placement="bottom" title="{{$page->title}}">
                                 {!!mb_strimwidth($page->title, 0, 10, "...")!!}
                                 </div>
                             </td>
                             <td>
                                 <div data-toggle="tooltip" data-placement="bottom" title="{{$page->description}}">
                                     {!!mb_strimwidth($page->description, 0, 10, "...")!!}
                                 </div>
                             </td>
                            
                             <td>
                                 <div data-toggle="tooltip" data-placement="bottom" title="{{$page->content}}">
                                     {!!mb_strimwidth($page->content, 0, 10, "...")!!}
                                 </div>
                             </td>
                              <td>
                                 <div data-toggle="tooltip" data-placement="bottom" title="{{$page->keywords}}">
                                 {!!mb_strimwidth($page->keywords, 0, 10, "...")!!}
                                 </div>
                              </td> 
                             <td>
                              <input type="checkbox" class="visible-change" data-url="pages" name="visible" @if($page->visible==1) checked @endif data-id="{{$page->id}}">
                             </td>
                             <td>
                                 <a href="/admin/pages/{{$page->id}}/edit?page=<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" class="btn btn-info" data-toggle="modal" data-target="#editPage{{$page->id}}">Edit</a>
                                 <div id="editPage{{$page->id}}" class="modal fade" >
                                     <div class="modal-dialog">
                                         <div class="modal-content">

                                         </div>
                                     </div>
                                 </div>

                                 <a href="/admin/pages/del/{{$page->id}}?page=<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" class="btn btn-danger" data-toggle="modal" data-target="#delPage{{$page->id}}">Delete</a>

                                 <div id="delPage{{$page->id}}"  class="modal fade">
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

                 @if ($pages && (!isset($all)))
                 
                    @if (!isset($limit))
                    {!! $pages->appends(Input::except('page'))->render() !!}
                    <ul class="pagination">
                    <li><a href="/admin/pages/all">All</a></li>
                    </ul>
                    @else
                    <ul class="pagination">
                    <li><a href="/admin/pages">1</a></li>
                    </ul>
                    @endif
                   
                 @else
                 <ul class="pagination">
                 <li><a href="/admin/pages">1</a></li>
                 </ul>
                 @endif
                 <input type="hidden" id="pageNumb" value="<?php if (isset($_GET['page'])) echo $_GET['page']; else echo '1'; ?>">
             </div>
        </div>
        
    </div> 
</div>
    
</div> 

@include('admin._partials.del-modal', ['url' => '/admin/pages/del_many']) 

@include('admin.js')

