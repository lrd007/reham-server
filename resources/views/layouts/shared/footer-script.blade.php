<!-- bundle -->
<!-- Vendor js -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>

@yield('script')
<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}?v=1.0.1"></script>
<script src="{{asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ asset('assets/js/pages/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/libs/toastr/toastr.min.js') }}"></script>
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('assets/js/modules/core/custom.js?v=1.0.1') }}"></script>

@yield('script-bottom')
