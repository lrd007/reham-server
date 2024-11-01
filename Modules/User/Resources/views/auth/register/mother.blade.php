<form id="motherForm" method="POST" action="{{ route('user.register.step.four.post') }}" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="relationship" value="Mother">
    @if(isset($mother) && !empty($mother))
        <input type="hidden" name="mother_update" value="{{ $mother->id }}">
    @endif
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputFirstName" class="col-form-label">First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('first_name'))parsley-error @endif" id="inputFirstName" name="first_name" value="{{ isset($mother) && !empty($mother) ? $mother->first_name : ( request()->session()->get('mother_first_name') ?? old('first_name') ) }}">
            @if ($errors->has('first_name'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('first_name') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputMiddleName" class="col-form-label">Middle Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('middle_name'))parsley-error @endif" id="inputMiddleName" name="middle_name" value="{{ isset($mother) && !empty($mother) ? $mother->middle_name : ( request()->session()->get('mother_middle_name') ?? old('middle_name') ) }}">
            @if ($errors->has('middle_name'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('middle_name') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputLastName" class="col-form-label">Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('last_name'))parsley-error @endif" id="inputLastName" name="last_name" value="{{ isset($mother) && !empty($mother) ? $mother->last_name : ( request()->session()->get('mother_last_name') ?? old('last_name') ) }}">
            @if ($errors->has('last_name'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('last_name') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputCivilIDNo" class="col-form-label">Civil ID <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('civil_id_no'))parsley-error @endif" id="inputCivilIDNo" name="civil_id_no" value="{{ isset($mother) && !empty($mother) ? $mother->civil_id_no : ( request()->session()->get('mother_civil_id_no') ?? old('civil_id_no') ) }}">
            @if ($errors->has('civil_id_no'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('civil_id_no') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputNationality" class="col-form-label">Nationality From<span class="text-danger">*</span></label>
            <select id="inputNationality" name="nationality" class="form-control @if ($errors->has('nationality'))parsley-error @endif">
                @if ($countries)
                    <option value="">Choose</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->name }}" @if (isset($mother) && !empty($mother) ? $country->name == $mother->nationality : $country->name == request()->session()->get('mother_nationality')) selected="selected" @endif>{{ $country->name }}</option>
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
            <label for="inputMarital" class="col-form-label">Marital Status <span class="text-danger">*</span></label>
            <select id="inputMarital" name="marital_status" class="form-control @if ($errors->has('marital_status'))parsley-error @endif">
            @if (config('constant.marital_status' . withLocalization()))
                <option value="">Choose</option>
                @foreach (config('constant.marital_status' . withLocalization()) as $key => $value)
                    <option value="{{ $key }}" @if ( isset($mother) && !empty($mother) ? $key == $mother->marital_status : $key == request()->session()->get('mother_marital_status') )selected="selected"@endif>{{ $value }}</option>
                @endforeach
            @endif
            </select>
            @if ($errors->has('marital_status'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('marital_status') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <!-- end row -->
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputPhoneHome" class="col-form-label">Phone Home <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('phone_home'))parsley-error @endif" id="inputPhoneHome" name="phone_home" value="{{ isset($mother) && !empty($mother) ? $mother->phone_home : ( request()->session()->get('mother_phone_home') ?? old('phone_home') ) }}">
            @if ($errors->has('phone_home'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('phone_home') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputMobile" class="col-form-label">Mobile <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('mobile'))parsley-error @endif" id="inputMobile" name="mobile" value="{{ isset($mother) && !empty($mother) ? $mother->mobile : ( request()->session()->get('mother_mobile') ?? old('mobile') ) }}">
            @if ($errors->has('mobile'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('mobile') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputEmail4" class="col-form-label">Email</label>
            <input type="text" class="form-control @if ($errors->has('email'))parsley-error @endif" id="inputEmail4" name="email" value="{{ isset($mother) && !empty($mother) ? $mother->email : ( request()->session()->get('mother_email') ?? old('email') ) }}">
            @if ($errors->has('email'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('email') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <!-- end row -->
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputOccupation" class="col-form-label">Job Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('occupation'))parsley-error @endif" id="inputOccupation" name="occupation" value="{{ isset($mother) && !empty($mother) ? $mother->occupation : ( request()->session()->get('mother_occupation') ?? old('occupation') ) }}">
            @if ($errors->has('occupation'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('occupation') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="inputCompanyName" class="col-form-label">Company Name</label>
            <input type="text" class="form-control @if ($errors->has('company_name'))parsley-error @endif" id="inputCompanyName" name="company_name" value="{{ isset($mother) && !empty($mother) ? $mother->company_name : ( request()->session()->get('mother_company_name') ?? old('company_name') ) }}">
            @if ($errors->has('company_name'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('company_name') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <!-- end row -->
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="inputAddress2" class="col-form-label">Address <span class="text-danger">*</span></label>
            <input type="text" name="address" class="form-control @if ($errors->has('address'))parsley-error @endif" id="inputAddress2" placeholder="Apartment, studio, or floor" value="{{ isset($mother) && !empty($mother) ? $mother->address : ( request()->session()->get('mother_address') ?? old('address') ) }}">
            @if ($errors->has('address'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('address') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <!-- end row -->
    <div class="form-row">
        <div class="form-group col-md-4" @if(isset($mother) && !empty($mother) ? strtolower($mother->nationality) == 'kuwait' : ( empty(request()->session()->get('mother_nationality')) || !empty(request()->session()->get('mother_nationality')) && strtolower(request()->session()->get('mother_nationality')) === 'kuwait')) style="display:none" @endif>
            <label for="inputPassportNo" class="col-form-label">Passport Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control @if ($errors->has('passport_no'))parsley-error @endif" id="inputPassportNo" name="passport_no" value="{{ isset($mother) && !empty($mother) ? $mother->passport_no : ( request()->session()->get('mother_passport_no') ?? old('passport_no') ) }}">
            @if ($errors->has('passport_no'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('passport_no') }}</li>
                </ul>
            @endif
        </div>
        <div class="form-group col-md-4" @if(isset($mother) && !empty($mother) ? strtolower($mother->nationality) == 'kuwait' : ( empty(request()->session()->get('mother_nationality')) || !empty(request()->session()->get('mother_nationality')) && strtolower(request()->session()->get('mother_nationality')) === 'kuwait')) style="display:none" @endif>
            <label for="inputDOE" class="col-form-label">Date of Residence Expires <span class="text-danger">*</span></label>
            <input type="date" class="form-control @if ($errors->has('residence_expires_at'))parsley-error @endif" id="inputDOE" name="residence_expires_at" value="{{ isset($mother) && !empty($mother) ? $mother->residence_expires_at : ( request()->session()->get('mother_residence_expires_at') ?? old('residence_expires_at') ) }}">
            @if ($errors->has('residence_expires_at'))
                <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                    <li class="parsley-required">{{ $errors->first('residence_expires_at') }}</li>
                </ul>
            @endif
        </div>
    </div>
    <!-- end row -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label" for="inputCID">Civil ID / Passport <span class="text-danger">*</span></label>
            <input type="file" id="inputCID" name="civil_id" class="dropzone form-control @if ($errors->has('civil_id'))parsley-error @endif" style="min-height: 75px;">
            @if(isset($mother->civil_id) && !empty($mother->civil_id))
                <a href="{{ url(uploads_files(null, null,true) . '/' . $mother->civil_id) }}" target="_blank">{{ $mother->civil_id }}</a>
                <input type="hidden" name="civil_id_old" value="{{ $mother->civil_id }}">
            @endif
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Nationality Certificate</label>
            <input type="file" name="nationality_certificate" class="dropzone form-control @if ($errors->has('nationality_certificate'))parsley-error @endif" style="min-height: 75px;">
            @if(isset($mother->nationality_certificate) && !empty($mother->nationality_certificate))
                <a href="{{ url(uploads_files(null, null,true) . '/' . $mother->civil_id) }}" target="_blank">{{ $mother->nationality_certificate }}</a>
                <input type="hidden" name="nationality_certificate_old" value="{{ $mother->nationality_certificate }}">
            @endif
        </div>
    </div>
    <!-- end row -->
    <ul class="list-inline wizard mb-0">
        <li class="previous list-inline-item">
            <a href="{{ auth()->check() && auth()->user()->can('applicant_registration.index') ? route('applicant.step-three') : route('user.register.step.three.get') }}" class="btn btn-secondary">Previous</a>
        </li>
        <li class="next list-inline-item float-right">
            <button type="button" id="submitRegForm" class="btn btn-secondary">Next</button>
        </li>
    </ul>
</form>

@section('script-bottom')
<script src="{{ asset('assets/js/modules/core/sweet-alert.init.js') }}"></script>
<script src="{{ asset('assets/js/modules/core/validation.init.js') }}"></script>
<script src="{{ asset('assets/js/modules/user/register.init.js') }}"></script>
@endsection
