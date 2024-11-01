<form action="{{ $action }}" method="post">
    {{ csrf_field() }}
    @if(isset($faqCategory))
        {{ method_field('PUT') }}
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">{{ __('Name') }} AR</label><span class="text-danger">*</span>
                <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$faqCategory->name_ar }}" required />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">{{ __('Name') }} EN</label><span class="text-danger">*</span>
                <input type="text" name="name_en" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$faqCategory->name_en }}" required />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="radio radio-success form-check-inline ml-1">
                <input type="radio" value="0" name="type" @if(isset($faqCategory) && $faqCategory->type == 0 || !isset($faqCategory)) checked @endif>
                <label> {{ __('General') }} </label>
            </div>
            <div class="radio radio-success form-check-inline">
                <input type="radio" value="1" name="type" @if(@isset($faqCategory) && $faqCategory->type == 1) checked @endif>
                <label>{{ __('Legal') }} </label>
            </div>
        </div>
    </div>

    <div class="text-right">
        <button type="button" class="save-button btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" >{{ __('Cancel') }}</button>
    </div>
</form>