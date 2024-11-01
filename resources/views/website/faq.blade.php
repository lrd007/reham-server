@include('website.static.navbar')

<!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
<div class="layout-main">
    <div class="container-fluid">
        <div class="d-flex layout-row">

            <div class="layout-main fqa-main">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <header class="section-heading">
                                <h3 class="heading text-center">
                                    الاسئلة الشائعة والمصطلحات
                                </h3>
                                <p class="sub__heading text-center">
                                    تعرف على المزيد حول الأحداث القادمة ومكالمات التدريب.
                                </p>
                            </header>
                        </div>
                        <div class="col-12">
                            <div class="questions__container">
                                <div class="row">
                                    @foreach($faqs as $faq)
                                    <div class="col-12">
                                        <!-- ⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️
                                            ==> data-index of toggle__btn and id of according__body must have the same value
                                        ⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️ -->
                                        <div class="question__card"  id="according-{{ $faq->id }}">
                                            <div class="question__title">
                                                <button class="toggle__btn d-flex align-items-center toggle__according" data-index="according-{{ $faq->id }}">
                                                    <i class="fa-solid fa-plus __icon"></i>
                                                    <p class="question__body">
                                                        {{ $faq->{ 'question'. withLocalization() } }}
                                                    </p>
                                                </button>
                                            </div>
                                            <div class="according__body">
                                                <p class="answer__body">
                                                    {!! $faq->{ 'answer'. withLocalization() } !!}
                                                </p>
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
<!-- 🚫🚫🚫🚫  layout 🚫🚫🚫🚫-->


@include('website.static.footer')

<!-- according  -->
<script src="{{ asset('assets/dexter/javascript/according.js') }}"></script>
