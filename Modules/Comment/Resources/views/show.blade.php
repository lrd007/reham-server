<div class="modal-header bg-light">
    <h4 class="modal-title" >{{ __('Comment') }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-4">
    <div class="row">
        <div class="col-sm-7">
            <label >{{ __('Comment By') }}</label>
            <p class="font-weight-bold">{{ @$comment->user->name }}</p>
        </div>
        <!-- <div class="col-sm-5">
            <label >{{ __('Program') }}</label>
            <p><span class="font-weight-bold text-primary">{{  @$comment->program->{'name' . withLocalization()} }}</span></p>
        </div> -->
        <div class="col-sm-5">
            <label >{{ __('Status') }}</label>
            <p class="font-weight-bold mb-0">{!! isActive($comment->deleted_at) !!}</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <label >{{ __('Comment') }}</label>
            <p>{!! @$comment->comment !!}</p>
        </div>
    </div>
</div>