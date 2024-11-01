@include('website.static.head')
<div class="Toastify"></div>

<div class="App ts-logged-in ts-rtl" dir="rtl">

    <div class="ts-header fixed-top ts-user-logged" data-testid="Header">

        @include('website.static.navbar')

        <!-- Profile Modal -->
        <div class="modal " id="ProfileModal" tabindex="2" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="z-index: 200000 !important;">
                <div class="modal-content  RightTopCorner  p-md-5 ">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                    </div>
                    @auth()
                        <div class="modal-body">
                            <div class="card mb-3 border-0">
                                <div class="row g-0">
                                    <div class="col-3 d-flex justify-content-center align-items-center title mb-0" style="font-size: 80px;">
                                        <div class="circle">
                                            <img src="frontend/images/logo.svg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="card-body pe-0 ps-2">
                                            <h1 class="card-title GreyTitle"><b>{{Auth::user()->name}}</b> </h1>
                                            <h5 class="card-text" style="color: #939597;">{{Auth::user()->email}}</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="list-group mt-4">
                                <a href="{{route('profile')}}" class="list-group-item list-group-item-action">{{ __('words.Update Profile') }}</a>
                                <a href="{{route('payment')}}" class="list-group-item list-group-item-action">{{ __('words.Payment Method') }}</a>
                                <a href="{{route('reset_password')}}" class="list-group-item list-group-item-action">{{ __('words.Change Password') }}</a>
                                <a href="{{route('legal_faq')}}" class="list-group-item list-group-item-action">{{ __('words.Legal FAQs') }}</a>
                                <a href="{{route('technical_support')}}" class="list-group-item list-group-item-action">{{ __('words.Technical Support') }}</a>
                                <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#LogOutModal" data-bs-dismiss="modal" aria-label="Close">
                                    {{ __('words.Log Out') }}
                                </a>
                            </div>
                        </div>
                    @endauth

                </div>
            </div>
        </div>

        <!--LogOut Modal -->
        <div class="modal fade" id="LogOutModal" tabindex="-1" aria-labelledby="LogOutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-5  RightTopCorner">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="GreyTitle"> {{ __('words.Log Out') }}</div>
                        <h5 class="my-4" style="color: #939597;">{{__('words.Are you sure you want to exit.')}}</h5>
                        <br>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary me-5" data-bs-dismiss="modal" aria-label="Close">{{__('words.No')}}</button>
                            <a href="{{ route('user.logout') }}"><button type="button" class="btn btn-primary">{{ __('words.Yes') }}</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>



