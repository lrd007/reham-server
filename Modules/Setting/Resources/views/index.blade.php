@extends('layouts.vertical', ['title' => __('Site Configuration') ])

@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('Site Configuration') }}</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
        <div class="row">
            <div class="col-xl-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active show mb-1" id="v-pills-landing-tab" data-toggle="pill" href="#v-pills-landing" role="tab" aria-controls="v-pills-landing"
                                    aria-selected="true">{{ __('Landing Page') }}</a>
                                <a class="nav-link mb-1" id="v-pills-subscriber-page-tab" data-toggle="pill" href="#v-pills-subscriber-page" role="tab" aria-controls="v-pills-subscriber-page"
                                aria-selected="true">{{ __('Subscriber Page') }}</a>
                                <a class="nav-link mb-1" href="{{ route('suggested-course.preview') }}" role="tab"
                                aria-selected="true" target="_blank">{{ __('Suggested Course Page') }}</a>
                                <!-- <a class="nav-link mb-1" id="v-pills-header-tab" data-toggle="pill" href="#v-pills-header" role="tab" aria-controls="v-pills-header"
                                    aria-selected="false">{{ __('Header') }}</a> -->
                                <a class="nav-link mb-1" id="v-pills-footer-tab" data-toggle="pill" href="#v-pills-footer" role="tab" aria-controls="v-pills-footer"
                                    aria-selected="false">{{ __('Footer') }}</a>
                            </div>
                        </div> <!-- end col-->
                        <div class="col-sm-9">
                            <div class="tab-content pt-0">
                                <div class="tab-pane fade active show" id="v-pills-landing" role="tabpanel" aria-labelledby="v-pills-landing-tab">
                                    @include('setting::landing')
                                </div>
                                <div class="tab-pane fade" id="v-pills-subscriber-page" role="tabpanel" aria-labelledby="v-pills-subscriber-page-tab">
                                    @include('setting::subscriber-page')
                                </div>
                                <div class="tab-pane fade" id="v-pills-header" role="tabpanel" aria-labelledby="v-pills-header-tab">
                                    @include('setting::header')
                                </div>
                                <div class="tab-pane fade" id="v-pills-footer" role="tabpanel" aria-labelledby="v-pills-footer-tab">
                                    @include('setting::footer')
                                </div>
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row-->
                    
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
        
    </div> <!-- container -->
    
@endsection
@section('script')
    <!-- Plugins js-->
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script>
        $("#contact_type, #subscriber_event_type").on('change', function(){
            $(this).closest('.row').find('.contact-type-input').hide();
            $(this).closest('.row').find("." + $(this).val() + "-container").show();
        });
        $('.select2').select2({
            placeholder: $(this).data('placeholder') ?? "Select"
        });
    </script>
@endsection