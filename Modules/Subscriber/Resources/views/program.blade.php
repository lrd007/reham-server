@can('subscriber.create')
    <div class="row d-flex flex-row-reverse mb-2">
        <div class="col-auto">
            <button type="button" class="btn btn-primary waves-effect waves-light text-right modal-button" data-url="{{ route('subscriber.program.create', isset($subscriber) ? $subscriber->id : 0) }}" data-toggle="modal" >{{ __('Add New') }}</button>
        </div>
    </div>
    <hr>
@endcan
@include('layouts.shared/data-table')