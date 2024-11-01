
@extends('layouts.vertical', ['title' => __('Subscriber')])

@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Subscriber') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('subscriber.create')
                        <div class="row d-flex flex-row-reverse mb-2">
                            <div class="col-auto">
                                <button class="btn btn-secondary modal-button" type="button" data-url="{{ route('subscriber.enrollment.filter') }}" data-toggle="modal">{{ __('Filter') }}</button>
                                @can('subscriber.export')
                                    <div class="btn-group" role="group">
                                        <button id="exportButton" type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('Export') }}</button>
                                        <div class="dropdown-menu" id="exportButtonDrop">
                                            <a data-href="{{ route('subscriber.enrollment.excel') }}" class="dropdown-item"><img src="{{ asset('images/csv.png') }}" height="20px"> {{ __('CSV') }} </a>
                                            <a data-href="{{ route('subscriber.enrollment.pdf') }}" class="dropdown-item"><img src="{{ asset('assets/images/pdf.png') }}" height="20px"> {{ __('PDF') }} </a>
                                        </div>
                                    </div>
                                @endcan
                                <a class="btn btn-primary waves-effect waves-light text-right" href="{{ route('subscriber.create') }}" >{{ __('Add New') }}</a>
                            </div>
                        </div>
                        <hr>
                    @endcan
                    @include('layouts.shared/data-table')
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Send Mail</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">{{ __('Send Email To : ') }} <span class="text-danger email"></span></label>
                            <input type="hidden" name="subject" class="form-control" id="email" placeholder="{{ __('Email') }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="{{ __('Title') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">{{ __('Subject') }} <span class="text-danger">*</span></label>
                            <textarea name="mail_body" id="mail_body" class="form-control"  cols="30" rows="3"></textarea>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" onclick="sendMail()">send</button>
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Plugins js-->
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script>
        $('#exampleModal').on('shown.bs.modal', function (e) {
            var email = $(e.relatedTarget).data('target-email');
            $('#email').val(email);
            $('.email').text(email);
            $('#myInput').trigger('focus')
        })
        function sendMail(){
            var email = $('#email').val();
            var subject = $('#subject').val();
            var mail_body = $('#mail_body').val();
            $.ajax({
                type: "POST",
                url: "subscriber/send-mail",
                data: {email,subject,mail_body},// now data come in this function
                dataType: "json",
                success: function (res) {
                    alert("success");
                }
          });
        }
    </script>
@endsection
