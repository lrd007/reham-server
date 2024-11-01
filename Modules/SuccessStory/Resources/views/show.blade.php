<div class="modal-header bg-light">
    <h4 class="modal-title" >{{ __('Success Story') }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-4">
    <!-- <div class="row">
        <div class="col-sm-7">
            <label >{{ __('Program') }}</label>
            <p><span class="font-weight-bold text-primary">{{  @$successstory->program->{'name' . withLocalization()} }}</span></p>
        </div>
        <div class="col-sm-5">
            <label >{{ __('Course') }}</label>
            <p class="font-weight-bold text-info">{{ @$successstory->course->{'name' . withLocalization()} }}</p>
        </div>
    </div>  -->
    <div class="row">
        <div class="col-sm-7">
            <label >{{ __('Subscriber') }}</label>
            <p class="font-weight-bold">{{ @$successstory->user->name }}</p>
        </div>
        <div class="col-sm-5">
            <label >{{ __('Status') }}</label>
            <p class="font-weight-bold">{!! isActive($successstory->deleted_at) !!}</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <label >{{ __('Title') }}</label>
            <p>{!! @$successstory->title !!}</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <label >{{ __('Comment') }}</label>
            <p>{!! @$successstory->comment !!}</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <label >{{ __('Video') }}</label>
            <p> <a href="{{ url(uploads_files('success_story', null,true) . '/' . $successstory->file) }}" target="_blank">{{ $successstory->file }}</a></p>
        </div>
    </div>
</div>