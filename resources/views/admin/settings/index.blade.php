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
				<div class="panel-heading">Administration Panel - Настройки</div>

				<div class="panel-body">
            {!! link_to_route('admin.settings.create', 'Create New Setting', array() ,array('class' => '', 'data-toggle'=>'modal', 'data-target'=>'#createSetting') ) !!}<br><br>
             <div class="table-responsive"> 
                 <table class="table table-bordered" data-search="true" data-url="">
                     <thead>
                         <tr>
                             <th data-sortable="true">ID</th>
                             <th>Name</th>
                             <th>Value</th>
                             <th>Description</th>
                             <th>Rem</th>
                             <th>Operations</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($settings as $setting)
                         <tr>
                             <td >{{$setting->id}}</td>
                             <td>{{$setting->name}}</td>
                             <td>{{$setting->value}}</td>
                             <td>{{$setting->description}}</td>
                             <td>{{$setting->rem}}</td>
                             <td>
                                 
                                 <a href="/admin/settings/{{$setting->id}}/edit?page=<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" class="btn btn-info" data-toggle="modal" data-target="#editSetting{{$setting->id}}">Edit</a>
                                 <div id="editSetting{{$setting->id}}" class="modal fade" >
                                     <div class="modal-dialog">
                                         <div class="modal-content">

                                         </div>
                                     </div>
                                 </div>

                                 <a href="/admin/settings/del/{{$setting->id}}?page=<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" class="btn btn-danger" data-toggle="modal" data-target="#delSetting{{$setting->id}}">Delete</a>

                                 <div id="delSetting{{$setting->id}}"  class="modal fade">
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

                 @if ($settings && count($settings) && (!isset($all)))

                 {!! $settings->appends(Input::except('page'))->render() !!}
                 <ul class="pagination">
                 <li><a href="/admin/settings/all">All</a></li>
                 </ul>
                 @else
                 <ul class="pagination">
                 <li><a href="/admin/settings">1</a></li>
                 </ul>
                 @endif
                 
             </div>
        </div>
        
    </div> 
</div>
    
</div>    

@include('admin._partials.modal', ['elementId' => 'createSetting']) 

@include('admin.js')
    

