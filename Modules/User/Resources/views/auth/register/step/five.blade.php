<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared.title-meta', ['title' => "Register & Signup"])
    @include('layouts.shared.head-css')
</head>

<body class="authentication-bg authentication-bg-pattern">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3"> Application Form - School Information </h4>
                            <div id="registerWizard">
                                <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3">
                                    <li class="nav-item" data-target-form="#contactForm">
                                        <a href="#fifth" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="mdi mdi-checkbox-marked-circle-outline mr-1"></i>
                                            <span class="d-none d-sm-inline">Contact</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content mb-0 b-0 pt-0">
                                    <div class="tab-pane active" id="fifth">
                                        @include('user::auth.register.contact')
                                    </div>
                                </div> <!-- tab-content -->
                            </div> <!-- end #rootwizard-->
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
    @include('layouts.shared.footer-alt')
    @include('layouts.shared.footer-script')
</body>

</html>
