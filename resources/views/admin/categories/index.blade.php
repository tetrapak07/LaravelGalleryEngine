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
				<div class="panel-heading">Administration Panel - Категории</div>

				<div class="panel-body">
            <a class="delete_selected btn btn-danger disabled">Delete Selected</a>
            {!! link_to_route('admin.categories.create', 'Create New Category', array() ,array('class' => '', 'data-toggle'=>'modal', 'data-target'=>'#createCategory') ) !!}<br><br>
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
                             <th>Title</th>
                            
                             <th>On/Off</th>
                             <th>Operations</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($categories as $category)
                         <tr>
                             <td>
                                 <div>
                                     <input type="checkbox" id="id{{$category->id}}" data-id="{{$category->id}}">
                                 </div>
                             </td>
                             <td class="delete_toggler">{{$category->id}}</td>
                             <td>{{$category->title}}</td>
                         
                             <td>
                              <input type="checkbox" class="categories-visible" name="visible" @if($category->visible==1) checked @endif data-id="{{$category->id}}">
                             </td>
                             <td>
                                 <a href="/admin/categories/{{$category->id}}/edit?page=<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" class="btn btn-info" data-toggle="modal" data-target="#editCategory{{$category->id}}">Edit</a>
                                 <div id="editCategory{{$category->id}}" class="modal fade" >
                                     <div class="modal-dialog">
                                         <div class="modal-content">

                                         </div>
                                     </div>
                                 </div>

                                 <a href="/admin/categories/del/{{$category->id}}?page=<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" class="btn btn-danger" data-toggle="modal" data-target="#delCategory{{$category->id}}">Delete</a>

                                 <div id="delCategory{{$category->id}}"  class="modal fade">
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

                 @if ($categories && (!isset($all)))

                 {!! $categories->appends(Input::except('page'))->render() !!}
                 <ul class="pagination">
                 <li><a href="/admin/categories/all">All</a></li>
                 </ul>
                 @else
                 <ul class="pagination">
                 <li><a href="/admin/categories">1</a></li>
                 </ul>
                 @endif
                 
             </div>
        </div>
        
    </div> 
</div>
    
</div> 

@include('admin._partials.del-modal', ['url' => '/admin/categories/del_many']) 

@include('admin._partials.modal', ['elementId' => 'createCategory']) 

@include('admin.js')

