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
                                <header class="section-heading">
                                    <h3 class="heading text-center">
                                        {{$course_data->name_ar}}
                                    </h3>
                                    <p class="sub__heading text-center">
                                        {!! $course_data->description_ar  !!}
                                    </p>
                                    @if(isset($percent))
                                    <p class="progress__count  text-center">
                                       {{ $percent }}%
                                    </p>
                                    @else
                                        <p class="progress__count  text-center">
                                        {{ $user->subscriber->SubscribtionPersent() }}%
                                        </p>
                                    @endif
                                    </p>
                                </header>
                            </div>

                            <div class="col-12">
                                <div class="lessons__container">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <div class="lesson__passed">
                                                اكتملت المشاهدة
                                            </div>
                                        </div>




                                        @foreach ($course_data->lessons as $chapter)
                                            @php
                                                $chapter_name = $chapter->name_ar;
                                                $description = $chapter->description_ar;
                                            @endphp
                                            <div class="col-12">
                                                <div class="lesson__card d-flex justify-content-between align-items-center">
                                                    <div class="card__right">
                                                        <a href="{{route('lesson-details',['program_id' => $program_data->id , 'course_id' => $course_data->id , 'chapter_id' => $chapter->id ])}}">
                                                            <p class="lesson_name">
                                                                <i class="fa-solid fa-caret-left __icon"></i>
                                                                {{$chapter_name}}


                                                            </p>
                                                        </a>
                                                        <p class="lesson_body">
                                                            {!!$description!!}
                                                        </p>
                                                        <p class="lesson__duration">
                                                            [مدة الدرس {{$chapter->duration ?? 0}} دقيقة]
                                                        </p>
                                                    </div>
                                                    <div class="card__center__image">

                                                        <iframe
                                                            title="vimeo-player" class="img-fluid"
                                                            src="{{ GetVimeoFrameLink($chapter->vimeo_embeded_code ) }}"
                                                            width="350"
                                                            frameborder="0"
                                                            allowfullscreen>
                                                        </iframe>

                                                    </div>
                                                    <div class="card__left">
                                                        <div class="card__left__top d-flex  align-items-center">
                                                            <label class="container">
                                                                @php
                                                                    $complete = auth()->user()->subscriber->CourseComplete($program_data->id,$chapter->id )
                                                                @endphp
                                                                <input type="checkbox" @if($chapter->is_completed) checked="checked" @else disabled readonly @endif>
                                                                <span class="checkmark"></span>
                                                            </label>
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
    <!-- 🚫🚫🚫🚫  layout 🚫🚫🚫🚫-->


@endauth


@include('website.static.footer')

