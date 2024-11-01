<div class="modal-header bg-light">
    <h4 class="modal-title" id="myCenterModalLabel">Update {{ isset($isTeacher) && $isTeacher ? 'Teacher' : 'Admin' }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-4">
    @include('admin::form')
</div>