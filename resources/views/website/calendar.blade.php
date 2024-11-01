@include('website.static.navbar')


<!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
<div class="layout-main">
    <div class="container-fluid">
        <div class="d-flex layout-row">
            <div class="layout-main calendar-main">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <header class="section-heading">
                                <p class="up__heading text-center">
                                    الرزمانة الشخصية
                                </p>
                                <h3 class="heading text-center">
                                    تعرف علي الاحداث القادمه
                                </h3>
                                <p class="sub__heading  text-center">
                                    هنالك العد من الأنواع المتوفرة لنصوص لوريم
                                </p>
                            </header>
                        </div>

                        <div class="col-12">
                            <div id='calendar' class="full-calendar"></div>
                        </div>
                        <div class="col-12">
                            <p class="content__bottom text-md-start text-center">
                                توقيت التقويم: (GMT 03:00) الكويت
                            </p>
                        </div>
                        <div class="co-12 cen-row">
                            <a href="#" class="add__calendar">
                                اضافة التنبيه في الرزنامة
                            </a>
                        </div>
                        <div class="col-12">
                            <div class="apps__items d-flex align-items-center justify-content-center">
                                <div class="item">
                                    <a href="#">
                                        <img src="{{asset('assets/dexter/src/icons/download (1).png')}}" class="img-fluid" alt="">
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="#">
                                        <img src="{{asset('assets/dexter/src/icons/download (2).png')}}" class="img-fluid" alt="">
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="#">
                                        <img src="{{asset('assets/dexter/src/icons/download (3).png')}}" class="img-fluid" alt="">
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="#">
                                        <img src="{{asset('assets/dexter/src/icons/download (4).png')}}" class="img-fluid" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @foreach($events as $event)
    <div class="modal " id="exampleModalCenter" tabindex="-1"
         role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="case__modal">
                        <p class="case__heading">
                            {{ $event->title_ar }}
                        </p>
                        <p class="sub__heading">
                            {{ $event->description_ar }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
<!-- 🚫🚫🚫🚫  layout 🚫🚫🚫🚫-->


<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script src="{{ asset('assets/dexter/javascript/pages/calendar.js') }}"></script>
{{--<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($events as $event)
            /* HOOK IF DAY HAVE EVENT */
            let eventDay = '{{ $event->start_date }}';
            let dayHaveEvent = document.querySelector(`[data-date='${eventDay}']`)
            dayHaveEvent.classList.add('--event');
            let openModal = document.createElement("button");
            openModal.setAttribute('data-toggle', 'modal');
            openModal.setAttribute('data-target', '#exampleModalCenter');
            openModal.setAttribute('type', 'button');
            openModal.setAttribute('class', 'btn btn-primary');
            dayHaveEvent.appendChild(openModal);
        @endforeach

    });
</script>--}}

@include('website.static.footer')
