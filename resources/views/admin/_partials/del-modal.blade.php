<div class="modal fade" id="delete_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>Are You Sure?</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete these Items?</p>
                <span style="word-wrap: break-word;"></span>
            </div>
            
            <div class="modal-footer">
                {!! Form::open(array('class' => 'form-inline', 'method' => 'POST', 'url' => $url)) !!}
                <a data-toggle="modal" href="#delete_modal" class="btn">Keep</a>
                <input class="form-control" name="page" type="hidden" value="<?php if (isset($_GET['page'])) echo $_GET['page']; ?>" id="page">
                 <input class="albSel" name="albSel" type="hidden" value="<?php if (isset($_GET['albSel'])) echo $_GET['albSel']; ?>" class="">
                <input type="hidden" name="hashes" id="postvalue" value="">
                {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                {!! Form::close() !!}
            </div>
            
        </div>
    </div>
</div>

