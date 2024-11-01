@extends('layouts.vertical', ['title' => __('Bonus Material')])

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Bonus Material') }}</h4>
            </div>
        </div>
    </div>
    <div class="material-container" style="display: none;">
            <div class="row bg-light mt-2 pt-2">
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{ __('Description') }} AR<span class="text-danger">*</span></label>
                                <input type="text" name="description_ar[]" class="form-control" placeholder="{{ __('Description') }}" >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{ __('Description') }} EN<span class="text-danger">*</span></label>
                                <input type="text" name="description_en[]" class="form-control" placeholder="{{ __('Description') }}" >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>{{ __('Type') }} <span class="text-danger">*</span></label>
                            <select name="type[]" class="form-control video-or-vimeo-type" data-placeholder="{{ __('Select') }}">
                                <option value="video" selected>{{ __('Video') }}</option>
                                <option value="vimeo" >{{ __('Vimeo') }}</option>
                            </select>
                        </div>
                        <div class="col-sm-4 video-type-input">
                            <div class="form-group">
                                <label>{{ __('File') }} <span class="text-danger">*</span></label>
                                <input type="file" name="file[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4 vimeo-type-input" style="display: none;">
                            <div class="form-group">
                                <label>{{ __('Vimeo') }}<span class="text-danger">*</span></label>
                                <input type="text" name="vimeo[]" class="form-control" placeholder="{{ __('Vimeo') }}" >
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
                <form id="materialForm" action="{{ $action }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @if(isset($bonusMaterial))
                    {{ method_field('PUT') }}
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Name') }} AR<span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$bonusMaterial->name_ar }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Name') }} EN<span class="text-danger">*</span></label>
                                <input type="text" name="name_en" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$bonusMaterial->name_en }}">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="materialContainer">
                        @if(isset($bonusMaterial) && $bonusMaterial->materials->count())
                            @foreach($bonusMaterial->materials as $bonusMaterial)
                                <div class="row bg-light mt-2 pt-2">
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>{{ __('Description') }} AR<span class="text-danger">*</span></label>
                                                    <input type="text" name="description_ar[]" class="form-control" placeholder="{{ __('Description') }}" value="{{ $bonusMaterial->description_ar }}" >
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>{{ __('Description') }} EN<span class="text-danger">*</span></label>
                                                    <input type="text" name="description_en[]" class="form-control" placeholder="{{ __('Description') }}" value="{{ $bonusMaterial->description_en }}" >
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>{{ __('Type') }} <span class="text-danger">*</span></label>
                                                <select name="type[]" class="form-control video-or-vimeo-type" data-placeholder="{{ __('Select') }}">
                                                    <option value="video" @if($bonusMaterial->type == 0) {{ 'selected' }} @endif>{{ __('Video') }}</option>
                                                    <option value="vimeo" @if($bonusMaterial->type == 1) {{ 'selected' }} @endif>{{ __('Vimeo') }}</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 vimeo-type-input" style="@if($bonusMaterial->type == 1) display: none; @endif">
                                                <div class="form-group">
                                                    <label>{{ __('File') }} <span class="text-danger">*</span></label>
                                                    <input type="file" name="file[]" class="form-control">
                                                    @if(@$bonusMaterial->file)
                                                        <a href="{{ url(uploads_files('bonus_material', null,true) . '/' . $bonusMaterial->file) }}" target="_blank">{{ $bonusMaterial->file }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-4 vimeo-type-input" style="@if($bonusMaterial->type == 0) display: none; @endif">
                                                <div class="form-group">
                                                    <label>{{ __('Vimeo') }}<span class="text-danger">*</span></label>
                                                    <input type="text" name="vimeo[]" class="form-control" placeholder="{{ __('Vimeo') }}" value="{{ $bonusMaterial->file }}">
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
                                                <label>{{ __('Description') }} AR<span class="text-danger">*</span></label>
                                                <input type="text" name="description_ar[]" class="form-control" placeholder="{{ __('Description') }}" >
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>{{ __('Description') }} EN<span class="text-danger">*</span></label>
                                                <input type="text" name="description_en[]" class="form-control" placeholder="{{ __('Description') }}" >
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>{{ __('Type') }} <span class="text-danger">*</span></label>
                                            <select name="type[]" class="form-control video-or-vimeo-type" data-placeholder="{{ __('Select') }}">
                                                <option value="video" selected>{{ __('Video') }}</option>
                                                <option value="vimeo" >{{ __('Vimeo') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 video-type-input">
                                            <div class="form-group">
                                                <label>{{ __('File') }} <span class="text-danger">*</span></label>
                                                <input type="file" name="file[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 vimeo-type-input" style="display: none;">
                                            <div class="form-group">
                                                <label>{{ __('Vimeo') }}<span class="text-danger">*</span></label>
                                                <input type="text" name="vimeo[]" class="form-control" placeholder="{{ __('Vimeo') }}" >
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
    <!-- Plugins js-->
    <script >
        $("#addMaterial").click(function(){
            $row = $('.material-container').html();
            $("#materialContainer").append($row);
        });

        $(document).on('click', ".remove-material", function () {
            $(this).closest('.bg-light').remove();
        });

        $(document).on('change', ".video-or-vimeo-type", function () {
            $row = $(this).closest('.row');
            $video = $row.find('.video-type-input');
            $vimeo = $row.find('.vimeo-type-input');

            if($(this).val() == "vimeo") {
                $video.hide();
                $vimeo.show();
            } else{
                $video.show();
                $vimeo.hide();
            }
        });
    </script>
@endsection