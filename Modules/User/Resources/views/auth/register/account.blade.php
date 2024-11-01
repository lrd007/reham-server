<form id="accountForm" method="POST" action="{{ route('user.register.step.one.post') }}" class="form-horizontal">
    @csrf
    @if(auth())
        <input type="hidden" name="new_registration" value="true">
    @endif
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label" for="inputBranch">Branch <span class="text-danger">*</span></label>
            <select id="branch" name="branch_id" class="form-control @if ($errors->has('branch_id'))parsley-error @endif" data-placeholder="{{ __('Select') }}" required>
                @if ($branches)
                    <option value="">Choose</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @if ($branch->id == request()->session()->get('branch_id'))selected="selected"@endif>{{ $branch->{'name' . withLocalization()} }}</option>
                    @endforeach
                @endif
            </select>
            @if ($errors->has('branch_id'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('branch_id') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label" for="inputGrade">Grade <span class="text-danger">*</span></label>
            <select id="grade" name="grade_id" class="form-control @if ($errors->has('grade_id'))parsley-error @endif" data-placeholder="{{ __('Select') }}" required></select>
            @if ($errors->has('branch_id'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('branch_id') }}</li>
                </ul>
            @endif
        </div>
    </div> <!-- end row -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label" for="inputCivilId">Father Civil ID <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('civil_id_no'))parsley-error @endif" id="inputCivilId" name="civil_id_no" value="{{ request()->session()->get('civil_id_no') ?? '' }}" required>
        </div>
        <!-- <div class="form-group col-md-6">
            <label class="col-form-label" for="inputPassword4">Password <span class="text-danger">*</span></label>
            <input type="password" id="inputPassword4" name="password" class="form-control @if ($errors->has('password'))parsley-error @endif" value="{{ request()->session()->get('password') ?? '' }}" required>
            @if ($errors->has('password'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('password') }}</li>
                </ul>
            @endif
        </div> -->
    </div> <!-- end row -->
    <ul class="list-inline wizard mb-0">
        <li class="next list-inline-item float-right">
            <button type="button" id="submitRegForm" class="btn btn-secondary">Next</button>
        </li>
    </ul>
</form>

@section('script-bottom')
<script type="text/javascript" src="{{ asset('assets/js/modules/core/sweet-alert.init.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/modules/user/register.init.js') }}"></script>
@endsection