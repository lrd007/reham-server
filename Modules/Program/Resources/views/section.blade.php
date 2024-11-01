@extends('layouts.vertical', ['title' => __('Section')])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Section') }}</h4>
            </div>
        </div>
    </div>

    <div class="material-container" style="display: none;">
        <div class="row bg-light mt-2 pt-2">
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ __('Title') }} AR<span class="text-danger">*</span></label>
                            <input type="text" name="title_ar[]" class="form-control" placeholder="{{ __('Title') }}" >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ __('Title') }} EN<span class="text-danger">*</span></label>
                            <input type="text" name="title_en[]" class="form-control" placeholder="{{ __('Title') }}" >
                        </div>
                    </div>
                    <div class="col-sm-4 video-type-input">
                        <div class="form-group">
                            <label>{{ __('Image') }} <span class="text-danger">*</span></label>
                            <input type="file" name="image[]" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{ __('Description') }} AR<span class="text-danger">*</span></label>
                            <input type="text" name="description_ar[]" class="form-control" placeholder="{{ __('Description') }}" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{ __('Description') }} EN<span class="text-danger">*</span></label>
                            <input type="text" name="description_en[]" class="form-control" placeholder="{{ __('Description') }}" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-danger waves-effect waves-light mt-4 remove-material mb-2" >{{ __('Remove') }} </button>
                        </div>
                    </div>
                </div>                    
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <form id="materialForm" action="{{ route('program.section.element') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @if(isset($section))
                        <input type="hidden" name="section_id" value="{{ $section->id }}">
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>{{ __('Title') }} AR<span class="text-danger">*</span></label>
                                <input type="text" name="section_title_ar" class="form-control" placeholder="{{ __('Title') }}" value="{{ @$section->title_ar }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>{{ __('Title') }} EN<span class="text-danger">*</span></label>
                                <input type="text" name="section_title_en" class="form-control" placeholder="{{ __('Title') }}" value="{{ @$section->title_en }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>{{ __('Program') }} <span class="text-danger">*</span></label>
                                <select name="program" class="form-control select2" data-placeholder="{{ __('Select') }}" >
                                    @foreach($programs as $key => $program)
                                        <option value="{{ $program->id }}" @if(isset($section) && $section->program_id == $program->id) {{ 'selected' }} @endif>{{ $program->{'name' . withLocalization()} }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0">
                    <label class="mb-3">{{ __('Element') }}</label>
                    <div id="materialContainer">
                        @if(isset($section) && $section->elements->count())
                            @foreach($section->elements as $element)
                                <div class="row bg-light mt-2 pt-2">
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>{{ __('Title') }} AR<span class="text-danger">*</span></label>
                                                    <input type="text" name="title_ar[]" class="form-control" placeholder="{{ __('Title') }}" value="{{ $element->title_ar }}" >
                                                    <input type="hidden" name="element_id[]" value="{{ $element->id }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>{{ __('Title') }} EN<span class="text-danger">*</span></label>
                                                    <input type="text" name="title_en[]" class="form-control" placeholder="{{ __('Title') }}" value="{{ $element->title_en }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 video-type-input">
                                                <div class="form-group">
                                                    <label>{{ __('Image') }} <span class="text-danger">*</span></label>
                                                    <input type="file" name="image[]" class="form-control">
                                                    @if(@$element->image)
                                                        <a href="{{ url(uploads_files('program_elements', null,true) . '/' . $element->image) }}" target="_blank">{{ $element->image }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>{{ __('Description') }} AR<span class="text-danger">*</span></label>
                                                    <input type="text" name="description_ar[]" class="form-control" placeholder="{{ __('Description') }}" value="{{ $element->description_ar }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>{{ __('Description') }} EN<span class="text-danger">*</span></label>
                                                    <input type="text" name="description_en[]" class="form-control" placeholder="{{ __('Description') }}" value="{{ $element->description_ar }}" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="text-right">
                                                    @if($loop->first)
                                                        <button type="button" id="addMaterial" class="btn btn-sm btn-primary waves-effect waves-light mt-4 mb-2">{{ __('Add More') }} </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-danger waves-effect waves-light mt-4 remove-material">{{ __('Remove') }} </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row bg-light pt-2">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>{{ __('Title') }} AR<span class="text-danger">*</span></label>
                                                <input type="text" name="title_ar[]" class="form-control" placeholder="{{ __('Title') }}" >
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>{{ __('Title') }} EN<span class="text-danger">*</span></label>
                                                <input type="text" name="title_en[]" class="form-control" placeholder="{{ __('Title') }}" >
                                            </div>
                                        </div>
                                        <div class="col-sm-4 video-type-input">
                                            <div class="form-group">
                                                <label>{{ __('Image') }} <span class="text-danger">*</span></label>
                                                <input type="file" name="image[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>{{ __('Description') }} AR<span class="text-danger">*</span></label>
                                                <input type="text" name="description_ar[]" class="form-control" placeholder="{{ __('Description') }}" >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>{{ __('Description') }} EN<span class="text-danger">*</span></label>
                                                <input type="text" name="description_en[]" class="form-control" placeholder="{{ __('Description') }}" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="text-right">
                                        <button type="button" id="addMaterial" class="btn btn-sm btn-primary waves-effect waves-light mt-4 mb-2">{{ __('Add More') }} </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="text-right">
                        <button type="button" id="saveButton" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
                    </div>
                </form>
            </div>  
        </div>    
    </div>
</div>
@endsection

@section('script')
    <script>
        $("#addMaterial").click(function(){
            $row = $('.material-container').html();
            $("#materialContainer").append($row);
        });

        $(document).on('click', ".remove-material", function () {
            $(this).closest('.bg-light').remove();
        });
    </script>
@endsection