<form id="contactForm" method="post" action="{{ route('user.register.step.five.post') }}" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12" id="contactFields">
            @php
                $i = 1;
                $contacts = isset($contacts) ? $contacts : request()->session()->get('contacts');
            @endphp
            @if ($contacts)
                @foreach ($contacts as $value)
                <div class="form-group row mb-3" id="{{ $i }}">
                    <div class="col-md-3">
                        <input type="text" id="name" name="name[]" class="form-control" placeholder="Name *" value="{{ isset($value['name']) ? $value['name'] : $value[0] }}" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="mobile" name="mobile[]" class="form-control" placeholder="Mobile Number *" value="{{ isset($value['mobile']) ? $value['mobile'] : $value[1] }}" required>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="relationship[]" id="relationship" data-placeholder="{{ __('Select') }}" >
                            @if (config('constant.relation' . withLocalization()))
                                <option value="">{{ __('Choose Relation') }}</option>
                                @foreach (config('constant.relation' . withLocalization()) as $relationName => $value)
                                    <option value="{{ $relationName }}" @if (isset($value['relationship']) ? $value['relationship'] == $relationName : $value[2] == $relationName) selected="selected" @endif>{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                    @if ($i > 1)
                        <button type="button" name="remove" id="{{ $i }}" class="btn btn-danger btn_remove"><i class="fa fa-minus"></i></button>
                    @else
                        <button type="button" name="add" id="add" class="btn btn-primary" value="submit"><i class="fa fa-plus"></i></button>
                    @endif
                    </div>
                </div>
                @php
                    $i++;
                @endphp
                @endforeach
            @else
            <div class="form-group row mb-3" id="{{ $i }}">
                <div class="col-md-3">
                    <input type="text" id="name" name="name[]" class="form-control @if ($errors->has('name'))parsley-error @endif"" placeholder="Name *" required>
                    @if ($errors->has('name'))
                        <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                            <li class="parsley-required">{{ $errors->first('name') }}</li>
                        </ul>
                    @endif
                </div>
                <div class="col-md-3">
                    <input type="text" id="mobile" name="mobile[]" class="form-control @if ($errors->has('mobile'))parsley-error @endif"" placeholder="Mobile Number *" required>
                    @if ($errors->has('mobile'))
                        <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                            <li class="parsley-required">{{ $errors->first('mobile') }}</li>
                        </ul>
                    @endif
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="relationship[]" id="relationship" data-placeholder="{{ __('Select') }}">
                        @if (config('constant.relation' . withLocalization()))
                            <option value="">{{ __('Choose Relation') }}</option>
                            @foreach (config('constant.relation' . withLocalization()) as $relationName => $value)
                                <option value="{{ $relationName }}">{{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('relationship'))
                        <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                            <li class="parsley-required">{{ $errors->first('relationship') }}</li>
                        </ul>
                    @endif
                </div>
                <div class="col-md-3">
                    <button type="button" name="add" id="add" class="btn btn-primary" value="submit"><i
                            class="fa fa-plus"></i></button>
                </div>
            </div>
            @endif
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
    <p class="text-muted font-14">Note: (*) marked fields are mandatory fields</p>
    <ul class="list-inline wizard mb-0">
        <li class="previous list-inline-item">
            <a href="{{ auth()->check() && auth()->user()->can('applicant_registration.index') ? route('applicant.step-four') : route('user.register.step.four.get') }}" class="btn btn-secondary">Previous</a>
        </li>
        <li class="next list-inline-item float-right">
            <button type="button" id="submitRegForm" class="btn btn-secondary">Next</button>
        </li>
    </ul>
</form>

@section('script-bottom')
<script type="text/javascript">
    var $relationship = $("#relationship").closest('div').html();
    $(document).ready(function() {
        var i = {{$i}};

        $('#add').click(function() {
            i++;
            $row = '<div class="form-group row mb-3" id="'+ i +'"><div class="col-md-3"><input type="text" id="name" name="name[]" class="form-control" placeholder="Name *" required></div><div class="col-md-3"><input type="text" id="mobile[]" name="mobile[]" class="form-control" placeholder="Mobile Number *"required></div><div class="col-md-3">'+ $relationship +'</div><div class="col-md-3"><button type="button" name="remove" id="'+ i +'" class="btn btn-danger btn_remove"><i class="fa fa-minus"></i></button></div></div>';
            $('#contactFields').append($row);
        });


        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#' + button_id + '').remove();
        });
    });
</script>

<script src="{{ asset('assets/js/modules/core/sweet-alert.init.js') }}"></script>
<script src="{{ asset('assets/js/modules/user/register.init.js') }}"></script>
@endsection