@include('website.static.navbar')
<div class="sales-page-main">


<!-- ⭐⭐⭐⭐⭐ HEADER ⭐⭐⭐⭐⭐-->
<header class="sales-header">
    <div class="container custom-container">
        <div class="row align-items-center">
            <div class="col-12 cen-row">
                <div class="video-container  cen-row">
                    <iframe
                        title="vimeo-player"
                        src="{{ GetVimeoFrameLink($program->vimeo) }}"
                        width="1100"
                        height="580"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- 🚫🚫🚫🚫 HEADER  🚫🚫🚫🚫-->

    <!-- ⭐⭐⭐⭐⭐ sales-adv ⭐⭐⭐⭐⭐-->
    <div class="sales-adv">
        <div class="container custom-container">
            <div class="row">
                <div class="col-12">
                    <div class="adv-content cen-col">
                        <p class="adv-body">
                            {{ $program->name_ar }}
                        </p>
                        <a href="{{ route('cart_post',['program_id' => $program->id]) }}" class="adv-link d-block">
                            اشتراك الآن مع رهام {{$amount}} {{ __('words.KD') }}
                        </a>
                        <img src="{{ asset('assets/dexter/src/images/secure-payment.png') }}" alt="secure-payment" class="d-block img-fluid secure-img">
                        <p class="adv-body-2">
                            يمكنك الاشتراك الآن بأقل من دقيقة واحدة
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 🚫🚫🚫🚫 sales-adv  🚫🚫🚫🚫-->





    <!-- ⭐⭐⭐⭐⭐ features ⭐⭐⭐⭐⭐-->
    <div class="features">
        <div class="container ">
            <div class="row">
                <div class="col-12 feature__container">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="feature-card cen-col">
                                <img src="{{ asset('assets/dexter/src/images/download-icon.png') }}" alt="icon" class="__img img-fluid d-block">
                                <p class="__title">
                                    أحتفظ بالمواد لديك مدى الحياة
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="feature-card cen-col">
                                <img src="{{ asset('assets/dexter/src/images/play-icon.png') }}" alt="icon" class="__img img-fluid d-block">
                                <p class="__title">شاهد الدروس من أي مكان في العالم</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="feature-card cen-col">
                                <img src="{{ asset('assets/dexter/src/images/note-icon.png') }}" alt="icon" class="__img img-fluid d-block">
                                <p class="__title">
                                    احصل على المذكرة التدريبية للبرنامج
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container custom-container">
            @foreach($sections as $section)
              @foreach($section->elements as $element)
                    <div class="feature-card-book">
                        <div class="tutorial-card d-flex align-items-center">
                            <div class="card__img">
                                <img src="{{url(uploads_images('program', null,true) . '/' .  $element->image)}}" alt="feature" class="__img img-fluid">
                            </div>
                            <div class="card__content">
                                <h4 class="heading">
                                    {{ $element->title_ar }}
                                </h4>
                                <p class="card__body">
                                    {{ $element->description_ar }}
                                </p>
                            </div>
                        </div>
                    </div>
              @endforeach
            @endforeach

        </div>
        <div class="gold-payment d-flex align-items-md-center">
            <div class="container">
                <div class="cen-row content-box">
                    <div class="right__img">
                        <img src="{{ asset('assets/dexter/src/images/30dayes.png') }}" alt="gold">
                    </div>
                    <p class="lef__body">
                        و نقدم لك الضمان الذهبي في حال لم يلاقي هذا
                        البرنامج تطلعاتك يمكنك استرجاع المبلغ المدفوع
                        عن طريق التواصل مع فريق العمل
                        خلال  {{$program->warranty}} يوم
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- 🚫🚫🚫🚫 features  🚫🚫🚫🚫-->





    <!-- ⭐⭐⭐⭐⭐ sales-adv ⭐⭐⭐⭐⭐-->
    <div class="about__tutorial">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="heading text-center">
                        ماذا سنتعلم  في الأمسية؟
                    </h3>
                    {{--<ul class="tutorial__items text-center ">
                        <li class="tutorial__item">
                            الذكورة في العلاقات. جميع الدروس مسجلة الذكورة في العلاقات. جميع الدروس مسجلة.
                        </li>
                        <li class="tutorial__item">
                            عضوية سنوية في برنامج الحب الروحي  الذي يتناول الحب.
                        </li>
                        <li class="tutorial__item">
                            كذلك طاقة الأنوثة و الذكورة في العلاقات جميع الدروس مسجلة يمكنك متابعتها.
                        </li>
                    </ul>--}}
                    {!! $program->{ 'description'. withLocalization() } !!}
                </div>
                <div class="col-12">
                    <h3 class="heading text-center">
                        هل هذه الأمسية مناسبة لي؟
                    </h3>
                   {{-- <ul class="tutorial__items text-center ">
                        <li class="tutorial__item">
                            الذكورة في العلاقات. جميع الدروس مسجلة الذكورة في العلاقات. جميع الدروس مسجلة.
                        </li>
                        <li class="tutorial__item">
                            عضوية سنوية في برنامج الحب الروحي  الذي يتناول الحب.
                        </li>
                        <li class="tutorial__item">
                            كذلك طاقة الأنوثة و الذكورة في العلاقات جميع الدروس مسجلة يمكنك متابعتها.
                        </li>
                    </ul>--}}
                    {!! $program->{ 'description'. withLocalization().'_2' } !!}
                </div>
            </div>
        </div>
    </div>
    <!-- 🚫🚫🚫🚫 features  🚫🚫🚫🚫-->
    <!-- ⭐⭐⭐⭐⭐ sales-adv ⭐⭐⭐⭐⭐-->
    <div class="sales-adv">
        <div class="container custom-container">
            <div class="row">
                <div class="col-12 cen-row">
                    <div class="adv-content cen-col">
                        <p class="adv-body">
                            يمكنك الحصول على الأمسية مدى الحياة جميع الدروس مسجلة
                            يمكنك مشاهدها وأنت في بلدك وتحصل كذلك على ملحقات الأمسية
                        </p>
                        <a href="{{ route('cart_post',['program_id' => $program->id]) }}" class="adv-link d-block">
                            اشتراك الآن مع رهام {{$amount}} {{ __('words.KD') }}
                        </a>
                        <img src="{{ asset('assets/dexter/src/images/secure-payment.png') }}" alt="secure-payment" class="d-block img-fluid secure-img">
                        <p class="adv-body-2">
                            يمكنك الاشتراك الآن بأقل من دقيقة واحدة
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 🚫🚫🚫🚫 sales-adv  🚫🚫🚫🚫-->
    <!-- ⭐⭐⭐⭐⭐ sales-adv ⭐⭐⭐⭐⭐-->
    <div class="sales-adv">
        <div class="container custom-container">
            <div class="row">
                <div class="col-12">
                    <div class="adv-content cen-col">
                        <p class="adv-body">
                            يمكنك الحصول على الأمسية مدى الحياة جميع الدروس مسجلة
                            يمكنك مشاهدها وأنت في بلدك وتحصل كذلك على ملحقات الأمسية
                        </p>
                        <a href="{{ route('cart_post',['program_id' => $program->id]) }}" class="adv-link d-block">
                            اشتراك الآن مع رهام {{$amount}} {{ __('words.KD') }}
                        </a>
                        <img src="{{ asset('assets/dexter/src/images/secure-payment.png') }}" alt="secure-payment" class="d-block img-fluid secure-img">
                        <p class="adv-body-2">
                            يمكنك الاشتراك الآن بأقل من دقيقة واحدة
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 🚫🚫🚫🚫 sales-adv  🚫🚫🚫🚫-->


    <!-- Gallery cards -->
    <div class="gallery-cards">
        <div class="container custom-container">
            <div class="row">
                @foreach($program->courses as $course)
                            {{ $course->name_ar }}
                        <div class="container PrgoramAgendaCards">
                            <div class="row justify-content-center">
                                @foreach($course->chapters as $chapter)
                                    @foreach($chapter->lessons as $lesson)

                                        <div class="col-md-2 col-lg-2 col-2">
                                            <div class="gallery-card">
                                                <img src="{{url(uploads_images('program', null,true) . '/' .  $lesson->thumb_image)}}" class="img-fluid"  alt="">
                                                <p class="card__title"> {{ $lesson->name_ar }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                @endforeach


            </div>
        </div>
    </div>

    <!-- Gallery cards -->

</div>

@include('website.static.footer')

<script>
    function addCart(){
        const program_id = window.location.href.split('/').slice(-1).pop();
        $.ajax
        ({
            url: '/add-cart/'+program_id,
            type: 'get',
            success: function(result)
            {
                $('.cart-alert').removeClass('d-none');
                console.log(result.cart_item);
                $('#cart_item').text(result.cart_item);
                // const get_cart = localStorage.getItem('program_details');
                // const program_details = get_cart ? JSON.parse(get_cart) : [];
                // if(program_details.findIndex(e => e === program_id ) == -1) {
                //     program_details.push(program_id);
                // }
                // localStorage.setItem('program_details', JSON.stringify(program_details));
                // const updated_get_cart = localStorage.getItem('program_details');
                // const update_get_cart_count = JSON.parse(updated_get_cart).length;
            }
        });
    }
</script>
