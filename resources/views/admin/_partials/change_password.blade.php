
<div class="panel-body" >
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"> 
  Change Admin Password
  </a>
</div> 

<div class="panel-body collapse" style="width:50%" id="collapseExample">
                    {!!Form::open(array('url'=>'admin/password', 'class'=>'block small center login'))!!}
                       <h6>Please change your password below.</h6>

    <div class="form-group">
    <label for="oldPassword">Old Password</label> 
    
    <input class="form-control" type="password" id="oldPassword" placeholder="Old Password" 
           value="{{old('old_password') ? old('old_password') : ''}}" name="old_password">
    </div>
                        
    <div class="form-group">
    <label for="newPassword">New Password</label> 
     <input class="form-control" type="password" id="newPassword" placeholder="New Password" 
            value="{{old('password') ? old('password') : ''}}" name="password">
    </div>
                       
    <div class="form-group">
    <label for="confirmNewPassword">Confirm New Password</label> 
    
    <input class="form-control" type="password" id="confirmNewPassword" placeholder="Confirm New Password" 
            value="{{old('password_confirmation') ? old('password_confirmation') : ''}}" name="password_confirmation">
    </div> 
                        
    {!!Form::submit('Change', array('class'=>'btn btn-default'))!!}
    {!!Form::close() !!}    
</div> 
