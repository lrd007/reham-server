@include('website.static.navbar')

@auth()
    <!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
    <div class="layout-main">
        <div class="container-fluid">
            <div class="d-flex layout-row">

                <div class="layout-main courses-main">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="notifications__list">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="header d-flex aling-items-center justify-content-between">
                                                    <p class="heading">{{__('words.Legal FAQs')}}</p>
                                                </div>
                                            </div>
                                            @foreach($legal_faqs as $legal_faq)
                                                    <div class="col-12">
                                                        <!-- ⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️
                                                            ==> data-index of toggle__btn and id of according__body must have the same value
                                                        ⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️ -->
                                                        <div class="notification__item">
                                                            <!-- id and  -->
                                                            <div class="notification__according">
                                                                <div class="according__title">
                                                                    <button class="toggle__btn d-flex align-items-center toggle__according" data-index="according-{{$legal_faq->id}}">
                                                                        <i class="fa-solid fa-plus"></i>
                                                                        <p>
                                                                            {{ $legal_faq->question_ar }}
                                                                        </p>
                                                                    </button>
                                                                </div>
                                                                <div class="according__body" id="according-{{$legal_faq->id}}">
                                                                    <p>
                                                                        {!! $legal_faq->answer_ar !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 🚫🚫🚫🚫  layout 🚫🚫🚫🚫-->

@endauth


@include('website.static.footer')
