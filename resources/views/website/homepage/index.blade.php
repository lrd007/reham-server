
@include('website.static.navbar')

<div class="layout-main home-user-main">

    @include('website.homepage.slider')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <main>
                    <!-- ⭐⭐⭐⭐⭐ programes  ⭐⭐⭐⭐⭐-->
                    <div class="home-programes">
                        <div class="row">
                            <div class="col-12 cen-row">
                                <div class="programes-header">
                                    <div class="section-heading text-center">
                                        <h3 class="heading" id="programs">
                                            البرامج والدروس
                                        </h3>
                                        <p class="sub__heading">
                                            تعرف علي الاحداث القادمة ومكالمات التدريب
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row programes__container">

                                    @foreach($programs as $program)
                                        @if($program->in_home_page == true)
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="program__card
                                                @if($loop->index == 0)
                                                rd-top-right
                                                @elseif ($loop->index == 2)
                                                 rd-top-left
                                                 @elseif ($loop->last)
                                                     @if($loop->index % 3 == 0)
                                                      rd-bottom-right
                                                    @elseif ($loop->index % 3 > 1)
                                                      rd-bottom-left
                                                    @endif
                                                 @endif
                                                    @if ($loop->index === $loop->count - 2)
                                                        rd-bottom-right
                                                    @endif
                                                 cen-col">
                                                    <h3 class="card__name">
                                                        {{ $program->name_ar }}
                                                    </h3>
                                                    <div class="program__img">
                                                        <img src="https://admin.reham.com/uploads/images/program/{{$program->thumb_image}}" alt="{{ $program->name_ar  }}" alt="{{ $program->{ 'name'. withLocalization() } }}" alt="vthum" />
                                                    </div>
                                                    <p class="card__brief">الاطلاق الخاص بك</p>
                                                    <p class="card__parts">{{ $program->caption_ar }}</p>
                                                    <a href="{{route('program_details',['program'=>$program->id])}}" class="card__link --active">اٍقرا المزيد</a>


                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 🚫🚫🚫🚫 programes  🚫🚫🚫🚫-->

                    <!-- ⭐⭐⭐⭐⭐ extra programes - 1 ⭐⭐⭐⭐⭐-->
                    <div class="extra-programes-1">
                        <div class="row">
                            <div class="col-12">
                                <div class="programes-header">
                                    <div class="section-heading text-center">
                                        <h3 class="heading">
                                            المواد الإضافية
                                        </h3>
                                        <p class="sub__heading">
                                            تعرف على المزيد حول الأحداث القادمة ومكالمات التدريب
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row programes__container">

                                    @foreach($bonus_materials as $material)
                                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="program__card
                                              @if($loop->index == 0) rd-top-right @elseif ($loop->index == 2) rd-top-left @endif
                                              cen-col">
                                                <h3 class="card__name">
                                                    {{ $material->name_ar }}
                                                </h3>
                                                <a href="{{route('bonus-material',['program_id' => 2, 'bonus_id' => $material->id])}}" class="card__link">اٍقرا المزيد</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 🚫🚫🚫🚫 extra programes - 1 🚫🚫🚫🚫-->
                </main>
            </div>
        </div>
    </div>

    <div class="container-fluid layout-fluid">
        <!-- ⭐⭐⭐⭐⭐ extra programes - 2 ⭐⭐⭐⭐⭐-->
        <div class="extra-programes-2">
            <div class="row">
                <div class="col-12">
                    <div class="row programes__container">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="program__card cen-col">
                                <img src="{{ asset('assets/dexter/src/icons/icon-3.png') }}" alt="icon" class="card__icon img-fluid" >
                                <h3 class="card__name">
                                    القيمة المضافة
                                </h3>
                                <p class="sub__heading">
                                    وريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="program__card cen-col">
                                <img src="{{ asset('assets/dexter/src/icons/icon-2.png') }}" alt="icon" class="card__icon img-fluid" >
                                <h3 class="card__name">
                                    القيمة المضافة
                                </h3>
                                <p class="sub__heading">
                                    وريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="program__card cen-col">
                                <img src="{{ asset('assets/dexter/src/icons/icon-1.png') }}" alt="icon" class="card__icon img-fluid" >
                                <h3 class="card__name">
                                    القيمة المضافة
                                </h3>
                                <p class="sub__heading">
                                    وريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="program__card cen-col">
                                <img src="{{ asset('assets/dexter/src/icons/icon-3.png') }}" alt="icon" class="card__icon img-fluid" >
                                <h3 class="card__name">
                                    القيمة المضافة
                                </h3>
                                <p class="sub__heading">
                                    وريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="program__card cen-col">
                                <img src="{{ asset('assets/dexter/src/icons/icon-2.png') }}" alt="icon" class="card__icon img-fluid" >
                                <h3 class="card__name">
                                    القيمة المضافة
                                </h3>
                                <p class="sub__heading">
                                    وريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="program__card cen-col">
                                <img src="{{ asset('assets/dexter/src/icons/icon-1.png') }}" alt="icon" class="card__icon img-fluid" >
                                <h3 class="card__name">
                                    القيمة المضافة
                                </h3>
                                <p class="sub__heading">
                                    وريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 🚫🚫🚫🚫 extra programes - 2 🚫🚫🚫🚫-->
    </div>
</div>

@include('website.static.footer')
