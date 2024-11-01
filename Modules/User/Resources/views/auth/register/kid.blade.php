<form id="kidForm" method="POST" action="{{ route('user.register.step.two.post') }}" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputFirstName" class="col-form-label">{{ __('First Name') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('first_name'))parsley-error @endif" id="inputFirstName" name="first_name" value="{{ request()->session()->get('kid_first_name') ?? old('first_name') }}" required>
            @if ($errors->has('first_name'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('first_name') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputFatherName" class="col-form-label">{{ __('Father Name') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('father_name'))parsley-error @endif" id="inputFatherName" name="father_name" value="{{ isset($father) && !empty($father) ? $father->first_name : ( request()->session()->get('kid_father_name') ?? old('father_name') ) }}" required>
            @if ($errors->has('father_name'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('father_name') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputGrandFatherName" class="col-form-label">{{ __('Grand Father Name') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('grand_father_name'))parsley-error @endif" id="inputGrandFatherName" name="grand_father_name" value="{{ isset($father) && !empty($father) ? $father->middle_name : ( request()->session()->get('kid_grand_father_name') ?? old('grand_father_name') ) }}" required>
            @if ($errors->has('grand_father_name'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('grand_father_name') }}</li>
                </ul>
            @endif
        </div>        
    </div>
    <!-- end row -->
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputFamilyName" class="col-form-label">{{ __('Family Name') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('family_name'))parsley-error @endif" id="inputFamilyName" name="family_name" value="{{ isset($father) && !empty($father) ? $father->last_name : ( request()->session()->get('kid_family_name') ?? old('family_name') ) }}" required>
            @if ($errors->has('family_name'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('family_name') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputDOB" class="col-form-label">{{ __('Date of Birth') }} <span class="text-danger">*</span></label>
            <input type="date" class="form-control @if ($errors->has('birth_date'))parsley-error @endif" id="inputDOB" name="birth_date" value="{{ request()->session()->get('kid_birth_date') ?? old('birth_date') }}" required>
            @if ($errors->has('birth_date'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('birth_date') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputPOB" class="col-form-label">{{ __('Birth Place') }} <span class="text-danger">*</span></label>
            <select id="inputPOB" name="birth_place" class="form-control @if ($errors->has('birth_place'))parsley-error @endif" data-placeholder="{{ __('Select') }}" required>
                @if ($countries)
                    <option value="">Choose</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->name }}" @if ($country->name == request()->session()->get('kid_birth_place') || $country->name == old('birth_place')) selected="selected" @endif >{{ $country->name }}</option>
                    @endforeach
                @endif
            </select>
            @if ($errors->has('birth_place'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('birth_place') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <!-- end row -->
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputNationality" class="col-form-label">Nationality From<span class="text-danger">*</span></label>
            <select id="inputNationality" name="nationality" class="form-control @if ($errors->has('nationality'))parsley-error @endif" data-placeholder="{{ __('Select') }}" required>
                @if ($countries)
                    <option value="">Choose</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->name }}" @if( $country->name == request()->session()->get('kid_nationality') || $country->name == old('nationality')) selected="selected" @endif>{{ $country->name }}</option>
                    @endforeach
                @endif
            </select>
            @if ($errors->has('nationality'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('nationality') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputGender" class="col-form-label">Gender <span class="text-danger">*</span></label>
            <select id="inputGender" name="gender" class="form-control @if ($errors->has('gender'))parsley-error @endif" data-placeholder="{{ __('Select') }}" required>
                @if (config('constant.gender' . withLocalization()))
                    <option value="">Choose</option>
                    @foreach (config('constant.gender' . withLocalization()) as $key => $value)
                        <option value="{{ $key }}" @if ($key == request()->session()->get('kid_gender') || $key = old('gender'))selected="selected"@endif>{{ $value }}</option>
                    @endforeach
                @endif
            </select>
            @if ($errors->has('civil_id_no'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('gender') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputCivilIDNo" class="col-form-label">Civil ID <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('civil_id_no'))parsley-error @endif" id="inputCivilIDNo" name="civil_id_no" value="{{ request()->session()->get('kid_civil_id_no') ?? old('civil_id_no') }}" required>
            @if ($errors->has('civil_id_no'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('civil_id_no') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <!-- end row -->
    <div class="form-row">
        
        <div class="form-group col-md-4" @if(empty(request()->session()->get('kid_nationality')) || !empty(request()->session()->get('kid_nationality')) && strtolower(request()->session()->get('kid_nationality')) === 'kuwait') style="display:none" @endif>
            <label for="inputPassportNo" class="col-form-label">Passport Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('passport_no'))parsley-error @endif" id="inputPassportNo" name="passport_no" value="{{ request()->session()->get('kid_passport_no') ?? old('passport_no') }}">
            @if ($errors->has('passport_no'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('passport_no') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4" @if(empty(request()->session()->get('kid_nationality')) || !empty(request()->session()->get('kid_nationality')) && strtolower(request()->session()->get('kid_nationality')) === 'kuwait') style="display:none" @endif>
            <label for="inputDOE" class="col-form-label">Date of Residence Expires <span class="text-danger">*</span></label>
            <input type="date" class="form-control @if ($errors->has('residence_expires_at'))parsley-error @endif" id="inputDOE" name="residence_expires_at" value="{{ request()->session()->get('kid_residence_expires_at') ?? old('residence_expires_at') }}" required>
            @if ($errors->has('residence_expires_at'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('residence_expires_at') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <!-- end row -->
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputLanguages" class="col-form-label">Languages <span class="text-danger">*</span></label>            
            @if (config('constant.languages'))
                @foreach (config('constant.languages') as $key => $value)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="languages[]" class="custom-control-input" id="{{ $key }}" value="{{ $key }}" @if ((!empty(request()->session()->get('kid_languages')) && in_array($key, request()->session()->get('kid_languages'))) || (!empty(old('languages')) && in_array($key, old('languages'))))checked @endif>
                        <label class="custom-control-label" for="{{ $key }}">{{ $value }}</label>
                    </div>
                @endforeach
            @endif
            @if ($errors->has('languages'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('languages') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <!-- end row -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label" for="inputImage">Image <span class="text-danger">*</span> {{ __('Image (300px X 300px)')  }}</label>
            <input type="file" id="inputImage" name="image" class="dropzone form-control @if ($errors->has('image'))parsley-error @endif" style="min-height: 75px;">
            @if ($errors->has('image'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('image') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label" for="inputCID">Civil ID / Passport <span class="text-danger">*</span></label>
            <input type="file" id="inputCID" name="civil_id" class="dropzone form-control @if ($errors->has('civil_id'))parsley-error @endif" style="min-height: 75px;">
            @if ($errors->has('civil_id'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('civil_id') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <!-- end row -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label" for="inputBC">Birth Certificate <span class="text-danger">*</span></label>
            <input type="file" id="inputBC" name="birth_certificate" class="dropzone form-control @if ($errors->has('birth_certificate'))parsley-error @endif" style="min-height: 75px;">
            @if ($errors->has('birth_certificate'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('birth_certificate') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label" for="inputVC">Vaccine Certificate <span class="text-danger">*</span></label>
            <input type="file" id="inputVC" name="vaccine_certificate" class="dropzone form-control @if ($errors->has('vaccine_certificate'))parsley-error @endif" style="min-height: 75px;">
            @if ($errors->has('vaccine_certificate'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('vaccine_certificate') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <!-- end row -->
    <ul class="list-inline wizard mb-0">
        <li class="previous list-inline-item">
            <a href="{{ auth()->check() && auth()->user()->can('applicant_registration.index') ? route('applicant.step-one') : route('user.register.step.one.get') }}" class="btn btn-secondary">Previous</a>
        </li>
        <li class="next list-inline-item float-right">
            <button type="button" id="submitRegForm" class="btn btn-secondary">Next</button>
        </li>
    </ul>
</form>

@section('script-bottom')
<script type="text/javascript" src="{{ asset('assets/js/modules/core/sweet-alert.init.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/modules/core/validation.init.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/modules/user/register.init.js') }}"></script>
@endsection