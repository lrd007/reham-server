<div class="modal-header bg-light">
    <h4 class="modal-title" >{{ __('Add Course Package') }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-4">
    @include('course::coursepackage.form')
</div>