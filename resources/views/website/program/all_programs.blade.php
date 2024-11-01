@include('website.static.navbar')

@auth()
    <div class="layout-main home-user-main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <main>
                        <!-- ⭐⭐⭐⭐⭐ extra programes - 1 ⭐⭐⭐⭐⭐-->
                        <div class="extra-programes-1">
                            <div class="row">
                                <div class="col-12">
                                    <div class="programes-header">
                                        <div class="section-heading text-center">
                                            <h3 class="heading">
                                                برامجي
                                            </h3>
                                            <p class="sub__heading">
                                                البرامج الخاصة بك
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row programes__container">

                                        @foreach($my_programs as $program)
                                            @if(isset($program->name_ar))
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="program__card
                                              @if($loop->index == 0) rd-top-right @elseif ($loop->index == 2) rd-top-left @endif
                                              cen-col">
                                                    <h3 class="card__name">
                                                        {{ $program->name_ar }}
                                                    </h3>
                                                    <a href="{{route('single-program',['program_id' => $program->id])}}" class="card__link">اٍقرا المزيد</a>
                                                </div>
                                            </div>
                                            @endif
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
    </div>

@endauth


@include('website.static.footer')

