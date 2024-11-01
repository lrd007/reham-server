<li class="side__item   @if(request()->routeIs('all_programs')) heading --heading-active @endif">
    <a href="{{ route('all_programs') }}#programs">
        البرامج
    </a>
</li>
<li class="side__item according__list">
    @auth()
        @php
            $user = auth()->user();
             $ids = [];
        @endphp
    @endauth
    <div class="accordion accordion-flush" id="programes">
        <div class="accordion-item">
            @isset($user->subscriber)
                @foreach ($user->subscriber->subscribePrograms as $program_data)
                    @if(!in_array($program_data->program_id,$ids))
                        @php
                            $program_id = $program_data->program_id;
                            array_push($ids, $program_id);
                            $program = Modules\Program\Entities\Program::find($program_id);

                            $program_name = $program ? $program->name_en : NULL;
                            if(Config::get('app.locale')=='ar'){
                                $program_name = $program ? $program->name_ar : NULL;
                            }
                        @endphp

                        @if($program_name != NULL)
                            @foreach ($program->courses as $course)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#programes-{{$course->id}}" aria-expanded="false"
                                                aria-controls="programes-{{$course->id}}">
                                            {{ $program_name }}
                                        </button>
                                    </h2>
                                    @foreach ($program->courses as $course)
                                        <div id="programes-{{$course->id}}" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingOne"
                                            data-bs-parent="#programes">
                                            <div class="accordion-body">
                                                <div class="accordion accordion-flush" id="programe-{{$course->id}}">
                                                    <div class="accordion-item">
                                                        @php
                                                            $course_name = $course->name_ar;
                                                        @endphp
                                                        <h2 class="accordion-header" id="flush-headingOne">
                                                            <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#programeOnePartOne"
                                                                    aria-expanded="false"
                                                                    aria-controls="programeOnePartOne">
                                                                {{ $course_name }}
                                                            </button>
                                                        </h2>

                                                        <div id="programeOnePartOne" class="accordion-collapse collapse"
                                                            aria-labelledby="flush-headingOne"
                                                            data-bs-parent="#programe-{{$course->id}}">
                                                            <div class="accordion-body">
                                                                <div class="accordion accordion-flush"
                                                                    id="programeOnePartOneLessones">
                                                                    @foreach ($course->chapters as $chapter)
                                                                        @php
                                                                            $chapter_name = $chapter->name_en;
                                                                            if(Config::get('app.locale')=='ar'){
                                                                                $chapter_name = $chapter->name_ar;
                                                                            }
                                                                        @endphp
                                                                        <div class="accordion-item lesson">
                                                                            <h2 class="accordion-header"
                                                                                id="flush-headingOne">
                                                                                <a href="{{route('lesson-details',['program_id' => $program_id , 'course_id' => $course->id , 'chapter_id' => $chapter->id ])}}">
                                                                                <button class="accordion-button collapsed"
                                                                                        type="button"
                                                                                        data-bs-toggle="collapse"
                                                                                        data-bs-target="#flush-collapseOne"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="flush-collapseOne">

                                                                                    {{ $chapter_name }}

                                                                                </button>
                                                                                </a>
                                                                            </h2>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                
                        @endif
                    @endif
                @endforeach
            @endisset
        </div>
    </div>
</li>
